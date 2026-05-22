<?= $this->extend('layout/dashboard_template') ?>
<?= $this->section('content') ?>

<div class="max-w-3xl mx-auto flex flex-col gap-6">

    <!-- Header -->
    <div class="flex items-center justify-between">

        <div>
            <p class="text-[10px] uppercase tracking-[0.3em] text-emerald-500 font-bold">
                Inventori
            </p>

            <h1 class="text-2xl font-black text-white mt-1">
                Edit Produk
            </h1>

            <p class="text-sm text-zinc-500 mt-1">
                Update stok, harga, dan gambar produk
            </p>
        </div>

        <a href="<?= base_url('products') ?>"
           class="btn btn-sm btn-ghost text-zinc-400">
            Kembali
        </a>

    </div>

    <!-- Form -->
    <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6">

        <form action="<?= base_url('products/update/' . $product['id']) ?>"
              method="post"
              enctype="multipart/form-data"
              class="space-y-5">

            <?= csrf_field() ?>

            <!-- Kode -->
            <div class="form-control">

                <label class="label">
                    <span class="label-text text-zinc-400">
                        Kode Produk
                    </span>
                </label>

                <input type="text"
                       value="<?= esc($product['kode_product']) ?>"
                       readonly
                       class="input input-bordered bg-zinc-800 border-zinc-700 text-zinc-500">

            </div>

            <!-- Nama -->
            <div class="form-control">

                <label class="label">
                    <span class="label-text text-zinc-400">
                        Nama Produk
                    </span>
                </label>

                <input type="text"
                       name="nama_product"
                       value="<?= esc($product['nama_product']) ?>"
                       required
                       class="input input-bordered bg-zinc-950 border-zinc-700">

            </div>

            <!-- Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <!-- Kategori -->
                <div class="form-control">

                    <label class="label">
                        <span class="label-text text-zinc-400">
                            Kategori
                        </span>
                    </label>

                    <select name="kategori"
                            class="select select-bordered bg-zinc-950 border-zinc-700">

                        <?php
                        $kategoriList = [
                            'makanan ringan',
                            'minuman',
                            'kebutuhan pokok',
                            'kebersihan',
                            'lainnya'
                        ];
                        ?>

                        <?php foreach ($kategoriList as $kategori): ?>

                            <option value="<?= $kategori ?>"
                                <?= $product['kategori'] == $kategori ? 'selected' : '' ?>>

                                <?= ucfirst($kategori) ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>

                <!-- Qty -->
                <div class="form-control">

                    <label class="label">
                        <span class="label-text text-zinc-400">
                            Qty
                        </span>
                    </label>

                    <input type="number"
                           name="qty"
                           min="0"
                           value="<?= esc($product['qty']) ?>"
                           required
                           class="input input-bordered bg-zinc-950 border-zinc-700">

                </div>

                <!-- Harga -->
                <div class="form-control">

                    <label class="label">
                        <span class="label-text text-zinc-400">
                            Harga
                        </span>
                    </label>

                    <input type="number"
                           name="harga"
                           min="0"
                           value="<?= esc($product['harga']) ?>"
                           required
                           class="input input-bordered bg-zinc-950 border-zinc-700">

                </div>

            </div>

            <!-- Image -->
            <div class="form-control">

                <label class="label">
                    <span class="label-text text-zinc-400">
                        Ganti Gambar
                    </span>
                </label>

                <?php if ($product['image']) : ?>

                    <div class="mb-3">

                        <img src="<?= base_url('assets/img/' . $product['image']) ?>"
                             class="w-28 h-28 rounded-xl object-cover border border-zinc-700">

                    </div>

                <?php endif; ?>

                <input type="file"
                       name="image"
                       accept="image/*"
                       class="file-input file-input-bordered bg-zinc-950 border-zinc-700">

            </div>

            <!-- Submit -->
            <div class="flex justify-end gap-3 pt-5 border-t border-zinc-800">

                <a href="<?= base_url('products') ?>"
                   class="btn btn-ghost text-zinc-400">
                    Batal
                </a>

                <button type="submit"
                        class="btn btn-success">
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

<?= $this->endSection() ?>