<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Hobby Shop</title>
</head>
<body class="bg-slate-900 text-white">

    <!-- nav -->
    <nav class="sticky top-0 z-50 bg-zinc-950/80 backdrop-blur-md border-b border-zinc-800">
    <div class="container mx-auto px-4 md:px-6 py-4 flex items-center justify-between">
      <a href="#" class="text-2xl font-black tracking-tighter text-white">
        AMBATOYS HOBBY SHOP<span class="text-blue-600">.</span>
      </a>

      <div class="hidden md:flex space-x-8 items-center font-semibold text-sm">
        <a href="#" class="text-zinc-300 hover:text-white transition-colors">GUNPLA</a>
        <a href="#" class="text-zinc-300 hover:text-white transition-colors">TCG</a>
        <a href="#" class="text-zinc-300 hover:text-white transition-colors">FIGURES</a>
        <a href="#" class="text-zinc-300 hover:text-white transition-colors">TOOLS & PAINTS</a>
      </div>

      <div class="flex items-center space-x-4">
        <div class="relative hidden sm:block">
          <input type="text" placeholder="Cari mokit, pokemon..." class="bg-zinc-900 border border-zinc-700 text-sm rounded-full px-4 py-2 w-64 focus:outline-none focus:border-blue-500 text-white placeholder-zinc-500 transition-colors">
        </div>
        <button class="text-zinc-300 hover:text-white relative">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
          </svg>
          <span class="absolute -top-1 -right-1 bg-blue-600 text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center">2</span>
        </button>
      </div>
    </div>
  </nav>
  <!-- end -->

 
<!-- banner -->
 <section>
    <?= $this->renderSection('banner') ?>
 </section>
<!-- banner end-->


  <!-- content -->
   <main class="container mx-auto p-6">
    <?= $this->renderSection('content') ?>
   </main>
  <!-- end -->

  <!-- footer -->
   <footer class="bg-zinc-950 border-t border-zinc-800 pt-12 pb-8 mt-12">
    <div class="container mx-auto px-4 md:px-6">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
        <div class="col-span-1 md:col-span-2">
          <h3 class="text-xl font-black tracking-tighter text-white mb-4">KOLEKTOR<span class="text-blue-600">.</span></h3>
          <p class="text-zinc-500 text-sm max-w-sm">Destinasi utama untuk para kolektor. Menyediakan berbagai macam model kit, action figure, dan trading card original terlengkap.</p>
        </div>
        <div>
          <h4 class="font-bold text-white mb-4 uppercase text-sm tracking-wider">Kategori</h4>
          <ul class="space-y-2 text-sm text-zinc-400">
            <li><a href="#" class="hover:text-blue-400 transition-colors">Model Kits</a></li>
            <li><a href="#" class="hover:text-blue-400 transition-colors">Trading Cards</a></li>
            <li><a href="#" class="hover:text-blue-400 transition-colors">Scale Figures</a></li>
            <li><a href="#" class="hover:text-blue-400 transition-colors">Paints & Tools</a></li>
          </ul>
        </div>
        <div>
          <h4 class="font-bold text-white mb-4 uppercase text-sm tracking-wider">Bantuan</h4>
          <ul class="space-y-2 text-sm text-zinc-400">
            <li><a href="#" class="hover:text-white transition-colors">Cara Pemesanan</a></li>
            <li><a href="#" class="hover:text-white transition-colors">Syarat Pre-Order</a></li>
            <li><a href="#" class="hover:text-white transition-colors">Konfirmasi Pembayaran</a></li>
            <li><a href="#" class="hover:text-white transition-colors">Hubungi Kami</a></li>
          </ul>
        </div>
      </div>
      <div class="border-t border-zinc-800 pt-8 flex flex-col md:flex-row justify-between items-center">
        <p class="text-zinc-600 text-sm">&copy; 2026 Kolektor Hobby Shop. All rights reserved.</p>
      </div>
    </div>
  </footer>
</body>
<script src="/assets/js/index.js"></script>
</html>
  <!-- footer end-->

</body>
</html>
