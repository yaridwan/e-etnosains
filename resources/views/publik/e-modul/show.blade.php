@php($sampul = $eModul->gambar_sampul ? \Illuminate\Support\Facades\Storage::url($eModul->gambar_sampul) : null)

<x-layout-publik :judul-seo="$eModul->judul.' | '.pengaturan('nama_aplikasi', 'E-ETNOSAINS')" :deskripsi-seo="$eModul->ringkasan">
    <div class="mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:px-8">
        <nav class="text-sm text-slate-500 dark:text-slate-400">
            <a href="{{ route('beranda') }}" class="hover:text-teal-700 dark:hover:text-teal-400">Beranda</a> /
            <a href="{{ route('e-modul.index') }}" class="hover:text-teal-700 dark:hover:text-teal-400">E-Modul</a> /
            <span class="text-slate-700 dark:text-slate-300">{{ $eModul->judul }}</span>
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

                <h1 class="mt-3 text-3xl font-bold text-slate-900 dark:text-slate-100">{{ $eModul->judul }}</h1>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                    Oleh <a href="{{ route('guru.profil', $eModul->pengguna) }}" class="font-medium text-teal-700 dark:text-teal-400 hover:underline">{{ $eModul->pengguna->nama_lengkap }}</a>
                    &middot; {{ $eModul->tahun }} &middot; {{ $eModul->jumlah_dilihat }} dilihat &middot; {{ $eModul->jumlah_diunduh }} diunduh
                </p>

                @if($sampul)
                    <img src="{{ $sampul }}" alt="{{ $eModul->judul }}" class="mt-6 aspect-video w-full rounded-2xl object-cover">
                @endif

                <p class="mt-6 text-lg text-slate-600 dark:text-slate-400">{{ $eModul->ringkasan }}</p>
                <div class="prose-etnosains mt-4 text-slate-700 dark:text-slate-300">{!! nl2br(e($eModul->deskripsi)) !!}</div>

                <div class="mt-8 rounded-2xl bg-teal-50 dark:bg-teal-950 p-6">
                    <h2 class="text-lg font-bold text-teal-900 dark:text-teal-200">Eksplorasi Etnosains</h2>
                    <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div><p class="text-xs font-semibold uppercase text-teal-700 dark:text-teal-400">Kearifan Lokal</p><p class="mt-1 text-sm text-slate-700 dark:text-slate-300">{{ $eModul->pengetahuan_lokal ?: '-' }}</p></div>
                        <div><p class="text-xs font-semibold uppercase text-teal-700 dark:text-teal-400">Konsep Sains</p><p class="mt-1 text-sm text-slate-700 dark:text-slate-300">{{ $eModul->konsep_sains ?: '-' }}</p></div>
                        <div><p class="text-xs font-semibold uppercase text-teal-700 dark:text-teal-400">Lokasi</p><p class="mt-1 text-sm text-slate-700 dark:text-slate-300">{{ $eModul->konteks_wilayah ?: ($eModul->daerahEtnosains?->namaLengkap() ?: '-') }}</p></div>
                        <div><p class="text-xs font-semibold uppercase text-teal-700 dark:text-teal-400">Nilai Budaya</p><p class="mt-1 text-sm text-slate-700 dark:text-slate-300">{{ $eModul->nilai_karakter ?: '-' }}</p></div>
                        @if($eModul->aktivitas_saintifik)
                            <div class="sm:col-span-2"><p class="text-xs font-semibold uppercase text-teal-700 dark:text-teal-400">Aktivitas Observasi</p><p class="mt-1 text-sm text-slate-700 dark:text-slate-300">{{ $eModul->aktivitas_saintifik }}</p></div>
                        @endif
                    </div>
                </div>

                @if($eModul->lkpd->isNotEmpty() || $eModul->video->isNotEmpty() || $eModul->observasi->isNotEmpty() || $eModul->poster->isNotEmpty() || $eModul->evaluasi->isNotEmpty())
                    <div class="mt-8">
                        <h2 class="text-lg font-bold text-slate-900 dark:text-slate-100">Konten Pendukung</h2>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">LKPD, observasi, video, poster, dan evaluasi yang menyertai E-Modul ini.</p>

                        <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2">
                            @foreach($eModul->lkpd as $lkpd)
                                <a href="{{ route('lkpd.show', $lkpd) }}" class="rounded-xl border border-slate-200 dark:border-slate-800 p-4 transition hover:border-teal-600 dark:hover:border-teal-500 hover:shadow-sm">
                                    <x-badge warna="sky">LKPD</x-badge>
                                    <p class="mt-2 font-medium text-slate-800 dark:text-slate-100">{{ $lkpd->judul }}</p>
                                </a>
                            @endforeach

                            @foreach($eModul->observasi as $observasi)
                                <a href="{{ route('observasi.show', $observasi) }}" class="rounded-xl border border-slate-200 dark:border-slate-800 p-4 transition hover:border-teal-600 dark:hover:border-teal-500 hover:shadow-sm">
                                    <x-badge warna="emerald">Observasi</x-badge>
                                    <p class="mt-2 font-medium text-slate-800 dark:text-slate-100">{{ $observasi->judul }}</p>
                                </a>
                            @endforeach

                            @foreach($eModul->video as $video)
                                <a href="{{ route('video.show', $video) }}" class="flex gap-3 rounded-xl border border-slate-200 dark:border-slate-800 p-4 transition hover:border-teal-600 dark:hover:border-teal-500 hover:shadow-sm">
                                    <img src="{{ $video->tautanThumbnail() }}" class="h-16 w-24 shrink-0 rounded-lg object-cover" alt="{{ $video->judul }}" loading="lazy">
                                    <div>
                                        <x-badge warna="rose">Video</x-badge>
                                        <p class="mt-2 font-medium text-slate-800 dark:text-slate-100">{{ $video->judul }}</p>
                                    </div>
                                </a>
                            @endforeach

                            @foreach($eModul->poster as $poster)
                                <a href="{{ \Illuminate\Support\Facades\Storage::url($poster->gambar) }}" target="_blank" rel="noopener" class="flex gap-3 rounded-xl border border-slate-200 dark:border-slate-800 p-4 transition hover:border-teal-600 dark:hover:border-teal-500 hover:shadow-sm">
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($poster->gambar) }}" class="h-16 w-16 shrink-0 rounded-lg object-cover" alt="{{ $poster->judul }}" loading="lazy">
                                    <div>
                                        <x-badge warna="amber">Poster</x-badge>
                                        <p class="mt-2 font-medium text-slate-800 dark:text-slate-100">{{ $poster->judul }}</p>
                                    </div>
                                </a>
                            @endforeach

                            @foreach($eModul->evaluasi as $evaluasi)
                                <a href="{{ route('evaluasi.show', $evaluasi) }}" class="rounded-xl border border-slate-200 dark:border-slate-800 p-4 transition hover:border-teal-600 dark:hover:border-teal-500 hover:shadow-sm">
                                    <x-badge warna="violet">Evaluasi</x-badge>
                                    <p class="mt-2 font-medium text-slate-800 dark:text-slate-100">{{ $evaluasi->judul }}</p>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if(pengaturan_aktif('ulasan_aktif', true))
                    <div class="mt-10">
                        <div class="flex items-baseline justify-between">
                            <h2 class="text-lg font-bold text-slate-900 dark:text-slate-100">Ulasan</h2>
                            @if($ulasan->isNotEmpty())
                                <p class="text-sm text-slate-500 dark:text-slate-400">
                                    <span class="font-semibold text-amber-600 dark:text-amber-400">&#9733; {{ number_format($rataRata, 1) }}</span>
                                    dari {{ $ulasan->count() }} ulasan
                                </p>
                            @endif
                        </div>

                        @auth
                            @if(auth()->id() !== $eModul->id_pengguna)
                                <form method="POST" action="{{ route('e-modul.ulasan.simpan', $eModul) }}" class="mt-4 rounded-2xl border border-slate-200 dark:border-slate-800 p-5">
                                    @csrf
                                    <p class="text-sm font-medium text-slate-700 dark:text-slate-300">
                                        {{ $ulasanSaya ? 'Perbarui ulasan Anda' : 'Berikan ulasan Anda' }}
                                    </p>

                                    <div class="mt-3">
                                        <label for="rating" class="mb-1.5 block text-sm text-slate-600 dark:text-slate-400">Rating <span class="text-rose-600 dark:text-rose-400">*</span></label>
                                        <select name="rating" id="rating" class="rounded-lg border border-slate-300 dark:border-slate-700 px-3.5 py-2 text-sm">
                                            @for($nilai = 5; $nilai >= 1; $nilai--)
                                                <option value="{{ $nilai }}" @selected(old('rating', $ulasanSaya?->rating) == $nilai)>{{ $nilai }} - {{ ['Sangat Kurang', 'Kurang', 'Cukup', 'Baik', 'Sangat Baik'][$nilai - 1] }}</option>
                                            @endfor
                                        </select>
                                        @error('rating')<p class="mt-1.5 text-sm text-rose-600 dark:text-rose-400">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="mt-3">
                                        <x-textarea label="Komentar (opsional)" name="komentar" :baris="3">{{ $ulasanSaya?->komentar }}</x-textarea>
                                    </div>

                                    @if($ulasanSaya && $ulasanSaya->status_moderasi === 'menunggu')
                                        <p class="mt-2 text-xs text-amber-700 dark:text-amber-400">Ulasan Anda sedang menunggu moderasi Administrator.</p>
                                    @endif

                                    <x-tombol type="submit" class="mt-4">Kirim Ulasan</x-tombol>
                                </form>
                            @endif
                        @else
                            <x-alert jenis="info" class="mt-4">
                                <a href="{{ route('masuk') }}" class="font-medium underline">Masuk</a> untuk memberikan ulasan pada E-Modul ini.
                            </x-alert>
                        @endauth

                        <div class="mt-5 space-y-4">
                            @forelse($ulasan as $item)
                                <div class="rounded-xl border border-slate-200 dark:border-slate-800 p-4">
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm font-semibold text-slate-800 dark:text-slate-100">{{ $item->pengguna?->nama_lengkap ?? 'Pengguna' }}</p>
                                        <p class="text-sm text-amber-600 dark:text-amber-400">{{ str_repeat('★', $item->rating) }}<span class="text-slate-200">{{ str_repeat('★', 5 - $item->rating) }}</span></p>
                                    </div>
                                    @if($item->komentar)
                                        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">{{ $item->komentar }}</p>
                                    @endif
                                    <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">{{ $item->dibuat_pada?->translatedFormat('d F Y') }}</p>
                                </div>
                            @empty
                                <p class="text-sm text-slate-400 dark:text-slate-500">Belum ada ulasan untuk E-Modul ini.</p>
                            @endforelse
                        </div>
                    </div>
                @endif

                @if($serupa->isNotEmpty())
                    <div class="mt-10">
                        <h2 class="text-lg font-bold text-slate-900 dark:text-slate-100">E-Modul Serupa</h2>
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
                    <h3 class="font-semibold text-slate-800 dark:text-slate-100">Bagikan</h3>
                    <div class="mt-3 flex gap-2">
                        <a href="https://wa.me/?text={{ urlencode($eModul->judul.' - '.request()->url()) }}" target="_blank" rel="noopener" class="flex-1 rounded-lg border border-slate-200 dark:border-slate-800 py-2 text-center text-sm hover:bg-slate-50 dark:hover:bg-slate-800">WhatsApp</a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" rel="noopener" class="flex-1 rounded-lg border border-slate-200 dark:border-slate-800 py-2 text-center text-sm hover:bg-slate-50 dark:hover:bg-slate-800">Facebook</a>
                    </div>
                    <button type="button"
                        x-data="{ tersalin: false }"
                        @click="navigator.clipboard.writeText(@js(request()->url())).then(() => { tersalin = true; setTimeout(() => tersalin = false, 2000) })"
                        class="mt-2 w-full rounded-lg border border-slate-200 dark:border-slate-800 py-2 text-sm hover:bg-slate-50 dark:hover:bg-slate-800">
                        <span x-show="! tersalin">Salin Tautan</span>
                        <span x-show="tersalin" x-cloak class="text-emerald-700 dark:text-emerald-400">Tautan disalin!</span>
                    </button>
                </x-kartu>

                <x-kartu class="text-center">
                    <h3 class="font-semibold text-slate-800 dark:text-slate-100">QR Code</h3>
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Pindai untuk membuka E-Modul ini di perangkat lain.</p>
                    <img src="{{ \App\Support\PembuatQrCode::dataUri(route('e-modul.show', $eModul)) }}"
                        alt="QR Code {{ $eModul->judul }}"
                        class="mx-auto mt-3 h-40 w-40">
                </x-kartu>

                <x-kartu>
                    <h3 class="font-semibold text-slate-800 dark:text-slate-100">Penulis</h3>
                    <a href="{{ route('guru.profil', $eModul->pengguna) }}" class="mt-2 block text-sm font-medium text-teal-700 dark:text-teal-400 hover:underline">{{ $eModul->pengguna->nama_lengkap }}</a>
                    <p class="text-xs text-slate-400 dark:text-slate-500">{{ $eModul->pengguna->profilGuru?->bidang_studi }}</p>
                </x-kartu>
            </div>
        </div>
    </div>
</x-layout-publik>
