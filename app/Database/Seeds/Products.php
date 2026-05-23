<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Products extends Seeder
{
    public function run()
    {
        $rows = [

            // =========================
            // MAKANAN RINGAN
            // =========================
            [
                'kode_product' => 'MRA001',
                'nama_product' => 'Roti Tawar Gandum',
                'kategori' => 'makanan ringan',
                'qty' => 40,
                'is_active' => 1,
                'harga' => 18000,
                'image' => 'roti_gandum.jpg',
            ],
            [
                'kode_product' => 'MRA002',
                'nama_product' => 'Biskuit Oreo Original',
                'kategori' => 'makanan ringan',
                'qty' => 60,
                'is_active' => 1,
                'harga' => 9500,
                'image' => 'oreo.jpg',
            ],
            [
                'kode_product' => 'MRA003',
                'nama_product' => 'Keripik Kentang Original',
                'kategori' => 'makanan ringan',
                'qty' => 80,
                'is_active' => 1,
                'harga' => 12000,
                'image' => 'keripik.jpg',
            ],
            [
                'kode_product' => 'MRA004',
                'nama_product' => 'Wafer Cokelat',
                'kategori' => 'makanan ringan',
                'qty' => 70,
                'is_active' => 1,
                'harga' => 8000,
                'image' => 'wafer.jpg',
            ],
            [
                'kode_product' => 'MRA005',
                'nama_product' => 'Cokelat Batangan',
                'kategori' => 'makanan ringan',
                'qty' => 50,
                'is_active' => 1,
                'harga' => 11000,
                'image' => 'cokelat.jpg',
            ],

            // =========================
            // MINUMAN
            // =========================
            [
                'kode_product' => 'MIN001',
                'nama_product' => 'Air Mineral 600ml',
                'kategori' => 'minuman',
                'qty' => 120,
                'is_active' => 1,
                'harga' => 4000,
                'image' => 'air_mineral.jpg',
            ],
            [
                'kode_product' => 'MIN002',
                'nama_product' => 'Teh Botol 450ml',
                'kategori' => 'minuman',
                'qty' => 90,
                'is_active' => 1,
                'harga' => 6000,
                'image' => 'teh_botol.jpg',
            ],
            [
                'kode_product' => 'MIN003',
                'nama_product' => 'Kopi Susu Botol',
                'kategori' => 'minuman',
                'qty' => 45,
                'is_active' => 1,
                'harga' => 15000,
                'image' => 'kopi_susu.jpg',
            ],
            [
                'kode_product' => 'MIN004',
                'nama_product' => 'Jus Jeruk Kemasan',
                'kategori' => 'minuman',
                'qty' => 35,
                'is_active' => 1,
                'harga' => 12000,
                'image' => 'jus_jeruk.jpg',
            ],
            [
                'kode_product' => 'MIN005',
                'nama_product' => 'Minuman Soda 390ml',
                'kategori' => 'minuman',
                'qty' => 60,
                'is_active' => 1,
                'harga' => 8000,
                'image' => 'soda.jpg',
            ],

            // =========================
            // KEBUTUHAN POKOK
            // =========================
            [
                'kode_product' => 'KP001',
                'nama_product' => 'Beras Premium 5kg',
                'kategori' => 'kebutuhan pokok',
                'qty' => 30,
                'is_active' => 1,
                'harga' => 79000,
                'image' => 'beras.jpg',
            ],
            [
                'kode_product' => 'KP002',
                'nama_product' => 'Gula Pasir 1kg',
                'kategori' => 'kebutuhan pokok',
                'qty' => 50,
                'is_active' => 1,
                'harga' => 18500,
                'image' => 'gula.jpg',
            ],
            [
                'kode_product' => 'KP003',
                'nama_product' => 'Minyak Goreng 1L',
                'kategori' => 'kebutuhan pokok',
                'qty' => 45,
                'is_active' => 1,
                'harga' => 22000,
                'image' => 'minyak.jpg',
            ],
            [
                'kode_product' => 'KP004',
                'nama_product' => 'Telur Ayam 1kg',
                'kategori' => 'kebutuhan pokok',
                'qty' => 40,
                'is_active' => 1,
                'harga' => 32000,
                'image' => 'telur.jpg',
            ],
            [
                'kode_product' => 'KP005',
                'nama_product' => 'Kecap Manis 275ml',
                'kategori' => 'kebutuhan pokok',
                'qty' => 55,
                'is_active' => 1,
                'harga' => 17000,
                'image' => 'kecap.jpg',
            ],

            // =========================
            // KEBERSIHAN
            // =========================
            [
                'kode_product' => 'CB001',
                'nama_product' => 'Deterjen Bubuk 800g',
                'kategori' => 'kebersihan',
                'qty' => 35,
                'is_active' => 1,
                'harga' => 28000,
                'image' => 'deterjen.jpg',
            ],
            [
                'kode_product' => 'CB002',
                'nama_product' => 'Sabun Cuci Piring 750ml',
                'kategori' => 'kebersihan',
                'qty' => 50,
                'is_active' => 1,
                'harga' => 15000,
                'image' => 'sabun_cuci.jpg',
            ],
            [
                'kode_product' => 'CB003',
                'nama_product' => 'Shampoo 170ml',
                'kategori' => 'kebersihan',
                'qty' => 45,
                'is_active' => 1,
                'harga' => 24000,
                'image' => 'shampoo.jpg',
            ],
            [
                'kode_product' => 'CB004',
                'nama_product' => 'Sabun Mandi Batang',
                'kategori' => 'kebersihan',
                'qty' => 80,
                'is_active' => 1,
                'harga' => 5500,
                'image' => 'sabun.jpg',
            ],
            [
                'kode_product' => 'CB005',
                'nama_product' => 'Tisu Gulung',
                'kategori' => 'kebersihan',
                'qty' => 60,
                'is_active' => 1,
                'harga' => 14000,
                'image' => 'tisu.jpg',
            ],

            // =========================
            // LAINNYA
            // =========================
            [
                'kode_product' => 'LAI001',
                'nama_product' => 'Baterai AAA Isi 2',
                'kategori' => 'lainnya',
                'qty' => 40,
                'is_active' => 1,
                'harga' => 12000,
                'image' => 'baterai.jpg',
            ],
            [
                'kode_product' => 'LAI002',
                'nama_product' => 'Pulpen Hitam',
                'kategori' => 'lainnya',
                'qty' => 100,
                'is_active' => 1,
                'harga' => 3500,
                'image' => 'pulpen.jpg',
            ],
            [
                'kode_product' => 'LAI003',
                'nama_product' => 'Korek Api Gas',
                'kategori' => 'lainnya',
                'qty' => 80,
                'is_active' => 1,
                'harga' => 5000,
                'image' => 'korek.jpg',
            ],
        ];

        $this->db->table('products')->insertBatch($rows);
    }
}