<x-layout-dashboard judul-seo="Pengumuman" :menu="\App\Support\MenuDashboard::administrator()">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Pengumuman</h1>
        <x-tombol x-data @click="$dispatch('buka-modal', 'tambah')">Tambah Pengumuman</x-tombol>
    </div>

    <x-kartu class="mt-6">
        <table class="w-full text-left text-sm">
            <thead class="text-xs uppercase text-slate-400 dark:text-slate-500">
                <tr><th class="pb-2">Judul</th><th class="pb-2">Target</th><th class="pb-2">Periode</th><th class="pb-2 text-right">Aksi</th></tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($data as $item)
                    <tr>
                        <td class="py-3 font-medium text-slate-700 dark:text-slate-300">{{ $item->judul }}</td>
                        <td class="py-3"><x-badge warna="teal">{{ ucfirst($item->target) }}</x-badge></td>
                        <td class="py-3 text-slate-500 dark:text-slate-400">{{ $item->tanggal_mulai?->translatedFormat('d M Y') }} - {{ $item->tanggal_selesai?->translatedFormat('d M Y') }}</td>
                        <td class="py-3 text-right">
                            <button type="button" x-data @click="$dispatch('buka-modal', 'edit-{{ $item->id }}')" class="mr-3 text-sm font-medium text-teal-700 dark:text-teal-400 hover:underline">Ubah</button>
                            <x-form-hapus :aksi="route('admin.pengumuman.destroy', $item)" class="inline" />
                        </td>
                    </tr>

                    <x-modal :nama="'edit-'.$item->id" judul="Ubah Pengumuman">
                        <form method="POST" action="{{ route('admin.pengumuman.update', $item) }}" class="space-y-4">
                            @csrf @method('PUT')
                            <x-input label="Judul" name="judul" :value="$item->judul" wajib />
                            <x-textarea label="Isi" name="isi" wajib>{{ $item->isi }}</x-textarea>
                            <x-select label="Target" name="target" :opsi="['umum'=>'Umum','guru'=>'Guru','siswa'=>'Siswa']" selected="{{ $item->target }}" />
                            <x-input label="Tanggal Mulai" name="tanggal_mulai" type="date" :value="$item->tanggal_mulai?->toDateString()" />
                            <x-input label="Tanggal Selesai" name="tanggal_selesai" type="date" :value="$item->tanggal_selesai?->toDateString()" />
                            <label class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                                <input type="checkbox" name="aktif" value="1" @checked($item->aktif) class="rounded border-slate-300 dark:border-slate-700 text-teal-700 dark:text-teal-400"> Aktifkan
                            </label>
                            <x-tombol type="submit" class="w-full">Simpan Perubahan</x-tombol>
                        </form>
                    </x-modal>
                @empty
                    <tr><td colspan="4"><x-empty-state judul="Belum ada pengumuman." /></td></tr>
                @endforelse
            </tbody>
        </table>
    </x-kartu>

    <x-modal nama="tambah" judul="Tambah Pengumuman">
        <form method="POST" action="{{ route('admin.pengumuman.store') }}" class="space-y-4">
            @csrf
            <x-input label="Judul" name="judul" wajib />
            <x-textarea label="Isi" name="isi" wajib />
            <x-select label="Target" name="target" :opsi="['umum'=>'Umum','guru'=>'Guru','siswa'=>'Siswa']" />
            <x-input label="Tanggal Mulai" name="tanggal_mulai" type="date" />
            <x-input label="Tanggal Selesai" name="tanggal_selesai" type="date" />
            <x-tombol type="submit" class="w-full">Simpan</x-tombol>
        </form>
    </x-modal>
</x-layout-dashboard>
