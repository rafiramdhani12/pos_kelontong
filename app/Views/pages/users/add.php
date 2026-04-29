<?= $this->extend('layout/dashboard_template'); ?>

<?= $this->section('content'); ?>

<div class="max-w-xl">
    <h2 class="text-xl font-bold mb-4">Tambah User</h2>

    <form action="<?= base_url('/users/store') ?>" method="post" class="space-y-4">

        <input type="text" name="name" placeholder="Nama"
            class="input input-bordered w-full bg-zinc-900" required>

        <input type="email" name="email" placeholder="Email"
            class="input input-bordered w-full bg-zinc-900" required>

        <input type="password" name="password" placeholder="Password"
            class="input input-bordered w-full bg-zinc-900" required>

        <button class="btn bg-blue-600 border-none w-full">
            Simpan
        </button>
    </form>
</div>

<?= $this->endSection(); ?>