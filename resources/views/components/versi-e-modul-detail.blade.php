@props(['versi'])

<div class="mt-6 space-y-6">
    <x-kartu>
        <h2 class="font-semibold text-slate-800 dark:text-slate-100">{{ $versi->judul }}</h2>
        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">{{ $versi->ringkasan }}</p>
        <p class="mt-2 whitespace-pre-line text-sm text-slate-500 dark:text-slate-400">{{ $versi->deskripsi }}</p>
    </x-kartu>

    <x-kartu>
        <h2 class="font-semibold text-slate-800 dark:text-slate-100">Capaian &amp; Tujuan Pembelajaran</h2>
        <dl class="mt-3 space-y-3 text-sm">
            <div><dt class="font-medium text-slate-700 dark:text-slate-300">Capaian Pembelajaran</dt><dd class="text-slate-500 dark:text-slate-400 whitespace-pre-line">{{ $versi->capaian_pembelajaran ?: '-' }}</dd></div>
            <div><dt class="font-medium text-slate-700 dark:text-slate-300">Tujuan Pembelajaran</dt><dd class="text-slate-500 dark:text-slate-400 whitespace-pre-line">{{ $versi->tujuan_pembelajaran ?: '-' }}</dd></div>
        </dl>
    </x-kartu>

    <x-kartu>
        <h2 class="font-semibold text-slate-800 dark:text-slate-100">Eksplorasi Etnosains</h2>
        <dl class="mt-3 space-y-3 text-sm">
            <div><dt class="font-medium text-slate-700 dark:text-slate-300">Pengetahuan Lokal</dt><dd class="text-slate-500 dark:text-slate-400 whitespace-pre-line">{{ $versi->pengetahuan_lokal ?: '-' }}</dd></div>
            <div><dt class="font-medium text-slate-700 dark:text-slate-300">Konsep Sains</dt><dd class="text-slate-500 dark:text-slate-400 whitespace-pre-line">{{ $versi->konsep_sains ?: '-' }}</dd></div>
            <div><dt class="font-medium text-slate-700 dark:text-slate-300">Konteks Wilayah</dt><dd class="text-slate-500 dark:text-slate-400">{{ $versi->konteks_wilayah ?: '-' }}</dd></div>
            <div><dt class="font-medium text-slate-700 dark:text-slate-300">Aktivitas Saintifik</dt><dd class="text-slate-500 dark:text-slate-400 whitespace-pre-line">{{ $versi->aktivitas_saintifik ?: '-' }}</dd></div>
            <div><dt class="font-medium text-slate-700 dark:text-slate-300">Nilai Karakter</dt><dd class="text-slate-500 dark:text-slate-400 whitespace-pre-line">{{ $versi->nilai_karakter ?: '-' }}</dd></div>
        </dl>
    </x-kartu>

    @if($versi->gambar_sampul || $versi->berkas_pdf)
        <x-kartu>
            <h2 class="font-semibold text-slate-800 dark:text-slate-100">Berkas Versi Ini</h2>
            <div class="mt-3 grid grid-cols-1 gap-4 sm:grid-cols-2">
                @if($versi->gambar_sampul)
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($versi->gambar_sampul) }}" alt="Sampul versi {{ $versi->nomor_versi }}" class="rounded-lg border border-slate-200 dark:border-slate-800">
                @endif
                @if($versi->berkas_pdf)
                    <div class="text-sm">
                        <p class="text-slate-500 dark:text-slate-400">Berkas PDF pada versi ini ({{ $versi->jumlah_halaman ?? '-' }} halaman):</p>
                        <a href="{{ \Illuminate\Support\Facades\Storage::url($versi->berkas_pdf) }}" target="_blank" rel="noopener" class="mt-1 inline-block text-teal-700 dark:text-teal-400 hover:underline">Buka berkas PDF versi ini &rarr;</a>
                    </div>
                @endif
            </div>
        </x-kartu>
    @endif
</div>
