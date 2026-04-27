<?= $this->extend('layout/dashboard_template'); ?>

<?= $this->section('content'); ?>
<?php
$filterType = $filter_type ?? 'harian';
$tanggal = $tanggal ?? '';
$minggu = $minggu ?? '';
$bulan = $bulan ?? '';
?>
<div class="p-6 bg-zinc-900 min-h-screen text-white">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-primary italic">Riwayat Penjualan</h1>
            <p class="text-sm text-gray-500">Daftar transaksi AmbaToys</p>
        </div>
        <button class="btn btn-outline btn-primary btn-sm">Download PDF (coming soon)</button>
    </div>

    <form method="get" action="<?= base_url('/penjualan') ?>" class="mb-6 bg-zinc-800 rounded-xl border border-zinc-700 p-4">
        <div class="grid grid-cols-1 md:grid-cols-6 gap-3 items-end">
            <div class="md:col-span-2">
                <label class="text-xs uppercase tracking-wider text-zinc-400 font-bold">Jenis Filter</label>
                <select name="filter" id="filter_type" class="select select-bordered w-full bg-zinc-900 border-zinc-700 mt-1">
                    <option value="harian" <?= $filterType === 'harian' ? 'selected' : '' ?>>Harian (per tanggal)</option>
                    <option value="mingguan" <?= $filterType === 'mingguan' ? 'selected' : '' ?>>Mingguan</option>
                    <option value="bulanan" <?= $filterType === 'bulanan' ? 'selected' : '' ?>>Bulanan</option>
                </select>
            </div>

            <div class="md:col-span-2 filter-input" data-type="harian" <?= $filterType === 'harian' ? '' : 'style="display:none;"' ?>>
                <label class="text-xs uppercase tracking-wider text-zinc-400 font-bold">Tanggal</label>
                <input type="date" name="tanggal" value="<?= esc($tanggal) ?>" class="input input-bordered w-full bg-zinc-900 border-zinc-700 mt-1">
            </div>

            <div class="md:col-span-2 filter-input" data-type="mingguan" <?= $filterType === 'mingguan' ? '' : 'style="display:none;"' ?>>
                <label class="text-xs uppercase tracking-wider text-zinc-400 font-bold">Minggu</label>
                <input type="week" name="minggu" value="<?= esc($minggu) ?>" class="input input-bordered w-full bg-zinc-900 border-zinc-700 mt-1">
            </div>

            <div class="md:col-span-2 filter-input" data-type="bulanan" <?= $filterType === 'bulanan' ? '' : 'style="display:none;"' ?>>
                <label class="text-xs uppercase tracking-wider text-zinc-400 font-bold">Bulan</label>
                <input type="month" name="bulan" value="<?= esc($bulan) ?>" class="input input-bordered w-full bg-zinc-900 border-zinc-700 mt-1">
            </div>

            <div class="md:col-span-2 flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm">Terapkan</button>
                <a href="<?= base_url('/penjualan') ?>" class="btn btn-ghost btn-sm">Reset</a>
            </div>
        </div>
    </form>

    <div class="bg-zinc-800 rounded-xl shadow-2xl border border-zinc-700">
        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead class="bg-zinc-700/50 text-gray-300">
                    <tr>
                        <th class="rounded-tl-xl">ID Transaksi</th>
                        <th>Waktu</th>
                        <th>Total Bayar</th>
                        <th class="text-center rounded-tr-xl">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($transaction === []): ?>
                        <tr>
                            <td colspan="4" class="text-center py-10 text-gray-400 italic">Tidak ada transaksi untuk filter yang dipilih.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($transaction as $t): ?>
                        <tr class="hover:bg-zinc-700/30 border-b border-zinc-700/50">
                            <td class="font-mono text-sm text-primary font-semibold">#TX-<?= $t['id'] ?></td>
                            <td class="text-gray-300"><?= date('d M Y, H:i', strtotime($t['created_at'])) ?></td>
                            <td class="font-bold text-success text-lg">Rp <?= number_format($t['total'], 0, ',', '.') ?></td>
                            <td class="text-center">
                                <button onclick="document.getElementById('modal_detail_<?= $t['id'] ?>').showModal()" class="btn btn-ghost btn-sm text-info hover:bg-info/10">
                                    Detail
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php foreach ($transaction as $t): ?>
<dialog id="modal_detail_<?= $t['id'] ?>" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box bg-zinc-800 border border-zinc-700 max-w-3xl">
        <div class="flex justify-between items-center mb-4 border-b border-zinc-700 pb-3">
            <h3 class="font-bold text-xl text-primary">Detail Transaksi #<?= $t['id'] ?></h3>
            <span class="text-xs text-gray-500 font-mono"><?= $t['created_at'] ?></span>
        </div>
        
        <div class="overflow-x-auto rounded-lg border border-zinc-700">
            <table class="table w-full bg-zinc-900">
                <thead class="text-gray-400 bg-zinc-800">
                    <tr>
                        <th>Barang</th> 
                        <th class="text-right">Harga</th>
                        <th class="text-center">Qty</th>
                        <th class="text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($t['items'])): ?>
                        <?php foreach ($t['items'] as $item): ?>
                        <tr class="border-zinc-800 hover:bg-zinc-800/50 text-gray-200">
                            <td>
                                <div class="font-bold text-white"><?= $item['nama_product'] ?></div>
                                <div class="text-[10px] opacity-50 font-mono italic">UID: <?= $item['product_id'] ?></div>
                            </td>
                            <td class="text-right">Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                            <td class="text-center bg-zinc-800/30 font-bold"><?= $item['qty'] ?></td>
                            <td class="text-right font-bold text-primary">Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4" class="text-center py-10 text-gray-500 italic">Data item tidak ditemukan</td></tr>
                    <?php endif; ?>
                </tbody>
                <tfoot class="bg-zinc-800">
                    <tr>
                        <th colspan="3" class="text-right text-white">Grand Total:</th>
                        <th class="text-right text-success text-lg font-bold italic underline">Rp <?= number_format($t['total'], 0, ',', '.') ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="modal-action">
            <form method="dialog">
                <button class="btn btn-primary btn-sm px-8">Tutup</button>
            </form>
        </div>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>
<?php endforeach; ?>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const filterSelect = document.getElementById('filter_type');
        const filterInputs = document.querySelectorAll('.filter-input');

        const toggleInputs = () => {
            const selected = filterSelect.value;
            filterInputs.forEach((el) => {
                el.style.display = el.dataset.type === selected ? '' : 'none';
            });
        };

        filterSelect.addEventListener('change', toggleInputs);
        toggleInputs();
    });
</script>

<?= $this->endSection(); ?>