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
            <label for="modal-batch" class="btn btn-sm btn-outline border-zinc-700 text-zinc-300 hover:bg-zinc-800 hover:border-zinc-600 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h8"/>
                </svg>
                Tambah Product
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
                        <th class="text-center pr-5">Aksi</th>
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
                            <button
                                onclick="editBarang(<?= htmlspecialchars(json_encode($p)) ?>)"
                                class="btn btn-ghost btn-xs text-zinc-500 hover:text-white"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                </svg>
                                Edit
                            </button>
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
        <form action="<?= base_url('barang/updateStock') ?>" method="post" class="space-y-4" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" name="id" id="edit-id">
            <div class="form-control">
                <label class="label pb-1"><span class="label-text text-zinc-400 text-xs uppercase tracking-wider">Nama Produk</span></label>
                <input type="text" id="edit-nama" class="input input-bordered input-sm bg-zinc-800 border-zinc-700 text-zinc-400 cursor-not-allowed" disabled />
            </div>
            <div class="grid grid-cols-3 gap-3">
                <div class="form-control">
                    <label class="label pb-1"><span class="label-text text-zinc-400 text-xs uppercase tracking-wider">Jumlah Stok</span></label>
                    <input type="number" name="qty" id="edit-qty" class="input input-bordered input-sm bg-zinc-950 border-zinc-700 focus:border-emerald-500" min="0" required />
                </div>
                <div class="form-control">
                    <label class="label pb-1"><span class="label-text text-zinc-400 text-xs uppercase tracking-wider">Harga Jual</span></label>
                    <input type="number" name="harga" id="edit-harga" class="input input-bordered input-sm bg-zinc-950 border-zinc-700 focus:border-emerald-500" min="0" required />
                </div>
                <!-- Di modal update, tambahin ini sebelum modal-action -->
<div class="form-control">
    <label class="label pb-1">
        <span class="label-text text-zinc-400 text-xs uppercase tracking-wider">
            Ganti Gambar 
            <span class="text-zinc-600">(opsional)</span>
        </span>
    </label>
    <!-- Preview gambar saat ini -->
    <div id="edit-image-preview" class="mb-2 hidden">
        <img id="edit-image-thumb" src="" alt="" 
             class="h-16 w-16 object-cover rounded-lg border border-zinc-700"/>
    </div>
    <input type="file" name="image" accept="image/*" 
           class="file-input file-input-bordered file-input-xs bg-zinc-950 border-zinc-700 w-full"
           onchange="previewEditImage(this)"/>
</div>
            </div>
            <div class="modal-action mt-6 pt-4 border-t border-zinc-800">
                <label for="modal-update" class="btn btn-ghost btn-sm text-zinc-500">Batal</label>
                <button type="submit" class="btn btn-success btn-sm">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- ===== MODAL BATCH INPUT ===== -->
<input type="checkbox" id="modal-batch" class="modal-toggle" />
<div class="modal modal-bottom sm:modal-middle">
    <div class="modal-box bg-zinc-900 border border-zinc-800 w-11/12 max-w-4xl">
        <div class="flex items-center justify-between mb-6">
            <div>
                <p class="text-[10px] uppercase tracking-widest text-purple-400 font-bold">Batch</p>
                <h3 class="font-black text-lg text-white">Input Banyak Produk Sekaligus</h3>
                <p class="text-xs text-zinc-500 mt-0.5">Tambahkan baris sesuai kebutuhan, simpan semua dalam sekali klik</p>
            </div>
            <label for="modal-batch" class="btn btn-ghost btn-sm btn-circle text-zinc-500">✕</label>
        </div>

        <form action="<?= base_url('barang/tambahProduct') ?>" method="post" id="form-batch" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <!-- Table header -->
            <div class="hidden md:grid grid-cols-12 gap-2 mb-2 px-1">
                <div class="col-span-2 text-[10px] uppercase tracking-wider text-zinc-500">Kode SKU</div>
                <div class="col-span-3 text-[10px] uppercase tracking-wider text-zinc-500">Nama Produk</div>
                <div class="col-span-2 text-[10px] uppercase tracking-wider text-zinc-500">Kategori</div>
                <div class="col-span-2 text-[10px] uppercase tracking-wider text-zinc-500">Stok</div>
                <div class="col-span-2 text-[10px] uppercase tracking-wider text-zinc-500">Harga</div>
                <div class="col-span-1"></div>
            </div>

            <!-- Rows container -->
            <div id="batch-rows" class="space-y-2 max-h-80 overflow-y-auto pr-1">
                <!-- Row pertama default -->
                <div class="batch-row grid grid-cols-12 gap-2 items-center bg-zinc-800/50 rounded-lg p-2">
                    <div class="col-span-12 md:col-span-2">
                        <input type="text" name="kode_product[]" placeholder="BRG-001"
                            class="input input-bordered input-xs w-full bg-zinc-950 border-zinc-700 focus:border-purple-500 font-mono" required />
                    </div>
                    <div class="col-span-12 md:col-span-3">
                        <input type="text" name="nama_product[]" placeholder="Nama produk"
                            class="input input-bordered input-xs w-full bg-zinc-950 border-zinc-700 focus:border-purple-500" required />
                    </div>
                    <div class="col-span-12 md:col-span-2">
                        <select name="kategori[]" class="select select-bordered select-xs w-full bg-zinc-950 border-zinc-700 focus:border-purple-500" required>
                            <option value="">Pilih</option>
                            <option value="makanan ringan">Mkn Ringan</option>
                            <option value="minuman">Minuman</option>
                            <option value="kebutuhan pokok">Kbthn Pokok</option>
                            <option value="kebersihan">Kebersihan</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="col-span-5 md:col-span-2">
                        <input type="number" name="qty[]" placeholder="Stok" value="0" min="0"
                            class="input input-bordered input-xs w-full bg-zinc-950 border-zinc-700 focus:border-purple-500" required />
                    </div>
                    <div class="col-span-6 md:col-span-2">
                        <input type="number" name="harga[]" placeholder="Harga" min="0"
                            class="input input-bordered input-xs w-full bg-zinc-950 border-zinc-700 focus:border-purple-500" required />
                    </div>
                    <div class="col-span-12 md:col-span-2">
        <label class="flex items-center gap-2 cursor-pointer bg-zinc-950 border border-zinc-700 
                       rounded-lg px-2 py-1 hover:border-purple-500 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-zinc-500 shrink-0" 
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span class="text-[10px] text-zinc-500 truncate image-label">Pilih gambar</span>
            <input type="file" name="image[image][]" accept="image/*" class="hidden"
                   onchange="previewImage(this)"/>
        </label>
    </div>
                    <div class="col-span-1 flex justify-center">
                        <button type="button" onclick="hapusBaris(this)"
                            class="btn btn-ghost btn-xs btn-circle text-zinc-600 hover:text-red-400 hover:bg-red-400/10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tambah baris -->
            <button type="button" onclick="tambahBaris()"
                class="btn btn-ghost btn-sm w-full mt-3 border border-dashed border-zinc-700 text-zinc-500 hover:text-white hover:border-zinc-500 rounded-lg">
                + Tambah Baris
            </button>

            <!-- Counter -->
            <p class="text-xs text-zinc-600 mt-2 text-center">
                <span id="row-count">1</span> produk akan ditambahkan
            </p>

            <div class="modal-action mt-4 pt-4 border-t border-zinc-800">
                <label for="modal-batch" class="btn btn-ghost btn-sm text-zinc-500">Batal</label>
                <button type="submit" class="btn btn-sm bg-purple-600 hover:bg-purple-500 border-0 text-white font-bold">
                    Simpan Semua Produk
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(input) {
    const label = input.closest('label');
    const span  = label.querySelector('.image-label');
    if (input.files && input.files[0]) {
        span.textContent = input.files[0].name;
        span.classList.add('text-purple-400');
    }
}
function editBarang(data) {
    document.getElementById('edit-id').value    = data.id;
    document.getElementById('edit-nama').value  = data.nama_product;
    document.getElementById('edit-qty').value   = data.qty;
    document.getElementById('edit-harga').value = data.harga;

    // Tambahin preview gambar kalau ada
    if (data.image) {
        const preview = document.getElementById('edit-image-preview');
        const thumb   = document.getElementById('edit-image-thumb');
        thumb.src     = '/assets/img/' + data.image;
        preview.classList.remove('hidden');
    }

    document.getElementById('modal-update').checked = true;
}

function previewEditImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = (e) => {
            const thumb = document.getElementById('edit-image-thumb');
            const preview = document.getElementById('edit-image-preview');
            thumb.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function rowTemplate() {
    return `
    <div class="batch-row grid grid-cols-12 gap-2 items-center bg-zinc-800/50 rounded-lg p-2">
        <div class="col-span-12 md:col-span-2">
            <input type="text" name="kode_product[]" placeholder="BRG-001"
                class="input input-bordered input-xs w-full bg-zinc-950 border-zinc-700 focus:border-purple-500 font-mono" required />
        </div>
        <div class="col-span-12 md:col-span-3">
            <input type="text" name="nama_product[]" placeholder="Nama produk"
                class="input input-bordered input-xs w-full bg-zinc-950 border-zinc-700 focus:border-purple-500" required />
        </div>
        <div class="col-span-12 md:col-span-2">
            <select name="kategori[]" class="select select-bordered select-xs w-full bg-zinc-950 border-zinc-700 focus:border-purple-500" required>
                <option value="">Pilih</option>
                <option value="makanan ringan">Mkn Ringan</option>
                <option value="minuman">Minuman</option>
                <option value="kebutuhan pokok">Kbthn Pokok</option>
                <option value="kebersihan">Kebersihan</option>
                <option value="lainnya">Lainnya</option>
            </select>
        </div>
        <div class="col-span-5 md:col-span-2">
            <input type="number" name="qty[]" placeholder="Stok" value="0" min="0"
                class="input input-bordered input-xs w-full bg-zinc-950 border-zinc-700 focus:border-purple-500" required />
        </div>
        <div class="col-span-6 md:col-span-2">
            <input type="number" name="harga[]" placeholder="Harga" min="0"
                class="input input-bordered input-xs w-full bg-zinc-950 border-zinc-700 focus:border-purple-500" required />
        </div>
        <div class="col-span-1 flex justify-center">
            <button type="button" onclick="hapusBaris(this)"
                class="btn btn-ghost btn-xs btn-circle text-zinc-600 hover:text-red-400 hover:bg-red-400/10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>`;
}

function tambahBaris() {
    const container = document.getElementById('batch-rows');
    container.insertAdjacentHTML('beforeend', rowTemplate());
    updateCounter();
    // Scroll ke bawah biar keliatan baris baru
    container.scrollTop = container.scrollHeight;
}

function hapusBaris(btn) {
    const rows = document.querySelectorAll('.batch-row');
    if (rows.length <= 1) return; // minimal 1 baris
    btn.closest('.batch-row').remove();
    updateCounter();
}

function updateCounter() {
    const count = document.querySelectorAll('.batch-row').length;
    document.getElementById('row-count').textContent = count;
}
</script>

<?= $this->endSection() ?>