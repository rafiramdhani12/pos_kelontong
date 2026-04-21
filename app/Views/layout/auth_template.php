<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <title><?= esc($title ?? 'Login — AmbaToys') ?></title>
</head>
<body class="bg-zinc-950 text-zinc-100 min-h-screen">

    <div class="min-h-screen flex items-center justify-center px-4 py-10">
        <div class="w-full max-w-md">
            <div class="mb-6 text-center">
                <a href="<?= base_url('/') ?>" class="inline-flex items-baseline gap-1 text-white font-black tracking-tighter text-2xl">
                    Kelontong Arya<span class="text-blue-600">.</span>
                </a>
                <p class="mt-2 text-zinc-500 text-sm">
                    Panel POS / Admin
                </p>
            </div>

            <?= $this->renderSection('content') ?>

            <p class="mt-8 text-center text-xs text-zinc-600">
                &copy; 2026 Kelontong Arya. Login untuk akses POS.
            </p>
        </div>
    </div>

</body>
</html>

