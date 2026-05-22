<?= $this->extend('layout/dashboard_template'); ?>

<?= $this->section('content'); ?>

<div class="max-w-xl mx-auto">

    <!-- Header -->
    <div class="mb-6">
        <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-blue-500">User</p>
        <h2 class="text-xl font-black text-white">Tambah User Baru</h2>
        <p class="text-xs text-zinc-500 mt-1">Buat akun baru untuk mengakses sistem</p>
    </div>

    <!-- Card -->
    <div class="bg-zinc-900 border border-zinc-800 rounded-xl p-6 shadow-sm">

        <!-- Error Message -->
        <?php if (session()->getFlashdata('errors')): ?>
            <div class="mb-4 text-sm text-red-400">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <p><?= $error ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('/users/store') ?>" method="post" class="space-y-5">

            <!-- Nama -->
            <div class="form-control">
                <label class="label pb-1">
                    <span class="label-text text-xs text-zinc-400 uppercase tracking-wider">Nama</span>
                </label>
                <input type="text" name="nama" placeholder="Masukkan nama"
                    class="input input-bordered w-full bg-zinc-950 border-zinc-700 focus:border-blue-500"
                    required>
            </div>

            <!-- Email -->
            <div class="form-control">
                <label class="label pb-1">
                    <span class="label-text text-xs text-zinc-400 uppercase tracking-wider">Email</span>
                </label>
                <input type="email" name="email" placeholder="Masukkan email"
                    class="input input-bordered w-full bg-zinc-950 border-zinc-700 focus:border-blue-500"
                    required>
            </div>

            <!-- Password -->
            <div class="form-control">
                <label class="label pb-1">
                    <span class="label-text text-xs text-zinc-400 uppercase tracking-wider">Password</span>
                </label>
                <input type="password" name="password" placeholder="Minimal 6 karakter"
                    class="input input-bordered w-full bg-zinc-950 border-zinc-700 focus:border-blue-500"
                    required>
            </div>

            <!-- Role -->
            <div class="form-control">
                <label class="label pb-1">
                    <span class="label-text text-xs text-zinc-400 uppercase tracking-wider">Role</span>
                </label>
                <select name="role"
                    class="select select-bordered w-full bg-zinc-950 border-zinc-700 focus:border-blue-500">
                    <option value="owner">Owner</option>
                    <option value="admin" selected>Kasir</option>
                </select>
            </div>

            <!-- Action -->
            <div class="flex justify-end gap-2 pt-4 border-t border-zinc-800">
                <a href="<?= base_url('/users') ?>"
                    class="btn btn-ghost btn-sm text-zinc-400">
                    Batal
                </a>
                <button class="btn btn-sm bg-blue-600 hover:bg-blue-500 border-none text-white font-bold">
                    Simpan User
                </button>
            </div>

        </form>
    </div>
</div>

<?= $this->endSection(); ?>