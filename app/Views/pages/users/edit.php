<?= $this->extend('layout/dashboard_template'); ?>

<?= $this->section('content'); ?>

<div class="max-w-xl">
    <h2 class="text-xl font-bold mb-4">Edit User</h2>

    <form action="<?= base_url('/users/update/' . $user['id']) ?>" method="post" class="space-y-4">

        <input type="text" name="nama" value="<?= esc($user['nama']) ?>"
            class="input input-bordered w-full bg-zinc-900" required>

        <input type="email" name="email" value="<?= esc($user['email']) ?>"
            class="input input-bordered w-full bg-zinc-900" required>

        <input type="password" name="password" placeholder="Password baru (opsional)"
            class="input input-bordered w-full bg-zinc-900">

        <label for="is_active">update active user</label>

        <button class="btn bg-blue-600 border-none w-full">
            Update
        </button>
    </form>
</div>

<?= $this->endSection(); ?>