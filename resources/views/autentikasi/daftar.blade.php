<x-layout-auth judul-seo="Daftar">
    <h1 class="text-xl font-bold text-slate-900 dark:text-slate-100">Daftar Akun Baru</h1>
    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Pilih jenis akun sesuai peran Anda.</p>

    <div class="mt-6 space-y-4">
        <a href="{{ route('daftar.guru') }}" class="group flex items-center gap-4 rounded-xl border border-slate-200 dark:border-slate-800 p-4 transition hover:border-teal-600 dark:hover:border-teal-500 hover:bg-teal-50 dark:hover:bg-slate-800">
            <x-lencana-ikon nama="topi" class="shrink-0" />
            <div class="min-w-0 flex-1">
                <p class="font-semibold text-slate-800 dark:text-slate-100">Daftar sebagai Guru</p>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Susun dan publikasikan e-modul, LKPD, observasi, dan kelas belajar. Terbuka untuk guru, dosen, maupun mahasiswa.</p>
            </div>
            <svg class="h-5 w-5 shrink-0 text-slate-300 transition group-hover:translate-x-0.5 group-hover:text-teal-600 dark:text-slate-600 dark:group-hover:text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6" /></svg>
        </a>

        <a href="{{ route('daftar.siswa') }}" class="group flex items-center gap-4 rounded-xl border border-slate-200 dark:border-slate-800 p-4 transition hover:border-teal-600 dark:hover:border-teal-500 hover:bg-teal-50 dark:hover:bg-slate-800">
            <x-lencana-ikon nama="lingkaran-pengguna" warna="violet" class="shrink-0" />
            <div class="min-w-0 flex-1">
                <p class="font-semibold text-slate-800 dark:text-slate-100">Daftar sebagai Siswa</p>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Belajar, bergabung ke kelas, dan mengerjakan LKPD serta observasi.</p>
            </div>
            <svg class="h-5 w-5 shrink-0 text-slate-300 transition group-hover:translate-x-0.5 group-hover:text-teal-600 dark:text-slate-600 dark:group-hover:text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6" /></svg>
        </a>
    </div>

    <p class="mt-6 text-center text-sm text-slate-500 dark:text-slate-400">
        Sudah punya akun?
        <a href="{{ route('masuk') }}" class="font-medium text-teal-700 dark:text-teal-400 hover:underline">Masuk</a>
    </p>
</x-layout-auth>
