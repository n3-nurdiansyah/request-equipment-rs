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
            <a href="#" onclick="confirmLogout(event)" class="flex items-center gap-3 px-4 py-3 mt-auto rounded-2xl text-red-600 hover:bg-red-50 hover:shadow-sm border border-transparent hover:border-red-100 transition-all font-semibold group">
                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                Keluar Sistem
            </a>
        </div>
    </aside>
</div>


<script>
    function confirmLogout(e) {
        e.preventDefault(); // Mencegah link langsung berpindah
        Swal.fire({
            title: 'Yakin ingin keluar?',
            text: "Sesi Anda akan diakhiri dengan aman.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444', // Merah Tailwind
            cancelButtonColor: '#94a3b8', // Slate Tailwind
            confirmButtonText: 'Ya, Keluar!',
            cancelButtonText: 'Batal',
            background: 'rgba(255, 255, 255, 0.9)', // Efek transparan
            customClass: {
                popup: 'rounded-3xl backdrop-blur-md border border-white/60 shadow-2xl'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Ganti URL ini sesuai dengan controller logout Anda
                window.location.href = "<?= site_url('auth/logout') ?>";
            }
        })
    }
</script>