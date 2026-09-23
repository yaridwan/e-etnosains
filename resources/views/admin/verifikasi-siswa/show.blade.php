<x-layout-dashboard judul-seo="Tinjau Siswa" :menu="\App\Support\MenuDashboard::administrator()">
    <a href="{{ route('admin.verifikasi-siswa.index') }}" class="text-sm text-teal-700 dark:text-teal-400 hover:underline">&larr; Kembali</a>
    <h1 class="mt-2 text-2xl font-bold text-slate-900 dark:text-slate-100">{{ $siswa->nama_lengkap }}</h1>

    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-3">
        <x-kartu class="lg:col-span-2">
            <h2 class="font-semibold text-slate-800 dark:text-slate-100">Data Pendaftaran</h2>
            <dl class="mt-4 grid grid-cols-1 gap-4 text-sm sm:grid-cols-2">
                <div><dt class="text-slate-400 dark:text-slate-500">Email</dt><dd class="font-medium text-slate-700 dark:text-slate-300">{{ $siswa->email }}</dd></div>
                <div><dt class="text-slate-400 dark:text-slate-500">Nomor Telepon</dt><dd class="font-medium text-slate-700 dark:text-slate-300">{{ $siswa->nomor_telepon ?: '-' }}</dd></div>
                <div><dt class="text-slate-400 dark:text-slate-500">Instansi</dt><dd class="font-medium text-slate-700 dark:text-slate-300">{{ $siswa->profilSiswa?->instansiPendidikan?->nama_instansi }}</dd></div>
                <div><dt class="text-slate-400 dark:text-slate-500">Kelas</dt><dd class="font-medium text-slate-700 dark:text-slate-300">{{ $siswa->profilSiswa?->kelas }}</dd></div>
                <div><dt class="text-slate-400 dark:text-slate-500">Jenis Kelamin</dt><dd class="font-medium text-slate-700 dark:text-slate-300">{{ $siswa->profilSiswa?->jenis_kelamin }}</dd></div>
            </dl>

            @if($siswa->catatan_verifikasi)
                <x-alert jenis="info" class="mt-4">Catatan sebelumnya: {{ $siswa->catatan_verifikasi }}</x-alert>
            @endif
        </x-kartu>

        <x-kartu>
            <h2 class="font-semibold text-slate-800 dark:text-slate-100">Keputusan</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Status saat ini:
                <x-badge :warna="match($siswa->status_akun->value) { 'aktif' => 'emerald', 'ditolak' => 'rose', 'nonaktif' => 'slate', default => 'amber' }">
                    {{ $siswa->status_akun->label() }}
                </x-badge>
            </p>

            <form method="POST" action="{{ route('admin.verifikasi-siswa.setujui', $siswa) }}" class="mt-4">
                @csrf
                <x-tombol type="submit" class="w-full">Setujui &amp; Aktifkan</x-tombol>
            </form>

            <form method="POST" action="{{ route('admin.verifikasi-siswa.tolak', $siswa) }}" class="mt-3 space-y-2">
                @csrf
                <x-textarea name="catatan" placeholder="Alasan penolakan..." :baris="2" />
                <x-tombol type="submit" varian="bahaya" class="w-full">Tolak</x-tombol>
            </form>
        </x-kartu>
    </div>
</x-layout-dashboard>
