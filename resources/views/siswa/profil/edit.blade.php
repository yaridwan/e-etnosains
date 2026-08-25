<x-layout-dashboard judul-seo="Profil Saya" :menu="\App\Support\MenuDashboard::siswa()">
    <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Profil Saya</h1>

    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-2">
        <x-kartu>
            <h2 class="font-semibold text-slate-800 dark:text-slate-100">Data Diri</h2>
            <form method="POST" action="{{ route('siswa.profil.update') }}" enctype="multipart/form-data" class="mt-4 space-y-4">
                @csrf @method('PUT')
                <x-unggah label="Foto Profil" name="foto" jenis="gambar" accept="image/*" :pratinjau="$siswa->foto ? \Illuminate\Support\Facades\Storage::url($siswa->foto) : null" />
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <x-input label="Nama Lengkap" name="nama_lengkap" :value="$siswa->nama_lengkap" wajib />
                    <x-input label="Nomor Telepon" name="nomor_telepon" :value="$siswa->nomor_telepon" />
                </div>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <x-select label="Sekolah" name="id_instansi_pendidikan" :opsi="$instansi->pluck('nama_instansi', 'id')" selected="{{ $siswa->profilSiswa?->id_instansi_pendidikan }}" />
                    <x-input label="Kelas" name="kelas" :value="$siswa->profilSiswa?->kelas" />
                </div>
                <x-tombol type="submit">Simpan Profil</x-tombol>
            </form>
        </x-kartu>

        <x-kartu>
            <h2 class="font-semibold text-slate-800 dark:text-slate-100">Ubah Kata Sandi</h2>
            <form method="POST" action="{{ route('siswa.profil.ubah-kata-sandi') }}" class="mt-4 space-y-4">
                @csrf @method('PUT')
                <x-input label="Kata Sandi Saat Ini" name="kata_sandi_saat_ini" type="password" wajib />
                <x-input label="Kata Sandi Baru" name="kata_sandi_baru" type="password" wajib />
                <x-input label="Konfirmasi Kata Sandi Baru" name="kata_sandi_baru_confirmation" type="password" wajib />
                <x-tombol type="submit" varian="sekunder">Ubah Kata Sandi</x-tombol>
            </form>
        </x-kartu>
    </div>
</x-layout-dashboard>
