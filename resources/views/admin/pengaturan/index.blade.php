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
                            <div class="flex items-center">
                                <x-checkbox :name="$pengaturan->kunci" :checked="(bool) $pengaturan->nilai">{{ $pengaturan->keterangan }}</x-checkbox>
                            </div>
                        @elseif($pengaturan->tipe === 'teks_panjang')
                            <div class="sm:col-span-2">
                                <x-textarea :label="$pengaturan->keterangan" :name="$pengaturan->kunci">{{ $pengaturan->nilai }}</x-textarea>
                            </div>
                        @elseif($pengaturan->tipe === 'berkas')
                            <x-unggah :label="$pengaturan->keterangan" :name="$pengaturan->kunci" jenis="gambar" accept="image/*" :pratinjau="$pengaturan->nilai ? \Illuminate\Support\Facades\Storage::url($pengaturan->nilai) : null" />
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
