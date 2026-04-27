<?= $this->extend('layout/dashboard_template') ?>
<?= $this->section('content') ?>

<?php
$products = $products ?? [];
$keyword  = $keyword ?? '';
$cart     = session()->get('cart') ?? [];
$subtotal = array_sum(array_map(fn($i) => $i['harga'] * $i['qty'], $cart));
$payment = 0;
?>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

    <!-- Panel kiri: daftar produk -->
    <section class="xl:col-span-2 bg-zinc-900 border border-zinc-800 rounded-xl overflow-hidden">
        <div class="p-4 md:p-5 border-b border-zinc-800 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-blue-500">POS</p>
                <h2 class="text-lg font-black text-white">Pilih item belanja</h2>
            </div>
            <form method="get" action="<?= base_url('/kasir') ?>" class="w-full md:w-auto">
                <label class="input input-bordered bg-zinc-950 border-zinc-700 flex items-center gap-2 w-full md:w-80">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-zinc-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 3a6 6 0 104.472 10.001l3.763 3.764a1 1 0 001.414-1.414l-3.764-3.763A6 6 0 009 3zm-4 6a4 4 0 118 0 4 4 0 01-8 0z" clip-rule="evenodd" />
                    </svg>
                    <input type="text" name="q" value="<?= esc($keyword) ?>" placeholder="Cari nama / kode produk" class="grow" />
                </label>
            </form>
        </div>

        <div class="p-4 md:p-5">
            <?php if (empty($products)): ?>
                <p class="text-zinc-500 text-sm text-center py-10">Produk tidak ditemukan.</p>
            <?php else: ?>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                    <?php foreach ($products as $product): ?>
                        <?php $habis = (int)$product['qty'] <= 0; ?>
                        <div class="bg-zinc-800 border border-zinc-700 rounded-xl overflow-hidden flex flex-col <?= $habis ? 'opacity-50' : '' ?>">
                            <div class="aspect-square overflow-hidden bg-zinc-700">
                                <?php if (!empty($product['image'])): ?>
                                    <img
                                        src="/assets/img/<?= esc($product['image']) ?>"
                                        alt="<?= esc($product['nama_product']) ?>"
                                        class="w-full h-full object-cover"
                                    />
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center text-zinc-500 text-xs">No image</div>
                                <?php endif; ?>
                            </div>
                            <div class="p-3 flex flex-col gap-1 flex-1">
                                <p class="text-[10px] uppercase tracking-wider text-blue-400"><?= esc($product['kategori']) ?></p>
                                <p class="text-sm font-semibold text-zinc-100 leading-tight"><?= esc($product['nama_product']) ?></p>
                                <p class="text-xs <?= $habis ? 'text-red-400' : 'text-zinc-400' ?>">
                                    Stok: <?= (int)$product['qty'] ?><?= $habis ? ' (Habis)' : '' ?>
                                </p>
                                <div class="mt-auto pt-2 flex items-center justify-between gap-2">
                                    <span class="text-sm font-black text-emerald-400">
                                        Rp <?= number_format((float)$product['harga'], 0, ',', '.') ?>
                                    </span>
                                   <button
                                        type="button"
                                        class="btn btn-xs bg-blue-600 hover:bg-blue-500 border-0 text-white"
                                        onclick="inputJumlah(<?= $product['id'] ?>, '<?= esc($product['nama_product']) ?>', <?= (int)$product['qty'] ?>)"
                                        <?= $habis ? 'disabled' : '' ?>
                                    >
                                        + Keranjang
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Panel kanan: keranjang -->
    <aside class="bg-zinc-900 border border-zinc-800 rounded-xl p-5 h-fit sticky top-4">
        <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-blue-500 mb-2">Checkout</p>
        <h3 class="text-lg font-black text-white mb-4">Keranjang kasir</h3>

        <!-- List item cart — diisi JS -->
        <div id="cart-items" class="space-y-2 mb-4 max-h-64 overflow-y-auto pr-1"></div>

        <div class="flex justify-between text-white">
            <span class="text-xs text-zinc-400">Pembayaran</span>
            <input type="number" name="payment" id="payment" placeholder="Rp0" oninput="kembalian()" >
        </div>
        
        <!-- Total -->
        <div class="space-y-3 border-t border-zinc-800 pt-4">
            <div class="flex items-center justify-between text-sm">
                <span class="text-zinc-400">Subtotal</span>
                <span class="font-bold text-zinc-200" id="cart-subtotal">Rp 0</span>
            </div>
            <div class="flex items-center justify-between text-sm">
            <span class="text-zinc-400">Pembayaran</span>
            <span class="font-bold text-zinc-200" id="cart-pembayaran">Rp 0</span>
        </div>
            <div class="border-t border-zinc-800 pt-3 flex items-center justify-between">
                <span class="text-zinc-300 font-semibold">Total Bayar</span>
                <span class="text-xl font-black text-emerald-400" id="cart-total">Rp 0</span>
            </div>
            <div class="border-t border-zinc-800 pt-3 flex items-center justify-between">
                <span class="text-zinc-300 font-semibold">kembalian</span>
                <span class="text-xl font-black text-emerald-400" id="cart-kembalian">Rp 0</span>
            </div>
        </div>

        <button
            id="btn-bayar"
            type="button"
            onclick="prosesBayar()"
            class="btn w-full mt-6 bg-blue-600 hover:bg-blue-500 text-white border-0"
            disabled
        >
            Proses Pembayaran
        </button>

        <p id="cart-msg" class="text-xs text-center mt-2 text-emerald-400 hidden"></p>
    </aside>

    <!-- Struk cetak — hidden di layar, muncul saat print -->
<div id="struk-print" style="display:none">
    <div style="font-family: monospace; width: 300px; margin: 0 auto; padding: 16px;">
        <div style="text-align:center; margin-bottom: 12px;">
            <h2 style="font-size: 16px; font-weight: bold; margin: 0;">toko arya</h2>
            <p style="font-size: 11px; margin: 4px 0;">toko arya</p>
            <p style="font-size: 10px; margin: 0;" id="struk-waktu"></p>
        </div>
        <div style="border-top: 1px dashed #000; border-bottom: 1px dashed #000; padding: 8px 0; margin-bottom: 8px;">
            <div id="struk-items" style="font-size: 12px;"></div>
        </div>
        <div style="font-size: 12px;">
            <div style="display:flex; justify-content:space-between;">
                <span>Subtotal</span>
                <span id="struk-subtotal"></span>
            </div>
            <div style="display:flex; justify-content:space-between; font-weight:bold; font-size:14px; margin-top:6px; border-top: 1px dashed #000; padding-top:6px;">
                <span>TOTAL</span>
                <span id="struk-total"></span>
            </div>
            <div style="display:flex; justify-content:space-between; font-weight:bold; font-size:14px; margin-top:6px; border-top: 1px dashed #000; padding-top:6px;">
                <span>PAYMENT</span>
                <span id="struk-payment"></span>
            </div>
            <div style="display:flex; justify-content:space-between; font-weight:bold; font-size:14px; margin-top:6px; border-top: 1px dashed #000; padding-top:6px;">
                <span>KEMBALIAN</span>
                <span id="struk-kembalian"></span>
            </div>
        </div>
        <div style="text-align:center; margin-top:12px; font-size:10px;">
            <p>Terima kasih sudah berbelanja!</p>
        </div>
    </div>
</div>
</div>

<script>
const CSRF_NAME  = '<?= csrf_token() ?>';
const CSRF_TOKEN = '<?= csrf_hash() ?>';

// Seed dari session saat halaman load
let cart = <?= json_encode(array_values(session()->get('cart') ?? [])) ?>;

function formatRp(n) {
    return 'Rp ' + Math.round(n).toLocaleString('id-ID');
}

function kembalian(){
    const subtotal = cart.reduce((total, item) => total + item.harga * item.qty, 0);
    const payment = parseInt(document.getElementById('payment').value);
    const kembalian   = payment - subtotal;
    document.getElementById('cart-pembayaran').textContent = formatRp(payment ? payment : 0);
    document.getElementById('cart-kembalian').textContent = formatRp(kembalian >= 0 ? kembalian : 0)
    
    // validate
    const btnBayar = document.getElementById('btn-bayar');
    if(cart.length > 0 && payment >= subtotal){
        btnBayar.disabled = false;
    } else {
        btnBayar.disabled = true;
    }

}

function renderCart() {
    const el       = document.getElementById('cart-items');
    const btnBayar = document.getElementById('btn-bayar');

    if (cart.length === 0) {
        el.innerHTML = `
            <div class="text-sm text-zinc-500 text-center border border-dashed border-zinc-700 rounded-lg py-6">
                Belum ada item
            </div>`;
        btnBayar.disabled = true;
    } else {
        el.innerHTML = cart.map(item => `
            <div class="flex items-center gap-3 bg-zinc-800 rounded-lg p-2">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-zinc-100 truncate">${item.nama}</p>
                    <p class="text-xs text-zinc-400">${item.qty} x ${formatRp(item.harga)}</p>
                </div>
                <div class="text-right shrink-0">
                    <p class="text-sm font-black text-emerald-400">${formatRp(item.harga * item.qty)}</p>
                    <button onclick="hapusItem(${item.id})" class="text-xs text-red-400 hover:text-red-300 mt-1">
                        hapus
                    </button>
                </div>
            </div>
        `).join('');
        btnBayar.disabled = false;
    }

    const subtotal = cart.reduce((s, i) => s + i.harga * i.qty, 0);
    document.getElementById('cart-subtotal').textContent = formatRp(subtotal);
    document.getElementById('cart-total').textContent    = formatRp(subtotal);

    kembalian();
}

function inputJumlah(productId, namaProduct, stokTersedia) {
    const qty = window.prompt(`Masukkan jumlah untuk "${namaProduct}" (Stok: ${stokTersedia}):`, "1");
    
    // Validasi kalau user klik cancel atau input kosong
    if (qty === null || qty === "") return;

    const jumlah = parseInt(qty);

    // Validasi angka
    if (isNaN(jumlah) || jumlah <= 0) {
        alert("Masukkan jumlah yang valid (angka minimal 1)");
        return;
    }

    if (jumlah > stokTersedia) {
        alert(`Stok tidak mencukupi! Maksimal pembelian: ${stokTersedia}`);
        return;
    }

    // Kalau lolos validasi, panggil fungsi fetch
    tambahItem(productId, jumlah);
}

async function tambahItem(productId, qty) {
    const res = await fetch('<?= base_url('/kasir/tambah') ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        // Perhatikan bagian &qty=${qty} di bawah ini
        body: `${CSRF_NAME}=${CSRF_TOKEN}&product_id=${productId}&qty=${qty}`,
    });
    
    const data = await res.json();
    if (data.ok) {
        cart = data.cart;
        renderCart();
    } else {
        alert(data.message ?? 'Terjadi kesalahan');
    }
}
async function hapusItem(productId) {
    const res  = await fetch('<?= base_url('/kasir/hapus') ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `${CSRF_NAME}=${CSRF_TOKEN}&product_id=${productId}`,
    });
    const data = await res.json();
    if (data.ok) {
        cart = data.cart;
        renderCart();
    }
}
function isiStruk(total) {
    // Waktu transaksi
    const now = new Date();
    document.getElementById('struk-waktu').textContent =
        now.toLocaleDateString('id-ID', { day:'2-digit', month:'long', year:'numeric' }) +
        ' ' + now.toLocaleTimeString('id-ID', { hour:'2-digit', minute:'2-digit' });

    // List item
    document.getElementById('struk-items').innerHTML = cart.map(item => `
        <div style="display:flex; justify-content:space-between; margin-bottom:4px;">
            <span style="flex:1;">${item.nama}</span>
            <span style="margin: 0 8px;">${item.qty}x</span>
            <span>${formatRp(item.harga * item.qty)}</span>
        </div>
    `).join('');

    // Total
    document.getElementById('struk-subtotal').textContent = formatRp(total);
    document.getElementById('struk-total').textContent    = formatRp(total);
    document.getElementById('struk-payment').textContent    = formatRp(parseInt(document.getElementById('payment').value));
    document.getElementById('struk-kembalian').textContent    = formatRp(parseInt(document.getElementById('payment').value) - total);
}

async function prosesBayar() {
    const btn = document.getElementById('btn-bayar');
    btn.disabled    = true;
    btn.textContent = 'Memproses...';

    const res  = await fetch('<?= base_url('/kasir/bayar') ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `${CSRF_NAME}=${CSRF_TOKEN}`,
    });
    const data = await res.json();

    if (data.ok) {
        // Isi struk pakai data cart yang masih ada
        isiStruk(data.total);

        const msg = document.getElementById('cart-msg');
        msg.textContent = `Berhasil! Total ${formatRp(data.total)}`;
        msg.classList.remove('hidden');

        window.addEventListener('afterprint', function handler(){
            window.removeEventListener('afterprint',handler);
            cart = [];
            renderCart();
            location.reload();
        });

        window.print()
    } else {
        alert(data.message ?? 'Terjadi kesalahan');
        btn.disabled    = false;
        btn.textContent = 'Proses Pembayaran';
    }
}

// Render cart dari session saat pertama load
renderCart();
</script>

<style>
@media print {
    body * {
        visibility: hidden !important;
    }

    #struk-print,
    #struk-print * {
        visibility: visible !important;
    }

    #struk-print {
        display: block !important;
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        width: 100% !important;
        background: white !important;
        color: black !important;
        z-index: 9999 !important;
    }
}
</style>

<?= $this->endSection() ?>
