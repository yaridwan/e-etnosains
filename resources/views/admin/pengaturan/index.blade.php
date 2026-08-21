@php($labelKelompok = ['identitas'=>'Identitas Aplikasi','tampilan'=>'Tampilan','kontak'=>'Kontak','media_sosial'=>'Media Sosial','seo'=>'SEO','registrasi'=>'Registrasi','pembelajaran'=>'Pembelajaran','upload'=>'Upload'])

<x-layout-dashboard judul-seo="Pengaturan Aplikasi" :menu="\App\Support\MenuDashboard::administrator()">
    <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Pengaturan Aplikasi</h1>
    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Perubahan akan langsung diterapkan ke seluruh tampilan aplikasi.</p>

    <form method="POST" action="{{ route('admin.pengaturan.simpan') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf

        @foreach($kelompok as $namaKelompok => $item)
            <x-kartu>
                <h2 class="font-semibold text-slate-800 dark:text-slate-100">{{ $labelKelompok[$namaKelompok] ?? ucfirst($namaKelompok) }}</h2>
                <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    @foreach($item as $pengaturan)
                        @if($pengaturan->tipe === 'boolean')
                            <label class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                                <input type="hidden" name="{{ $pengaturan->kunci }}" value="0">
                                <input type="checkbox" name="{{ $pengaturan->kunci }}" value="1" @checked($pengaturan->nilai) class="rounded border-slate-300 dark:border-slate-700 text-teal-700 dark:text-teal-400">
                                {{ $pengaturan->keterangan }}
                            </label>
                        @elseif($pengaturan->tipe === 'teks_panjang')
                            <div class="sm:col-span-2">
                                <x-textarea :label="$pengaturan->keterangan" :name="$pengaturan->kunci">{{ $pengaturan->nilai }}</x-textarea>
                            </div>
                        @elseif($pengaturan->tipe === 'berkas')
                            <x-input type="file" :label="$pengaturan->keterangan" :name="$pengaturan->kunci" />
                        @elseif($pengaturan->tipe === 'warna')
                            <x-input type="color" :label="$pengaturan->keterangan" :name="$pengaturan->kunci" :value="$pengaturan->nilai" />
                        @else
                            <x-input :label="$pengaturan->keterangan" :name="$pengaturan->kunci" :value="$pengaturan->nilai" />
                        @endif
                    @endforeach
                </div>
            </x-kartu>
        @endforeach

        <x-tombol type="submit">Simpan Semua Pengaturan</x-tombol>
    </form>
</x-layout-dashboard>
