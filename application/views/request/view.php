<main class="flex-1 flex flex-col h-full rounded-3xl bg-white/30 backdrop-blur-xl border border-white/50 shadow-xl overflow-y-auto">
    <header class="p-6 border-b border-white/30 bg-white/20 flex items-center gap-4">
        <!-- Tombol Kembali -->
        <a href="<?= site_url('request') ?>" class="p-2 rounded-xl bg-white/50 hover:bg-white/80 text-slate-600 transition-colors shadow-sm border border-white/60">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <div>
            <h3 class="text-2xl font-semibold text-slate-800 tracking-tight">Detail Pengajuan: <?= $req['request_code'] ?></h3>
            <p class="text-sm text-slate-600 mt-1">Tanggal Pengajuan: <?= date('d F Y', strtotime($req['request_date'])) ?></p>
        </div>
    </header>

    <div class="p-6 flex-1 flex justify-center items-start pt-10">
        <div class="w-full max-w-2xl p-8 rounded-3xl bg-white/50 backdrop-blur-md border border-white/60 shadow-sm space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-b border-white/40 pb-6">
                <div>
                    <p class="text-sm font-semibold text-slate-500 mb-1">Nama Alat Kesehatan</p>
                    <p class="font-bold text-slate-800 text-lg"><?= $req['equipment_name'] ?></p>
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-500 mb-1">Nomor Seri (SN)</p>
                    <p class="font-bold text-slate-800 text-lg font-mono"><?= $req['serial_number'] ?></p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <p class="text-sm font-semibold text-slate-500">Status Saat Ini:</p>
                <!-- Badge Status Dinamis -->
                <?php if ($req['status'] == 'pending'): ?>
                    <span class="px-4 py-1.5 rounded-full text-sm font-bold bg-slate-200 text-slate-700 uppercase tracking-wider shadow-inner">PENDING</span>
                <?php elseif ($req['status'] == 'processing'): ?>
                    <span class="px-4 py-1.5 rounded-full text-sm font-bold bg-amber-200 text-amber-800 uppercase tracking-wider shadow-inner">PROCESSING</span>
                <?php elseif ($req['status'] == 'completed'): ?>
                    <span class="px-4 py-1.5 rounded-full text-sm font-bold bg-emerald-200 text-emerald-800 uppercase tracking-wider shadow-inner">COMPLETED</span>
                <?php elseif ($req['status'] == 'rejected'): ?>
                    <span class="px-4 py-1.5 rounded-full text-sm font-bold bg-red-200 text-red-800 uppercase tracking-wider shadow-inner">REJECTED</span>
                <?php endif; ?>
            </div>

            <?php if ($req['status'] == 'rejected'): ?>
                <div class="mt-4 p-4 rounded-xl bg-red-50/80 border border-red-200 text-red-700 text-sm">
                    <strong>Catatan Admin:</strong> Alat tidak memenuhi syarat administrasi. Silakan perbaiki data dan ajukan kembali.
                </div>
            <?php endif; ?>

        </div>
    </div>
</main>