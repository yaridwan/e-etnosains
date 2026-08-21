<x-layout-dashboard judul-seo="Tinjau Pengumpulan Observasi" :menu="\App\Support\MenuDashboard::guru()">
    <a href="{{ route('guru.pengumpulan-observasi.index') }}" class="text-sm text-teal-700 dark:text-teal-400 hover:underline">&larr; Kembali</a>
    <h1 class="mt-2 text-2xl font-bold text-slate-900 dark:text-slate-100">{{ $pengumpulan->observasi->judul }}</h1>
    <p class="text-sm text-slate-500 dark:text-slate-400">Oleh: {{ $pengumpulan->pengguna->nama_lengkap }}</p>

    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-3">
        <x-kartu class="lg:col-span-2">
            <h2 class="font-semibold text-slate-800 dark:text-slate-100">Jawaban</h2>
            <div class="mt-4 space-y-4">
                @foreach($pengumpulan->observasi->butirObservasi as $butir)
                    @php($jawaban = $pengumpulan->jawaban->firstWhere('id_butir_observasi', $butir->id))
                    <div class="border-b border-slate-100 dark:border-slate-800 pb-3">
                        <p class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ $butir->pertanyaan }}</p>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                            {{ $jawaban?->jawaban_teks ?? $jawaban?->jawaban_angka ?? $jawaban?->opsiTerpilih?->teks_opsi ?? '-' }}
                        </p>
                    </div>
                @endforeach
            </div>

            @if($pengumpulan->dokumentasi->isNotEmpty())
                <h2 class="mt-6 font-semibold text-slate-800 dark:text-slate-100">Dokumentasi</h2>
                <div class="mt-3 grid grid-cols-2 gap-3 sm:grid-cols-3">
                    @foreach($pengumpulan->dokumentasi as $dok)
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($dok->berkas) }}" class="aspect-square rounded-lg object-cover" alt="Dokumentasi">
                    @endforeach
                </div>
            @endif
        </x-kartu>

        <x-kartu>
            <h2 class="font-semibold text-slate-800 dark:text-slate-100">Penilaian</h2>
            <form method="POST" action="{{ route('guru.pengumpulan-observasi.nilai', $pengumpulan) }}" class="mt-4 space-y-4">
                @csrf
                <x-input label="Skor (0-100)" name="skor" type="number" :value="$pengumpulan->skor" wajib />
                <x-textarea label="Catatan" name="catatan_guru">{{ $pengumpulan->catatan_guru }}</x-textarea>
                <x-tombol type="submit" class="w-full">Simpan Penilaian</x-tombol>
            </form>
        </x-kartu>
    </div>
</x-layout-dashboard>
