<x-layout-dashboard judul-seo="FAQ" :menu="\App\Support\MenuDashboard::administrator()">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">FAQ</h1>
        <x-tombol x-data @click="$dispatch('buka-modal', 'tambah')">Tambah FAQ</x-tombol>
    </div>

    <x-kartu class="mt-6">
        <table class="w-full text-left text-sm">
            <thead class="text-xs uppercase text-slate-400 dark:text-slate-500">
                <tr><th class="pb-2">Pertanyaan</th><th class="pb-2">Status</th><th class="pb-2 text-right">Aksi</th></tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($data as $item)
                    <tr>
                        <td class="py-3 font-medium text-slate-700 dark:text-slate-300">{{ $item->pertanyaan }}</td>
                        <td class="py-3"><x-badge :warna="$item->aktif ? 'emerald' : 'slate'">{{ $item->aktif ? 'Aktif' : 'Nonaktif' }}</x-badge></td>
                        <td class="py-3 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <x-tombol-ikon type="button" x-data @click="$dispatch('buka-modal', 'edit-{{ $item->id }}')" ikon="pensil" label="Ubah" />
                                <x-form-hapus :aksi="route('admin.faq.destroy', $item)" />
                            </div>
                        </td>
                    </tr>

                    <x-modal :nama="'edit-'.$item->id" judul="Ubah FAQ">
                        <form method="POST" action="{{ route('admin.faq.update', $item) }}" class="space-y-4">
                            @csrf @method('PUT')
                            <x-input label="Pertanyaan" name="pertanyaan" :value="$item->pertanyaan" wajib />
                            <x-textarea label="Jawaban" name="jawaban" wajib>{{ $item->jawaban }}</x-textarea>
                            <x-input label="Urutan" name="urutan" type="number" :value="$item->urutan" />
                            <label class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                                <input type="checkbox" name="aktif" value="1" @checked($item->aktif) class="rounded border-slate-300 dark:border-slate-700 text-teal-700 dark:text-teal-400">
                                Aktifkan
                            </label>
                            <x-tombol type="submit" class="w-full">Simpan Perubahan</x-tombol>
                        </form>
                    </x-modal>
                @empty
                    <tr><td colspan="3"><x-empty-state judul="Belum ada FAQ." /></td></tr>
                @endforelse
            </tbody>
        </table>
    </x-kartu>

    <x-modal nama="tambah" judul="Tambah FAQ">
        <form method="POST" action="{{ route('admin.faq.store') }}" class="space-y-4">
            @csrf
            <x-input label="Pertanyaan" name="pertanyaan" wajib />
            <x-textarea label="Jawaban" name="jawaban" wajib />
            <x-input label="Urutan" name="urutan" type="number" value="0" />
            <x-tombol type="submit" class="w-full">Simpan</x-tombol>
        </form>
    </x-modal>
</x-layout-dashboard>
