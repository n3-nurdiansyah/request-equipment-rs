<!-- Main Content Area -->
<main class="flex-1 flex flex-col h-full rounded-3xl bg-white/30 backdrop-blur-xl border border-white/50 shadow-xl overflow-y-auto">

    <!-- Header Dashboard -->
    <header class="p-6 border-b border-white/30 bg-white/20">
        <h3 class="text-2xl font-semibold text-slate-800 tracking-tight">Dashboard Utama</h3>
        <p class="text-sm text-slate-600 mt-1">Ringkasan aktivitas pengecekan alat kesehatan Anda hari ini.</p>
    </header>

    <div class="p-6">

        <!-- ========================================== -->
        <!-- 1. BAGIAN ATAS: SUMMARY CARDS (HORIZONTAL) -->
        <!-- ========================================== -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <!-- Card 1: Total Pengajuan -->
            <div class="p-5 rounded-2xl bg-white/50 backdrop-blur-md border border-white/60 shadow-sm flex items-center gap-5 hover:scale-[1.02] transition-transform duration-300">
                <div class="p-4 rounded-xl bg-gradient-to-br from-indigo-100 to-indigo-200 text-indigo-600 shadow-inner">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Total Alat</p>
                    <h4 class="text-3xl font-extrabold text-slate-800 mt-1"><?= number_format($total_count) ?></h4>
                </div>
            </div>

            <!-- Card 2: Diproses -->
            <div class="p-5 rounded-2xl bg-white/50 backdrop-blur-md border border-white/60 shadow-sm flex items-center gap-5 hover:scale-[1.02] transition-transform duration-300">
                <div class="p-4 rounded-xl bg-gradient-to-br from-amber-100 to-amber-200 text-amber-600 shadow-inner">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Sedang Diproses</p>
                    <h4 class="text-3xl font-extrabold text-slate-800 mt-1"><?= number_format($processing_count) ?></h4>
                </div>
            </div>

            <!-- Card 3: Selesai -->
            <div class="p-5 rounded-2xl bg-white/50 backdrop-blur-md border border-white/60 shadow-sm flex items-center gap-5 hover:scale-[1.02] transition-transform duration-300">
                <div class="p-4 rounded-xl bg-gradient-to-br from-emerald-100 to-emerald-200 text-emerald-600 shadow-inner">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Selesai Validasi</p>
                    <h4 class="text-3xl font-extrabold text-slate-800 mt-1"><?= number_format($completed_count) ?></h4>
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- 2. BAGIAN BAWAH: DATA TABLE (HISTORY)      -->
        <!-- ========================================== -->
        <div class="mb-4 flex justify-between items-end px-1">
            <div>
                <h4 class="text-xl font-bold text-slate-800">History Pengajuan Terakhir</h4>
                <p class="text-sm text-slate-500">5 pengajuan terakhir dari rumah sakit Anda.</p>
            </div>
            <!-- Tombol jalan pintas untuk melihat semua data -->
            <a href="<?= site_url('request') ?>" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 hover:underline transition-all">
                Lihat Semua Data &rarr;
            </a>
        </div>

        <!-- Table Container (Glassmorphism) -->
        <div class="rounded-2xl border border-white/60 bg-white/40 overflow-hidden shadow-sm backdrop-blur-md">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-white/50 text-slate-800 font-semibold border-b border-white/60">
                        <tr>
                            <th class="px-6 py-4 whitespace-nowrap">Tanggal</th>
                            <th class="px-6 py-4 whitespace-nowrap">Kode Request</th>
                            <th class="px-6 py-4">Nama Alat</th>
                            <th class="px-6 py-4 whitespace-nowrap">Status</th>
                            <th class="px-6 py-4 text-center whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/40">
                        <?php if (empty($recent_requests)): ?>
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-slate-400 italic">Belum ada data pengajuan.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($recent_requests as $req): ?>
                                <tr class="hover:bg-white/50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap"><?= date('d M Y', strtotime($req['request_date'])) ?></td>
                                    <td class="px-6 py-4 font-mono font-medium text-indigo-700"><?= $req['request_code'] ?></td>
                                    <td class="px-6 py-4 font-medium text-slate-800"><?= $req['equipment_name'] ?></td>
                                    <td class="px-6 py-4">
                                        <?php if ($req['status'] == 'completed'): ?>
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100/80 text-emerald-700 border border-emerald-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                Completed
                                            </span>
                                        <?php elseif ($req['status'] == 'processing'): ?>
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-100/80 text-amber-700 border border-amber-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                Processing
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100/80 text-slate-600 border border-slate-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                                <?= ucfirst($req['status']) ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <?php if ($req['status'] == 'completed'): ?>
                                            <a href="#" class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-teal-500 hover:bg-teal-600 rounded-lg shadow-sm transition-all active:scale-95">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                                </svg>
                                                Unduh Sertifikat
                                            </a>
                                        <?php elseif ($req['status'] == 'processing'): ?>
                                            <button class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition-colors">Detail</button>
                                        <?php else: ?>
                                            <button class="text-sm font-semibold text-slate-400 cursor-not-allowed" disabled>Menunggu</button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination / Footer Table Opsional -->
            <div class="px-6 py-3 border-t border-white/50 bg-white/30 text-xs text-slate-500 text-center">
                Menampilkan <?= count($recent_requests) ?> data pengajuan terakhir
            </div>
        </div>

    </div>
</main>