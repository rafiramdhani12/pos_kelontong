<?= $this->extend('layout/template') ?> 

<?= $this->section('banner') ?>
 <!-- hero -->
 <div
  class="hero min-h-[60vh] md:min-h-screen"
  style="background-image: url(/assets/img/banner.png); background-size: cover; background-position: center;">
  <div class="hero-overlay" style="background-color: rgba(0,0,0,0.65);"></div>
  <div class="hero-content text-neutral-content text-center px-4">
    <div class="max-w-md">
      <h1 class="mb-4 text-3xl md:text-5xl font-bold leading-tight">Selamat datang di AmbaToys</h1>
      <p class="mb-5 text-sm md:text-base text-zinc-300 leading-relaxed">
        kami menyediakan banyak item hobby dari berbagai macam mokit , gunpla , tcg , dan action figure
      </p>
      <button class="btn btn-primary btn-sm md:btn-md">Get Started</button>
    </div>
  </div>
</div>
<!-- hero end-->
<?= $this->endSection() ?>


<?= $this->section('content') ?> 

<!-- new arrival -->
<div class="flex justify-between items-end mb-8">
    <div>
      <span class="text-blue-500 text-xs font-bold tracking-[0.25em] uppercase">Attention please!!!!</span>
      <h2 class="text-3xl font-black uppercase tracking-tight mt-1">New Arrival</h2>
      <p class="text-zinc-500 mt-1 text-sm">Kit dan figures yang dinantikan.</p>
    </div>
    <a href="#" class="hidden sm:inline-flex items-center gap-1 text-blue-400 font-semibold hover:text-blue-300 transition-colors text-sm">
      View All <span>&rarr;</span>
    </a>
</div>

<section class="relative bg-zinc-950 overflow-hidden border-y border-zinc-800">

  <!-- Mobile: gambar full background, opacity rendah -->
  <!-- Desktop: gambar 2/3 kanan dengan clip-path -->
  <img
    src="/assets/img/rg_unicorn_closeup.jpg"
    class="absolute inset-0 w-full h-full object-cover opacity-20
           md:opacity-40 md:left-auto md:right-0 md:w-2/3"
    style="object-position: center top;"
    alt="Gundam Unicorn"
  />

  <!-- Mobile: gradient dari bawah ke atas -->
  <!-- Desktop: gradient dari kiri ke kanan -->
  <div class="absolute inset-0 z-10
              bg-gradient-to-t from-zinc-950 via-zinc-950/80 to-zinc-950/50
              md:bg-gradient-to-r md:from-zinc-950 md:via-zinc-950/90 md:to-transparent">
  </div>

  <div class="relative z-20 container mx-auto px-6 py-14 md:py-0 md:h-[520px] md:flex md:items-center">
    <div>
      <span class="inline-block text-blue-400 font-bold tracking-[0.3em] uppercase text-xs mb-4 border border-blue-400/30 px-3 py-1">
        ✦ New Arrival
      </span>
      <h2 class="text-4xl md:text-6xl font-black text-white leading-none tracking-tight uppercase">
        GUNDAM<br/>UNICORN
      </h2>
      <p class="text-zinc-400 text-base md:text-xl italic mt-2 font-light tracking-wide">Perfectibility Divine</p>
      <div class="flex flex-wrap items-center gap-3 mt-8">
        <button class="bg-blue-600 hover:bg-blue-500 active:scale-95 text-white px-6 py-3 font-black uppercase tracking-widest text-sm transition-all duration-200">
          PRE-ORDER NOW
        </button>
        <a href="#" class="text-zinc-400 hover:text-white text-sm font-semibold transition-colors underline underline-offset-4">
          Lihat Detail →
        </a>
      </div>
    </div>
  </div>

</section>
<!-- new arrival end-->

<!-- carrousel -->

<div class="mx-auto px-4 md:px-6">

  <div class="flex justify-between items-end my-4">
    <div>
      <span class="text-blue-500 text-xs font-bold tracking-[0.25em] uppercase">This Week</span>
      <h2 class="text-3xl font-black uppercase tracking-tight mt-1">Trending Now</h2>
      <p class="text-zinc-500 mt-1 text-sm">Kit dan figures paling dicari minggu ini.</p>
    </div>
    <a href="#" class="hidden sm:inline-flex items-center gap-1 text-blue-400 font-semibold hover:text-blue-300 transition-colors text-sm">
      View All <span>&rarr;</span>
    </a>
  </div>

 <div class="carousel carousel-center w-full gap-4 rounded-box py-4">
  <div class="carousel-item w-72">
    <img src="..." class="rounded-box w-full h-64 object-cover" alt="" />
  </div>
  <div class="carousel-item w-72">
    <img src="..." class="rounded-box w-full h-64 object-cover" alt="" />
  </div>
</div>

<!-- carrousel end-->

<!-- restock -->

<div class="flex justify-between items-end mt-8">
    <div>
      <span class="text-blue-500 text-xs font-bold tracking-[0.25em] uppercase">Attention please!!!!</span>
      <h2 class="text-3xl font-black uppercase tracking-tight mt-1">Resctock Items</h2>
      <p class="text-zinc-500 mt-1 text-sm">Kit dan figures yang dinantikan.</p>
    </div>
    <a href="#" class="hidden sm:inline-flex items-center gap-1 text-blue-400 font-semibold hover:text-blue-300 transition-colors text-sm">
      View All <span>&rarr;</span>
    </a>
</div>

<section class="relative h-[55vh] min-h-[420px] flex items-center overflow-hidden bg-zinc-950 border-y border-zinc-800 mt-10 py-10">
  <div class="absolute inset-0 bg-gradient-to-r from-zinc-950 via-zinc-950/80 to-transparent z-10"></div>
  <img
    src="assets/img/hi_nu_gundam.webp"
    alt="RG Hi-Nu Gundam"
    class="absolute inset-0 w-full h-full object-cover opacity-30"
  />
  <div class="container mx-auto px-6 relative z-20">
    <span class="inline-flex items-center gap-2 text-emerald-400 font-bold tracking-widest text-xs uppercase mb-3">
      <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
      Restock Alert
    </span>
    <h1 class="text-5xl md:text-7xl font-black text-white leading-tight uppercase tracking-tight">
      Real Grade<br>
      <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-emerald-400">Hi-Nu Gundam</span>
    </h1>
    <p class="mt-4 text-zinc-400 max-w-lg text-base leading-relaxed">
      Detail ekstrim dan artikulasi maksimal dalam skala 1/144.<br>Amankan kit incaranmu sebelum kehabisan.
    </p>
    <button class="mt-8 bg-white text-zinc-950 hover:bg-zinc-100 active:scale-95 px-8 py-3 font-black uppercase tracking-widest text-sm transition-all duration-200">
      Shop Now
    </button>
  </div>
</section>

<!-- restock end -->

<!-- all product -->

<main class="container mx-auto px-4 md:px-6 py-16">

  <div class="flex justify-between items-end mb-8">
    <div>
      <span class="text-blue-500 text-xs font-bold tracking-[0.25em] uppercase">Featured</span>
      <h2 class="text-3xl font-black uppercase tracking-tight mt-1">Pilihan Terbaik</h2>
      <p class="text-zinc-500 mt-1 text-sm">Koleksi pilihan editor bulan ini.</p>
    </div>
    <a href="#" class="hidden sm:inline-flex items-center gap-1 text-blue-400 font-semibold hover:text-blue-300 transition-colors text-sm">
      View All <span>&rarr;</span>
    </a>
  </div>

  <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">

    <!-- Card -->
     <?php foreach($products as $product): ?>
  <div class="group flex flex-col bg-zinc-900 border border-zinc-800 hover:border-blue-500/50 transition-all duration-300 overflow-hidden">
  <div class="relative aspect-square bg-zinc-800 overflow-hidden">
    <span class="absolute top-2 left-2 bg-red-600 text-white text-[10px] px-2 py-1 font-black z-10 uppercase tracking-widest">
        <?= $product['kondisi'] == 'new' ? 'New Arrival' : 'Used' ?>
    </span>
    <img
      src="/assets/img/<?=$product['image']  ?>"
      alt="<?= $product['nama_product'] ?>"
      class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 opacity-80 group-hover:opacity-100"
    >
    <div class="absolute inset-0 bg-gradient-to-t from-zinc-900/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
  </div>
  <div class="p-4 flex flex-col flex-grow">
    <p class="text-[10px] text-blue-400 font-black uppercase tracking-[0.2em] mb-1"><?= $product['kategori'] ?></p>
    <h3 class="font-bold text-sm text-zinc-100 leading-snug mb-2 line-clamp-2"><?= $product['nama_product'] ?></h3>
    <div class="mt-auto flex justify-between items-center pt-3 border-t border-zinc-800">
      <span class="font-black text-emerald-400 text-sm">
        Rp <?= number_format($product['harga'], 0, ',', '.') ?>
      </span>
      <button class="w-7 h-7 flex items-center justify-center bg-zinc-800 hover:bg-blue-600 text-zinc-400 hover:text-white transition-all duration-200 rounded-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
        </svg>
      </button>
    </div>
  </div>
  </div>
  <?php endforeach ?>

  </div>
</main>

<!-- all product end-->


<?= $this->endSection() ?>