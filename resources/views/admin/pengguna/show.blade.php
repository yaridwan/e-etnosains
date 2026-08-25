<x-layout-dashboard judul-seo="Detail Pengguna" :menu="\App\Support\MenuDashboard::administrator()">
    <a href="{{ route('admin.pengguna.index') }}" class="text-sm text-teal-700 dark:text-teal-400 hover:underline">&larr; Kembali</a>

    <div class="mt-2 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">{{ $pengguna->nama_lengkap }}</h1>
        <x-badge :warna="$pengguna->status_akun->value === 'aktif' ? 'emerald' : 'slate'">{{ $pengguna->status_akun->label() }}</x-badge>
    </div>

    <x-kartu class="mt-6">
        <dl class="grid grid-cols-1 gap-4 text-sm sm:grid-cols-2">
            <div><dt class="text-slate-400 dark:text-slate-500">Email</dt><dd class="font-medium text-slate-700 dark:text-slate-300">{{ $pengguna->email }}</dd></div>
            <div><dt class="text-slate-400 dark:text-slate-500">Nomor Telepon</dt><dd class="font-medium text-slate-700 dark:text-slate-300">{{ $pengguna->nomor_telepon }}</dd></div>
            <div><dt class="text-slate-400 dark:text-slate-500">Peran</dt><dd class="font-medium text-slate-700 dark:text-slate-300">{{ $pengguna->peran->pluck('nama_peran')->implode(', ') }}</dd></div>
            <div><dt class="text-slate-400 dark:text-slate-500">Terakhir Masuk</dt><dd class="font-medium text-slate-700 dark:text-slate-300">{{ $pengguna->terakhir_masuk_pada?->translatedFormat('d M Y, H:i') ?? '-' }}</dd></div>
        </dl>

        <form method="POST" action="{{ route('admin.pengguna.ubah-status', $pengguna) }}" class="mt-6 flex items-end gap-3">
            @csrf @method('PATCH')
            <div class="w-40">
                <x-select name="status_akun" :placeholder="null" :opsi="['aktif' => 'Aktif', 'nonaktif' => 'Nonaktif']" :selected="$pengguna->status_akun->value" />
            </div>
            <x-tombol type="submit" varian="sekunder">Perbarui Status</x-tombol>
        </form>
    </x-kartu>
</x-layout-dashboard>
