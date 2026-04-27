from flask import Flask, jsonify, request
from flask_cors import CORS
import pandas as pd
import numpy as np
from sklearn.linear_model import LinearRegression
from datetime import datetime
import math
import requests

app = Flask(__name__)
CORS(app)

@app.route('/forecast', methods=['GET', 'POST'])
def forecast():
    try:
        transactions = []
        items = []
        products = []
        payload = request.get_json(silent=True) or {}

        if isinstance(payload, dict) and isinstance(payload.get('transaction'), list):
            transactions = payload.get('transaction', [])
            items = payload.get('items', [])
            products = payload.get('products', [])
        else:
            url = "http://localhost:8080/api/penjualan"
            res = requests.get(url, timeout=10)
            data = res.json()
            transactions = data.get('transaction', [])
            items = data.get('items', [])
            products = data.get('products', [])
    except Exception as e:
        return jsonify({'status': 'error', 'message': f'Gagal ambil data: {str(e)}'}), 500
    
    if not transactions or len(transactions) < 3:
        return jsonify({
            'status': 'error', 
            'message': 'Data transaksi minimal 3 hari untuk forecasting'
        }), 400

    # Preprocessing Data
    df = pd.DataFrame(transactions)
    df['created_at'] = pd.to_datetime(df['created_at'])
    df['total'] = pd.to_numeric(df['total'])  # ← penting, convert string ke number
    
    # Agregasi per hari
    daily_sales = df.groupby(df['created_at'].dt.date)['total'].sum().reset_index()
    daily_sales.columns = ['ds', 'y']
    
    daily_sales['ds_ordinal'] = daily_sales['ds'].apply(lambda x: pd.to_datetime(x).toordinal())
    
    X = daily_sales['ds_ordinal'].values.reshape(-1, 1)
    y = daily_sales['y'].values
    
    # Training Model
    model = LinearRegression()
    model.fit(X, y)
    
    # Prediksi 7 hari ke depan
    last_date = daily_sales['ds_ordinal'].max()
    future_dates = np.array([last_date + i for i in range(1, 8)]).reshape(-1, 1)
    predictions = model.predict(future_dates)
    
    # Format hasil
    forecast_results = []
    for i, pred in enumerate(predictions):
        forecast_results.append({
            'tanggal': datetime.fromordinal(int(future_dates[i][0])).strftime('%Y-%m-%d'),
            'prediksi_omzet': max(0, round(float(pred), 2))
        })

    ops_insight = {
        'slow_moving': [],
        'restock_plan': [],
        'fast_moving': []
    }

    if items and products:
        items_df = pd.DataFrame(items)
        products_df = pd.DataFrame(products)

        tx_lookup = df[['id', 'created_at']].copy()
        tx_lookup['id'] = tx_lookup['id'].astype(str)
        items_df['transaksi_id'] = items_df['transaksi_id'].astype(str)
        items_df['product_id'] = pd.to_numeric(items_df['product_id'], errors='coerce').fillna(0).astype(int)
        items_df['qty'] = pd.to_numeric(items_df['qty'], errors='coerce').fillna(0)

        items_df = items_df.merge(tx_lookup, left_on='transaksi_id', right_on='id', how='left')
        items_df['created_at'] = pd.to_datetime(items_df['created_at'], errors='coerce')

        now = pd.Timestamp.now()
        window_start = now - pd.Timedelta(days=30)
        recent_items = items_df[items_df['created_at'] >= window_start].copy()

        sold_30d = recent_items.groupby('product_id')['qty'].sum().reset_index(name='sold_30d')
        last_sold = items_df.dropna(subset=['created_at']).groupby('product_id')['created_at'].max().reset_index(name='last_sold_at')

        products_df['id'] = pd.to_numeric(products_df['id'], errors='coerce').fillna(0).astype(int)
        products_df['qty'] = pd.to_numeric(products_df['qty'], errors='coerce').fillna(0)
        products_df = products_df.merge(sold_30d, left_on='id', right_on='product_id', how='left')
        products_df = products_df.merge(last_sold, left_on='id', right_on='product_id', how='left')
        products_df['sold_30d'] = products_df['sold_30d'].fillna(0)

        slow_moving = []
        restock_plan = []
        fast_moving = []

        for _, row in products_df.iterrows():
            stock = float(row.get('qty', 0) or 0)
            sold = float(row.get('sold_30d', 0) or 0)
            avg_daily = sold / 30.0
            last_sold_at = row.get('last_sold_at')
            last_sold_text = '-' if pd.isna(last_sold_at) else pd.Timestamp(last_sold_at).strftime('%Y-%m-%d')

            if sold <= 20:
                slow_moving.append({
                    'product_id': int(row.get('id', 0)),
                    'nama_product': str(row.get('nama_product', '')),
                    'kategori': str(row.get('kategori', '')),
                    'stok_saat_ini': int(stock),
                    'terjual_30_hari': int(sold),
                    'last_sold_at': last_sold_text,
                    'saran': 'Bundling / diskon ringan / kurangi reorder'
                })
            if sold >= 20:
                fast_moving.append({
                    'product_id': int(row.get('id', 0)),
                    'nama_product': str(row.get('nama_product', '')),
                    'kategori': str(row.get('kategori', '')),
                    'stok_saat_ini': int(stock),
                    'terjual_30_hari': int(sold),
                    'rata_harian': round(avg_daily, 2),
                    'saran': 'Stok aman, pertimbangkan display di area kasir (upselling)'
                })

            if avg_daily > 0:
                days_cover = stock / avg_daily if avg_daily else float('inf')
                if days_cover < 14:
                    target_stock = avg_daily * 21
                    qty_restock = max(0, int(math.ceil(target_stock - stock)))
                    if qty_restock > 0:
                        restock_plan.append({
                            'product_id': int(row.get('id', 0)),
                            'nama_product': str(row.get('nama_product', '')),
                            'kategori': str(row.get('kategori', '')),
                            'stok_saat_ini': int(stock),
                            'rata_harian': round(avg_daily, 2),
                            'estimasi_habis_hari': round(days_cover, 1),
                            'qty_restock': qty_restock,
                            'priority': 'tinggi' if days_cover < 7 else 'normal'
                        })

        slow_moving.sort(key=lambda x: (x['terjual_30_hari'], -x['stok_saat_ini']))
        restock_plan.sort(key=lambda x: (0 if x['priority'] == 'tinggi' else 1, x['estimasi_habis_hari']))
        
        fast_moving.sort(key=lambda x: (x['terjual_30_hari'], +x['stok_saat_ini']))

        ops_insight = {
            'slow_moving': slow_moving[:5],
            'restock_plan': restock_plan[:5],
            'fast_moving': fast_moving[:5]
        }

    return jsonify({
        'status': 'success',
        'forecast': forecast_results,
        'trend': 'naik' if model.coef_[0] > 0 else 'turun',
        'insight': f"Tren penjualan lagi {'naik nih!' if model.coef_[0] > 0 else 'sepi, stok jangan kebanyakan.'}",
        'ops_insight': ops_insight
    })

if __name__ == '__main__':
    app.run(port=5000, debug=True)