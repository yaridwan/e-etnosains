<x-layout-publik>
    <!-- Hero -->
    <section class="relative overflow-hidden bg-gradient-to-b from-teal-50 via-white to-white dark:from-slate-900 dark:via-slate-950 dark:to-slate-950">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <h1 class="text-4xl font-bold tracking-tight text-slate-900 dark:text-slate-100 sm:text-5xl">
                    {{ $banner->first()->judul ?? 'Belajar Sains dari Kearifan Lokal' }}
                </h1>
                <p class="mt-6 text-lg text-slate-600 dark:text-slate-400">
                    {{ $banner->first()->subjudul ?? 'Temukan e-modul, LKPD, bahan ajar, aktivitas observasi, dan video pembelajaran berbasis budaya serta kearifan lokal Indonesia.' }}
                </p>

                <form action="{{ route('pencarian') }}" method="GET" class="mx-auto mt-8 flex max-w-xl gap-2">
                    <input type="search" name="q" placeholder="Cari e-modul, topik, atau daerah..." class="flex-1 rounded-full border border-slate-200 dark:border-slate-800 px-5 py-3 text-sm shadow-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-600">
                    <button type="submit" class="rounded-full bg-teal-700 px-6 py-3 text-sm font-semibold text-white hover:bg-teal-800">Cari</button>
                </form>

                <div class="mt-6 flex flex-wrap items-center justify-center gap-3">
                    <x-tombol :href="route('e-modul.index')">Jelajahi E-Modul</x-tombol>
                    <x-tombol :href="route('daftar.guru')" varian="sekunder">Daftar sebagai Guru</x-tombol>
                </div>

                <div class="mx-auto mt-12 grid max-w-2xl grid-cols-2 gap-6 sm:grid-cols-4">
                    @foreach([
                        ['label' => 'E-Modul', 'nilai' => $statistik['e_modul']],
                        ['label' => 'Guru', 'nilai' => $statistik['guru']],
                        ['label' => 'Siswa', 'nilai' => $statistik['siswa']],
                        ['label' => 'Topik Etnosains', 'nilai' => $statistik['topik']],
                    ] as $item)
                        <div>
                            <p class="text-2xl font-bold text-teal-800 dark:text-teal-300">{{ $item['nilai'] }}+</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ $item['label'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- E-Modul Unggulan -->
    @if($eModulUnggulan->isNotEmpty())
    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-900 dark:text-slate-100">E-Modul Pilihan</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Konten unggulan yang direkomendasikan Administrator.</p>
            </div>
            <a href="{{ route('e-modul.index') }}" class="text-sm font-medium text-teal-700 dark:text-teal-400 hover:underline">Lihat semua &rarr;</a>
        </div>

        <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($eModulUnggulan as $eModul)
                @include('publik.partials.kartu-e-modul', ['eModul' => $eModul])
            @endforeach
        </div>
    </section>
    @endif

    <!-- Topik Etnosains Populer -->
    <section class="bg-slate-50 dark:bg-slate-900/50 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Topik Etnosains Populer</h2>
            <div class="mt-8 grid grid-cols-2 gap-4 sm:grid-cols-4">
                @foreach($topikPopuler as $topik)
                    <a href="{{ route('topik-etnosains.show', $topik) }}" class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-4 text-center transition hover:border-teal-600 dark:hover:border-teal-500 hover:shadow-sm">
                        <p class="font-semibold text-slate-800 dark:text-slate-100">{{ $topik->nama_topik }}</p>
                        <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">{{ $topik->e_modul_count }} E-Modul</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- E-Modul Terbaru -->
    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between">
            <h2 class="text-2xl font-bold text-slate-900 dark:text-slate-100">E-Modul Terbaru</h2>
            <a href="{{ route('e-modul.index') }}" class="text-sm font-medium text-teal-700 dark:text-teal-400 hover:underline">Lihat semua &rarr;</a>
        </div>
        <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($eModulTerbaru->take(8) as $eModul)
                @include('publik.partials.kartu-e-modul', ['eModul' => $eModul])
            @endforeach
        </div>
    </section>

    <!-- LKPD & Observasi -->
    <section class="bg-slate-50 dark:bg-slate-900/50 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-10 lg:grid-cols-2">
                <div>
                    <div class="flex items-end justify-between">
                        <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100">LKPD Terbaru</h2>
                        <a href="{{ route('lkpd.index') }}" class="text-sm font-medium text-teal-700 dark:text-teal-400 hover:underline">Lihat semua &rarr;</a>
                    </div>
                    <div class="mt-4 space-y-3">
                        @foreach($lkpdTerbaru as $lkpd)
                            <a href="{{ route('lkpd.show', $lkpd) }}" class="block rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-4 hover:border-teal-600 dark:hover:border-teal-500">
                                <p class="font-medium text-slate-800 dark:text-slate-100">{{ $lkpd->judul }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
                <div>
                    <div class="flex items-end justify-between">
                        <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100">Aktivitas Observasi</h2>
                        <a href="{{ route('observasi.index') }}" class="text-sm font-medium text-teal-700 dark:text-teal-400 hover:underline">Lihat semua &rarr;</a>
                    </div>
                    <div class="mt-4 space-y-3">
                        @foreach($observasiTerbaru as $observasi)
                            <a href="{{ route('observasi.show', $observasi) }}" class="block rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-4 hover:border-teal-600 dark:hover:border-teal-500">
                                <p class="font-medium text-slate-800 dark:text-slate-100">{{ $observasi->judul }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Jenjang & Mata Pelajaran -->
    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Jelajahi Berdasarkan Jenjang</h2>
        <div class="mt-6 grid grid-cols-2 gap-4 sm:grid-cols-5">
            @foreach($jenjang as $item)
                <a href="{{ route('e-modul.index', ['jenjang' => $item->id]) }}" class="rounded-xl border border-slate-200 dark:border-slate-800 py-4 text-center font-medium text-slate-700 dark:text-slate-300 hover:border-teal-600 dark:hover:border-teal-500">
                    {{ $item->nama_jenjang }}
                </a>
            @endforeach
        </div>

        <h2 class="mt-12 text-2xl font-bold text-slate-900 dark:text-slate-100">Jelajahi Berdasarkan Mata Pelajaran</h2>
        <div class="mt-6 flex flex-wrap gap-3">
            @foreach($mataPelajaran as $item)
                <a href="{{ route('e-modul.index', ['mata_pelajaran' => $item->id]) }}" class="rounded-full border border-slate-200 dark:border-slate-800 px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 hover:border-teal-600 dark:hover:border-teal-500">
                    {{ $item->nama_mata_pelajaran }}
                </a>
            @endforeach
        </div>
    </section>

    <!-- Cara Menggunakan -->
    <section class="bg-teal-900 py-16 text-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-center text-2xl font-bold">Cara Menggunakan E-ETNOSAINS</h2>
            <div class="mt-10 grid grid-cols-2 gap-6 sm:grid-cols-3 lg:grid-cols-6">
                @foreach(['Temukan Materi', 'Pelajari E-Modul', 'Kerjakan LKPD', 'Lakukan Observasi', 'Kumpulkan Hasil', 'Pantau Kemajuan'] as $i => $langkah)
                    <div class="text-center">
                        <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-full bg-white/10 font-bold">{{ $i + 1 }}</div>
                        <p class="mt-3 text-sm text-teal-50">{{ $langkah }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimoni -->
    @if($testimoni->isNotEmpty())
    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Apa Kata Mereka</h2>
        <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-3">
            @foreach($testimoni as $item)
                <x-kartu>
                    <p class="text-sm italic text-slate-600 dark:text-slate-400">&ldquo;{{ $item->isi_testimoni }}&rdquo;</p>
                    <p class="mt-4 font-semibold text-slate-800 dark:text-slate-100">{{ $item->nama }}</p>
                    <p class="text-xs text-slate-400 dark:text-slate-500">{{ $item->peran_testimoni }}</p>
                </x-kartu>
            @endforeach
        </div>
    </section>
    @endif

    <!-- FAQ -->
    @if($faq->isNotEmpty())
    <section class="bg-slate-50 dark:bg-slate-900/50 py-16">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Pertanyaan Umum</h2>
            <div class="mt-8 space-y-3" x-data="{ terbuka: null }">
                @foreach($faq as $i => $item)
                    <div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900">
                        <button type="button" @click="terbuka = terbuka === {{ $i }} ? null : {{ $i }}" class="flex w-full items-center justify-between px-5 py-4 text-left text-sm font-semibold text-slate-800 dark:text-slate-100">
                            {{ $item->pertanyaan }}
                            <span x-text="terbuka === {{ $i }} ? '−' : '+'"></span>
                        </button>
                        <div x-show="terbuka === {{ $i }}" x-cloak class="px-5 pb-4 text-sm text-slate-600 dark:text-slate-400">{{ $item->jawaban }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- CTA -->
    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="rounded-3xl bg-teal-700 px-8 py-14 text-center text-white">
            <h2 class="text-2xl font-bold">Bagikan Pembelajaran Berbasis Kearifan Lokal Anda</h2>
            <p class="mx-auto mt-3 max-w-xl text-teal-50">Bergabunglah sebagai guru dan publikasikan karya pembelajaran etnosains Anda.</p>
            <x-tombol :href="route('daftar.guru')" varian="putih" class="mt-6">Daftar sebagai Guru</x-tombol>
        </div>
    </section>
</x-layout-publik>
