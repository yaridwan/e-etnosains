<x-layout-dashboard judul-seo="Testimoni" :menu="\App\Support\MenuDashboard::administrator()">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Testimoni</h1>
        <x-tombol x-data @click="$dispatch('buka-modal', 'tambah')">Tambah Testimoni</x-tombol>
    </div>

    <x-kartu class="mt-6">
        <table class="w-full text-left text-sm">
            <thead class="text-xs uppercase text-slate-400 dark:text-slate-500">
                <tr><th class="pb-2">Nama</th><th class="pb-2">Peran</th><th class="pb-2">Rating</th><th class="pb-2 text-right">Aksi</th></tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($data as $item)
                    <tr>
                        <td class="py-3 font-medium text-slate-700 dark:text-slate-300">{{ $item->nama }}</td>
                        <td class="py-3 text-slate-500 dark:text-slate-400">{{ $item->peran_testimoni }}</td>
                        <td class="py-3 text-slate-500 dark:text-slate-400">{{ $item->rating }}/5</td>
                        <td class="py-3 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <x-tombol-ikon type="button" x-data @click="$dispatch('buka-modal', 'edit-{{ $item->id }}')" ikon="pensil" label="Ubah" />
                                <x-form-hapus :aksi="route('admin.testimoni.destroy', $item)" />
                            </div>
                        </td>
                    </tr>

                    <x-modal :nama="'edit-'.$item->id" judul="Ubah Testimoni">
                        <form method="POST" action="{{ route('admin.testimoni.update', $item) }}" class="space-y-4">
                            @csrf @method('PUT')
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <x-input label="Nama" name="nama" :value="$item->nama" wajib />
                                <x-input label="Peran/Jabatan" name="peran_testimoni" :value="$item->peran_testimoni" />
                            </div>
                            <x-textarea label="Isi Testimoni" name="isi_testimoni" wajib>{{ $item->isi_testimoni }}</x-textarea>
                            <x-input label="Rating (1-5)" name="rating" type="number" :value="$item->rating" wajib />
                            <x-checkbox name="aktif" :checked="$item->aktif">Aktifkan</x-checkbox>
                            <x-tombol type="submit" class="w-full">Simpan Perubahan</x-tombol>
                        </form>
                    </x-modal>
                @empty
                    <tr><td colspan="4"><x-empty-state judul="Belum ada testimoni." /></td></tr>
                @endforelse
            </tbody>
        </table>
    </x-kartu>

    <x-modal nama="tambah" judul="Tambah Testimoni">
        <form method="POST" action="{{ route('admin.testimoni.store') }}" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <x-input label="Nama" name="nama" wajib />
                <x-input label="Peran/Jabatan" name="peran_testimoni" />
            </div>
            <x-textarea label="Isi Testimoni" name="isi_testimoni" wajib />
            <x-input label="Rating (1-5)" name="rating" type="number" value="5" wajib />
            <x-tombol type="submit" class="w-full">Simpan</x-tombol>
        </form>
    </x-modal>
</x-layout-dashboard>
