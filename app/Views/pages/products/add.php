<?= $this->extend('layout/dashboard_template') ?>
<?= $this->section('content') ?>

<div class="flex flex-col gap-6">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">

        <div>
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-purple-500 animate-pulse"></div>

                <p class="text-[10px] uppercase tracking-[0.35em] text-purple-400 font-bold">
                    Inventory Management
                </p>
            </div>

            <h1 class="text-3xl font-black text-white mt-2">
                Tambah Produk
            </h1>

            <p class="text-sm text-zinc-500 mt-1">
                Input produk dengan layout yang lebih clean dan nyaman
            </p>
        </div>

        <a href="<?= base_url('products') ?>"
           class="btn btn-sm rounded-xl bg-zinc-900 border border-zinc-700 hover:bg-zinc-800 hover:border-zinc-500 text-zinc-300">
            ← Kembali
        </a>

    </div>

    <!-- Form Wrapper -->
    <div class="relative overflow-hidden rounded-3xl border border-zinc-800 bg-zinc-900">

        <!-- Glow -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-purple-500/10 blur-3xl rounded-full"></div>

        <div class="relative p-6">

            <!-- Top -->
            <div class="flex items-center justify-between mb-6">

                <div>
                    <h2 class="text-xl font-black text-white">
                        Batch Input Produk
                    </h2>

                    <p class="text-xs text-zinc-500 mt-1">
                        Tambahkan beberapa produk sekaligus
                    </p>
                </div>

                <div class="badge border-purple-500 text-purple-400 bg-purple-500/10 px-4 py-3">
                    <span id="total-row">1</span> Item
                </div>

            </div>

            <form action="<?= base_url('products/store') ?>"
                  method="post"
                  enctype="multipart/form-data">

                <?= csrf_field() ?>

                <!-- Rows -->
                <div id="batch-rows"
                     class="space-y-4 max-h-[650px] overflow-y-auto pr-1">
                </div>

                <!-- Bottom -->
                <div class="flex flex-col md:flex-row justify-between gap-3 mt-6">

                    <button type="button"
                            onclick="tambahBaris()"
                            class="btn rounded-2xl bg-zinc-800 border border-zinc-700 hover:bg-zinc-700 hover:border-zinc-500 text-zinc-200">

                        + Tambah Produk

                    </button>

                    <button type="submit"
                            class="btn rounded-2xl bg-purple-600 hover:bg-purple-500 border-0 text-white font-bold px-8 shadow-lg shadow-purple-500/20">

                        Simpan Semua Produk

                    </button>

                </div>

            </form>

        </div>

    </div>

        <?php if (session()->getFlashdata('error')) : ?>
        <div class="mb-6 flex items-center gap-3 rounded-2xl border border-red-500/50 bg-red-500/10 p-4 text-red-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-sm font-medium"><?= session()->getFlashdata('error') ?></span>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="mb-6 flex items-center gap-3 rounded-2xl border border-emerald-500/50 bg-emerald-500/10 p-4 text-emerald-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-sm font-medium"><?= session()->getFlashdata('success') ?></span>
        </div>
    <?php endif; ?>

</div>

<script>

function updateCounter() {

    document.getElementById('total-row').textContent =
        document.querySelectorAll('.batch-row').length;
}

function buatRow() {

    const total =
        document.querySelectorAll('.batch-row').length + 1;

    const div = document.createElement('div');

    div.className =
        'batch-row bg-zinc-950/70 border border-zinc-800 rounded-3xl overflow-hidden';

    div.innerHTML = `

        <div class="p-5 border-b border-zinc-800 flex items-center justify-between">

            <div class="badge bg-zinc-800 border border-zinc-700 text-zinc-300 font-bold">
                ITEM #${total}
            </div>

            <button type="button"
                    onclick="hapusBaris(this)"
                    class="btn btn-xs btn-circle btn-ghost hover:bg-red-500/10 hover:text-red-400">

                ✕

            </button>

        </div>

        <div class="p-5 grid grid-cols-1 lg:grid-cols-[140px_1fr] gap-5">

            <!-- Upload -->
            <div>

                <p class="text-[11px] uppercase tracking-wider text-zinc-500 font-bold mb-2">
                    Foto
                </p>

                <div class="relative">

                    <label class="upload-box h-[140px] rounded-2xl border-2 border-dashed border-zinc-700 bg-zinc-900 hover:border-purple-500 transition-all cursor-pointer flex flex-col items-center justify-center gap-2 overflow-hidden">

                        <div class="preview-wrapper hidden absolute inset-0">

                            <img src=""
                                 class="preview-image w-full h-full object-cover">
                        </div>

                        <div class="upload-content flex flex-col items-center gap-2">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-8 h-8 text-zinc-600"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="1.5"
                                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01"/>

                            </svg>

                            <div class="text-center">
                                <p class="text-[11px] text-zinc-400 font-semibold">
                                    Upload
                                </p>

                                <p class="text-[10px] text-zinc-600">
                                    maks 2MB
                                </p>
                            </div>

                        </div>

                        <input type="file"
                               name="image[]"
                               accept="image/*"
                               class="hidden"
                               onchange="previewImage(this)">
                    </label>

                    <!-- Remove -->
                    <button type="button"
                            onclick="removeImage(this)"
                            class="remove-image hidden absolute top-2 right-2 bg-red-500 hover:bg-red-400 w-6 h-6 rounded-full text-xs text-white z-10">

                        ✕

                    </button>

                </div>

            </div>

            <!-- Form -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">

                <!-- Nama -->
                <div class="md:col-span-2">

                    <label class="block text-[11px] uppercase tracking-wider text-zinc-500 font-bold mb-2">
                        Nama Produk *
                    </label>

                    <input type="text"
                           name="nama_product[]"
                           placeholder="Contoh: indomie goreng"
                           required
                           class="input w-full rounded-2xl bg-zinc-900 border-zinc-800 focus:border-purple-500">

                </div>

                <!-- Kode -->
                <div class="md:col-span-2">

                    <label class="block text-[11px] uppercase tracking-wider text-zinc-500 font-bold mb-2">
                        SKU / Kode
                    </label>

                    <input type="text"
                           name="kode_product[]"
                           placeholder="PROD-001"
                           required
                           class="input w-full rounded-2xl bg-zinc-900 border-zinc-800 focus:border-purple-500">

                </div>

                <!-- Kategori -->
                <div>

                    <label class="block text-[11px] uppercase tracking-wider text-zinc-500 font-bold mb-2">
                        Kategori
                    </label>

                    <select name="kategori[]"
                            required
                            class="select w-full rounded-2xl bg-zinc-900 border-zinc-800 focus:border-purple-500">

                        <option value="">Pilih Kategori</option>
                        <option value="makanan ringan">Makanan Ringan</option>
                        <option value="minuman">Minuman</option>
                        <option value="kebutuhan pokok">Kebutuhan Pokok</option>
                        <option value="kebersihan">Kebersihan</option>
                        <option value="lainnya">Lainnya</option>

                    </select>

                </div>

                <!-- Harga -->
                <div>

                    <label class="block text-[11px] uppercase tracking-wider text-zinc-500 font-bold mb-2">
                        Harga (Rp)
                    </label>

                    <input type="number"
                           name="harga[]"
                           min="0"
                           placeholder="0"
                           required
                           class="input w-full rounded-2xl bg-zinc-900 border-zinc-800 focus:border-purple-500">

                </div>

                <!-- Qty -->
                <div>

                    <label class="block text-[11px] uppercase tracking-wider text-zinc-500 font-bold mb-2">
                        Stok
                    </label>

                    <input type="number"
                           name="qty[]"
                           min="0"
                           value="0"
                           required
                           class="input w-full rounded-2xl bg-zinc-900 border-zinc-800 focus:border-purple-500">

                </div>

            </div>

        </div>
    `;

    return div;
}

function tambahBaris() {

    const container =
        document.getElementById('batch-rows');

    container.appendChild(buatRow());

    updateCounter();

    container.scrollTop =
        container.scrollHeight;
}

function hapusBaris(btn) {

    const rows =
        document.querySelectorAll('.batch-row');

    if (rows.length <= 1) return;

    btn.closest('.batch-row').remove();

    refreshItemNumber();

    updateCounter();
}

function refreshItemNumber() {

    document.querySelectorAll('.batch-row').forEach((row, index) => {

        row.querySelector('.badge').innerText =
            `ITEM #${index + 1}`;
    });
}

function previewImage(input) {

    const wrapper =
        input.closest('.relative');

    const previewWrapper =
        wrapper.querySelector('.preview-wrapper');

    const image =
        wrapper.querySelector('.preview-image');

    const uploadContent =
        wrapper.querySelector('.upload-content');

    const removeBtn =
        wrapper.querySelector('.remove-image');

    if (input.files && input.files[0]) {

        const reader = new FileReader();

        reader.onload = function(e) {

            image.src = e.target.result;

            previewWrapper.classList.remove('hidden');

            uploadContent.classList.add('hidden');

            removeBtn.classList.remove('hidden');
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function removeImage(btn) {

    const wrapper =
        btn.closest('.relative');

    const input =
        wrapper.querySelector('input[type="file"]');

    const previewWrapper =
        wrapper.querySelector('.preview-wrapper');

    const uploadContent =
        wrapper.querySelector('.upload-content');

    const image =
        wrapper.querySelector('.preview-image');

    input.value = '';

    image.src = '';

    previewWrapper.classList.add('hidden');

    uploadContent.classList.remove('hidden');

    btn.classList.add('hidden');
}

document.addEventListener('DOMContentLoaded', () => {

    tambahBaris();
});
</script>

<?= $this->endSection() ?>