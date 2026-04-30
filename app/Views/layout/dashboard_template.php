<?php $currentPath = trim(service('uri')->getPath(), '/'); ?>

<?php
$menus = [
    [
        'label' => 'Kasir',
        'd' => 'M3 7h18M3 12h18m-7 5h7',
        'link' => base_url('/kasir'),
        'active' => $currentPath === 'kasir'
    ],
    [
        'label' => 'Dashboard',
        'd' => 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z',
        'link' => base_url('/dashboard'),
        'active' => $currentPath === 'dashboard'
    ],
    [
        'label' => 'Penjualan',
        'd' => 'M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25',
        'link' => base_url('/kasir/penjualan'),
        'active' => $currentPath === 'penjualan'
    ],
    [
        'label' => 'Products (Master)',
        'xmlns' => 'http://www.w3.org/2000/svg',
        'd' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
        'link' => base_url('/products'),
        'active' => 'barang'
    ],
    [
        'label' => 'Users (Master)',
        'xmlns' => 'http://www.w3.org/2000/svg',
        'd' => 'M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z',
        'link' => base_url('/users'),
        'active' => 'users'
    ]
]

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <title><?= esc($title ?? 'Dashboard — AmbaToys') ?></title>
</head>
<body class="bg-zinc-950 text-zinc-100 min-h-screen flex flex-col md:flex-row">

    <!-- Sidebar -->
    <aside class="w-full md:w-64 shrink-0 border-b md:border-b-0 md:border-r border-zinc-800 bg-zinc-950/95 md:min-h-screen md:sticky md:top-0 md:self-start">
        <div class="p-4 md:p-6 flex flex-col gap-6">
            <a href="<?= base_url('/') ?>" class="text-xl font-black tracking-tighter text-white">
                POS SYSTEM<span class="text-blue-600">.</span>
            </a>
            <span class="text-[10px] font-bold uppercase tracking-[0.35em] text-blue-500/90">Admin</span>

            <nav class="flex flex-row md:flex-col gap-1 overflow-x-auto md:overflow-visible pb-2 md:pb-0 -mx-1 px-1">
                <?php foreach ($menus as $menu) : ?>

                    <?php
                        $isOwnerMenu = ($menu['label'] === 'Barang (Master)') ;
                        $isNotOwner = (session()->get('user_role') !== 'owner') ;
                        if($isOwnerMenu && $isNotOwner) continue;
                    ?>

                <a href="<?= $menu['link'] ?>"
                  class="shrink-0 flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold 
   <?= ($currentPath === "kasir") ? 'bg-blue-600/15 text-blue-400 border border-blue-500/30' : 'text-zinc-300 hover:text-white border border-transparent hover:border-zinc-700' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="<?= $menu['d'] ?>" />
                    </svg>
                    <?= $menu['label'] ?>
                </a>
                <?php endforeach?>
            </nav>

            <a href="<?= base_url('/logout') ?>" class="hidden md:flex items-center gap-2 text-sm text-zinc-400 hover:text-blue-400 transition-colors mt-auto pt-4 border-t border-zinc-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 11-4 0V7a2 2 0 114 0v1" />
                </svg>
                Logout
            </a>
            <a href="<?= base_url('/') ?>" class="hidden md:flex items-center gap-2 text-sm text-zinc-500 hover:text-blue-400 transition-colors mt-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke toko
            </a>
        </div>
    </aside>

    <!-- Main -->
    <div class="flex-1 flex flex-col min-w-0">
        <header class="border-b border-zinc-800 bg-zinc-950/80 backdrop-blur-md px-4 md:px-8 py-4 flex items-center justify-between gap-4">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-blue-500">Panel</p>
                <h1 class="text-lg md:text-xl font-black tracking-tight text-white"><?= esc($page_heading ?? 'Ringkasan') ?></h1>
            </div>
            <a href="<?= base_url('/logout') ?>" class="md:hidden btn btn-sm btn-ghost text-zinc-400">Logout</a>
        </header>

        <main class="flex-1 p-4 md:p-8">
            <?= $this->renderSection('content') ?>
        </main>

        <footer class="border-t border-zinc-800 px-4 md:px-8 py-4 text-center md:text-left">
            <p class="text-zinc-600 text-xs">&copy; <?= date('Y') ?> Toko Arya dashboard.</p>
        </footer>
    </div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/assets/js/index.js"></script>
</body>
</html>
