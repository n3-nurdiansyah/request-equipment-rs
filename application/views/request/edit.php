<main class="flex-1 flex flex-col h-full rounded-3xl bg-white/30 backdrop-blur-xl border border-white/50 shadow-xl overflow-y-auto">
    <header class="p-6 border-b border-white/30 bg-white/20 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="<?= site_url('request') ?>" class="p-2 rounded-xl bg-white/50 hover:bg-white/80 text-slate-600 transition-colors border border-white/60 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h3 class="text-2xl font-semibold text-slate-800 tracking-tight">Edit Pengajuan</h3>
                <p class="text-sm text-slate-600 mt-1">Ubah atau batalkan pengajuan Anda sebelum diproses.</p>
            </div>
        </div>
        <!-- Tombol Batalkan / Delete -->
        <a href="<?= site_url('request/delete/' . $request['id']) ?>"
            onclick="return confirm('Apakah Anda yakin ingin membatalkan pengajuan ini? Data akan dihapus permanen.')"
            class="px-4 py-2 rounded-xl bg-rose-50 text-rose-600 text-sm font-bold border border-rose-200 hover:bg-rose-100 transition-all flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
            Batalkan Pengajuan
        </a>
    </header>

    <div class="p-6 flex-1 flex justify-center items-start pt-10">
        <div class="w-full max-w-2xl p-8 rounded-3xl bg-white/50 backdrop-blur-md border border-white/60 shadow-sm">
            <?php if ($this->session->flashdata('error')): ?>
                <div class="mb-6 p-4 rounded-xl bg-red-100/80 border border-red-200 text-red-600 text-sm font-medium">
                    <?= $this->session->flashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= site_url('request/update/' . $request['id']) ?>" method="POST" class="space-y-6">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />

                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Alat Kesehatan <span class="text-red-500">*</span></label>
                        <input type="text" name="equipment_name" required value="<?= $request['equipment_name'] ?>"
                            class="w-full px-4 py-3 rounded-xl bg-white/60 border border-white/60 focus:bg-white/90 focus:ring-2 focus:ring-indigo-400 outline-none transition-all shadow-inner">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nomor Seri (Serial Number) <span class="text-red-500">*</span></label>
                        <input type="text" name="serial_number" required value="<?= $request['serial_number'] ?>"
                            class="w-full px-4 py-3 rounded-xl bg-white/60 border border-white/60 focus:bg-white/90 focus:ring-2 focus:ring-indigo-400 outline-none transition-all shadow-inner font-mono">
                    </div>
                </div>

                <div class="pt-4 flex justify-end gap-3 border-t border-white/40">
                    <a href="<?= site_url('request') ?>" class="px-6 py-2.5 rounded-xl bg-white/50 text-slate-700 font-semibold border border-white/60 transition-all hover:bg-white/80">Kembali</a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 text-white font-semibold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition-all active:scale-95">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>