# TokoArya - POS Kelontong & AI Insights

Sistem Point of Sales (POS) modern yang dirancang untuk toko kelontong, dilengkapi dengan analisis data pintar menggunakan Machine Learning untuk prediksi omzet dan manajemen stok.

## 🚀 Fitur Utama
- **Sistem Kasir (Point of Sales):** Transaksi cepat dengan fitur keranjang belanja dan manajemen stok real-time.
- **Manajemen Produk:** Pengelolaan SKU, kategori, dan status aktif/non-aktif barang.
- **AI Intelligent Insights (Flask Integration):**
  - **Omzet Forecasting:** Prediksi pendapatan 7 hari ke depan menggunakan *Linear Regression*.
  - **Product Analysis:** Identifikasi barang *Fast-Moving* (paling laku) dan *Slow-Moving* (kurang laku).
  - **Restock Suggestion:** Rekomendasi otomatis jumlah restock berdasarkan rata-rata penjualan harian.
- **Audit Trail:** Pencatatan setiap aksi penting (seperti rollback transaksi) untuk keamanan data.
- **Laporan Penjualan:** Filter harian, mingguan, dan bulanan yang komprehensif.

## 🛠 Tech Stack
- **Web Framework:** CodeIgniter 4 (PHP 8.3)
- **AI Service:** Flask (Python 3.12)
- **Database:** MariaDB / MySQL
- **Frontend:** Vanilla CSS / Tailwind (via Dashboard Template)
- **Machine Learning Libraries:** Pandas, Scikit-Learn, NumPy

## 📦 Instalasi

### 1. Prasyarat (Linux/Pop OS)
Pastikan ekstensi PHP yang dibutuhkan sudah terinstall, terutama `curl` yang sering menjadi blindspot:
```bash
sudo apt update
sudo apt install php8.3-curl php8.3-intl php8.3-mysql php8.3-mbstring
```

### 2. Setup CodeIgniter 4
```bash
# Install dependencies
composer install

# Setup environment
cp env .env
# Edit .env dan sesuaikan database settings
```

### 3. Setup AI Service (Flask)
```bash
cd ml
python3 -m venv venv
source venv/bin/activate
pip install -r requirements.txt
```

## 🏃‍♂️ Menjalankan Aplikasi
Buka dua terminal terpisah:

**Terminal 1 (Web Server):**
```bash
php spark serve
```

**Terminal 2 (AI Service):**
```bash
cd ml
source venv/bin/activate
python app.py
```

Aplikasi dapat diakses di `http://localhost:8080`.

## ⚠️ Troubleshooting (Blindspots)
- **Status 503 AI Offline:** Jika muncul error ini, pastikan ekstensi `php-curl` sudah terinstall di Linux dan Flask service sedang berjalan di port 5000.
- **Data AI Kosong:** AI membutuhkan minimal data transaksi dari **3 hari yang berbeda** untuk melakukan forecasting secara akurat.
- **Docker:** Jika menggunakan Docker, pastikan komunikasi antar container menggunakan nama service (misal: `http://ai_service:5000`) bukan `127.0.0.1`.

## 📄 Lisensi
[MIT License](LICENSE)
