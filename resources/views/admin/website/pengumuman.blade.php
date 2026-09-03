<x-layout-dashboard judul-seo="Pengumuman" :menu="\App\Support\MenuDashboard::administrator()">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Pengumuman</h1>
        <x-tombol x-data @click="$dispatch('buka-modal', 'tambah')">Tambah Pengumuman</x-tombol>
    </div>

    <form method="GET" class="mt-4 flex flex-wrap items-end gap-3">
        <div class="w-full sm:w-64">
            <x-input type="search" name="q" value="{{ request('q') }}" placeholder="Cari judul/isi..." />
        </div>
        <div class="w-full sm:w-40">
            <x-select name="target" placeholder="Semua Target" :opsi="['umum'=>'Umum','guru'=>'Guru','siswa'=>'Siswa']" :selected="request('target')" />
        </div>
        <div class="w-full sm:w-44">
            <x-select name="status" placeholder="Semua Status" :opsi="['aktif' => 'Aktif', 'nonaktif' => 'Nonaktif']" :selected="request('status')" />
        </div>
        <x-tombol type="submit" varian="sekunder">Filter</x-tombol>
    </form>

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
                            <div class="flex items-center justify-end gap-1">
                                <x-tombol-ikon type="button" x-data @click="$dispatch('buka-modal', 'edit-{{ $item->id }}')" ikon="pensil" label="Ubah" />
                                <x-form-hapus :aksi="route('admin.pengumuman.destroy', $item)" />
                            </div>
                        </td>
                    </tr>

                    <x-modal :nama="'edit-'.$item->id" judul="Ubah Pengumuman" lebar="max-w-xl">
                        <form method="POST" action="{{ route('admin.pengumuman.update', $item) }}" class="space-y-4">
                            @csrf @method('PUT')
                            <x-input label="Judul" name="judul" :value="$item->judul" wajib />
                            <x-textarea label="Isi" name="isi" wajib>{{ $item->isi }}</x-textarea>
                            <x-select label="Target" name="target" :opsi="['umum'=>'Umum','guru'=>'Guru','siswa'=>'Siswa']" selected="{{ $item->target }}" />
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <x-input label="Tanggal Mulai" name="tanggal_mulai" type="date" :value="$item->tanggal_mulai?->toDateString()" />
                                <x-input label="Tanggal Selesai" name="tanggal_selesai" type="date" :value="$item->tanggal_selesai?->toDateString()" />
                            </div>
                            <x-checkbox name="aktif" :checked="$item->aktif">Aktifkan</x-checkbox>
                            <x-tombol type="submit" class="w-full">Simpan Perubahan</x-tombol>
                        </form>
                    </x-modal>
                @empty
                    <tr><td colspan="4"><x-empty-state judul="Belum ada pengumuman." deskripsi="{{ request('q') || request('target') || request('status') ? 'Tidak ada pengumuman yang cocok dengan filter.' : null }}" /></td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">{{ $data->links() }}</div>
    </x-kartu>

    <x-modal nama="tambah" judul="Tambah Pengumuman" lebar="max-w-xl">
        <form method="POST" action="{{ route('admin.pengumuman.store') }}" class="space-y-4">
            @csrf
            <x-input label="Judul" name="judul" wajib />
            <x-textarea label="Isi" name="isi" wajib />
            <x-select label="Target" name="target" :opsi="['umum'=>'Umum','guru'=>'Guru','siswa'=>'Siswa']" />
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <x-input label="Tanggal Mulai" name="tanggal_mulai" type="date" />
                <x-input label="Tanggal Selesai" name="tanggal_selesai" type="date" />
            </div>
            <x-tombol type="submit" class="w-full">Simpan</x-tombol>
        </form>
    </x-modal>
</x-layout-dashboard>
