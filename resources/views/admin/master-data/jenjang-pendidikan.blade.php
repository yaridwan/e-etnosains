<x-layout-dashboard judul-seo="Jenjang Pendidikan" :menu="\App\Support\MenuDashboard::administrator()">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Jenjang Pendidikan</h1>
        <x-tombol @click="$dispatch('buka-modal', 'tambah')" x-data>Tambah Jenjang</x-tombol>
    </div>

    <x-kartu class="mt-6">
        <table class="w-full text-left text-sm">
            <thead class="text-xs uppercase text-slate-400 dark:text-slate-500">
                <tr><th class="pb-2">Nama Jenjang</th><th class="pb-2">Urutan</th><th class="pb-2 text-right">Aksi</th></tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($data as $item)
                    <tr>
                        <td class="py-3 font-medium text-slate-700 dark:text-slate-300">{{ $item->nama_jenjang }}</td>
                        <td class="py-3 text-slate-500 dark:text-slate-400">{{ $item->urutan }}</td>
                        <td class="py-3 text-right">
                            <button type="button" x-data @click="$dispatch('buka-modal', 'edit-{{ $item->id }}')" class="mr-3 text-sm font-medium text-teal-700 dark:text-teal-400 hover:underline">Ubah</button>
                            <x-form-hapus :aksi="route('admin.jenjang-pendidikan.destroy', $item)" class="inline" />
                        </td>
                    </tr>

                    <x-modal :nama="'edit-'.$item->id" judul="Ubah Jenjang Pendidikan">
                        <form method="POST" action="{{ route('admin.jenjang-pendidikan.update', $item) }}" class="space-y-4">
                            @csrf @method('PUT')
                            <x-input label="Nama Jenjang" name="nama_jenjang" :value="$item->nama_jenjang" wajib />
                            <x-input label="Urutan" name="urutan" type="number" :value="$item->urutan" />
                            <x-tombol type="submit" class="w-full">Simpan Perubahan</x-tombol>
                        </form>
                    </x-modal>
                @empty
                    <tr><td colspan="3"><x-empty-state judul="Belum ada jenjang pendidikan." /></td></tr>
                @endforelse
            </tbody>
        </table>
    </x-kartu>

    <x-modal nama="tambah" judul="Tambah Jenjang Pendidikan">
        <form method="POST" action="{{ route('admin.jenjang-pendidikan.store') }}" class="space-y-4">
            @csrf
            <x-input label="Nama Jenjang" name="nama_jenjang" wajib placeholder="Contoh: SMA/MA" />
            <x-input label="Urutan" name="urutan" type="number" value="0" />
            <x-tombol type="submit" class="w-full">Simpan</x-tombol>
        </form>
    </x-modal>
</x-layout-dashboard>
