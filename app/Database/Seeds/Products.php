<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Products extends Seeder
{
    public function run()
    {
        $rows = [
            // Kategori: makanan ringan
            [
                'kode_product' => 'MRA001',
                'nama_product' => 'Roti Gandum',
                'kategori'     => 'makanan ringan',
                'qty'       => 50,
                'is_active'    => 1,
                'harga'        => 15000.00,
                'image'        => 'roti_gandum.jpg',
            ],
            [
                'kode_product' => 'MRA002',
                'nama_product' => 'Biskuit Oreo',
                'kategori'     => 'makanan ringan',
                'qty'       => 45,
                'is_active'    => 1,
                'harga'        => 18000.00,
                'image'        => 'biskuit_oreo.jpg',
            ],
            [
                'kode_product' => 'MRA003',
                'nama_product' => 'Keripik Kentang Lays',
                'kategori'     => 'makanan ringan',
                'qty'       => 60,
                'is_active'    => 1,
                'harga'        => 8000.00,
                'image'        => 'lays_keripik.jpg',
            ],
            [
                'kode_product' => 'MRA004',
                'nama_product' => 'Cokelat KitKat',
                'kategori'     => 'makanan ringan',
                'qty'       => 55,
                'is_active'    => 1,
                'harga'        => 12000.00,
                'image'        => 'kitkat.jpg',
            ],
            [
                'kode_product' => 'MRA005',
                'nama_product' => 'Permen Gobigames',
                'kategori'     => 'makanan ringan',
                'qty'       => 80,
                'is_active'    => 1,
                'harga'        => 3500.00,
                'image'        => 'permen_gobigames.jpg',
            ],

            // Kategori: minuman
            [
                'kode_product' => 'MIN001',
                'nama_product' => 'Air Mineral Galon 19L',
                'kategori'     => 'minuman',
                'qty'       => 30,
                'is_active'    => 1,
                'harga'        => 25000.00,
                'image'        => 'air_mineral.jpg',
            ],
            [
                'kode_product' => 'MIN002',
                'nama_product' => 'Teh Kotak Susu',
                'kategori'     => 'minuman',
                'qty'       => 100,
                'is_active'    => 1,
                'harga'        => 15000.00,
                'image'        => 'teh_susu.jpg',
            ],
            [
                'kode_product' => 'MIN003',
                'nama_product' => 'Soda Coca-Cola 600ml',
                'kategori'     => 'minuman',
                'qty'       => 70,
                'is_active'    => 1,
                'harga'        => 9000.00,
                'image'        => 'coca_cola.jpg',
            ],
            [
                'kode_product' => 'MIN004',
                'nama_product' => 'Jus Jeruk 1L',
                'kategori'     => 'minuman',
                'qty'       => 35,
                'is_active'    => 1,
                'harga'        => 18000.00,
                'image'        => 'jus_jeruk.jpg',
            ],
            [
                'kode_product' => 'MIN005',
                'nama_product' => 'Kopi Sachet 3in1',
                'kategori'     => 'minuman',
                'qty'       => 120,
                'is_active'    => 1,
                'harga'        => 6000.00,
                'image'        => 'kopi_sachet.jpg',
            ],

            // Kategori: kebutuhan pokok
            [
                'kode_product' => 'KP001',
                'nama_product' => 'Beras 5kg',
                'kategori'     => 'kebutuhan pokok',
                'qty'       => 40,
                'is_active'    => 1,
                'harga'        => 65000.00,
                'image'        => 'beras.jpg',
            ],
            [
                'kode_product' => 'KP002',
                'nama_product' => 'Gula Pasir 1kg',
                'kategori'     => 'kebutuhan pokok',
                'qty'       => 80,
                'is_active'    => 1,
                'harga'        => 15000.00,
                'image'        => 'gula.jpg',
            ],
            [
                'kode_product' => 'KP003',
                'nama_product' => 'Minyak Goreng 2L',
                'kategori'     => 'kebutuhan pokok',
                'qty'       => 35,
                'is_active'    => 1,
                'harga'        => 25000.00,
                'image'        => 'minyak.jpg',
            ],
            [
                'kode_product' => 'KP004',
                'nama_product' => 'Telur Ayam 1kg (30 butir)',
                'kategori'     => 'kebutuhan pokok',
                'qty'       => 60,
                'is_active'    => 1,
                'harga'        => 28000.00,
                'image'        => 'telur.jpg',
            ],
            [
                'kode_product' => 'KP005',
                'nama_product' => 'Kecap Manis 300ml',
                'kategori'     => 'kebutuhan pokok',
                'qty'       => 50,
                'is_active'    => 1,
                'harga'        => 22000.00,
                'image'        => 'kecap_manis.jpg',
            ],

            // Kategori: kebersihan
            [
                'kode_product' => 'CB001',
                'nama_product' => 'Sampung Deterjen 750g',
                'kategori'     => 'kebersihan',
                'qty'       => 45,
                'is_active'    => 1,
                'harga'        => 32000.00,
                'image'        => 'deterjen.jpg',
            ],
            [
                'kode_product' => 'CB002',
                'nama_product' => 'Sabun Cuci Piring 300g',
                'kategori'     => 'kebersihan',
                'qty'       => 70,
                'is_active'    => 1,
                'harga'        => 15000.00,
                'image'        => 'sabun_cuci_piring.jpg',
            ],
            [
                'kode_product' => 'CB003',
                'nama_product' => 'Shampoo 250ml',
                'kategori'     => 'kebersihan',
                'qty'       => 90,
                'is_active'    => 1,
                'harga'        => 20000.00,
                'image'        => 'shampoo.jpg',
            ],
            [
                'kode_product' => 'CB004',
                'nama_product' => 'Sabun Mandi 75g',
                'kategori'     => 'kebersihan',
                'qty'       => 150,
                'is_active'    => 1,
                'harga'        => 5000.00,
                'image'        => 'sabun_mandi.jpg',
            ],
            [
                'kode_product' => 'CB005',
                'nama_product' => 'Kertas Tisu Roll',
                'kategori'     => 'kebersihan',
                'qty'       => 60,
                'is_active'    => 1,
                'harga'        => 18000.00,
                'image'        => 'tisu.jpg',
            ],

            // Kategori: lainnya
            [
                'kode_product' => 'LAI001',
                'nama_product' => 'Baterai AAA 8 pcs',
                'kategori'     => 'lainnya',
                'qty'       => 40,
                'is_active'    => 1,
                'harga'        => 25000.00,
                'image'        => 'baterai.jpg',
            ],
            [
                'kode_product' => 'LAI002',
                'nama_product' => 'Kaos Kaki 10 pasang',
                'kategori'     => 'lainnya',
                'qty'       => 50,
                'is_active'    => 1,
                'harga'        => 20000.00,
                'image'        => 'kaos_kaki.jpg',
            ],
            [
                'kode_product' => 'LAI003',
                'nama_product' => 'Kain Morl 1 meter',
                'kategori'     => 'lainnya',
                'qty'       => 25,
                'is_active'    => 1,
                'harga'        => 35000.00,
                'image'        => 'kain_mori.jpg',
            ],
        ];

        $this->db->table('products')->insertBatch($rows);
    }
}
