<x-layout-dashboard judul-seo="Tinjau Guru" :menu="\App\Support\MenuDashboard::administrator()">
    <a href="{{ route('admin.verifikasi-guru.index') }}" class="text-sm text-teal-700 dark:text-teal-400 hover:underline">&larr; Kembali</a>
    <h1 class="mt-2 text-2xl font-bold text-slate-900 dark:text-slate-100">{{ $verifikasi->pengguna->nama_lengkap }}</h1>

    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-3">
        <x-kartu class="lg:col-span-2">
            <h2 class="font-semibold text-slate-800 dark:text-slate-100">Data Pendaftaran</h2>
            <dl class="mt-4 grid grid-cols-1 gap-4 text-sm sm:grid-cols-2">
                <div><dt class="text-slate-400 dark:text-slate-500">Email</dt><dd class="font-medium text-slate-700 dark:text-slate-300">{{ $verifikasi->pengguna->email }}</dd></div>
                <div><dt class="text-slate-400 dark:text-slate-500">Nomor Telepon</dt><dd class="font-medium text-slate-700 dark:text-slate-300">{{ $verifikasi->pengguna->nomor_telepon }}</dd></div>
                <div><dt class="text-slate-400 dark:text-slate-500">Instansi</dt><dd class="font-medium text-slate-700 dark:text-slate-300">{{ $verifikasi->pengguna->profilGuru?->instansiPendidikan?->nama_instansi }}</dd></div>
                <div><dt class="text-slate-400 dark:text-slate-500">NIP/NUPTK/NIM</dt><dd class="font-medium text-slate-700 dark:text-slate-300">{{ $verifikasi->pengguna->profilGuru?->nip_nuptk ?: '-' }}</dd></div>
                <div><dt class="text-slate-400 dark:text-slate-500">Bidang Studi</dt><dd class="font-medium text-slate-700 dark:text-slate-300">{{ $verifikasi->pengguna->profilGuru?->bidang_studi }}</dd></div>
                <div><dt class="text-slate-400 dark:text-slate-500">Jenis Kelamin</dt><dd class="font-medium text-slate-700 dark:text-slate-300">{{ $verifikasi->pengguna->profilGuru?->jenis_kelamin }}</dd></div>
                <div class="sm:col-span-2"><dt class="text-slate-400 dark:text-slate-500">Alamat</dt><dd class="font-medium text-slate-700 dark:text-slate-300">{{ $verifikasi->pengguna->profilGuru?->alamat }}</dd></div>
            </dl>

            @if($verifikasi->catatan)
                <x-alert jenis="info" class="mt-4">Catatan sebelumnya: {{ $verifikasi->catatan }}</x-alert>
            @endif
        </x-kartu>

        <x-kartu>
            <h2 class="font-semibold text-slate-800 dark:text-slate-100">Keputusan</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Status saat ini:
                <x-badge :warna="match($verifikasi->status->value) { 'disetujui' => 'emerald', 'ditolak' => 'rose', 'perlu_perbaikan' => 'orange', default => 'amber' }">
                    {{ $verifikasi->status->label() }}
                </x-badge>
            </p>

            <form method="POST" action="{{ route('admin.verifikasi-guru.setujui', $verifikasi) }}" class="mt-4">
                @csrf
                <x-tombol type="submit" class="w-full">Setujui &amp; Aktifkan</x-tombol>
            </form>

            <form method="POST" action="{{ route('admin.verifikasi-guru.minta-perbaikan', $verifikasi) }}" class="mt-3 space-y-2">
                @csrf
                <x-textarea name="catatan" placeholder="Catatan perbaikan..." :baris="2" />
                <x-tombol type="submit" varian="sekunder" class="w-full">Minta Perbaikan</x-tombol>
            </form>

            <form method="POST" action="{{ route('admin.verifikasi-guru.tolak', $verifikasi) }}" class="mt-3 space-y-2">
                @csrf
                <x-textarea name="catatan" placeholder="Alasan penolakan..." :baris="2" />
                <x-tombol type="submit" varian="bahaya" class="w-full">Tolak</x-tombol>
            </form>
        </x-kartu>
    </div>
</x-layout-dashboard>
