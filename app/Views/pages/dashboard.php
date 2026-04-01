<?= $this->extend('layout/dashboard_template') ?>

<?= $this->section('content') ?>

<?php
$stats = $stats ?? [];
$by_category = $by_category ?? [];
$low_stock = $low_stock ?? [];
$out_of_stock = $out_of_stock ?? [];

$labelKategori = static function (string $k): string {
    return match ($k) {
        'gunpla' => 'Gunpla',
        'tcg'    => 'TCG',
        'figure' => 'Figures',
        'tools'  => 'Tools',
        'paints' => 'Paints',
        default  => ucfirst($k),
    };
};
?>

<!-- Stat cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-10">
    <div class="bg-zinc-900 border border-zinc-800 rounded-xl p-5 hover:border-blue-500/30 transition-colors">
        <p class="text-[10px] font-bold uppercase tracking-[0.25em] text-zinc-500 mb-2">Total SKU</p>
        <p class="text-3xl font-black text-white tabular-nums"><?= number_format((int) ($stats['total_produk'] ?? 0), 0, ',', '.') ?></p>
        <p class="text-xs text-zinc-500 mt-1">Produk aktif di katalog</p>
    </div>
    <div class="bg-zinc-900 border border-zinc-800 rounded-xl p-5 hover:border-emerald-500/30 transition-colors">
        <p class="text-[10px] font-bold uppercase tracking-[0.25em] text-zinc-500 mb-2">Total stok unit</p>
        <p class="text-3xl font-black text-emerald-400 tabular-nums"><?= number_format((int) ($stats['total_stok'] ?? 0), 0, ',', '.') ?></p>
        <p class="text-xs text-zinc-500 mt-1">Jumlah unit tersedia</p>
    </div>
    <div class="bg-zinc-900 border border-zinc-800 rounded-xl p-5 hover:border-amber-500/30 transition-colors">
        <p class="text-[10px] font-bold uppercase tracking-[0.25em] text-zinc-500 mb-2">Nilai inventori</p>
        <p class="text-2xl md:text-3xl font-black text-amber-400 tabular-nums leading-tight">
            Rp <?= number_format((float) ($stats['total_nilai_inventori'] ?? 0), 0, ',', '.') ?>
        </p>
        <p class="text-xs text-zinc-500 mt-1">Σ (harga × jumlah)</p>
    </div>
    <div class="bg-zinc-900 border border-zinc-800 rounded-xl p-5 hover:border-zinc-600 transition-colors">
        <p class="text-[10px] font-bold uppercase tracking-[0.25em] text-zinc-500 mb-2">Kondisi</p>
        <div class="flex gap-6 mt-1">
            <div>
                <p class="text-2xl font-black text-blue-400 tabular-nums"><?= (int) ($stats['produk_baru'] ?? 0) ?></p>
                <p class="text-[10px] uppercase text-zinc-500">Baru</p>
            </div>
            <div>
                <p class="text-2xl font-black text-zinc-400 tabular-nums"><?= (int) ($stats['produk_bekas'] ?? 0) ?></p>
                <p class="text-[10px] uppercase text-zinc-500">Bekas</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Per kategori -->
    <div class="lg:col-span-1 bg-zinc-900 border border-zinc-800 rounded-xl overflow-hidden">
        <div class="px-5 py-4 border-b border-zinc-800 flex items-center justify-between">
            <h2 class="font-black text-sm uppercase tracking-wider text-white">Per kategori</h2>
            <span class="text-[10px] text-zinc-500 font-bold uppercase">SKU</span>
        </div>
        <ul class="divide-y divide-zinc-800">
            <?php if ($by_category === []): ?>
                <li class="px-5 py-8 text-center text-zinc-500 text-sm">Belum ada data produk.</li>
            <?php else: ?>
                <?php foreach ($by_category as $row): ?>
                    <li class="px-5 py-3 flex items-center justify-between gap-3">
                        <span class="text-sm font-semibold text-zinc-200"><?= esc($labelKategori($row['kategori'])) ?></span>
                        <span class="text-sm font-black text-blue-400 tabular-nums"><?= (int) $row['jumlah'] ?></span>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>

    <!-- Stok menipis & habis -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-zinc-900 border border-zinc-800 rounded-xl overflow-hidden">
            <div class="px-5 py-4 border-b border-zinc-800 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse shrink-0"></span>
                <h2 class="font-black text-sm uppercase tracking-wider text-white">Stok menipis (≤5)</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="table table-sm w-full">
                    <thead class="text-[10px] uppercase tracking-wider text-zinc-500">
                        <tr>
                            <th class="bg-zinc-900">Kode</th>
                            <th class="bg-zinc-900">Nama</th>
                            <th class="bg-zinc-900">Kategori</th>
                            <th class="bg-zinc-900 text-right">Stok</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        <?php if ($low_stock === []): ?>
                            <tr>
                                <td colspan="4" class="text-center text-zinc-500 py-8">Tidak ada SKU di bawah ambang.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($low_stock as $p): ?>
                                <tr class="border-zinc-800">
                                    <td class="font-mono text-xs text-zinc-400"><?= esc($p['kode_product'] ?? '') ?></td>
                                    <td class="font-medium text-zinc-200 max-w-[200px] truncate"><?= esc($p['nama_product'] ?? '') ?></td>
                                    <td class="text-blue-400/90 text-xs uppercase"><?= esc($p['kategori'] ?? '') ?></td>
                                    <td class="text-right font-black text-amber-400 tabular-nums"><?= (int) ($p['jumlah'] ?? 0) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php if ($out_of_stock !== []): ?>
        <div class="bg-zinc-900 border border-red-900/40 rounded-xl overflow-hidden">
            <div class="px-5 py-4 border-b border-zinc-800 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-red-500 shrink-0"></span>
                <h2 class="font-black text-sm uppercase tracking-wider text-white">Habis stok</h2>
            </div>
            <ul class="divide-y divide-zinc-800">
                <?php foreach ($out_of_stock as $p): ?>
                    <li class="px-5 py-3 flex flex-wrap items-center justify-between gap-2">
                        <span class="text-sm font-medium text-zinc-200"><?= esc($p['nama_product'] ?? '') ?></span>
                        <span class="text-xs font-bold text-red-400 uppercase">Restock needed</span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
