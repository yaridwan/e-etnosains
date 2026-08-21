<x-layout-dashboard judul-seo="Topik Etnosains" :menu="\App\Support\MenuDashboard::administrator()">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-900">Topik Etnosains</h1>
        <x-tombol x-data @click="$dispatch('buka-modal', 'tambah')">Tambah Topik</x-tombol>
    </div>

    <x-kartu class="mt-6">
        <table class="w-full text-left text-sm">
            <thead class="text-xs uppercase text-slate-400">
                <tr><th class="pb-2">Nama Topik</th><th class="pb-2">Deskripsi</th><th class="pb-2 text-right">Aksi</th></tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($data as $item)
                    <tr>
                        <td class="py-3 font-medium text-slate-700">{{ $item->nama_topik }}</td>
                        <td class="py-3 max-w-sm truncate text-slate-500">{{ $item->deskripsi }}</td>
                        <td class="py-3 text-right">
                            <button type="button" x-data @click="$dispatch('buka-modal', 'edit-{{ $item->id }}')" class="mr-3 text-sm font-medium text-teal-700 hover:underline">Ubah</button>
                            <x-form-hapus :aksi="route('admin.topik-etnosains.destroy', $item)" class="inline" />
                        </td>
                    </tr>

                    <x-modal :nama="'edit-'.$item->id" judul="Ubah Topik Etnosains">
                        <form method="POST" action="{{ route('admin.topik-etnosains.update', $item) }}" class="space-y-4">
                            @csrf @method('PUT')
                            <x-input label="Nama Topik" name="nama_topik" :value="$item->nama_topik" wajib />
                            <x-textarea label="Deskripsi" name="deskripsi">{{ $item->deskripsi }}</x-textarea>
                            <x-tombol type="submit" class="w-full">Simpan Perubahan</x-tombol>
                        </form>
                    </x-modal>
                @empty
                    <tr><td colspan="3"><x-empty-state judul="Belum ada topik etnosains." /></td></tr>
                @endforelse
            </tbody>
        </table>
    </x-kartu>

    <x-modal nama="tambah" judul="Tambah Topik Etnosains">
        <form method="POST" action="{{ route('admin.topik-etnosains.store') }}" class="space-y-4">
            @csrf
            <x-input label="Nama Topik" name="nama_topik" wajib />
            <x-textarea label="Deskripsi" name="deskripsi" />
            <x-tombol type="submit" class="w-full">Simpan</x-tombol>
        </form>
    </x-modal>
</x-layout-dashboard>
