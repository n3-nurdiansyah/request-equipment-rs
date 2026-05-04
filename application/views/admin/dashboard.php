<main class="flex-1 flex flex-col h-full rounded-3xl bg-white/30 backdrop-blur-xl border border-white/50 shadow-xl overflow-y-auto">
    <header class="p-6 border-b border-white/30 bg-white/20">
        <h3 class="text-2xl font-semibold text-slate-800 tracking-tight">Dashboard Administrator</h3>
        <p class="text-sm text-slate-600 mt-1">Pusat kendali verifikasi dan sertifikasi alat kesehatan.</p>
    </header>

    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
            <!-- Card 1: Perlu Tindakan -->
            <div class="p-5 rounded-2xl bg-white/50 backdrop-blur-md border border-white/60 shadow-sm flex items-center gap-4 hover:scale-[1.02] transition-transform">
                <div class="p-4 rounded-xl bg-red-100 text-red-600 shadow-inner">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase">Pending (Baru)</p>
                    <h4 class="text-3xl font-extrabold text-slate-800 mt-1">4</h4>
                </div>
            </div>

            <!-- Card 2: Sedang Dikalibrasi -->
            <div class="p-5 rounded-2xl bg-white/50 backdrop-blur-md border border-white/60 shadow-sm flex items-center gap-4 hover:scale-[1.02] transition-transform">
                <div class="p-4 rounded-xl bg-amber-100 text-amber-600 shadow-inner">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase">Proses Pengecekan</p>
                    <h4 class="text-3xl font-extrabold text-slate-800 mt-1">2</h4>
                </div>
            </div>

            <!-- Card 3 & 4 (Bisa Anda kustomisasi untuk Selesai / Ditolak) -->
        </div>

        <div class="rounded-2xl bg-white/40 border border-white/60 shadow-sm p-6 text-center backdrop-blur-md">
            <h5 class="text-lg font-semibold text-slate-800">Selamat Datang di Portal Admin BPAFK</h5>
            <p class="text-slate-600 text-sm mt-1">Gunakan menu Pengajuan Alat untuk mulai memverifikasi data dari Rumah Sakit.</p>
        </div>
    </div>
</main>