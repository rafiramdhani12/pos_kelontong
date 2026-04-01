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

        $totalProduk = (int) $this->countAll();

        $stokRow = $db->table('products')
            ->selectSum('jumlah', 'total_stok')
            ->get()
            ->getRowArray();
        $totalStok = (int) ($stokRow['total_stok'] ?? 0);

        $nilaiRow = $db->query(
            'SELECT COALESCE(SUM(harga * jumlah), 0) AS total_nilai FROM products'
        )->getRowArray();
        $totalNilai = (float) ($nilaiRow['total_nilai'] ?? 0);

        $kondisi = $db->table('products')
            ->select('kondisi, COUNT(*) AS c')
            ->groupBy('kondisi')
            ->get()
            ->getResultArray();

        $baru = 0;
        $bekas = 0;
        foreach ($kondisi as $row) {
            if (($row['kondisi'] ?? '') === 'new') {
                $baru = (int) $row['c'];
            }
            if (($row['kondisi'] ?? '') === 'used') {
                $bekas = (int) $row['c'];
            }
        }

        return [
            'total_produk'           => $totalProduk,
            'total_stok'             => $totalStok,
            'total_nilai_inventori' => $totalNilai,
            'produk_baru'            => $baru,
            'produk_bekas'           => $bekas,
        ];
    }

    /**
     * Jumlah SKU per kategori (untuk chart / tabel ringkas).
     *
     * @return list<array{kategori:string, jumlah:int}>
     */
    public function getCountByCategory(): array
    {
        $rows = $this->db->table('products')
            ->select('kategori, COUNT(*) AS jumlah')
            ->groupBy('kategori')
            ->orderBy('kategori', 'ASC')
            ->get()
            ->getResultArray();

        $out = [];
        foreach ($rows as $row) {
            $out[] = [
                'kategori' => (string) ($row['kategori'] ?? ''),
                'jumlah'   => (int) ($row['jumlah'] ?? 0),
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
            ->where('jumlah <=', $maxQty)
            ->where('jumlah >', 0)
            ->orderBy('jumlah', 'ASC')
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
            ->where('jumlah', 0)
            ->orderBy('updated_at', 'DESC')
            ->limit($limit)
            ->get()
            ->getResultArray();
    }
}
