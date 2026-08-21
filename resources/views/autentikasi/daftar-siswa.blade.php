<x-layout-auth judul-seo="Daftar sebagai Siswa">
    <h1 class="text-xl font-bold text-slate-900">Daftar sebagai Siswa</h1>
    <p class="mt-1 text-sm text-slate-500">Mulai belajar sains lewat kearifan lokal Indonesia.</p>

    <form method="POST" action="{{ route('daftar.siswa.proses') }}" class="mt-6 space-y-4">
        @csrf

        <x-input label="Nama Lengkap" name="nama_lengkap" wajib autofocus />
        <x-input label="Email" name="email" type="email" wajib />
        <x-input label="Nomor Telepon (opsional)" name="nomor_telepon" />

        <x-select label="Jenis Kelamin" name="jenis_kelamin" wajib :opsi="['Laki-laki' => 'Laki-laki', 'Perempuan' => 'Perempuan']" />
        <x-select label="Sekolah" name="id_instansi_pendidikan" wajib :opsi="$instansi->pluck('nama_instansi', 'id')" />
        <x-input label="Kelas" name="kelas" wajib placeholder="Contoh: X IPA 1" />

        <x-input label="Kata Sandi" name="kata_sandi" type="password" wajib />
        <x-input label="Konfirmasi Kata Sandi" name="kata_sandi_confirmation" type="password" wajib />

        <x-tombol type="submit" varian="utama" class="w-full">Daftar</x-tombol>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500">
        Sudah punya akun?
        <a href="{{ route('masuk') }}" class="font-medium text-teal-700 hover:underline">Masuk</a>
    </p>
</x-layout-auth>
