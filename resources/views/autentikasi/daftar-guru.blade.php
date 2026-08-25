<x-layout-auth judul-seo="Daftar sebagai Guru" lebar="max-w-2xl">
    <h1 class="text-xl font-bold text-slate-900 dark:text-slate-100">Daftar sebagai Guru</h1>
    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Akun akan aktif setelah verifikasi email dan persetujuan Administrator.</p>

    <form method="POST" action="{{ route('daftar.guru.proses') }}" class="mt-6 space-y-6">
        @csrf

        <div>
            <x-judul-form-seksi>Data Akun</x-judul-form-seksi>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="sm:col-span-2"><x-input label="Nama Lengkap" name="nama_lengkap" wajib autofocus /></div>
                <x-input label="Email" name="email" type="email" wajib />
                <x-input label="Nomor Telepon" name="nomor_telepon" wajib />
                <x-input label="Kata Sandi" name="kata_sandi" type="password" wajib />
                <x-input label="Konfirmasi Kata Sandi" name="kata_sandi_confirmation" type="password" wajib />
            </div>
        </div>

        <div>
            <x-judul-form-seksi>Data Kepegawaian</x-judul-form-seksi>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <x-select label="Jenis Kelamin" name="jenis_kelamin" wajib :opsi="['Laki-laki' => 'Laki-laki', 'Perempuan' => 'Perempuan']" />
                <x-input label="NIP/NUPTK (opsional)" name="nip_nuptk" />
                <div class="sm:col-span-2"><x-select label="Instansi/Sekolah" name="id_instansi_pendidikan" wajib :opsi="$instansi->pluck('nama_instansi', 'id')" /></div>
                <div class="sm:col-span-2"><x-input label="Bidang/Mata Pelajaran" name="bidang_studi" wajib /></div>
                <div class="sm:col-span-2"><x-textarea label="Alamat" name="alamat" wajib /></div>
            </div>
        </div>

        <x-tombol type="submit" varian="utama" class="w-full">Daftar</x-tombol>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500 dark:text-slate-400">
        Sudah punya akun?
        <a href="{{ route('masuk') }}" class="font-medium text-teal-700 dark:text-teal-400 hover:underline">Masuk</a>
    </p>
</x-layout-auth>
