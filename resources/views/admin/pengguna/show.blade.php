<x-layout-dashboard judul-seo="Detail Pengguna" :menu="\App\Support\MenuDashboard::administrator()">
    <a href="{{ route('admin.pengguna.index') }}" class="text-sm text-teal-700 hover:underline">&larr; Kembali</a>

    <div class="mt-2 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-900">{{ $pengguna->nama_lengkap }}</h1>
        <x-badge :warna="$pengguna->status_akun->value === 'aktif' ? 'emerald' : 'slate'">{{ $pengguna->status_akun->label() }}</x-badge>
    </div>

    <x-kartu class="mt-6">
        <dl class="grid grid-cols-1 gap-4 text-sm sm:grid-cols-2">
            <div><dt class="text-slate-400">Email</dt><dd class="font-medium text-slate-700">{{ $pengguna->email }}</dd></div>
            <div><dt class="text-slate-400">Nomor Telepon</dt><dd class="font-medium text-slate-700">{{ $pengguna->nomor_telepon }}</dd></div>
            <div><dt class="text-slate-400">Peran</dt><dd class="font-medium text-slate-700">{{ $pengguna->peran->pluck('nama_peran')->implode(', ') }}</dd></div>
            <div><dt class="text-slate-400">Terakhir Masuk</dt><dd class="font-medium text-slate-700">{{ $pengguna->terakhir_masuk_pada?->translatedFormat('d M Y, H:i') ?? '-' }}</dd></div>
        </dl>

        <form method="POST" action="{{ route('admin.pengguna.ubah-status', $pengguna) }}" class="mt-6 flex items-center gap-3">
            @csrf @method('PATCH')
            <select name="status_akun" class="rounded-lg border border-slate-300 px-3.5 py-2 text-sm">
                <option value="aktif" @selected($pengguna->status_akun->value === 'aktif')>Aktif</option>
                <option value="nonaktif" @selected($pengguna->status_akun->value === 'nonaktif')>Nonaktif</option>
            </select>
            <x-tombol type="submit" varian="sekunder">Perbarui Status</x-tombol>
        </form>
    </x-kartu>
</x-layout-dashboard>
