<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Portal BPAFK</title>
    <!-- Ganti dengan base_url('assets/css/output.css') saat production -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-indigo-100 via-purple-50 to-teal-100 min-h-screen text-slate-800 font-sans antialiased">

    <div class="min-h-screen flex items-center justify-center p-6">
        <!-- Glassmorphism Card -->
        <div class="w-full max-w-md p-8 rounded-3xl bg-white/40 backdrop-blur-xl border border-white/50 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Portal BPAFK</h1>
                <p class="text-sm text-slate-500 mt-1">Sistem Manajemen Pengecekan Alat</p>
            </div>

            <!-- Tampilkan flashdata error jika login gagal -->
            <?php if ($this->session->flashdata('error')): ?>
                <div class="mb-4 p-3 rounded-lg bg-red-100/80 border border-red-200 text-red-600 text-sm text-center font-medium backdrop-blur-sm">
                    <?= $this->session->flashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= site_url('auth/do_login') ?>" method="POST" class="space-y-5">
                <!-- CSRF Token Security -->
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Username</label>
                    <input type="text" name="username" required class="w-full px-4 py-3 rounded-xl bg-white/50 border border-white/60 focus:bg-white/80 focus:ring-2 focus:ring-indigo-400 focus:outline-none transition-all placeholder-slate-400" placeholder="Masukkan username">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                    <input type="password" name="password" required class="w-full px-4 py-3 rounded-xl bg-white/50 border border-white/60 focus:bg-white/80 focus:ring-2 focus:ring-indigo-400 focus:outline-none transition-all" placeholder="••••••••">
                </div>
                <button type="submit" class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-lg shadow-indigo-200 transition-all active:scale-95">
                    Sign In
                </button>
            </form>
        </div>
    </div>

</body>

</html>