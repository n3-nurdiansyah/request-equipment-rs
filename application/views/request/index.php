<!-- Main Content Area: Modul Pengajuan Alat -->
<main class="flex-1 flex flex-col h-full rounded-3xl bg-white/30 backdrop-blur-xl border border-white/50 shadow-xl overflow-y-auto">

    <!-- Header Modul & Action Button -->
    <header class="p-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-white/30 bg-white/20">
        <div>
            <h3 class="text-2xl font-semibold text-slate-800 tracking-tight">Manajemen Pengajuan</h3>
            <p class="text-sm text-slate-600 mt-1">Kelola dan pantau status kalibrasi alat kesehatan Anda.</p>
        </div>
        <!-- Tombol Tambah (Bisa diarahkan ke halaman form atau membuka Modal) -->
        <a href="<?= site_url('request/create') ?>" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-indigo-200 transition-all active:scale-95">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Buat Pengajuan
        </a>
    </header>

    <div class="p-6 flex-1 flex flex-col">

        <!-- Toolbar: Pencarian & Filter -->
        <div class="flex flex-col sm:flex-row justify-between gap-4 mb-6">
            <!-- Search Bar -->
            <div class="relative w-full sm:w-96">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-white/50 backdrop-blur-sm border border-white/60 focus:bg-white/80 focus:ring-2 focus:ring-indigo-400 focus:outline-none transition-all placeholder-slate-400 text-sm" placeholder="Cari kode request atau nama alat...">
            </div>

            <!-- Filter Dropdown -->
            <select class="px-4 py-2.5 rounded-xl bg-white/50 backdrop-blur-sm border border-white/60 focus:bg-white/80 focus:ring-2 focus:ring-indigo-400 focus:outline-none transition-all text-slate-600 text-sm font-medium appearance-none outline-none">
                <option value="">Semua Status</option>
                <option value="pending">Pending</option>
                <option value="processing">Processing</option>
                <option value="completed">Completed</option>
            </select>
        </div>

        <!-- Tabel Data (Full Page) -->
        <div class="flex-1 rounded-2xl border border-white/60 bg-white/40 shadow-sm backdrop-blur-md overflow-hidden flex flex-col">
            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left text-sm text-slate-600 min-w-max">
                    <thead class="bg-white/50 text-slate-800 font-semibold border-b border-white/60 sticky top-0 backdrop-blur-md z-10">
                        <tr>
                            <th class="px-6 py-4">No.</th>
                            <th class="px-6 py-4">Tanggal Masuk</th>
                            <th class="px-6 py-4">Kode Request</th>
                            <th class="px-6 py-4">Nama Alat & No. Seri</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/40">

                        <?php if (empty($requests)): ?>
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-slate-400 italic">Belum ada data pengajuan.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($requests as $index => $req): ?>
                                <tr class="hover:bg-white/50 transition-colors duration-200">
                                    <td class="px-6 py-4 font-medium text-slate-500"><?= $index + 1 ?></td>
                                    <td class="px-6 py-4"><?= date('d M Y', strtotime($req['request_date'])) ?></td>
                                    <td class="px-6 py-4 font-mono font-medium text-indigo-700"><?= $req['request_code'] ?></td>
                                    <td class="px-6 py-4">
                                        <p class="font-medium text-slate-800"><?= $req['equipment_name'] ?></p>
                                        <p class="text-xs text-slate-500 mt-0.5">SN: <?= $req['serial_number'] ?></p>
                                    </td>
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
                                        <?php elseif ($req['status'] == 'rejected'): ?>
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-rose-100/80 text-rose-700 border border-rose-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                                Rejected
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100/80 text-slate-600 border border-slate-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                                <?= ucfirst($req['status']) ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <?php if ($req['status'] == 'completed'): ?>
                                                <a href="#" class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-teal-500 hover:bg-teal-600 rounded-lg shadow-sm transition-all active:scale-95" title="Unduh Sertifikat PDF">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                                    </svg>
                                                    Sertifikat
                                                </a>
                                            <?php elseif ($req['status'] == 'processing' || $req['status'] == 'rejected'): ?>
                                                <a href="<?= site_url('request/view/' . $req['id']) ?>" class="p-2 rounded-lg text-indigo-600 hover:bg-indigo-50 transition-colors" title="Lihat Detail">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </a>
                                            <?php elseif ($req['status'] == 'pending'): ?>
                                                <a href="<?= site_url('request/edit/' . $req['id']) ?>" class="p-2 rounded-lg text-amber-600 hover:bg-amber-50 transition-colors" title="Edit Pengajuan">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    </tbody>
                </table>
            </div>

            <!-- Pagination Bar Dinamis -->
            <div class="px-6 py-4 border-t border-white/50 bg-white/30 flex items-center justify-between">
                <?php
                $showing_start = ($total_rows > 0) ? $start + 1 : 0;
                $showing_end   = min($start + $per_page, $total_rows);
                ?>
                <span class="text-sm text-slate-500">
                    Menampilkan <?= $showing_start ?> sampai <?= $showing_end ?> dari <?= $total_rows ?> entri
                </span>
                <?= $pagination ?>
            </div>
        </div>

    </div>
</main>