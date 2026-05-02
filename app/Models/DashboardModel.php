<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Agregasi data untuk halaman admin dashboard (berbasis tabel products).
 */
class DashboardModel extends Model
{
    protected $table = 'products';

    protected $primaryKey = 'id';

    protected $useTimestamps = true;

    /**
     * Ringkasan angka untuk kartu dashboard.
     *
     * @return array{total_produk:int, total_stok:int, total_nilai_inventori:float, produk_baru:int, produk_bekas:int}
     */
   public function getOverviewStats(): array
{
    $db = $this->db;

    // 1. Total Produk (Hanya yang Aktif)
    $totalProduk = (int) $this->where('is_active', 1)->countAllResults();

    // 2. Total Stok (Hanya dari Produk yang Aktif)
    $stokRow = $db->table('products')
        ->selectSum('qty', 'total_stok')
        ->where('is_active', 1) // Filter barang aktif
        ->get()
        ->getRowArray();
    $totalStok = (int) ($stokRow['total_stok'] ?? 0);

    // 3. Total Nilai Inventori (Hanya dari Produk yang Aktif)
    $nilaiRow = $db->table('products')
        ->select('SUM(harga * qty) AS total_nilai')
        ->where('is_active', 1) // Filter barang aktif
        ->get()
        ->getRowArray();
    $totalNilai = (float) ($nilaiRow['total_nilai'] ?? 0);

    $nilaiNonAktif = $db->table('products')->selectSum('qty' , 'total')->where('is_active', 0)->get()->getRowArray();
    $barangNonActive = $db->table('products')->select('nama_product , qty')->where('is_active', 0)->get()->getResultArray();
    

    return [
        'total_produk'           => $totalProduk,
        'total_stok'             => $totalStok,
        'total_nilai_inventori'  => $totalNilai,
        'nilai_non_aktif'        => (int) ($nilaiNonAktif['total'] ?? 0),
        'barang_non_aktif'       => $barangNonActive
    ];
}

    /**
     * Jumlah SKU per kategori (untuk chart / tabel ringkas).
     *
     * @return list<array{kategori:string, qty:int}>
     */
    public function getCountByCategory(): array
    {
        $rows = $this->db->table('products')
            ->select('kategori, COUNT(*) AS qty')
            ->groupBy('kategori')
            ->orderBy('kategori', 'ASC')
            ->get()
            ->getResultArray();

        $out = [];
        foreach ($rows as $row) {
            $out[] = [
                'kategori' => (string) ($row['kategori'] ?? ''),
                'qty'   => (int) ($row['qty'] ?? 0),
            ];
        }

        return $out;
    }

    /**
     * Produk dengan stok menipis (untuk alert).
     *
     * @return list<array<string, mixed>>
     */
    public function getLowStockProducts(int $maxQty = 5, int $limit = 8): array
    {
        return $this->db->table('products')
            ->where('qty <=', $maxQty)
            ->where('qty >', 0)
            ->orderBy('qty', 'ASC')
            ->limit($limit)
            ->get()
            ->getResultArray();
    }

    /**
     * Produk habis stok.
     *
     * @return list<array<string, mixed>>
     */
    public function getOutOfStockProducts(int $limit = 10): array
    {
        return $this->db->table('products')
            ->where('qty', 0)
            ->orderBy('updated_at', 'DESC')
            ->limit($limit)
            ->get()
            ->getResultArray();
    }
 public function getDailyOmzet(): float
{
    $row = $this->db->table('transaksi')
              ->selectSum('total', 'omzet')
              ->get()
              ->getRowArray();

    return (float) ($row['omzet'] ?? 0);
}
}
