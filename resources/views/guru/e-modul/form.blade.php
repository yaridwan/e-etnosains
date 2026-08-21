@php($sedangUbah = $eModul->exists)

<x-layout-dashboard :judul-seo="$sedangUbah ? 'Ubah E-Modul' : 'Buat E-Modul'" :menu="\App\Support\MenuDashboard::guru()">
    <a href="{{ route('guru.e-modul.index') }}" class="text-sm text-teal-700 dark:text-teal-400 hover:underline">&larr; Kembali</a>
    <h1 class="mt-2 text-2xl font-bold text-slate-900 dark:text-slate-100">{{ $sedangUbah ? 'Ubah E-Modul' : 'Buat E-Modul Baru' }}</h1>

    @if($sedangUbah && $eModul->catatan_reviewer)
        <x-alert jenis="peringatan" class="mt-4">Catatan reviewer: {{ $eModul->catatan_reviewer }}</x-alert>
    @endif

    <form method="POST" action="{{ $sedangUbah ? route('guru.e-modul.update', $eModul) : route('guru.e-modul.store') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @if($sedangUbah) @method('PUT') @endif

        <x-kartu>
            <h2 class="font-semibold text-slate-800 dark:text-slate-100">1. Informasi Dasar</h2>
            <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <x-input label="Judul E-Modul" name="judul" :value="$eModul->judul" wajib />
                </div>
                <x-select label="Jenjang Pendidikan" name="id_jenjang_pendidikan" wajib :opsi="$jenjang->pluck('nama_jenjang', 'id')" selected="{{ $eModul->id_jenjang_pendidikan }}" />
                <x-select label="Mata Pelajaran" name="id_mata_pelajaran" wajib :opsi="$mataPelajaran->pluck('nama_mata_pelajaran', 'id')" selected="{{ $eModul->id_mata_pelajaran }}" />
                <x-input label="Kelas" name="kelas" :value="$eModul->kelas" placeholder="Contoh: X" />
                <x-input label="Fase" name="fase" :value="$eModul->fase" placeholder="Contoh: E" />
                <x-input label="Tahun" name="tahun" type="number" :value="$eModul->tahun ?? now()->year" />
                <x-input label="Kata Kunci" name="kata_kunci" :value="$eModul->kata_kunci" placeholder="Pisahkan dengan koma" />
            </div>
        </x-kartu>

        <x-kartu>
            <h2 class="font-semibold text-slate-800 dark:text-slate-100">2. Informasi Pembelajaran</h2>
            <div class="mt-4 space-y-4">
                <x-textarea label="Ringkasan" name="ringkasan" wajib>{{ $eModul->ringkasan }}</x-textarea>
                <x-textarea label="Deskripsi Lengkap" name="deskripsi" :baris="6" wajib>{{ $eModul->deskripsi }}</x-textarea>
                <x-textarea label="Capaian Pembelajaran" name="capaian_pembelajaran">{{ $eModul->capaian_pembelajaran }}</x-textarea>
                <x-textarea label="Tujuan Pembelajaran" name="tujuan_pembelajaran">{{ $eModul->tujuan_pembelajaran }}</x-textarea>
            </div>
        </x-kartu>

        <x-kartu>
            <h2 class="font-semibold text-slate-800 dark:text-slate-100">3. Eksplorasi Etnosains</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Hubungkan kearifan lokal dengan konsep sains yang dipelajari.</p>
            <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                <x-select label="Topik Etnosains" name="id_topik_etnosains" :opsi="$topik->pluck('nama_topik', 'id')" selected="{{ $eModul->id_topik_etnosains }}" />
                <x-select label="Daerah Etnosains" name="id_daerah_etnosains" :opsi="$daerah->pluck('nama_kearifan_lokal', 'id')" selected="{{ $eModul->id_daerah_etnosains }}" />
                <x-input label="Konteks Wilayah" name="konteks_wilayah" :value="$eModul->konteks_wilayah" class="sm:col-span-2" />
                <div class="sm:col-span-2"><x-textarea label="Pengetahuan Lokal" name="pengetahuan_lokal">{{ $eModul->pengetahuan_lokal }}</x-textarea></div>
                <div class="sm:col-span-2"><x-textarea label="Konsep Sains Terkait" name="konsep_sains">{{ $eModul->konsep_sains }}</x-textarea></div>
                <div class="sm:col-span-2"><x-textarea label="Aktivitas Saintifik" name="aktivitas_saintifik">{{ $eModul->aktivitas_saintifik }}</x-textarea></div>
                <div class="sm:col-span-2"><x-textarea label="Nilai/Karakter" name="nilai_karakter">{{ $eModul->nilai_karakter }}</x-textarea></div>
            </div>
        </x-kartu>

        <x-kartu>
            <h2 class="font-semibold text-slate-800 dark:text-slate-100">4. Media dan Berkas PDF</h2>
            <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                <x-input type="file" label="Gambar Sampul" name="gambar_sampul" />
                <x-input type="file" label="Gambar Poster" name="gambar_poster" />
                <div class="sm:col-span-2"><x-input type="file" label="Berkas PDF E-Modul" name="berkas_pdf" /></div>
            </div>
        </x-kartu>

        <x-kartu>
            <h2 class="font-semibold text-slate-800 dark:text-slate-100">5. Pengaturan Publikasi</h2>
            <label class="mt-4 flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                <input type="hidden" name="izin_unduh" value="0">
                <input type="checkbox" name="izin_unduh" value="1" @checked($eModul->izin_unduh) class="rounded border-slate-300 dark:border-slate-700 text-teal-700 dark:text-teal-400">
                Izinkan pengunjung mengunduh berkas PDF
            </label>
        </x-kartu>

        <div class="flex gap-3">
            <x-tombol type="submit">Simpan Draf</x-tombol>
            @if($sedangUbah)
                <x-tombol :href="route('guru.e-modul.preview', $eModul)" varian="sekunder">Pratinjau</x-tombol>
            @endif
        </div>
    </form>

    @if($sedangUbah && in_array($eModul->status_publikasi->value, ['draf', 'perlu_perbaikan']))
        <form method="POST" action="{{ route('guru.e-modul.ajukan', $eModul) }}" class="mt-4">
            @csrf
            <x-tombol type="submit" varian="utama">Ajukan untuk Ditinjau Administrator</x-tombol>
        </form>
    @endif

    @if($sedangUbah)
        <x-kartu class="mt-6">
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-slate-800 dark:text-slate-100">Konten Terkait</h2>
                <p class="text-sm text-slate-400 dark:text-slate-500">LKPD, observasi, video, dan poster yang terhubung ke E-Modul ini</p>
            </div>

            <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div>
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-400">LKPD</p>
                        <x-tombol :href="route('guru.lkpd.create', ['e_modul' => $eModul->id])" varian="hantu" class="px-2! py-1! text-xs">+ Tambah</x-tombol>
                    </div>
                    <ul class="mt-2 space-y-1">
                        @forelse($eModul->lkpd as $lkpd)
                            <li><a href="{{ route('guru.lkpd.edit', $lkpd) }}" class="text-sm text-teal-700 dark:text-teal-400 hover:underline">{{ $lkpd->judul }}</a></li>
                        @empty
                            <li class="text-sm text-slate-400 dark:text-slate-500">Belum ada.</li>
                        @endforelse
                    </ul>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-400">Observasi</p>
                        <x-tombol :href="route('guru.observasi.create', ['e_modul' => $eModul->id])" varian="hantu" class="px-2! py-1! text-xs">+ Tambah</x-tombol>
                    </div>
                    <ul class="mt-2 space-y-1">
                        @forelse($eModul->observasi as $observasi)
                            <li><a href="{{ route('guru.observasi.edit', $observasi) }}" class="text-sm text-teal-700 dark:text-teal-400 hover:underline">{{ $observasi->judul }}</a></li>
                        @empty
                            <li class="text-sm text-slate-400 dark:text-slate-500">Belum ada.</li>
                        @endforelse
                    </ul>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-400">Video</p>
                        <x-tombol :href="route('guru.video.create', ['e_modul' => $eModul->id])" varian="hantu" class="px-2! py-1! text-xs">+ Tambah</x-tombol>
                    </div>
                    <ul class="mt-2 space-y-1">
                        @forelse($eModul->video as $video)
                            <li><a href="{{ route('guru.video.edit', $video) }}" class="text-sm text-teal-700 dark:text-teal-400 hover:underline">{{ $video->judul }}</a></li>
                        @empty
                            <li class="text-sm text-slate-400 dark:text-slate-500">Belum ada.</li>
                        @endforelse
                    </ul>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-400">Poster</p>
                        <x-tombol :href="route('guru.poster.create', ['e_modul' => $eModul->id])" varian="hantu" class="px-2! py-1! text-xs">+ Tambah</x-tombol>
                    </div>
                    <ul class="mt-2 space-y-1">
                        @forelse($eModul->poster as $poster)
                            <li><a href="{{ route('guru.poster.edit', $poster) }}" class="text-sm text-teal-700 dark:text-teal-400 hover:underline">{{ $poster->judul }}</a></li>
                        @empty
                            <li class="text-sm text-slate-400 dark:text-slate-500">Belum ada.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </x-kartu>
    @endif
</x-layout-dashboard>
