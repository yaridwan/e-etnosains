<x-layout-dashboard judul-seo="Banner" :menu="\App\Support\MenuDashboard::administrator()">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Banner</h1>
        <x-tombol x-data @click="$dispatch('buka-modal', 'tambah')">Tambah Banner</x-tombol>
    </div>

    <x-kartu class="mt-6">
        <table class="w-full text-left text-sm">
            <thead class="text-xs uppercase text-slate-400 dark:text-slate-500">
                <tr><th class="pb-2">Judul</th><th class="pb-2">Tombol</th><th class="pb-2 text-right">Aksi</th></tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($data as $item)
                    <tr>
                        <td class="py-3 font-medium text-slate-700 dark:text-slate-300">{{ $item->judul }}</td>
                        <td class="py-3 text-slate-500 dark:text-slate-400">{{ $item->teks_tombol }}</td>
                        <td class="py-3 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <x-tombol-ikon type="button" x-data @click="$dispatch('buka-modal', 'edit-{{ $item->id }}')" ikon="pensil" label="Ubah" />
                                <x-form-hapus :aksi="route('admin.banner.destroy', $item)" />
                            </div>
                        </td>
                    </tr>

                    <x-modal :nama="'edit-'.$item->id" judul="Ubah Banner" lebar="max-w-xl">
                        <form method="POST" action="{{ route('admin.banner.update', $item) }}" class="space-y-4" enctype="multipart/form-data">
                            @csrf
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <x-input label="Judul" name="judul" :value="$item->judul" wajib />
                                <x-input label="Subjudul" name="subjudul" :value="$item->subjudul" />
                                <x-input label="Teks Tombol" name="teks_tombol" :value="$item->teks_tombol" />
                                <x-input label="Tautan Tombol" name="tautan_tombol" :value="$item->tautan_tombol" />
                            </div>
                            <x-unggah label="Gambar" name="gambar" jenis="gambar" accept="image/*" :pratinjau="$item->gambar ? \Illuminate\Support\Facades\Storage::url($item->gambar) : null" />
                            <x-checkbox name="aktif" :checked="$item->aktif">Aktifkan</x-checkbox>
                            <x-tombol type="submit" class="w-full">Simpan Perubahan</x-tombol>
                        </form>
                    </x-modal>
                @empty
                    <tr><td colspan="3"><x-empty-state judul="Belum ada banner." /></td></tr>
                @endforelse
            </tbody>
        </table>
    </x-kartu>

    <x-modal nama="tambah" judul="Tambah Banner" lebar="max-w-xl">
        <form method="POST" action="{{ route('admin.banner.store') }}" class="space-y-4" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <x-input label="Judul" name="judul" wajib />
                <x-input label="Subjudul" name="subjudul" />
                <x-input label="Teks Tombol" name="teks_tombol" />
                <x-input label="Tautan Tombol" name="tautan_tombol" />
            </div>
            <x-unggah label="Gambar" name="gambar" jenis="gambar" accept="image/*" />
            <x-tombol type="submit" class="w-full">Simpan</x-tombol>
        </form>
    </x-modal>
</x-layout-dashboard>
