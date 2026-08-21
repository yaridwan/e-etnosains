<x-layout-auth judul-seo="Daftar sebagai Guru">
    <h1 class="text-xl font-bold text-slate-900">Daftar sebagai Guru</h1>
    <p class="mt-1 text-sm text-slate-500">Akun akan aktif setelah verifikasi email dan persetujuan Administrator.</p>

    <form method="POST" action="{{ route('daftar.guru.proses') }}" class="mt-6 space-y-4">
        @csrf

        <x-input label="Nama Lengkap" name="nama_lengkap" wajib autofocus />
        <x-input label="Email" name="email" type="email" wajib />
        <x-input label="Nomor Telepon" name="nomor_telepon" wajib />

        <x-select label="Jenis Kelamin" name="jenis_kelamin" wajib :opsi="['Laki-laki' => 'Laki-laki', 'Perempuan' => 'Perempuan']" />

        <x-select label="Instansi/Sekolah" name="id_instansi_pendidikan" wajib :opsi="$instansi->pluck('nama_instansi', 'id')" />

        <x-input label="NIP/NUPTK (opsional)" name="nip_nuptk" />
        <x-input label="Bidang/Mata Pelajaran" name="bidang_studi" wajib />
        <x-textarea label="Alamat" name="alamat" wajib />

        <x-input label="Kata Sandi" name="kata_sandi" type="password" wajib />
        <x-input label="Konfirmasi Kata Sandi" name="kata_sandi_confirmation" type="password" wajib />

        <x-tombol type="submit" varian="utama" class="w-full">Daftar</x-tombol>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500">
        Sudah punya akun?
        <a href="{{ route('masuk') }}" class="font-medium text-teal-700 hover:underline">Masuk</a>
    </p>
</x-layout-auth>
