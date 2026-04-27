<?= $this->extend('layout/dashboard_template') ?>

<?= $this->section('content') ?>

<div class="flex flex-col gap-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-black text-white italic">MASTER DATA BARANG</h2>
            <p class="text-xs text-zinc-500 uppercase tracking-widest">Update stok dan inventori toko</p>
        </div>
        <label for="modal-tambah" class="btn btn-primary btn-sm md:btn-md rounded-lg font-bold shadow-lg shadow-blue-600/20">
            + Tambah Produk Baru
        </label>
    </div>

    <div class="bg-zinc-900 border border-zinc-800 rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table  w-full">
                <thead class="bg-zinc-950 text-zinc-500 uppercase text-[10px] tracking-wider">
                    <tr>
                        <th class="py-4">Kode</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    <?php foreach ($products as $p) : ?>
                    <tr class="hover:bg-zinc-800/50 transition-colors border-zinc-800">
                        <td class="font-mono text-blue-400 font-bold"><?= $p['kode_product'] ?></td>
                        <td class="font-semibold text-zinc-200"><?= $p['nama_product'] ?></td>
                        <td><span class="badge badge-outline badge-sm text-zinc-400 uppercase"><?= $p['kategori'] ?></span></td>
                        <td class="<?= $p['qty'] <= 5 ? 'text-amber-500 font-bold' : '' ?>">
                            <?= $p['qty'] ?> unit
                        </td>
                        <td class="font-black text-emerald-400">Rp <?= number_format($p['harga'], 0, ',', '.') ?></td>
                        <td class="flex justify-center gap-2">
                            <button onclick="editBarang(<?= htmlspecialchars(json_encode($p)) ?>)" class="btn btn-square btn-ghost btn-sm text-zinc-400 hover:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<input type="checkbox" id="modal-tambah" class="modal-toggle" />
<div class="modal">
    <div class="modal-box bg-zinc-900 border border-zinc-800">
        <h3 class="font-black text-lg text-white mb-6 uppercase tracking-tighter">Entry Barang Baru</h3>
        <form action="<?= base_url('barang/tambahBarang') ?>" method="post" class="space-y-4">
            <?= csrf_field() ?>
            <div class="grid grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="label"><span class="label-text text-zinc-400 text-xs uppercase">Kode SKU</span></label>
                    <input type="text" name="kode_product" class="input input-bordered bg-zinc-950 border-zinc-700" placeholder="BRG-001" required />
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text text-zinc-400 text-xs uppercase">Kategori</span></label>
                    <input type="text" name="kategori" class="input input-bordered bg-zinc-950 border-zinc-700" placeholder="Gunpla" required />
                </div>
            </div>
            <div class="form-control">
                <label class="label"><span class="label-text text-zinc-400 text-xs uppercase">Nama Produk</span></label>
                <input type="text" name="nama_product" class="input input-bordered bg-zinc-950 border-zinc-700" placeholder="Ex: MG Destiny Gundam" required />
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="label"><span class="label-text text-zinc-400 text-xs uppercase">Stok Awal</span></label>
                    <input type="number" name="qty" class="input input-bordered bg-zinc-950 border-zinc-700" value="0" required />
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text text-zinc-400 text-xs uppercase">Harga Jual</span></label>
                    <input type="number" name="harga" class="input input-bordered bg-zinc-950 border-zinc-700" placeholder="Rp" required />
                </div>
            </div>
            <div class="modal-action">
                <label for="modal-tambah" class="btn btn-ghost">Batal</label>
                <button type="submit" class="btn btn-primary">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<input type="checkbox" id="modal-update" class="modal-toggle" />
<div class="modal">
    <div class="modal-box bg-zinc-900 border border-zinc-800 ">
        <h3 class="font-black text-lg text-white mb-6 uppercase tracking-tighter">Update Stok/Harga</h3>
        <form action="<?= base_url('barang/updateStock') ?>" method="post" class="space-y-4">
            <?= csrf_field() ?>
            <input type="hidden" name="id" id="edit-id">
            <div class="form-control">
                <label class="label"><span class="label-text text-xs uppercase">Nama Produk</span></label>
                <input type="text" id="edit-nama" class="input input-bordered text-black border-zinc-700" disabled />
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="label"><span class="label-text text-zinc-400 text-xs uppercase">Jumlah Stok</span></label>
                    <input type="number" name="qty" id="edit-qty" class="input input-bordered bg-zinc-950 border-zinc-700" required />
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text text-zinc-400 text-xs uppercase">Update Harga</span></label>
                    <input type="number" name="harga" id="edit-harga" class="input input-bordered bg-zinc-950 border-zinc-700" required />
                </div>
            </div>
            <div class="modal-action">
                <label for="modal-update" class="btn btn-ghost">Batal</label>
                <button type="submit" class="btn btn-success">Update Data</button>
            </div>
        </form>
    </div>
</div>

<script>
    function editBarang(data) {
        // Isi data ke input modal
        document.getElementById('edit-id').value = data.id;
        document.getElementById('edit-nama').value = data.nama_product;
        document.getElementById('edit-qty').value = data.qty;
        document.getElementById('edit-harga').value = data.harga;
        
        // Buka modal
        document.getElementById('modal-update').checked = true;
    }
</script>

<?= $this->endSection() ?>