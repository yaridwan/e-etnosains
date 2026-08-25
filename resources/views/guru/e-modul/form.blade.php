@php($sedangUbah = $eModul->exists)

<x-layout-dashboard :judul-seo="$sedangUbah ? 'Ubah E-Modul' : 'Buat E-Modul'" :menu="\App\Support\MenuDashboard::guru()">
    <a href="{{ route('guru.e-modul.index') }}" class="text-sm text-teal-700 dark:text-teal-400 hover:underline">&larr; Kembali</a>
    <div class="mt-2 flex flex-wrap items-center gap-3">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">{{ $sedangUbah ? 'Ubah E-Modul' : 'Buat E-Modul Baru' }}</h1>
        @if($sedangUbah)<x-status-publikasi :status="$eModul->status_publikasi" />@endif
    </div>

    @if($sedangUbah && $eModul->status_publikasi === \App\Enums\StatusPublikasi::Dijadwalkan)
        <x-alert jenis="info" class="mt-4">Dijadwalkan tampil otomatis di portal publik pada {{ $eModul->dijadwalkan_pada?->translatedFormat('d F Y, H:i') }} WIB.</x-alert>
    @endif

    @if($sedangUbah && $eModul->catatan_reviewer)
        <x-alert jenis="peringatan" class="mt-4">Catatan reviewer: {{ $eModul->catatan_reviewer }}</x-alert>
    @endif

    <form
        method="POST"
        action="{{ $sedangUbah ? route('guru.e-modul.update', $eModul) : route('guru.e-modul.store') }}"
        enctype="multipart/form-data"
        class="mt-6 space-y-6"
        @if($sedangUbah)
            x-data="{
                status: null,
                waktu: null,
                simpanOtomatis() {
                    const data = {};
                    new FormData(this.$el).forEach((nilai, kunci) => {
                        if (! (nilai instanceof File)) data[kunci] = nilai;
                    });
                    this.status = 'menyimpan';
                    axios.patch('{{ route('guru.e-modul.simpan-otomatis', $eModul) }}', data)
                        .then((res) => { this.status = 'tersimpan'; this.waktu = res.data.tersimpan_pada; })
                        .catch(() => { this.status = 'gagal'; });
                },
            }"
            @input.debounce.2500ms="simpanOtomatis()"
        @endif
    >
        @csrf
        @if($sedangUbah) @method('PUT') @endif

        @if($sedangUbah)
            <p class="-mt-3 text-xs text-slate-400 dark:text-slate-500">
                <span x-show="status === 'menyimpan'" x-cloak>Menyimpan draf otomatis&hellip;</span>
                <span x-show="status === 'tersimpan'" x-cloak>Draf tersimpan otomatis pukul <span x-text="waktu"></span>.</span>
                <span x-show="status === 'gagal'" x-cloak class="text-rose-500 dark:text-rose-400">Gagal menyimpan otomatis. Perubahan Anda belum hilang — klik "Simpan Draf" untuk menyimpan manual.</span>
                <span x-show="! status">Perubahan disimpan otomatis saat Anda berhenti mengetik.</span>
            </p>
        @endif

        <x-kartu>
            <x-judul-form-seksi :nomor="1">Informasi Dasar</x-judul-form-seksi>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
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
            <x-judul-form-seksi :nomor="2">Informasi Pembelajaran</x-judul-form-seksi>
            <div class="space-y-4">
                <x-textarea label="Ringkasan" name="ringkasan" wajib>{{ $eModul->ringkasan }}</x-textarea>
                <x-textarea label="Deskripsi Lengkap" name="deskripsi" :baris="6" wajib>{{ $eModul->deskripsi }}</x-textarea>
                <x-textarea label="Capaian Pembelajaran" name="capaian_pembelajaran">{{ $eModul->capaian_pembelajaran }}</x-textarea>
                <x-textarea label="Tujuan Pembelajaran" name="tujuan_pembelajaran">{{ $eModul->tujuan_pembelajaran }}</x-textarea>
            </div>
        </x-kartu>

        <x-kartu>
            <x-judul-form-seksi :nomor="3" deskripsi="Hubungkan kearifan lokal dengan konsep sains yang dipelajari.">Eksplorasi Etnosains</x-judul-form-seksi>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
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
            <x-judul-form-seksi :nomor="4">Media dan Berkas PDF</x-judul-form-seksi>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <x-unggah label="Gambar Sampul" name="gambar_sampul" jenis="gambar" accept="image/*" :pratinjau="$eModul->gambar_sampul ? \Illuminate\Support\Facades\Storage::url($eModul->gambar_sampul) : null" />
                <x-unggah label="Gambar Poster" name="gambar_poster" jenis="gambar" accept="image/*" :pratinjau="$eModul->gambar_poster ? \Illuminate\Support\Facades\Storage::url($eModul->gambar_poster) : null" />
                <div class="sm:col-span-2">
                    <x-unggah label="Berkas PDF E-Modul" name="berkas_pdf" jenis="dokumen" accept="application/pdf" :pratinjau="$eModul->berkas_pdf ? \Illuminate\Support\Facades\Storage::url($eModul->berkas_pdf) : null" />
                </div>
            </div>
        </x-kartu>

        <x-kartu>
            <x-judul-form-seksi :nomor="5">Pengaturan Publikasi</x-judul-form-seksi>
            <x-checkbox name="izin_unduh" :checked="$eModul->izin_unduh">
                Izinkan pengunjung mengunduh berkas PDF
            </x-checkbox>
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

        @if($eModul->versi->isNotEmpty())
            <x-kartu class="mt-6">
                <h2 class="font-semibold text-slate-800 dark:text-slate-100">Riwayat Versi Terbit</h2>
                <p class="text-sm text-slate-400 dark:text-slate-500">Setiap kali disetujui dan terbit, isi E-Modul saat itu dibekukan sebagai satu versi.</p>
                <div class="mt-4 space-y-3">
                    @foreach($eModul->versi as $versi)
                        <div class="flex items-center justify-between gap-3 border-b border-slate-100 dark:border-slate-800 pb-3 text-sm last:border-0">
                            <div>
                                <p class="font-medium text-slate-700 dark:text-slate-300">Versi {{ $versi->nomor_versi }}</p>
                                <p class="text-xs text-slate-400 dark:text-slate-500">{{ $versi->dibuat_pada?->translatedFormat('d M Y, H:i') }}</p>
                            </div>
                            <x-tombol :href="route('guru.e-modul.versi', [$eModul, $versi])" varian="hantu" class="px-2! py-1! text-xs">Lihat</x-tombol>
                        </div>
                    @endforeach
                </div>
            </x-kartu>
        @endif
    @endif
</x-layout-dashboard>
