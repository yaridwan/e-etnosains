@php($sudahDinilai = $pengumpulan?->status === 'dinilai')

<x-layout-dashboard judul-seo="Kerjakan Observasi" :menu="\App\Support\MenuDashboard::siswa()">
    <a href="{{ route('siswa.observasi.index') }}" class="text-sm text-teal-700 dark:text-teal-400 hover:underline">&larr; Kembali</a>
    <h1 class="mt-2 text-2xl font-bold text-slate-900 dark:text-slate-100">{{ $observasi->judul }}</h1>

    <x-kartu class="mt-6">
        <h2 class="font-semibold text-slate-800 dark:text-slate-100">Petunjuk</h2>
        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">{{ $observasi->petunjuk }}</p>
        <dl class="mt-4 grid grid-cols-1 gap-3 text-sm sm:grid-cols-2">
            <div><dt class="text-slate-400 dark:text-slate-500">Lokasi</dt><dd class="text-slate-700 dark:text-slate-300">{{ $observasi->lokasi_observasi }}</dd></div>
            <div><dt class="text-slate-400 dark:text-slate-500">Durasi</dt><dd class="text-slate-700 dark:text-slate-300">{{ $observasi->durasi }}</dd></div>
            <div><dt class="text-slate-400 dark:text-slate-500">Alat dan Bahan</dt><dd class="text-slate-700 dark:text-slate-300">{{ $observasi->alat_dan_bahan }}</dd></div>
            <div><dt class="text-slate-400 dark:text-slate-500">Aspek Keselamatan</dt><dd class="text-slate-700 dark:text-slate-300">{{ $observasi->aspek_keselamatan }}</dd></div>
        </dl>
    </x-kartu>

    @if($sudahDinilai)
        <x-alert jenis="sukses" class="mt-6">
            Observasi Anda telah dinilai dengan skor {{ $pengumpulan->skor }}.
            @if($pengumpulan->catatan_guru) Catatan guru: {{ $pengumpulan->catatan_guru }} @endif
        </x-alert>
    @endif

    <form method="POST" action="{{ route('siswa.observasi.kirim', $observasi) }}" enctype="multipart/form-data" class="mt-6 space-y-4">
        @csrf
        <x-kartu class="space-y-5">
            <h2 class="font-semibold text-slate-800 dark:text-slate-100">Instrumen Observasi</h2>
            @foreach($observasi->butirObservasi as $butir)
                @php($jawabanAda = $pengumpulan?->jawaban->firstWhere('id_butir_observasi', $butir->id))
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">
                        {{ $butir->pertanyaan }} @if($butir->wajib)<span class="text-rose-600 dark:text-rose-400">*</span>@endif
                    </label>

                    @php($kelasKontrol = 'block w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm shadow-sm transition placeholder:text-slate-400 focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-600/30 disabled:cursor-not-allowed disabled:opacity-60 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:placeholder:text-slate-500 dark:focus:border-teal-500')

                    @if(in_array($butir->tipe_pertanyaan->value, ['teks_pendek']))
                        <input type="text" name="jawaban[{{ $butir->id }}]" value="{{ $jawabanAda?->jawaban_teks }}" {{ $sudahDinilai ? 'disabled' : '' }} class="{{ $kelasKontrol }}">
                    @elseif($butir->tipe_pertanyaan->value === 'teks_panjang')
                        <textarea name="jawaban[{{ $butir->id }}]" rows="3" {{ $sudahDinilai ? 'disabled' : '' }} class="{{ $kelasKontrol }}">{{ $jawabanAda?->jawaban_teks }}</textarea>
                    @elseif($butir->tipe_pertanyaan->value === 'angka')
                        <input type="number" name="jawaban[{{ $butir->id }}]" value="{{ $jawabanAda?->jawaban_angka }}" {{ $sudahDinilai ? 'disabled' : '' }} class="{{ $kelasKontrol }}">
                    @elseif($butir->tipe_pertanyaan->value === 'ya_tidak')
                        <div class="relative">
                            <select name="jawaban[{{ $butir->id }}]" {{ $sudahDinilai ? 'disabled' : '' }} class="{{ $kelasKontrol }} appearance-none bg-no-repeat pr-9">
                                <option value="Ya" @selected($jawabanAda?->jawaban_teks === 'Ya')>Ya</option>
                                <option value="Tidak" @selected($jawabanAda?->jawaban_teks === 'Tidak')>Tidak</option>
                            </select>
                            <svg class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400 dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 10.5 3.75 3.75 3.75-3.75" />
                            </svg>
                        </div>
                    @elseif(in_array($butir->tipe_pertanyaan->value, ['pilihan_tunggal', 'pilihan_ganda']))
                        <div class="space-y-1.5">
                            @foreach($butir->opsi as $opsi)
                                <label class="flex cursor-pointer items-center gap-2.5 text-sm text-slate-600 dark:text-slate-400">
                                    <span class="relative flex h-5 w-5 shrink-0 items-center justify-center">
                                        <input type="radio" name="jawaban_opsi[{{ $butir->id }}]" value="{{ $opsi->id }}" {{ $sudahDinilai ? 'disabled' : '' }} @checked($jawabanAda?->id_opsi_butir_observasi === $opsi->id) class="peer absolute inset-0 h-5 w-5 shrink-0 cursor-pointer appearance-none rounded-full border border-slate-300 bg-white transition checked:border-teal-700 checked:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-600/30 disabled:cursor-not-allowed disabled:opacity-60 dark:border-slate-600 dark:bg-slate-900 dark:checked:border-teal-500 dark:checked:bg-teal-500">
                                        <span class="pointer-events-none relative hidden h-1.5 w-1.5 rounded-full bg-white peer-checked:block"></span>
                                    </span>
                                    {{ $opsi->teks_opsi }}
                                </label>
                            @endforeach
                        </div>
                    @elseif($butir->tipe_pertanyaan->value === 'unggah_foto')
                        <x-unggah name="dokumentasi[]" :id="'dokumentasi_'.$butir->id" jenis="gambar" accept="image/*" :disabled="$sudahDinilai" />
                    @else
                        <input type="text" name="jawaban[{{ $butir->id }}]" value="{{ $jawabanAda?->jawaban_teks }}" {{ $sudahDinilai ? 'disabled' : '' }} class="{{ $kelasKontrol }}">
                    @endif
                </div>
            @endforeach
        </x-kartu>

        @unless($sudahDinilai)
            <x-tombol type="submit">{{ $pengumpulan ? 'Perbarui Jawaban' : 'Kirim Hasil Observasi' }}</x-tombol>
        @endunless
    </form>
</x-layout-dashboard>
