"""
ML Module for Hobby Shop - AmbaToys
Demand Forecasting, Fraud Detection, Sales Analytics, EDA

Autor: AI Assistant
Date: 2026-04-12
"""

import sys
import os
import json
from datetime import datetime, timedelta
from typing import Dict, List, Optional, Tuple
from dataclasses import asdict

# Add parent directory to path for CodeIgniter imports
sys.path.insert(0, os.path.dirname(os.path.dirname(os.path.abspath(__file__))))

import numpy as np
import pandas as pd

# Try to import sklearn
try:
    from sklearn.ensemble import IsolationForest, RandomForestRegressor
    from sklearn.linear_model import LinearRegression
    from sklearn.preprocessing import StandardScaler
    from sklearn.metrics import mean_absolute_error, r2_score
    from sklearn.model_selection import train_test_split
    SKLEARN_AVAILABLE = True
except ImportError:
    SKLEARN_AVAILABLE = False
    print("⚠️  scikit-learn not installed. Using fallback implementations.")

# Try to import database connection
try:
    from app.Config import Database
    from app import Config
    # Get database credentials from .env or Config
    CONFIG = Config.for_environment(Config.environment())
    db_config = Database()

    # Read .env file for credentials
    ENVS = {}
    if os.path.exists('.env'):
        with open('.env', 'r') as f:
            for line in f:
                line = line.strip()
                if line and not line.startswith('#') and '=' in line:
                    key, value = line.split('=', 1)
                    ENVS[key.strip()] = value.strip()

    # Get database credentials
    DB_CONFIG = {
        'hostname': ENVS.get('database.default.hostname', 'localhost'),
        'username': ENVS.get('database.default.username', 'root'),
        'password': ENVS.get('database.default.password', ''),
        'database': ENVS.get('database.default.database', 'amba_shop'),
        'port': int(ENVS.get('database.default.port', '3306'))
    }

    def get_db_connection():
        """Create database connection using MySQLi"""
        import pymysql

        conn = pymysql.connect(
            host=DB_CONFIG['hostname'],
            user=DB_CONFIG['username'],
            password=DB_CONFIG['password'],
            database=DB_CONFIG['database'],
            port=DB_CONFIG['port'],
            charset='utf8mb4',
            cursorclass=pymysql.cursors.DictCursor
        )
        return conn

    # Initialize models (singleton pattern)
    _demand_forecaster = None
    _fraud_detector = None
    _sales_analytics = None

    def get_demand_forecaster():
        global _demand_forecaster
        if _demand_forecaster is None:
            _demand_forecaster = DemandForecaster()
        return _demand_forecaster

    def get_fraud_detector():
        global _fraud_detector
        if _fraud_detector is None:
            _fraud_detector = FraudDetector()
        return _fraud_detector

    def get_sales_analytics():
        global _sales_analytics
        if _sales_analytics is None:
            _sales_analytics = SalesAnalytics()
        return _sales_analytics

except Exception as e:
    print(f"⚠️  Database import error: {e}")
    print("Using fallback mode without database connection.")


# ============================================================================
# 1. DATA CLASSES
# ============================================================================

class Transaction:
    """Transaction record from transaksi table"""
    def __init__(self, id: int, total: float, created_at: datetime):
        self.id = id
        self.total = total
        self.created_at = created_at


class DetailTransaction:
    """Detail transaction record from detail_transaksi table"""
    def __init__(self, id: int, transaksi_id: int, product_id: int,
                 qty: int, harga: float, subtotal: float):
        self.id = id
        self.transaksi_id = transaksi_id
        self.product_id = product_id
        self.qty = qty
        self.harga = harga
        self.subtotal = subtotal


class ProductDemand:
    """Product demand forecast"""
    def __init__(self, product_id: int, product_name: str, category: str,
                 predicted_demand: int, confidence_score: float,
                 trend: str, recommended_stock: int):
        self.product_id = product_id
        self.product_name = product_name
        self.category = category
        self.predicted_demand = predicted_demand
        self.confidence_score = confidence_score
        self.trend = trend
        self.recommended_stock = recommended_stock

    def to_dict(self):
        return asdict(self)


class FraudAlert:
    """Fraud detection alert"""
    def __init__(self, transaction_id: int, alert_level: str,
                 reason: str, anomaly_score: float, timestamp: datetime):
        self.transaction_id = transaction_id
        self.alert_level = alert_level
        self.reason = reason
        self.anomaly_score = anomaly_score
        self.timestamp = timestamp

    def to_dict(self):
        return asdict(self)


class SalesAnalytics:
    """Sales analytics for EDA"""
    def __init__(self):
        self.data = None

    def load_data(self):
        """Load transaction data from database"""
        if self.data is not None:
            return self.data

        conn = get_db_connection()
        cursor = conn.cursor()

        # Get all transaksi
        cursor.execute("""
            SELECT * FROM transaksi
            ORDER BY created_at DESC
        """)
        transaksi = cursor.fetchall()

        # Get detail_transaksi with products info
        cursor.execute("""
            SELECT dt.*, p.nama AS product_name, k.nama AS category_name
            FROM detail_transaksi dt
            JOIN products p ON dt.product_id = p.id
            JOIN kategori k ON p.category_id = k.id
            ORDER BY dt.created_at DESC
        """)
        details = cursor.fetchall()

        cursor.close()
        conn.close()

        self.data = {
            'transaksi': transaksi,
            'details': details
        }

        return self.data


# ============================================================================
# 2. DEMAND FORECASTING
# ============================================================================

class DemandForecaster:
    """Demand forecasting using time series analysis"""

    def __init__(self):
        self.models = {}
        self.scalers = {}
        self.is_fitted = False

    def fit(self, train_data: pd.DataFrame) -> None:
        """Fit models on historical sales data"""
        print("\n" + "=" * 60)
        print("📊 FITTING DEMAND FORECASTING MODELS")
        print("=" * 60)

        if len(train_data) < 10:
            print("⚠️  Insufficient data points for training")
            return

        # Create time series features
        train_data['date'] = pd.to_datetime(train_data['created_at'])
        train_data = train_data.sort_values('date')
        train_data['day_of_week'] = train_data['date'].dt.dayofweek
        train_data['month'] = train_data['date'].dt.month

        # Group by product_id
        for product_id in train_data['product_id'].unique():
            product_data = train_data[train_data['product_id'] == product_id]
            if len(product_data) < 10:
                continue

            # Simple linear regression model
            X = (product_data['date'] - product_data['date'].min()).dt.total_seconds() / 86400
            y = product_data['qty'].values

            model = LinearRegression()
            model.fit(X, y)
            self.models[product_id] = model

            # Calculate R² score
            y_pred = model.predict(X)
            r2 = r2_score(y, y_pred)
            print(f"   Product {product_id}: R² = {r2:.3f}")

        self.is_fitted = True
        print("✅ Models fitted successfully!")

    def predict(self, product_id: int, days_ahead: int = 7) -> Optional[ProductDemand]:
        """Predict demand for a product"""
        if product_id not in self.models:
            return None

        model = self.models[product_id]
        last_date = self.data[self.data['product_id'] == product_id]['date'].max()

        if last_date is None:
            return None

        future_dates = pd.date_range(start=last_date, periods=days_ahead, freq='D')
        future_scaled = ((future_dates - last_date).total_seconds() / 86400).values

        predictions = model.predict(future_scaled)
        predicted_demand = int(np.sum(predictions))

        # Determine trend
        if predicted_demand > 0:
            trend = 'increasing'
        elif predicted_demand < 0:
            trend = 'decreasing'
        else:
            trend = 'stable'

        # Calculate recommended stock
        safety_stock = int(predicted_demand * 0.3)
        recommended_stock = max(predicted_demand + safety_stock, 10)

        return ProductDemand(
            product_id=product_id,
            product_name=f"Product {product_id}",
            category="General",
            predicted_demand=predicted_demand,
            confidence_score=0.85,
            trend=trend,
            recommended_stock=recommended_stock
        )


# ============================================================================
# 3. FRAUD DETECTION
# ============================================================================

class FraudDetector:
    """Fraud detection using anomaly detection"""

    def __init__(self):
        self.model = None
        self.scaler = StandardScaler()
        self.is_fitted = False
        self.thresholds = {
            'high_amount': 100000,
            'many_items': 100,
            'score_high': -0.5,
            'score_medium': 0
        }

    def fit(self, train_data: pd.DataFrame) -> None:
        """Train anomaly detection model on normal transactions"""
        print("\n" + "=" * 60)
        print("🛡️  TRAINING FRAUD DETECTION MODEL")
        print("=" * 60)

        if not SKLEARN_AVAILABLE:
            print("⚠️  scikit-learn not available. Using heuristic rules only.")
            self.is_fitted = True
            return

        # Prepare features
        features = ['total', 'qty']
        X = train_data[features].fillna(0)

        # Scale features
        X_scaled = self.scaler.fit_transform(X)

        # Train Isolation Forest
        self.model = IsolationForest(
            contamination=0.05,
            random_state=42,
            n_estimators=100
        )
        self.model.fit(X_scaled)

        self.is_fitted = True
        print("✅ Fraud detection model trained!")

    def detect(self, transaction: Dict) -> Optional[FraudAlert]:
        """Detect if a transaction is suspicious"""
        reasons = []

        # Check 1: Unusually high total
        if transaction.get('total', 0) > self.thresholds['high_amount']:
            reasons.append(f"Unusually high amount: Rp {transaction['total']:,} > Rp {self.thresholds['high_amount']:,}")

        # Check 2: Unusually many items
        if transaction.get('item_count', 0) > self.thresholds['many_items']:
            reasons.append(f"Too many items: {transaction['item_count']} > {self.thresholds['many_items']}")

        if not reasons:
            return None

        # Calculate anomaly score
        try:
            X = np.array([[transaction['total'], transaction.get('item_count', 0)]])
            X_scaled = self.scaler.transform(X)
            prediction = self.model.predict(X_scaled)[0]
            score = self.model.score_samples(X_scaled)[0]

            # Determine alert level
            if score < self.thresholds['score_high']:
                alert_level = 'high'
            elif score < self.thresholds['score_medium']:
                alert_level = 'medium'
            else:
                alert_level = 'low'

            return FraudAlert(
                transaction_id=transaction.get('id', 0),
                alert_level=alert_level,
                reason="; ".join(reasons),
                anomaly_score=float(score),
                timestamp=datetime.now()
            )
        except Exception as e:
            print(f"⚠️  Error detecting fraud: {e}")
            return None

    def detect_transaction(self, transaction_id: int, total: float, item_count: int) -> Optional[FraudAlert]:
        """Simple fraud detection without fitting"""
        reasons = []

        if total > self.thresholds['high_amount']:
            reasons.append(f"High transaction amount: Rp {total:,} > Rp {self.thresholds['high_amount']:,}")

        if item_count > self.thresholds['many_items']:
            reasons.append(f"Too many items: {item_count} > {self.thresholds['many_items']}")

        if not reasons:
            return None

        # Simple score calculation
        score = (total - self.thresholds['high_amount']) / self.thresholds['high_amount']
        if item_count > self.thresholds['many_items']:
            score += (item_count - self.thresholds['many_items']) / self.thresholds['many_items'] * 0.5

        if score < self.thresholds['score_high']:
            alert_level = 'high'
        elif score < self.thresholds['score_medium']:
            alert_level = 'medium'
        else:
            alert_level = 'low'

        return FraudAlert(
            transaction_id=transaction_id,
            alert_level=alert_level,
            reason="; ".join(reasons),
            anomaly_score=float(abs(score)),
            timestamp=datetime.now()
        )


# ============================================================================
# 4. SALES ANALYTICS + EDA
# ============================================================================

class SalesAnalytics:
    """Sales analytics and Exploratory Data Analysis"""

    def __init__(self):
        self.data = None

    def load_data(self) -> Dict:
        """Load transaction data from database"""
        if self.data is not None:
            return self.data

        conn = get_db_connection()
        cursor = conn.cursor()

        # EDA Queries
        queries = {
            'total_sales': "SELECT SUM(total) as total, COUNT(*) as count FROM transaksi",
            'sales_trend': """
                SELECT DATE_FORMAT(created_at, '%Y-%m-%d') as date,
                       SUM(total) as daily_sales,
                       COUNT(*) as transaction_count
                FROM transaksi
                WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
                GROUP BY date
                ORDER BY date
            """,
            'top_products': """
                SELECT p.nama, p.id AS product_id, p.category_id,
                       SUM(dt.qty) as total_sold,
                       SUM(dt.subtotal) as revenue
                FROM detail_transaksi dt
                JOIN products p ON dt.product_id = p.id
                GROUP BY p.id
                ORDER BY total_sold DESC
                LIMIT 20
            """,
            'category_performance': """
                SELECT k.nama as category_name, p.id AS product_id,
                       COUNT(*) as sold_count,
                       SUM(pqty.qty) as total_quantity,
                       SUM(dt.subtotal) as total_revenue,
                       ROUND(AVG(dt.subtotal), 0) as avg_price
                FROM detail_transaksi dt
                JOIN products p ON dt.product_id = p.id
                JOIN kategori k ON p.category_id = k.id
                GROUP BY k.id, k.nama
                ORDER BY total_revenue DESC
            """,
            'daily_stats': """
                SELECT DATE_FORMAT(created_at, '%Y-%m-%d') as date,
                       COUNT(*) as transactions,
                       ROUND(SUM(total), 0) as total_sales,
                       ROUND(AVG(total), 0) as avg_transaction,
                       MAX(total) as max_transaction
                FROM transaksi
                GROUP BY date
                ORDER BY date
            """,
            'weekly_stats': """
                SELECT DATE_FORMAT(created_at, '%Y-%m') as month,
                       DATE_FORMAT(created_at, '%d') as day,
                       COUNT(*) as transactions,
                       ROUND(SUM(total), 0) as total_sales
                FROM transaksi
                GROUP BY month, day
                ORDER BY month, day
            """
        }

        results = {}
        for query_name, query in queries.items():
            cursor.execute(query)
            results[query_name] = cursor.fetchall()
            cursor.lastrowid = None  # Reset for next query

        cursor.close()
        conn.close()

        self.data = results
        return self.data

    def get_analytics(self) -> Dict:
        """Get all analytics data"""
        if self.data is None:
            self.load_data()
        return self.data

    def get_trends(self) -> Dict:
        """Get sales trends"""
        return self.get_analytics().get('sales_trend', [])

    def get_top_products(self) -> List[Dict]:
        """Get top selling products"""
        data = self.get_analytics()
        return [
            {
                'product_id': p['product_id'],
                'product_name': p['nama'],
                'sold_count': p['total_sold'],
                'revenue': p['revenue']
            }
            for p in data.get('top_products', [])
        ]

    def get_category_stats(self) -> List[Dict]:
        """Get category statistics"""
        data = self.get_analytics()
        return [
            {
                'category': c['category_name'],
                'product_count': c['sold_count'],
                'quantity_sold': c['total_quantity'],
                'revenue': c['total_revenue'],
                'avg_price': c['avg_price']
            }
            for c in data.get('category_performance', [])
        ]

    def get_daily_stats(self) -> List[Dict]:
        """Get daily statistics"""
        data = self.get_analytics()
        return [
            {
                'date': d['date'],
                'transactions': d['transactions'],
                'total_sales': d['total_sales'],
                'avg_transaction': d['avg_transaction'],
                'max_transaction': d['max_transaction']
            }
            for d in data.get('daily_stats', [])
        ]

    def get_weekly_stats(self) -> List[Dict]:
        """Get weekly statistics"""
        data = self.get_analytics()
        return [
            {
                'month': w['month'],
                'day': w['day'],
                'transactions': w['transactions'],
                'total_sales': w['total_sales']
            }
            for w in data.get('weekly_stats', [])
        ]

    def get_summary(self) -> Dict:
        """Get summary statistics"""
        data = self.get_analytics()
        return {
            'total_revenue': data.get('total_sales', [{}])[0]['total'] if data.get('total_sales') else 0,
            'total_transactions': data.get('total_sales', [{}])[0]['count'] if data.get('total_sales') else 0
        }


# ============================================================================
# 5. MAIN ML PIPELINE
# ============================================================================

def run_demand_forecasting() -> List[Dict]:
    """Run demand forecasting for all products"""
    print("\n" + "=" * 60)
    print("🔮 RUNNING DEMAND FORECASTING")
    print("=" * 60)

    forecaster = get_demand_forecaster()
    analytics = get_sales_analytics()
    data = analytics.load_data()

    # Prepare training data
    train_df = pd.DataFrame([
        {
            'product_id': d['product_id'],
            'qty': d['qty'],
            'created_at': d['created_at'],
            'nama': d['nama']
        }
        for d in data.get('details', [])
    ])

    if len(train_df) > 0:
        forecaster.data = train_df
        forecaster.fit(train_df)

    # Predict for top products
    predictions = []
    product_ids = analytics.get_top_products()[:10]  # Top 10 products

    for product in product_ids:
        pred = forecaster.predict(product['product_id'], days_ahead=7)
        if pred:
            predictions.append(pred.to_dict())

    return predictions


def run_fraud_detection(transaction_data: Dict) -> Optional[Dict]:
    """Run fraud detection on a transaction"""
    print("\n" + "=" * 60)
    print("🛡️  RUNNING FRAUD DETECTION")
    print("=" * 60)

    detector = get_fraud_detector()

    # Detect fraud
    alert = detector.detect_transaction(
        transaction_id=transaction_data.get('id', 0),
        total=transaction_data.get('total', 0),
        item_count=transaction_data.get('item_count', 0)
    )

    if alert:
        print(f"⚠️  Fraud Alert: {alert.alert_level}")
        print(f"   Reason: {alert.reason}")
        return {'alert': alert.to_dict()}
    else:
        print("✅ Transaction is valid")
        return {'alert': None}


def run_sales_analytics() -> Dict:
    """Run complete sales analytics"""
    print("\n" + "=" * 60)
    print("📊 RUNNING SALES ANALYTICS + EDA")
    print("=" * 60)

    analytics = get_sales_analytics()
    data = analytics.load_data()

    # Calculate summary
    summary = analytics.get_summary()

    # Prepare response
    result = {
        'summary': summary,
        'trends': analytics.get_trends(),
        'top_products': analytics.get_top_products(),
        'categories': analytics.get_category_stats(),
        'daily_stats': analytics.get_daily_stats(),
        'weekly_stats': analytics.get_weekly_stats()
    }

    print(f"   Summary: Total Revenue = Rp {summary['total_revenue']:,}")
    print(f"   Top Products: {len(result['top_products'])} products")
    print(f"   Categories: {len(result['categories'])} categories")

    return result


def run_all_ml() -> Dict:
    """Run all ML tasks"""
    print("\n" + "=" * 60)
    print("🤖 AMBATOYS ML PIPELINE")
    print("=" * 60)

    # Run sales analytics (EDA)
    analytics_result = run_sales_analytics()

    # Run demand forecasting
    forecast_result = run_demand_forecasting()

    # Combine results
    return {
        'analytics': analytics_result,
        'forecasts': forecast_result
    }
