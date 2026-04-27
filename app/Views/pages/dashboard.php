<?= $this->extend('layout/dashboard_template') ?>

<?= $this->section('content') ?>

<?php
$stats = $stats ?? [];
$daily_omzet = $daily_omzet ?? [];
$by_category = $by_category ?? [];
$low_stock = $low_stock ?? [];
$out_of_stock = $out_of_stock ?? [];
?>

<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
    <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 relative overflow-hidden group hover:border-blue-500/50 transition-all">
        <div class="relative z-10">
            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-zinc-500 mb-3">Total SKU</p>
            <p class="text-4xl font-black text-white tabular-nums tracking-tighter">
                <?= number_format((int) ($stats['total_produk'] ?? 0), 0, ',', '.') ?>
            </p>
            <p class="text-xs text-zinc-500 mt-2 flex items-center gap-1">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Katalog Aktif
            </p>
        </div>
        <svg class="absolute -right-4 -bottom-4 h-24 w-24 text-zinc-800/50 group-hover:text-blue-500/10 transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
    </div>

    <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 relative overflow-hidden group hover:border-emerald-500/50 transition-all">
        <div class="relative z-10">
            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-zinc-500 mb-3">Unit Tersedia</p>
            <p class="text-4xl font-black text-emerald-400 tabular-nums tracking-tighter">
                <?= number_format((int) ($stats['total_stok'] ?? 0), 0, ',', '.') ?>
            </p>
            <p class="text-xs text-zinc-500 mt-2 font-medium">Stok Fisik Terkini</p>
        </div>
        <svg class="absolute -right-4 -bottom-4 h-24 w-24 text-zinc-800/50 group-hover:text-emerald-500/10 transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
    </div>

    <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 relative overflow-hidden group hover:border-amber-500/50 transition-all">
        <div class="relative z-10">
            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-zinc-500 mb-3">Nilai Inventori</p>
            <p class="text-2xl font-black text-amber-400 tracking-tighter">
                Rp <?= number_format((float) ($stats['total_nilai_inventori'] ?? 0), 0, ',', '.') ?>
            </p>
            <p class="text-xs text-zinc-500 mt-3 italic">Aset Barang Toko</p>
        </div>
        <svg class="absolute -right-4 -bottom-4 h-24 w-24 text-zinc-800/50 group-hover:text-amber-500/10 transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.407 2.67 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.407-2.67-1M12 16V7"/></svg>
    </div>

   <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 relative overflow-hidden group hover:border-green-500/50 transition-all">
    <div class="relative z-10">
        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-zinc-500 mb-3">Omzet Hari Ini</p>
        <p class="text-2xl font-black text-green-400 tracking-tighter">
            Rp <?= number_format((float) ($daily_omzet ?? 0), 0, ',', '.') ?>
        </p>
        <p class="text-xs text-zinc-500 mt-3 italic">Total Penjualan Real-time</p>
    </div>
    <svg class="absolute -right-4 -bottom-4 h-24 w-24 text-zinc-800/50 group-hover:text-green-500/10 transition-colors" fill="currentColor" viewBox="0 0 24 24">
        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 14h-2v-2h2v2zm0-4h-2V7h2v5z"/>
    </svg>
</div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
    
    <div class="space-y-8">
        <div class="bg-zinc-900 border border-zinc-800 rounded-2xl overflow-hidden shadow-xl">
            <div class="px-6 py-4 border-b border-zinc-800 bg-zinc-950/50 flex items-center justify-between">
                <h2 class="font-black text-xs uppercase tracking-widest text-white">Distribusi Kategori</h2>
                <div class="h-2 w-2 rounded-full bg-blue-600 shadow-[0_0_8px_rgba(37,99,235,0.6)]"></div>
            </div>
            <ul class="divide-y divide-zinc-800/50">
                <?php if ($by_category === []): ?>
                    <li class="px-6 py-10 text-center text-zinc-600 text-sm italic">Belum ada kategori.</li>
                <?php else: ?>
                    <?php foreach ($by_category as $row): ?>
                        <li class="px-6 py-3.5 flex items-center justify-between hover:bg-zinc-800/30 transition-colors">
                            <span class="text-sm font-semibold text-zinc-300"><?= esc($row['kategori']) ?></span>
                            <span class="px-2.5 py-0.5 rounded-md bg-zinc-800 text-xs font-black text-blue-400 tabular-nums border border-zinc-700">
                                <?= (int) $row['qty'] ?> SKU
                            </span>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>

        <?php if ($out_of_stock !== []): ?>
        <div class="bg-red-500/5 border border-red-500/20 rounded-2xl overflow-hidden shadow-2xl">
            <div class="px-6 py-4 border-b border-red-500/10 bg-red-500/10 flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                <h2 class="font-black text-xs uppercase tracking-widest text-red-500 italic">STOK HABIS (RESTOCK!)</h2>
            </div>
            <ul class="divide-y divide-red-500/10 px-4 py-2">
                <?php foreach ($out_of_stock as $p): ?>
                    <li class="px-2 py-3 flex items-center justify-between">
                        <span class="text-xs font-bold text-zinc-200 truncate pr-4"><?= esc($p['nama_product'] ?? '') ?></span>
                        <span class="shrink-0 text-[10px] px-2 py-0.5 rounded bg-red-500 text-white font-black uppercase">Kosong</span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
    </div>

    <div class="lg:col-span-2 space-y-6">
        
        <div id="ai-insight-container" class="hidden animate-in fade-in slide-in-from-top-4 duration-700">
            <div class="bg-indigo-600/10 border border-indigo-500/30 rounded-2xl p-6 backdrop-blur-sm relative overflow-hidden">
                <div class="flex items-start justify-between relative z-10 gap-4">
                    <div class="flex items-center gap-4">
                        <div class="bg-indigo-500 p-2.5 rounded-xl shadow-[0_0_15px_rgba(99,102,241,0.4)]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-[0.3em] text-indigo-400">AI Intelligent Forecast</p>
                            <p id="ai-message" class="text-sm text-zinc-100 font-bold mt-1 leading-relaxed">Menganalisa riwayat penjualan AmbaToys...</p>
                        </div>
                    </div>
                    <div id="ai-trend-badge" class="badge badge-lg border-0 font-black uppercase text-[10px] italic py-3 px-4">
                        Processing
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-zinc-900 border border-zinc-800 rounded-2xl overflow-hidden shadow-xl p-6">
            <div class="flex items-center justify-between mb-8 px-2">
                <div>
                    <h2 class="font-black text-sm uppercase tracking-widest text-white italic">Estimasi Omzet 7 Hari</h2>
                    <p class="text-[10px] text-zinc-500 font-bold mt-1">Sistem Prediksi Linear Regression v1.0</p>
                </div>
                <div class="flex items-center gap-2">
                    <div class="h-3 w-3 rounded-full bg-indigo-500"></div>
                    <span class="text-[10px] font-bold text-zinc-400">Prediksi</span>
                </div>
            </div>
            <div class="h-[300px] w-full">
                <canvas id="forecastChart"></canvas>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <div class="bg-zinc-900 border border-zinc-800 rounded-2xl overflow-hidden shadow-xl">
                <div class="px-6 py-4 border-b border-zinc-800 flex items-center gap-3">
                    <span class="w-2.5 h-2.5 rounded-full bg-fuchsia-500"></span>
                    <h2 class="font-black text-xs uppercase tracking-widest text-white">AI: Kurang Laku</h2>
                </div>
                <div id="slow-moving-list" class="divide-y divide-zinc-800/50">
                    <p class="px-6 py-6 text-xs text-zinc-500">Memuat analisa barang slow moving...</p>
                </div>
            </div>

            <div class="bg-zinc-900 border border-zinc-800 rounded-2xl overflow-hidden shadow-xl">
                <div class="px-6 py-4 border-b border-zinc-800 flex items-center gap-3">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                    <h2 class="font-black text-xs uppercase tracking-widest text-white">AI: Paling Laku</h2>
                </div>
                <div id="fast-moving-list" class="divide-y divide-zinc-800/50">
                    <p class="px-6 py-6 text-xs text-zinc-500">Memuat analisa barang fast moving...</p>
                </div>
            </div>

            <div class="bg-zinc-900 border border-zinc-800 rounded-2xl overflow-hidden shadow-xl">
                <div class="px-6 py-4 border-b border-zinc-800 flex items-center gap-3">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                    <h2 class="font-black text-xs uppercase tracking-widest text-white">AI: Saran Restock</h2>
                </div>
                <div id="restock-list" class="divide-y divide-zinc-800/50">
                    <p class="px-6 py-6 text-xs text-zinc-500">Memuat prioritas restock...</p>
                </div>
            </div>
        </div>

        <div class="bg-zinc-900 border border-zinc-800 rounded-2xl overflow-hidden shadow-xl">
            <div class="px-6 py-4 border-b border-zinc-800 flex items-center gap-3">
                <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-pulse"></span>
                <h2 class="font-black text-xs uppercase tracking-widest text-white">Stok Menipis (Limit ≤ 5)</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="table table-compact w-full">
                    <thead class="text-[10px] uppercase tracking-widest text-zinc-500 bg-zinc-950/30">
                        <tr>
                            <th class="py-4 px-6 border-0">Kode SKU</th>
                            <th class="border-0">Nama Produk</th>
                            <th class="border-0">Kategori</th>
                            <th class="border-0 text-right">Sisa Stok</th>
                        </tr>
                    </thead>
                    <tbody class="text-xs">
                        <?php if ($low_stock === []): ?>
                            <tr><td colspan="4" class="text-center text-zinc-600 py-10 italic">Semua stok dalam kondisi aman.</td></tr>
                        <?php else: ?>
                            <?php foreach ($low_stock as $p): ?>
                                <tr class="hover:bg-zinc-800/40 transition-colors border-zinc-800/50">
                                    <td class="px-6 font-mono text-blue-500 font-bold tracking-tighter"><?= esc($p['kode_product'] ?? '-') ?></td>
                                    <td class="font-bold text-zinc-200"><?= esc($p['nama_product'] ?? '') ?></td>
                                    <td><span class="badge badge-outline border-zinc-700 text-[10px] uppercase font-bold text-zinc-500"><?= esc($p['kategori'] ?? '') ?></span></td>
                                    <td class="text-right font-black text-amber-500 tabular-nums text-sm"><?= (int) ($p['qty'] ?? 0) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const aiContainer = document.getElementById('ai-insight-container');
        const aiMessage = document.getElementById('ai-message');
        const aiTrend = document.getElementById('ai-trend-badge');
        const slowMovingList = document.getElementById('slow-moving-list');
        const fastMovingList = document.getElementById('fast-moving-list'); // TAMBAHAN ID Paling Laku
        const restockList = document.getElementById('restock-list');
        const ctx = document.getElementById('forecastChart').getContext('2d');

        // Render chart fallback agar user tetap dapat feedback saat data AI gagal.
        const renderFallbackChart = (label = 'Data tidak tersedia') => {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [label],
                    datasets: [{
                        label: 'Prediksi Omzet',
                        data: [0],
                        borderColor: '#3f3f46',
                        borderWidth: 2,
                        backgroundColor: 'rgba(63, 63, 70, 0.2)',
                        fill: true,
                        tension: 0.2,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { grid: { color: '#27272a' }, ticks: { color: '#71717a' } },
                        x: { grid: { display: false }, ticks: { color: '#71717a' } }
                    }
                }
            });
        };

        const renderSlowMoving = (items = []) => {
            if (!Array.isArray(items) || items.length === 0) {
                slowMovingList.innerHTML = '<p class="px-6 py-6 text-xs text-zinc-500">Tidak ada produk slow moving dalam 30 hari terakhir.</p>';
                return;
            }

            slowMovingList.innerHTML = items.map((item) => `
                <div class="px-6 py-4">
                    <p class="text-sm font-bold text-zinc-200">${item.nama_product ?? '-'}</p>
                    <p class="text-[11px] text-zinc-500 mt-1">${item.kategori ?? '-'} • Terjual 30 hari: ${item.terjual_30_hari ?? 0} • Stok: ${item.stok_saat_ini ?? 0}</p>
                    <p class="text-[11px] text-fuchsia-400 mt-2">${item.saran ?? '-'}</p>
                </div>
            `).join('');
        };

        // TAMBAHAN FUNCTION: Render Paling Laku
        const renderFastMoving = (items = []) => {
            if (!Array.isArray(items) || items.length === 0) {
                fastMovingList.innerHTML = '<p class="px-6 py-6 text-xs text-zinc-500">Tidak ada data produk fast moving.</p>';
                return;
            }

            fastMovingList.innerHTML = items.map((item) => `
                <div class="px-6 py-4">
                    <p class="text-sm font-bold text-zinc-200">${item.nama_product ?? '-'}</p>
                    <p class="text-[11px] text-zinc-500 mt-1">${item.kategori ?? '-'} • Terjual 30 hari: <span class="text-blue-400 font-bold">${item.terjual_30_hari ?? 0}</span> • Rata-rata harian: ${item.rata_harian ?? 0}</p>
                    <p class="text-[11px] text-blue-400 mt-2">${item.saran ?? '-'}</p>
                </div>
            `).join('');
        };

        const renderRestockPlan = (items = []) => {
            if (!Array.isArray(items) || items.length === 0) {
                restockList.innerHTML = '<p class="px-6 py-6 text-xs text-zinc-500">Stok relatif aman, belum ada restock prioritas.</p>';
                return;
            }

            restockList.innerHTML = items.map((item) => {
                const priorityClass = item.priority === 'tinggi' ? 'bg-red-500 text-white' : 'bg-emerald-500 text-zinc-950';
                return `
                    <div class="px-6 py-4">
                        <div class="flex items-start justify-between gap-3">
                            <p class="text-sm font-bold text-zinc-200">${item.nama_product ?? '-'}</p>
                            <span class="text-[10px] px-2 py-0.5 rounded font-black uppercase ${priorityClass}">${item.priority ?? 'normal'}</span>
                        </div>
                        <p class="text-[11px] text-zinc-500 mt-1">Stok: ${item.stok_saat_ini ?? 0} • Avg/day: ${item.rata_harian ?? 0} • Estimasi habis: ${item.estimasi_habis_hari ?? 0} hari</p>
                        <p class="text-[11px] text-emerald-400 mt-2">Saran restock: +${item.qty_restock ?? 0} unit</p>
                    </div>
                `;
            }).join('');
        };

        try {
            const response = await fetch('<?= base_url('dashboard/get-ai-data') ?>');
            const resData = await response.json().catch(() => ({}));

            if (response.ok && resData.status === 'success' && Array.isArray(resData.forecast) && resData.forecast.length > 0) {
                aiContainer.classList.remove('hidden');
                aiMessage.innerText = resData.insight;
                
                // Panggil render function untuk masing-masing panel
                renderSlowMoving(resData.ops_insight?.slow_moving ?? []);
                renderFastMoving(resData.ops_insight?.fast_moving ?? []); // TAMBAHAN PEMANGGILAN FAST MOVING
                renderRestockPlan(resData.ops_insight?.restock_plan ?? []);
                
                // Set Badge Trend
                aiTrend.innerText = resData.trend;
                aiTrend.classList.add(resData.trend === 'naik' ? 'bg-emerald-500' : 'bg-amber-500');
                aiTrend.classList.add('text-zinc-950');

                // Gradient for chart
                const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                gradient.addColorStop(0, 'rgba(99, 102, 241, 0.3)');
                gradient.addColorStop(1, 'rgba(99, 102, 241, 0)');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: resData.forecast.map(f => f.tanggal),
                        datasets: [{
                            label: 'Prediksi Omzet',
                            data: resData.forecast.map(f => f.prediksi_omzet),
                            borderColor: '#818cf8',
                            borderWidth: 4,
                            backgroundColor: gradient,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 6,
                            pointHoverRadius: 8,
                            pointBackgroundColor: '#818cf8',
                            pointBorderColor: '#18181b',
                            pointBorderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { 
                                grid: { color: '#27272a', borderDash: [5, 5] }, 
                                ticks: { 
                                    color: '#71717a',
                                    callback: (value) => 'Rp ' + value.toLocaleString('id-ID')
                                } 
                            },
                            x: { grid: { display: false }, ticks: { color: '#71717a' } }
                        }
                    }
                });
            } else {
                aiContainer.classList.remove('hidden');
                aiMessage.innerText = resData.message ?? 'Data prediksi belum siap. Cek data transaksi minimal dan koneksi AI service.';
                aiTrend.innerText = 'error';
                aiTrend.classList.add('bg-red-500', 'text-zinc-50');
                renderFallbackChart('Prediksi belum tersedia');
                renderSlowMoving([]);
                renderFastMoving([]); // Render error fallback fast moving
                renderRestockPlan([]);
            }
        } catch (error) {
            console.error('AI Data Error:', error);
            aiContainer.classList.remove('hidden');
            aiMessage.innerText = 'Gagal mengambil data AI. Pastikan Flask service aktif di port 5000.';
            aiTrend.innerText = 'offline';
            aiTrend.classList.add('bg-red-500', 'text-zinc-50');
            renderFallbackChart('Service offline');
            renderSlowMoving([]);
            renderFastMoving([]); // Render error fallback fast moving
            renderRestockPlan([]);
        }
    });
</script>

<?= $this->endSection() ?>