<x-layout-dashboard judul-seo="Profil Saya" :menu="\App\Support\MenuDashboard::guru()">
    <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Profil Saya</h1>

    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-2">
        <x-kartu>
            <h2 class="font-semibold text-slate-800 dark:text-slate-100">Data Diri</h2>
            <form method="POST" action="{{ route('guru.profil.update') }}" enctype="multipart/form-data" class="mt-4 space-y-4">
                @csrf @method('PUT')
                <x-input label="Nama Lengkap" name="nama_lengkap" :value="$guru->nama_lengkap" wajib />
                <x-input label="Nomor Telepon" name="nomor_telepon" :value="$guru->nomor_telepon" wajib />
                <x-input type="file" label="Foto Profil" name="foto" />
                <x-select label="Instansi" name="id_instansi_pendidikan" :opsi="$instansi->pluck('nama_instansi', 'id')" selected="{{ $guru->profilGuru?->id_instansi_pendidikan }}" />
                <x-input label="Bidang/Mata Pelajaran" name="bidang_studi" :value="$guru->profilGuru?->bidang_studi" />
                <x-textarea label="Alamat" name="alamat">{{ $guru->profilGuru?->alamat }}</x-textarea>
                <x-textarea label="Bio Singkat" name="bio">{{ $guru->profilGuru?->bio }}</x-textarea>
                <x-tombol type="submit">Simpan Profil</x-tombol>
            </form>
        </x-kartu>

        <x-kartu>
            <h2 class="font-semibold text-slate-800 dark:text-slate-100">Ubah Kata Sandi</h2>
            <form method="POST" action="{{ route('guru.profil.ubah-kata-sandi') }}" class="mt-4 space-y-4">
                @csrf @method('PUT')
                <x-input label="Kata Sandi Saat Ini" name="kata_sandi_saat_ini" type="password" wajib />
                <x-input label="Kata Sandi Baru" name="kata_sandi_baru" type="password" wajib />
                <x-input label="Konfirmasi Kata Sandi Baru" name="kata_sandi_baru_confirmation" type="password" wajib />
                <x-tombol type="submit" varian="sekunder">Ubah Kata Sandi</x-tombol>
            </form>
        </x-kartu>
    </div>
</x-layout-dashboard>
