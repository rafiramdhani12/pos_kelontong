<?= $this->extend('layout/dashboard_template'); ?>

<?= $this->section('content'); ?>
<div class="p-6 bg-zinc-900 min-h-screen text-white">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-primary italic">Log Audit Trail</h1>
            <p class="text-sm text-gray-500">Catatan pembatalan (rollback) transaksi</p>
        </div>
    </div>

    <div class="bg-zinc-800 rounded-xl shadow-2xl border border-zinc-700">
        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead class="bg-zinc-700/50 text-gray-300">
                    <tr>
                        <th class="rounded-tl-xl">Waktu Kejadian</th>
                        <th>User (Pelaku)</th>
                        <th>ID Detail</th>
                        <th class="text-right">Nominal</th>
                        <th class="rounded-tr-xl">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($audits)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-10 text-gray-400 italic">Belum ada catatan audit trail.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($audits as $a): ?>
                        <tr class="hover:bg-zinc-700/30 border-b border-zinc-700/50">
                            <td class="text-gray-300"><?= date('d M Y, H:i:s', strtotime($a['created_at'])) ?></td>
                            <td class="font-bold text-emerald-400"><?= esc($a['nama_user']) ?></td>
                            <td class="font-mono text-sm">#DT-<?= $a['detail_transaksi_id'] ?></td>
                            <td class="text-right font-bold text-success">Rp <?= number_format($a['nominal'], 0, ',', '.') ?></td>
                            <td>
                                <span class="badge badge-error badge-sm">Rollback</span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
