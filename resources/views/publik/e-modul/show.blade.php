@php($sampul = $eModul->gambar_sampul ? \Illuminate\Support\Facades\Storage::url($eModul->gambar_sampul) : null)

<x-layout-publik :judul-seo="$eModul->judul.' | '.pengaturan('nama_aplikasi', 'E-ETNOSAINS')" :deskripsi-seo="$eModul->ringkasan">
    <div class="mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:px-8">
        <nav class="text-sm text-slate-500">
            <a href="{{ route('beranda') }}" class="hover:text-teal-700">Beranda</a> /
            <a href="{{ route('e-modul.index') }}" class="hover:text-teal-700">E-Modul</a> /
            <span class="text-slate-700">{{ $eModul->judul }}</span>
        </nav>

        <div class="mt-6 grid grid-cols-1 gap-8 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <div class="flex flex-wrap gap-2">
                    <x-badge warna="teal">{{ $eModul->mataPelajaran->nama_mata_pelajaran }}</x-badge>
                    <x-badge warna="slate">{{ $eModul->jenjangPendidikan->nama_jenjang }}</x-badge>
                    @if($eModul->topikEtnosains)
                        <a href="{{ route('topik-etnosains.show', $eModul->topikEtnosains) }}"><x-badge warna="amber">{{ $eModul->topikEtnosains->nama_topik }}</x-badge></a>
                    @endif
                </div>

                <h1 class="mt-3 text-3xl font-bold text-slate-900">{{ $eModul->judul }}</h1>
                <p class="mt-2 text-sm text-slate-500">
                    Oleh <a href="{{ route('guru.profil', $eModul->pengguna) }}" class="font-medium text-teal-700 hover:underline">{{ $eModul->pengguna->nama_lengkap }}</a>
                    &middot; {{ $eModul->tahun }} &middot; {{ $eModul->jumlah_dilihat }} dilihat &middot; {{ $eModul->jumlah_diunduh }} diunduh
                </p>

                @if($sampul)
                    <img src="{{ $sampul }}" alt="{{ $eModul->judul }}" class="mt-6 aspect-video w-full rounded-2xl object-cover">
                @endif

                <p class="mt-6 text-lg text-slate-600">{{ $eModul->ringkasan }}</p>
                <div class="prose-etnosains mt-4 text-slate-700">{!! nl2br(e($eModul->deskripsi)) !!}</div>

                <div class="mt-8 rounded-2xl bg-teal-50 p-6">
                    <h2 class="text-lg font-bold text-teal-900">Eksplorasi Etnosains</h2>
                    <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div><p class="text-xs font-semibold uppercase text-teal-700">Kearifan Lokal</p><p class="mt-1 text-sm text-slate-700">{{ $eModul->pengetahuan_lokal ?: '-' }}</p></div>
                        <div><p class="text-xs font-semibold uppercase text-teal-700">Konsep Sains</p><p class="mt-1 text-sm text-slate-700">{{ $eModul->konsep_sains ?: '-' }}</p></div>
                        <div><p class="text-xs font-semibold uppercase text-teal-700">Lokasi</p><p class="mt-1 text-sm text-slate-700">{{ $eModul->konteks_wilayah ?: ($eModul->daerahEtnosains?->namaLengkap() ?: '-') }}</p></div>
                        <div><p class="text-xs font-semibold uppercase text-teal-700">Nilai Budaya</p><p class="mt-1 text-sm text-slate-700">{{ $eModul->nilai_karakter ?: '-' }}</p></div>
                        @if($eModul->aktivitas_saintifik)
                            <div class="sm:col-span-2"><p class="text-xs font-semibold uppercase text-teal-700">Aktivitas Observasi</p><p class="mt-1 text-sm text-slate-700">{{ $eModul->aktivitas_saintifik }}</p></div>
                        @endif
                    </div>
                </div>

                @if($eModul->lkpd->isNotEmpty() || $eModul->video->isNotEmpty() || $eModul->observasi->isNotEmpty() || $eModul->poster->isNotEmpty())
                    <div class="mt-8">
                        <h2 class="text-lg font-bold text-slate-900">Konten Pendukung</h2>
                        <p class="mt-1 text-sm text-slate-500">LKPD, observasi, video, dan poster yang menyertai E-Modul ini.</p>

                        <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2">
                            @foreach($eModul->lkpd as $lkpd)
                                <a href="{{ route('lkpd.show', $lkpd) }}" class="rounded-xl border border-slate-200 p-4 transition hover:border-teal-600 hover:shadow-sm">
                                    <x-badge warna="sky">LKPD</x-badge>
                                    <p class="mt-2 font-medium text-slate-800">{{ $lkpd->judul }}</p>
                                </a>
                            @endforeach

                            @foreach($eModul->observasi as $observasi)
                                <a href="{{ route('observasi.show', $observasi) }}" class="rounded-xl border border-slate-200 p-4 transition hover:border-teal-600 hover:shadow-sm">
                                    <x-badge warna="emerald">Observasi</x-badge>
                                    <p class="mt-2 font-medium text-slate-800">{{ $observasi->judul }}</p>
                                </a>
                            @endforeach

                            @foreach($eModul->video as $video)
                                <a href="{{ route('video.show', $video) }}" class="flex gap-3 rounded-xl border border-slate-200 p-4 transition hover:border-teal-600 hover:shadow-sm">
                                    <img src="{{ $video->tautanThumbnail() }}" class="h-16 w-24 shrink-0 rounded-lg object-cover" alt="{{ $video->judul }}" loading="lazy">
                                    <div>
                                        <x-badge warna="rose">Video</x-badge>
                                        <p class="mt-2 font-medium text-slate-800">{{ $video->judul }}</p>
                                    </div>
                                </a>
                            @endforeach

                            @foreach($eModul->poster as $poster)
                                <a href="{{ \Illuminate\Support\Facades\Storage::url($poster->gambar) }}" target="_blank" rel="noopener" class="flex gap-3 rounded-xl border border-slate-200 p-4 transition hover:border-teal-600 hover:shadow-sm">
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($poster->gambar) }}" class="h-16 w-16 shrink-0 rounded-lg object-cover" alt="{{ $poster->judul }}" loading="lazy">
                                    <div>
                                        <x-badge warna="amber">Poster</x-badge>
                                        <p class="mt-2 font-medium text-slate-800">{{ $poster->judul }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($serupa->isNotEmpty())
                    <div class="mt-10">
                        <h2 class="text-lg font-bold text-slate-900">E-Modul Serupa</h2>
                        <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                            @foreach($serupa as $item)
                                @include('publik.partials.kartu-e-modul', ['eModul' => $item])
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="space-y-4">
                <x-kartu>
                    <x-tombol :href="route('e-modul.baca', $eModul)" class="w-full">Baca E-Modul</x-tombol>
                    @if($eModul->izin_unduh)
                        <x-tombol :href="route('e-modul.unduh', $eModul)" varian="sekunder" class="mt-3 w-full">Unduh PDF</x-tombol>
                    @endif
                    @auth
                        <form method="POST" action="{{ route('siswa.favorit.toggle') }}" class="mt-3">
                            @csrf
                            <input type="hidden" name="jenis_konten" value="e_modul">
                            <input type="hidden" name="id_referensi" value="{{ $eModul->id }}">
                            <x-tombol type="submit" varian="hantu" class="w-full">Tambah ke Favorit</x-tombol>
                        </form>
                    @endauth
                </x-kartu>

                <x-kartu>
                    <h3 class="font-semibold text-slate-800">Bagikan</h3>
                    <div class="mt-3 flex gap-2">
                        <a href="https://wa.me/?text={{ urlencode($eModul->judul.' - '.request()->url()) }}" target="_blank" rel="noopener" class="flex-1 rounded-lg border border-slate-200 py-2 text-center text-sm hover:bg-slate-50">WhatsApp</a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" rel="noopener" class="flex-1 rounded-lg border border-slate-200 py-2 text-center text-sm hover:bg-slate-50">Facebook</a>
                    </div>
                </x-kartu>

                <x-kartu>
                    <h3 class="font-semibold text-slate-800">Penulis</h3>
                    <a href="{{ route('guru.profil', $eModul->pengguna) }}" class="mt-2 block text-sm font-medium text-teal-700 hover:underline">{{ $eModul->pengguna->nama_lengkap }}</a>
                    <p class="text-xs text-slate-400">{{ $eModul->pengguna->profilGuru?->bidang_studi }}</p>
                </x-kartu>
            </div>
        </div>
    </div>
</x-layout-publik>
