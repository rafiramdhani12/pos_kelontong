<?= $this->extend('layout/dashboard_template') ?>

<?= $this->section('content') ?>

<?php
$products = $products ?? [];
$keyword = $keyword ?? '';
?>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    <section class="xl:col-span-2 bg-zinc-900 border border-zinc-800 rounded-xl overflow-hidden">
        <div class="p-4 md:p-5 border-b border-zinc-800 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-blue-500">POS</p>
                <h2 class="text-lg font-black text-white">Pilih item belanja</h2>
            </div>
            <form method="get" action="<?= base_url('/kasir') ?>" class="w-full md:w-auto">
                <label class="input input-bordered bg-zinc-950 border-zinc-700 flex items-center gap-2 w-full md:w-80">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-zinc-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 3a6 6 0 104.472 10.001l3.763 3.764a1 1 0 001.414-1.414l-3.764-3.763A6 6 0 009 3zm-4 6a4 4 0 118 0 4 4 0 01-8 0z" clip-rule="evenodd" />
                    </svg>
                    <input type="text" name="q" value="<?= esc($keyword) ?>" placeholder="Cari nama / kode produk" class="grow" />
                </label>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr class="text-zinc-500 text-[10px] uppercase tracking-wider">
                        <th>SKU</th>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th class="text-right">Stok</th>
                        <th class="text-right">Harga</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($products === []): ?>
                        <tr>
                            <td colspan="6" class="text-center py-10 text-zinc-500">Produk tidak ditemukan.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($products as $product): ?>
                            <tr class="border-zinc-800">
                                <td class="font-mono text-xs text-zinc-400"><?= esc($product['kode_product']) ?></td>
                                <td class="font-semibold text-zinc-200"><?= esc($product['nama_product']) ?></td>
                                <td class="text-xs uppercase text-blue-400/90"><?= esc($product['kategori']) ?></td>
                                <td class="text-right font-bold text-zinc-300"><?= (int) $product['jumlah'] ?></td>
                                <td class="text-right font-black text-emerald-400">
                                    Rp <?= number_format((float) $product['harga'], 0, ',', '.') ?>
                                </td>
                                <td class="text-right">
                                    <button type="button" class="btn btn-xs bg-blue-600 hover:bg-blue-500 border-0 text-white" disabled>
                                        + Keranjang
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

    <aside class="bg-zinc-900 border border-zinc-800 rounded-xl p-5 h-fit">
        <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-blue-500 mb-2">Checkout</p>
        <h3 class="text-lg font-black text-white">Keranjang kasir</h3>
        <p class="text-sm text-zinc-500 mt-1">Struktur POS siap, tinggal sambungkan aksi tambah item & pembayaran.</p>

        <div class="mt-6 space-y-3">
            <div class="flex items-center justify-between text-sm">
                <span class="text-zinc-400">Subtotal</span>
                <span class="font-bold text-zinc-200">Rp 0</span>
            </div>
            <div class="flex items-center justify-between text-sm">
                <span class="text-zinc-400">Diskon</span>
                <span class="font-bold text-zinc-200">Rp 0</span>
            </div>
            <div class="border-t border-zinc-800 pt-3 flex items-center justify-between">
                <span class="text-zinc-300 font-semibold">Total Bayar</span>
                <span class="text-xl font-black text-emerald-400">Rp 0</span>
            </div>
        </div>

        <button type="button" class="btn w-full mt-6 bg-blue-600 hover:bg-blue-500 text-white border-0" disabled>
            Proses Pembayaran
        </button>
        <p class="text-xs text-zinc-600 mt-3">Tahap berikutnya: aktifkan session cart + simpan transaksi.</p>
    </aside>
</div>

<?= $this->endSection() ?>

