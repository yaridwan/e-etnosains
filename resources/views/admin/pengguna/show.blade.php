<x-layout-dashboard judul-seo="Detail Pengguna" :menu="\App\Support\MenuDashboard::administrator()">
    <a href="{{ route('admin.pengguna.index') }}" class="text-sm text-teal-700 dark:text-teal-400 hover:underline">&larr; Kembali</a>

    <div class="mt-2 flex flex-wrap items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">{{ $pengguna->nama_lengkap }}</h1>
            <x-badge :warna="$pengguna->status_akun->value === 'aktif' ? 'emerald' : 'slate'">{{ $pengguna->status_akun->label() }}</x-badge>
        </div>

        @if($pengguna->id !== auth()->id())
            <x-form-hapus :aksi="route('admin.pengguna.destroy', $pengguna)" label="Hapus Pengguna" pesan="Yakin ingin menghapus pengguna ini? Seluruh akses akunnya akan dicabut dan tindakan ini tidak dapat dibatalkan." />
        @endif
    </div>

    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-2">
        <x-kartu>
            <h2 class="font-semibold text-slate-800 dark:text-slate-100">Edit Profil</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Peran: {{ $pengguna->peran->pluck('nama_peran')->map(fn ($p) => ucfirst($p))->implode(', ') }}</p>

            <form method="POST" action="{{ route('admin.pengguna.update', $pengguna) }}" class="mt-4 space-y-4">
                @csrf
                @method('PUT')
                <x-input label="Nama Lengkap" name="nama_lengkap" :value="$pengguna->nama_lengkap" wajib />
                <x-input label="Email" name="email" type="email" :value="$pengguna->email" wajib />
                <x-input label="Nomor Telepon" name="nomor_telepon" :value="$pengguna->nomor_telepon" />
                <x-tombol type="submit">Simpan Perubahan</x-tombol>
            </form>
        </x-kartu>

        <div class="space-y-6">
            <x-kartu>
                <h2 class="font-semibold text-slate-800 dark:text-slate-100">Ubah Kata Sandi</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Atur kata sandi baru untuk pengguna ini.</p>

                <form method="POST" action="{{ route('admin.pengguna.ubah-kata-sandi', $pengguna) }}" class="mt-4 space-y-4">
                    @csrf
                    @method('PUT')
                    <x-input label="Kata Sandi Baru" name="kata_sandi" type="password" wajib petunjuk="Minimal 8 karakter." />
                    <x-input label="Konfirmasi Kata Sandi Baru" name="kata_sandi_confirmation" type="password" wajib />
                    <x-tombol type="submit" varian="sekunder">Ubah Kata Sandi</x-tombol>
                </form>
            </x-kartu>

            <x-kartu>
                <h2 class="font-semibold text-slate-800 dark:text-slate-100">Status Akun</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Nonaktifkan untuk memblokir akun ini agar tidak bisa masuk.</p>

                <div class="mt-4 space-y-4 text-sm">
                    <div><dt class="text-slate-400 dark:text-slate-500">Terakhir Masuk</dt><dd class="font-medium text-slate-700 dark:text-slate-300">{{ $pengguna->terakhir_masuk_pada?->translatedFormat('d M Y, H:i') ?? '-' }}</dd></div>
                </div>

                <form method="POST" action="{{ route('admin.pengguna.ubah-status', $pengguna) }}" class="mt-4 flex items-end gap-3">
                    @csrf @method('PATCH')
                    <div class="w-40">
                        <x-select name="status_akun" :placeholder="null" :opsi="['aktif' => 'Aktif', 'nonaktif' => 'Nonaktif (Blokir)']" :selected="$pengguna->status_akun->value" />
                    </div>
                    <x-tombol type="submit" varian="sekunder">Perbarui Status</x-tombol>
                </form>
            </x-kartu>
        </div>
    </div>
</x-layout-dashboard>
