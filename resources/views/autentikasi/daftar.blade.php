<x-layout-auth judul-seo="Daftar">
    <h1 class="text-xl font-bold text-slate-900">Daftar Akun Baru</h1>
    <p class="mt-1 text-sm text-slate-500">Pilih jenis akun sesuai peran Anda.</p>

    <div class="mt-6 space-y-4">
        <a href="{{ route('daftar.guru') }}" class="block rounded-xl border border-slate-200 p-4 transition hover:border-teal-600 hover:bg-teal-50">
            <p class="font-semibold text-slate-800">Daftar sebagai Guru</p>
            <p class="mt-1 text-sm text-slate-500">Susun dan publikasikan e-modul, LKPD, observasi, dan kelas belajar.</p>
        </a>

        <a href="{{ route('daftar.siswa') }}" class="block rounded-xl border border-slate-200 p-4 transition hover:border-teal-600 hover:bg-teal-50">
            <p class="font-semibold text-slate-800">Daftar sebagai Siswa</p>
            <p class="mt-1 text-sm text-slate-500">Belajar, bergabung ke kelas, dan mengerjakan LKPD serta observasi.</p>
        </a>
    </div>

    <p class="mt-6 text-center text-sm text-slate-500">
        Sudah punya akun?
        <a href="{{ route('masuk') }}" class="font-medium text-teal-700 hover:underline">Masuk</a>
    </p>
</x-layout-auth>
