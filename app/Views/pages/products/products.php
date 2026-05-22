<?= $this->extend('layout/dashboard_template') ?>
<?= $this->section('content') ?>

<div class="flex flex-col gap-6">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-blue-500">Inventori</p>
            <h2 class="text-xl font-black text-white">Master Data Barang</h2>
            <p class="text-xs text-zinc-500 mt-0.5">Kelola stok dan katalog produk toko</p>
        </div>
        <div class="flex gap-2">
            <label class="btn btn-sm bg-purple-600 hover:bg-purple-500 border-0 text-white font-bold rounded-lg">
            <a href="/products/add">
                + Tambah Produk
            </a>    
            </label>
        </div>
    </div>

    <!-- Tabel Produk -->
    <div class="bg-zinc-900 border border-zinc-800 rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead class="bg-zinc-950 text-zinc-500 uppercase text-[10px] tracking-wider">
                    <tr>
                        <th class="py-4 pl-5">Kode</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    <?php foreach ($products as $p): ?>
                    <tr class="hover:bg-zinc-800/40 transition-colors border-zinc-800">
                        <td class="pl-5 font-mono text-blue-400 text-xs font-bold"><?= esc($p['kode_product']) ?></td>
                        <td class="font-semibold text-zinc-200"><?= esc($p['nama_product']) ?></td>
                        <td>
                            <span class="text-[10px] px-2 py-0.5 rounded-full border border-zinc-700 text-zinc-400 uppercase tracking-wider">
                                <?= esc($p['kategori']) ?>
                            </span>
                        </td>
                        <td class="<?= (int)$p['qty'] <= 5 ? 'text-amber-400 font-bold' : 'text-zinc-300' ?>">
                            <?= (int)$p['qty'] ?> unit
                            <?php if ((int)$p['qty'] <= 5): ?>
                                <span class="text-[9px] bg-amber-500/20 text-amber-400 px-1.5 py-0.5 rounded ml-1">LOW</span>
                            <?php endif; ?>
                        </td>
                        <td class="font-black text-emerald-400">Rp <?= number_format((float)$p['harga'], 0, ',', '.') ?></td>
                        <td class="text-center pr-5">
                            <a
                            href="<?= base_url('products/edit/' . $p['id']) ?>"
                                class="btn btn-ghost btn-xs text-zinc-500 hover:text-white"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                </svg>
                                Edit
                            </a>
                        </td>
                        <?php if (session()->get('user_role') == 'owner'): ?>
                        <td class="text-center pr-5">
                            <form action="<?= base_url('products/delete/' . $p['id']) ?>" method="post">
                                <button 
                                type="submit"
                                    class="btn btn-error btn-xs text-white hover:text-white">
                                   <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                    Hapus
                                </button>
                            </form>
                        </td>
                        <?php endif; ?>
                        <td class="text-center">
                            <?php if ($p['is_active'] == 1): ?>
                                <form action="<?= base_url('products/toggleStock/' . $p['id']) ?>" method="post">
                                    <button type="submit" class="btn btn-xs btn-success gap-2">
                                        <div class="badge badge-white badge-xs"></div> 
                                        Aktif
                                    </button>
                                </form>
                            <?php else: ?>
                                <form action="<?= base_url('products/toggleStock/' . $p['id']) ?>" method="post">
                                    <button type="submit" class="btn btn-xs btn-error btn-outline gap-2">
                                        <div class="badge badge-error badge-xs"></div> 
                                        Non-Aktif
                                    </button>
                                </form>
                            <?php endif; ?>
                       </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ===== MODAL EDIT ===== -->
<input type="checkbox" id="modal-update" class="modal-toggle" />
<div class="modal modal-bottom sm:modal-middle">
    <div class="modal-box bg-zinc-900 border border-zinc-800 max-w-lg">
        <div class="flex items-center justify-between mb-6">
            <div>
                <p class="text-[10px] uppercase tracking-widest text-emerald-500 font-bold">Edit</p>
                <h3 class="font-black text-lg text-white">Update Stok / Harga</h3>
            </div>
            <label for="modal-update" class="btn btn-ghost btn-sm btn-circle text-zinc-500">✕</label>
        </div>
        <form action="<?= base_url('products/updateStock') ?>" method="post" class="space-y-4" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" name="id" id="edit-id">
            <div class="form-control">
                <label class="label pb-1"><span class="label-text text-zinc-400 text-xs uppercase tracking-wider">Nama Produk</span></label>
                <input type="text" name="nama_product" id="edit-nama" class="input input-bordered input-sm bg-zinc-800 border-zinc-700 text-zinc-400 cursor-not-allowed" readonly />
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div class="form-control">
                    <label class="label pb-1"><span class="label-text text-zinc-400 text-xs uppercase tracking-wider">Jumlah Stok</span></label>
                    <input type="number" name="qty" id="edit-qty" class="input input-bordered input-sm bg-zinc-950 border-zinc-700 focus:border-emerald-500" min="0" required />
                </div>
                <div class="form-control">
                    <label class="label pb-1"><span class="label-text text-zinc-400 text-xs uppercase tracking-wider">Harga Jual</span></label>
                    <input type="number" name="harga" id="edit-harga" class="input input-bordered input-sm bg-zinc-950 border-zinc-700 focus:border-emerald-500" min="0" required />
                </div>
            </div>
            <div class="form-control">
                <label class="label pb-1">
                    <span class="label-text text-zinc-400 text-xs uppercase tracking-wider">Ganti Gambar <span class="text-zinc-600 normal-case">(opsional)</span></span>
                </label>
                <!-- Preview gambar existing -->
                <div id="edit-image-preview" class="mb-2 hidden">
                    <div class="relative inline-block">
                        <img id="edit-image-thumb" src="" alt=""
                             class="h-16 w-16 object-cover rounded-lg border border-zinc-700"/>
                        <button type="button" onclick="clearEditImage()"
                            class="absolute -top-1.5 -right-1.5 bg-red-500 hover:bg-red-400 rounded-full w-4 h-4 flex items-center justify-center text-white text-[10px] leading-none">
                            ✕
                        </button>
                    </div>
                </div>
                <input type="file" name="image" id="edit-image-input" accept="image/*"
                       class="file-input file-input-bordered file-input-sm bg-zinc-950 border-zinc-700 w-full"
                       onchange="previewEditImage(this)"/>
            </div>
            <div class="modal-action mt-6 pt-4 border-t border-zinc-800">
                <label for="modal-update" class="btn btn-ghost btn-sm text-zinc-500">Batal</label>
                <button type="submit" class="btn btn-success btn-sm">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>


<script>
   

function updateCounter() {
    document.getElementById('row-count').textContent = document.querySelectorAll('.batch-row').length;
}

// Preview image di batch — tiap baris punya preview sendiri
function previewBatchImage(input) {
    const label   = input.closest('label');
    const wrapper = label.closest('div.relative');
    const span    = label.querySelector('.image-label');
    const preview = wrapper.querySelector('.image-preview');
    const thumb   = wrapper.querySelector('.image-thumb');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = (e) => {
            thumb.src = e.target.result;
            preview.classList.remove('hidden');
            span.textContent = input.files[0].name.length > 10
                ? input.files[0].name.substring(0, 8) + '...'
                : input.files[0].name;
            span.classList.add('text-purple-400');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Clear image di baris batch
function clearBatchImage(btn) {
    const wrapper = btn.closest('div.relative');
    const fileInput = wrapper.querySelector('input[type="file"]');
    const span    = wrapper.querySelector('.image-label');
    const preview = wrapper.querySelector('.image-preview');
    const thumb   = wrapper.querySelector('.image-thumb');

    fileInput.value = '';
    thumb.src = '';
    span.textContent = 'Pilih';
    span.classList.remove('text-purple-400');
    preview.classList.add('hidden');
}

// Init satu baris saat halaman load
document.addEventListener('DOMContentLoaded', () => tambahBaris());

// Reset batch form saat modal ditutup
document.getElementById('modal-batch').addEventListener('change', function () {
    if (!this.checked) {
        const container = document.getElementById('batch-rows');
        container.innerHTML = '';
        tambahBaris();
    }
});

// ============================================================
// EDIT MODAL
// ============================================================

function editBarang(data) {
    console.log(data)
    document.getElementById('edit-id').value    = data.id;
    document.getElementById('edit-nama').value  = data.nama_product;
    document.getElementById('edit-qty').value   = data.qty;
    document.getElementById('edit-harga').value = data.harga;

    const preview = document.getElementById('edit-image-preview');
    const thumb   = document.getElementById('edit-image-thumb');

    if (data.image) {
        thumb.src = '/assets/img/' + data.image;
        preview.classList.remove('hidden');
    } else {
        preview.classList.add('hidden');
        thumb.src = '';
    }

    // Reset file input
    document.getElementById('edit-image-input').value = '';
    document.getElementById('modal-update').checked = true;
}

function previewEditImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = (e) => {
            const thumb   = document.getElementById('edit-image-thumb');
            const preview = document.getElementById('edit-image-preview');
            thumb.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function clearEditImage() {
    document.getElementById('edit-image-input').value = '';
    document.getElementById('edit-image-thumb').src   = '';
    document.getElementById('edit-image-preview').classList.add('hidden');
}

async function konfirmasiNonActive(id, nama) {
    const result = await Swal.fire({
        title: 'Nonaktifkan produk?',
        html: `<span class="text-zinc-400">Produk <strong class="text-white">${nama}</strong> tidak akan muncul di kasir.</span>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, nonaktifkan',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#ef4444',
        background: '#18181b',
        color: '#fff',
    });

    if (result.isConfirmed) {
        document.getElementById('nonactive-id').value = id;
        document.getElementById('form-nonactive').submit();
    }
}
</script>

<?= $this->endSection() ?>