<?= $this->extend('layout/auth_template') ?>

<?= $this->section('content') ?>

<div class="bg-zinc-900 border border-zinc-800 rounded-2xl overflow-hidden">
    <div class="p-6 border-b border-zinc-800">
        <p class="text-[10px] font-bold uppercase tracking-[0.35em] text-blue-500">POS Access</p>
        <h1 class="text-xl font-black tracking-tight text-white mt-1"><?= esc($page_heading ?? 'Login') ?></h1>
        <p class="text-sm text-zinc-400 mt-1">Masuk untuk mulai transaksi dan kelola produk.</p>
    </div>

    <div class="p-6">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-error bg-red-950/40 border border-red-900/50 text-red-200 mb-4">
                <span class="text-sm"><?= esc(session()->getFlashdata('error')) ?></span>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= base_url('/login') ?>" class="space-y-4">
            <?= csrf_field() ?>

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text text-zinc-300 text-sm">Email</span>
                </div>
                <input
                    name="email"
                    type="text"
                    autocomplete="username"
                    placeholder="kasir@gmail.com"
                    value="<?= esc(old('email')) ?>"
                    class="input input-bordered w-full bg-zinc-950 border-zinc-700 text-zinc-100 placeholder:text-zinc-600 focus:border-blue-500"
                    required
                />
            </label>

            <label class="form-control w-full">
                <div class="label flex items-center justify-between mt-5">
                    <span class="label-text text-zinc-300 text-sm">Password</span>
                </div>
                <input
                    name="password"
                    type="password"
                    autocomplete="current-password"
                    placeholder="••••••••"
                    class="input input-bordered w-full bg-zinc-950 border-zinc-700 text-zinc-100 placeholder:text-zinc-600 focus:border-blue-500"
                    required
                />
            </label>

            <button type="submit" class="btn w-full bg-blue-600 hover:bg-blue-500 border-0 text-white font-black tracking-wider uppercase mt-10">
                Masuk
            </button>

            <p class="text-xs text-zinc-500 mt-3">
                Gunakan akun user aktif untuk masuk ke dashboard POS.
            </p>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

