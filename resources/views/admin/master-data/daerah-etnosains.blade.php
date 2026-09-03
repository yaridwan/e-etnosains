<x-layout-dashboard judul-seo="Daerah Etnosains" :menu="\App\Support\MenuDashboard::administrator()">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Daerah Etnosains</h1>
        <x-tombol x-data @click="$dispatch('buka-modal', 'tambah')">Tambah Daerah</x-tombol>
    </div>

    <form method="GET" class="mt-4 flex flex-wrap items-end gap-3">
        <div class="w-full sm:w-64">
            <x-input type="search" name="q" value="{{ request('q') }}" placeholder="Cari provinsi/kota/kearifan lokal..." />
        </div>
        <x-tombol type="submit" varian="sekunder">Filter</x-tombol>
    </form>

    <x-kartu class="mt-6">
        <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="text-xs uppercase text-slate-400 dark:text-slate-500">
                <tr><th class="pb-2">Provinsi</th><th class="pb-2">Kab/Kota</th><th class="pb-2">Kearifan Lokal</th><th class="pb-2 text-right">Aksi</th></tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($data as $item)
                    <tr>
                        <td class="py-3 font-medium text-slate-700 dark:text-slate-300">{{ $item->provinsi }}</td>
                        <td class="py-3 text-slate-500 dark:text-slate-400">{{ $item->kabupaten_kota }}</td>
                        <td class="py-3 text-slate-500 dark:text-slate-400">{{ $item->nama_kearifan_lokal }}</td>
                        <td class="py-3 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <x-tombol-ikon type="button" x-data @click="$dispatch('buka-modal', 'edit-{{ $item->id }}')" ikon="pensil" label="Ubah" />
                                <x-form-hapus :aksi="route('admin.daerah-etnosains.destroy', $item)" />
                            </div>
                        </td>
                    </tr>

                    <x-modal :nama="'edit-'.$item->id" judul="Ubah Daerah Etnosains" lebar="max-w-xl">
                        <form method="POST" action="{{ route('admin.daerah-etnosains.update', $item) }}" class="space-y-4">
                            @csrf @method('PUT')
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <x-input label="Provinsi" name="provinsi" :value="$item->provinsi" wajib />
                                <x-input label="Kabupaten/Kota" name="kabupaten_kota" :value="$item->kabupaten_kota" />
                                <x-input label="Kecamatan" name="kecamatan" :value="$item->kecamatan" />
                                <x-input label="Desa/Kelurahan" name="desa_kelurahan" :value="$item->desa_kelurahan" />
                            </div>
                            <x-input label="Nama Kearifan Lokal" name="nama_kearifan_lokal" :value="$item->nama_kearifan_lokal" />
                            <x-tombol type="submit" class="w-full">Simpan Perubahan</x-tombol>
                        </form>
                    </x-modal>
                @empty
                    <tr><td colspan="4"><x-empty-state judul="Belum ada daerah etnosains." deskripsi="{{ request('q') ? 'Tidak ada daerah yang cocok dengan pencarian.' : null }}" /></td></tr>
                @endforelse
            </tbody>
        </table>
        </div>

        <div class="mt-4">{{ $data->links() }}</div>
    </x-kartu>

    <x-modal nama="tambah" judul="Tambah Daerah Etnosains" lebar="max-w-xl">
        <form method="POST" action="{{ route('admin.daerah-etnosains.store') }}" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <x-input label="Provinsi" name="provinsi" wajib />
                <x-input label="Kabupaten/Kota" name="kabupaten_kota" />
                <x-input label="Kecamatan" name="kecamatan" />
                <x-input label="Desa/Kelurahan" name="desa_kelurahan" />
            </div>
            <x-input label="Nama Kearifan Lokal" name="nama_kearifan_lokal" />
            <x-tombol type="submit" class="w-full">Simpan</x-tombol>
        </form>
    </x-modal>
</x-layout-dashboard>
