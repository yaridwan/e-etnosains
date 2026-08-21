<x-layout-auth judul-seo="Daftar">
    <h1 class="text-xl font-bold text-slate-900 dark:text-slate-100">Daftar Akun Baru</h1>
    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Pilih jenis akun sesuai peran Anda.</p>

    <div class="mt-6 space-y-4">
        <a href="{{ route('daftar.guru') }}" class="block rounded-xl border border-slate-200 dark:border-slate-800 p-4 transition hover:border-teal-600 dark:hover:border-teal-500 hover:bg-teal-50 dark:hover:bg-slate-800">
            <p class="font-semibold text-slate-800 dark:text-slate-100">Daftar sebagai Guru</p>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Susun dan publikasikan e-modul, LKPD, observasi, dan kelas belajar.</p>
        </a>

        <a href="{{ route('daftar.siswa') }}" class="block rounded-xl border border-slate-200 dark:border-slate-800 p-4 transition hover:border-teal-600 dark:hover:border-teal-500 hover:bg-teal-50 dark:hover:bg-slate-800">
            <p class="font-semibold text-slate-800 dark:text-slate-100">Daftar sebagai Siswa</p>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Belajar, bergabung ke kelas, dan mengerjakan LKPD serta observasi.</p>
        </a>
    </div>

    <p class="mt-6 text-center text-sm text-slate-500 dark:text-slate-400">
        Sudah punya akun?
        <a href="{{ route('masuk') }}" class="font-medium text-teal-700 dark:text-teal-400 hover:underline">Masuk</a>
    </p>
</x-layout-auth>
