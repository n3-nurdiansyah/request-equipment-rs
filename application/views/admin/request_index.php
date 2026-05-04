<main class="flex-1 flex flex-col h-full rounded-3xl bg-white/30 backdrop-blur-xl border border-white/50 shadow-xl overflow-y-auto">

    <header class="p-6 border-b border-white/30 bg-white/20">
        <h3 class="text-2xl font-semibold text-slate-800 tracking-tight">Verifikasi Pengajuan Alat</h3>
        <p class="text-sm text-slate-600 mt-1">Kelola permohonan pengecekan alat dari berbagai instansi kesehatan.</p>
    </header>

    <div class="p-6 flex-1 flex flex-col">

        <!-- Toolbar: Client-Side Pencarian & Filter (Vanilla JS) -->
        <div class="flex flex-col sm:flex-row justify-between gap-4 mb-6">
            <div class="relative w-full sm:w-96">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" id="searchInputAdmin" class="w-full pl-11 pr-4 py-3 rounded-xl bg-white/60 backdrop-blur-md border border-white/60 focus:bg-white/90 focus:ring-2 focus:ring-indigo-400 focus:outline-none transition-all placeholder-slate-400 text-sm text-slate-800 shadow-sm" placeholder="Cari Instansi, Alat, atau Kode...">
            </div>

            <div class="w-full sm:w-auto">
                <select id="statusFilterAdmin" class="w-full px-5 py-3 rounded-xl bg-white/60 backdrop-blur-md border border-white/60 focus:bg-white/90 focus:ring-2 focus:ring-indigo-400 focus:outline-none transition-all text-slate-700 text-sm font-semibold appearance-none cursor-pointer shadow-sm outline-none">
                    <option value="all">Semua Status</option>
                    <option value="pending">⏳ Pending</option>
                    <option value="processing">⚙️ Processing</option>
                    <option value="completed">✅ Completed</option>
                    <option value="rejected">❌ Rejected</option>
                </select>
            </div>
        </div>

        <!-- Tabel Data Admin -->
        <div class="flex-1 rounded-2xl border border-white/60 bg-white/40 shadow-sm backdrop-blur-md overflow-hidden flex flex-col">
            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left text-sm text-slate-600 min-w-max">
                    <thead class="bg-white/50 text-slate-800 font-semibold border-b border-white/60 sticky top-0 backdrop-blur-md z-10">
                        <tr>
                            <th class="px-6 py-4">Tgl Masuk</th>
                            <th class="px-6 py-4">Instansi Pengaju</th>
                            <th class="px-6 py-4">Alat & No. Seri</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-center">Tindakan Admin</th>
                        </tr>
                    </thead>
                    <tbody id="tableBodyAdmin" class="divide-y divide-white/40">
                        <?php if (!empty($requests)): ?>
                            <?php foreach ($requests as $req): ?>
                                <tr class="hover:bg-white/60 transition-colors duration-200 request-row-admin" data-status="<?= $req['status'] ?>">
                                    <td class="px-6 py-4 whitespace-nowrap text-slate-500 font-medium"><?= date('d M Y', strtotime($req['request_date'])) ?></td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs border border-indigo-200">
                                                <?= strtoupper(substr($req['hospital_name'], 0, 2)) ?>
                                            </div>
                                            <span class="font-bold text-slate-700"><?= html_escape($req['hospital_name']) ?></span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <p class="font-bold text-slate-800"><?= html_escape($req['equipment_name']) ?></p>
                                        <p class="text-xs text-indigo-500 font-mono mt-1">REQ: <?= $req['request_code'] ?></p>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php if ($req['status'] == 'pending'): ?>
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-slate-100/80 text-slate-600 border border-slate-300 shadow-sm backdrop-blur-sm">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg> PENDING
                                            </span>
                                        <?php elseif ($req['status'] == 'processing'): ?>
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-amber-100/80 text-amber-800 border border-amber-300 shadow-sm backdrop-blur-sm">
                                                <svg class="w-3.5 h-3.5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg> PROCESSING
                                            </span>
                                        <?php elseif ($req['status'] == 'completed'): ?>
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-100/80 text-emerald-800 border border-emerald-300 shadow-sm backdrop-blur-sm">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg> COMPLETED
                                            </span>
                                        <?php elseif ($req['status'] == 'rejected'): ?>
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-red-100/80 text-red-800 border border-red-300 shadow-sm backdrop-blur-sm">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg> REJECTED
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- TOMBOL AKSI ADMIN MENGGUNAKAN SWEETALERT -->
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <?php if ($req['status'] == 'pending'): ?>
                                                <button onclick="confirmAdminAction('<?= site_url('request/update_status/' . $req['id'] . '/processing') ?>', 'Terima & Proses?', 'Alat ini akan masuk ke tahap kalibrasi.', 'info', '#4f46e5', 'Ya, Proses!')" class="px-3 py-1.5 rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 text-xs font-bold transition-all shadow-md active:scale-95">Terima & Proses</button>

                                                <button onclick="confirmAdminAction('<?= site_url('request/update_status/' . $req['id'] . '/rejected') ?>', 'Tolak Pengajuan?', 'Pengajuan akan dikembalikan ke instansi untuk diperbaiki.', 'warning', '#ef4444', 'Ya, Tolak!')" class="px-3 py-1.5 rounded-lg text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 text-xs font-bold transition-all active:scale-95">Tolak</button>

                                            <?php elseif ($req['status'] == 'processing'): ?>
                                                <button onclick="confirmAdminAction('<?= site_url('request/update_status/' . $req['id'] . '/completed') ?>', 'Selesaikan Kalibrasi?', 'Status akan menjadi Completed dan tidak dapat diubah lagi.', 'success', '#10b981', 'Ya, Selesai!')" class="px-3 py-1.5 rounded-lg text-white bg-emerald-500 hover:bg-emerald-600 text-xs font-bold transition-all shadow-md active:scale-95">Tandai Selesai</button>

                                            <?php else: ?>
                                                <!-- Jika sudah Selesai atau Ditolak, Admin tidak memiliki tombol aksi, hanya label Terkunci -->
                                                <span class="text-xs font-bold text-slate-400 bg-white/50 px-3 py-1.5 rounded-lg border border-white/60">Terkunci</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-slate-500">Belum ada pengajuan masuk.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <div id="noResultMsgAdmin" class="hidden px-6 py-10 text-center">
                    <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-slate-500 font-medium text-lg">Oops! Data tidak ditemukan.</p>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-white/50 bg-white/30 flex items-center justify-between">
                <?= isset($pagination) ? $pagination : '' ?>
            </div>

        </div>
    </div>
</main>

<script>
    // 1. Script Filter Real-Time Admin
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInputAdmin');
        const statusFilter = document.getElementById('statusFilterAdmin');
        const tableRows = document.querySelectorAll('.request-row-admin');
        const noResultMsg = document.getElementById('noResultMsgAdmin');

        function filterAdminTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const statusTerm = statusFilter.value.toLowerCase();
            let visibleCount = 0;

            tableRows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                const rowStatus = row.getAttribute('data-status').toLowerCase();

                const matchesSearch = rowText.includes(searchTerm);
                const matchesStatus = (statusTerm === 'all') ? true : (rowStatus === statusTerm);

                if (matchesSearch && matchesStatus) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            if (visibleCount === 0 && tableRows.length > 0) {
                noResultMsg.classList.remove('hidden');
            } else {
                noResultMsg.classList.add('hidden');
            }
        }

        searchInput.addEventListener('input', filterAdminTable);
        statusFilter.addEventListener('change', filterAdminTable);
    });

    // 2. Fungsi SweetAlert Universal untuk Aksi Admin
    function confirmAdminAction(url, title, text, icon, btnColor, btnText) {
        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: btnColor,
            cancelButtonColor: '#94a3b8',
            confirmButtonText: btnText,
            cancelButtonText: 'Batal',
            background: 'rgba(255, 255, 255, 0.95)',
            customClass: {
                popup: 'rounded-3xl backdrop-blur-md border border-white/60 shadow-xl'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        })
    }

    // 3. Notifikasi Flashdata CodeIgniter -> SweetAlert Toast
    <?php if ($this->session->flashdata('success')): ?>
        Swal.fire({
            icon: 'success',
            title: 'Sukses!',
            text: '<?= $this->session->flashdata("success") ?>',
            timer: 3000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end',
            customClass: {
                popup: 'rounded-2xl border border-white/60 shadow-lg mt-4 mr-4'
            }
        });
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '<?= $this->session->flashdata("error") ?>',
            timer: 4000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end',
            customClass: {
                popup: 'rounded-2xl border border-white/60 shadow-lg mt-4 mr-4'
            }
        });
    <?php endif; ?>
</script>