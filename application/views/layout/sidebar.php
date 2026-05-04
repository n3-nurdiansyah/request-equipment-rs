<!-- Wrapper -->
<div class="flex h-screen overflow-hidden p-4 gap-4">

    <!-- Sidebar (macOS Dock Style) -->
    <aside class="w-64 flex flex-col rounded-3xl bg-white/40 backdrop-blur-2xl border border-white/60 shadow-xl overflow-hidden relative z-10">
        <div class="p-6 border-b border-white/50">
            <h2 class="font-bold text-lg text-slate-800">BPAFK System</h2>
            <p class="text-xs text-indigo-600 font-medium mt-1">
                Halo, <?= ucfirst($user['username']) ?> (<?= $user['role'] ?>)
            </p>
        </div>

        <nav class="flex-1 p-4 space-y-2">
            <!-- 1. Link Menu Dashboard -->
            <a href="<?= site_url('dashboard') ?>"
                class="<?= ($this->uri->segment(1) == 'dashboard' || $this->uri->segment(1) == '') ? 'bg-white/60 text-indigo-700 shadow-sm border-white/50' : 'text-slate-600 hover:bg-white/40 hover:text-slate-900' ?> flex items-center gap-3 px-4 py-3 rounded-xl font-medium border border-transparent transition-all cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Dashboard
            </a>

            <!-- 2. Link Menu Pengajuan Alat -->
            <a href="<?= site_url('request') ?>"
                class="<?= ($this->uri->segment(1) == 'request') ? 'bg-white/60 text-indigo-700 shadow-sm border-white/50' : 'text-slate-600 hover:bg-white/40 hover:text-slate-900' ?> flex items-center gap-3 px-4 py-3 rounded-xl font-medium border border-transparent transition-all cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Pengajuan Alat
            </a>
        </nav>

        <div class="p-4 border-t border-white/50">
            <!-- 3. Link Menu Log Out -->
            <a href="<?= site_url('auth/logout') ?>"
                class="flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50/50 rounded-xl font-medium transition-all cursor-pointer">
                Log Out
            </a>
        </div>
    </aside>
</div>