<x-layout-dashboard judul-seo="Instansi Pendidikan" :menu="\App\Support\MenuDashboard::administrator()">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Instansi Pendidikan</h1>
        <x-tombol x-data @click="$dispatch('buka-modal', 'tambah')">Tambah Instansi</x-tombol>
    </div>

    <form method="GET" class="mt-4 flex flex-wrap items-end gap-3">
        <div class="w-full sm:w-64">
            <x-input type="search" name="q" value="{{ request('q') }}" placeholder="Cari nama instansi/kota..." />
        </div>
        <div class="w-full sm:w-48">
            <x-select name="jenis_instansi" placeholder="Semua Jenis" :opsi="['SD/MI'=>'SD/MI','SMP/MTs'=>'SMP/MTs','SMA/MA'=>'SMA/MA','SMK'=>'SMK','Perguruan Tinggi'=>'Perguruan Tinggi']" :selected="request('jenis_instansi')" />
        </div>
        <x-tombol type="submit" varian="sekunder">Filter</x-tombol>
    </form>

    <x-kartu class="mt-6">
        <table class="w-full text-left text-sm">
            <thead class="text-xs uppercase text-slate-400 dark:text-slate-500">
                <tr><th class="pb-2">Nama Instansi</th><th class="pb-2">Jenis</th><th class="pb-2">Kota</th><th class="pb-2 text-right">Aksi</th></tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($data as $item)
                    <tr>
                        <td class="py-3 font-medium text-slate-700 dark:text-slate-300">{{ $item->nama_instansi }}</td>
                        <td class="py-3 text-slate-500 dark:text-slate-400">{{ $item->jenis_instansi }}</td>
                        <td class="py-3 text-slate-500 dark:text-slate-400">{{ $item->kota }}</td>
                        <td class="py-3 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <x-tombol-ikon type="button" x-data @click="$dispatch('buka-modal', 'edit-{{ $item->id }}')" ikon="pensil" label="Ubah" />
                                <x-form-hapus :aksi="route('admin.instansi-pendidikan.destroy', $item)" />
                            </div>
                        </td>
                    </tr>

                    <x-modal :nama="'edit-'.$item->id" judul="Ubah Instansi Pendidikan" lebar="max-w-xl">
                        <form method="POST" action="{{ route('admin.instansi-pendidikan.update', $item) }}" class="space-y-4">
                            @csrf @method('PUT')
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <x-input label="Nama Instansi" name="nama_instansi" :value="$item->nama_instansi" wajib />
                                <x-select label="Jenis Instansi" name="jenis_instansi" :opsi="['SD/MI'=>'SD/MI','SMP/MTs'=>'SMP/MTs','SMA/MA'=>'SMA/MA','SMK'=>'SMK','Perguruan Tinggi'=>'Perguruan Tinggi']" selected="{{ $item->jenis_instansi }}" />
                                <x-input label="Kota" name="kota" :value="$item->kota" />
                                <x-input label="Provinsi" name="provinsi" :value="$item->provinsi" />
                            </div>
                            <x-input label="Alamat" name="alamat" :value="$item->alamat" />
                            <x-tombol type="submit" class="w-full">Simpan Perubahan</x-tombol>
                        </form>
                    </x-modal>
                @empty
                    <tr><td colspan="4"><x-empty-state judul="Belum ada instansi pendidikan." deskripsi="{{ request('q') || request('jenis_instansi') ? 'Tidak ada instansi yang cocok dengan filter.' : null }}" /></td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">{{ $data->links() }}</div>
    </x-kartu>

    <x-modal nama="tambah" judul="Tambah Instansi Pendidikan" lebar="max-w-xl">
        <form method="POST" action="{{ route('admin.instansi-pendidikan.store') }}" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <x-input label="Nama Instansi" name="nama_instansi" wajib />
                <x-select label="Jenis Instansi" name="jenis_instansi" :opsi="['SD/MI'=>'SD/MI','SMP/MTs'=>'SMP/MTs','SMA/MA'=>'SMA/MA','SMK'=>'SMK','Perguruan Tinggi'=>'Perguruan Tinggi']" />
                <x-input label="Kota" name="kota" />
                <x-input label="Provinsi" name="provinsi" />
            </div>
            <x-input label="Alamat" name="alamat" />
            <x-tombol type="submit" class="w-full">Simpan</x-tombol>
        </form>
    </x-modal>
</x-layout-dashboard>
