<?= $this->extend('layout/dashboard_template'); ?>

<?= $this->section('content'); ?>

<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-xl font-bold text-white">Manajemen User</h2>
        <p class="text-sm text-zinc-500">Kelola akun pengguna sistem</p>
    </div>

    <a href="<?= base_url('/users/add') ?>" class="btn btn-sm bg-blue-600 hover:bg-blue-700 border-none text-white">
        + Tambah User
    </a>
</div>

<div class="overflow-x-auto bg-zinc-900 border border-zinc-800 rounded-xl">
    <table class="table">
        <thead>
            <tr class="text-zinc-400 text-xs uppercase">
                <th>#</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Status</th>
                <th class="text-right">Aksi</th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($users as $i => $user): ?>
            <tr class="hover">
                <td><?= $i + 1 ?></td>

                <td class="font-semibold text-white">
                    <?= esc($user['nama']) ?>
                </td>

                <td class="text-zinc-400">
                    <?= esc($user['email']) ?>
                </td>

                <td>
                    <?php if ($user['is_active']) : ?>
                        <span class="badge badge-success badge-sm">Active</span>
                    <?php else: ?>
                        <span class="badge badge-error badge-sm">Inactive</span>
                    <?php endif; ?>
                </td>

                <td class="text-right">
                    <div class="flex justify-end gap-2">

                        <!-- Edit -->
                        <a href="<?= base_url('/users/edit/' . $user['id']) ?>"
                           class="btn btn-xs btn-ghost text-blue-400">
                           Edit
                        </a>

                        <!-- Deactivate -->
                        <?php if ($user['is_active']) : ?>
                        <form action="<?= base_url('/users/deactive/' . $user['id']) ?>" method="post">
                            <button class="btn btn-xs btn-warning text-black">
                                Deactive
                            </button>
                        </form>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>

        </tbody>
    </table>
</div>
<?= $this->endSection(); ?>