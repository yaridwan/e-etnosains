<x-layout-dashboard judul-seo="Mata Pelajaran" :menu="\App\Support\MenuDashboard::administrator()">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Mata Pelajaran</h1>
        <x-tombol x-data @click="$dispatch('buka-modal', 'tambah')">Tambah Mata Pelajaran</x-tombol>
    </div>

    <x-kartu class="mt-6">
        <table class="w-full text-left text-sm">
            <thead class="text-xs uppercase text-slate-400 dark:text-slate-500">
                <tr><th class="pb-2">Nama Mata Pelajaran</th><th class="pb-2 text-right">Aksi</th></tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($data as $item)
                    <tr>
                        <td class="py-3 font-medium text-slate-700 dark:text-slate-300">{{ $item->nama_mata_pelajaran }}</td>
                        <td class="py-3 text-right">
                            <button type="button" x-data @click="$dispatch('buka-modal', 'edit-{{ $item->id }}')" class="mr-3 text-sm font-medium text-teal-700 dark:text-teal-400 hover:underline">Ubah</button>
                            <x-form-hapus :aksi="route('admin.mata-pelajaran.destroy', $item)" class="inline" />
                        </td>
                    </tr>

                    <x-modal :nama="'edit-'.$item->id" judul="Ubah Mata Pelajaran">
                        <form method="POST" action="{{ route('admin.mata-pelajaran.update', $item) }}" class="space-y-4">
                            @csrf @method('PUT')
                            <x-input label="Nama Mata Pelajaran" name="nama_mata_pelajaran" :value="$item->nama_mata_pelajaran" wajib />
                            <x-tombol type="submit" class="w-full">Simpan Perubahan</x-tombol>
                        </form>
                    </x-modal>
                @empty
                    <tr><td colspan="2"><x-empty-state judul="Belum ada mata pelajaran." /></td></tr>
                @endforelse
            </tbody>
        </table>
    </x-kartu>

    <x-modal nama="tambah" judul="Tambah Mata Pelajaran">
        <form method="POST" action="{{ route('admin.mata-pelajaran.store') }}" class="space-y-4">
            @csrf
            <x-input label="Nama Mata Pelajaran" name="nama_mata_pelajaran" wajib />
            <x-tombol type="submit" class="w-full">Simpan</x-tombol>
        </form>
    </x-modal>
</x-layout-dashboard>
