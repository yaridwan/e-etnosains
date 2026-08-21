@php($sudahDinilai = $pengumpulan?->status === 'dinilai')

<x-layout-dashboard judul-seo="Kerjakan Observasi" :menu="\App\Support\MenuDashboard::siswa()">
    <a href="{{ route('siswa.observasi.index') }}" class="text-sm text-teal-700 hover:underline">&larr; Kembali</a>
    <h1 class="mt-2 text-2xl font-bold text-slate-900">{{ $observasi->judul }}</h1>

    <x-kartu class="mt-6">
        <h2 class="font-semibold text-slate-800">Petunjuk</h2>
        <p class="mt-2 text-sm text-slate-600">{{ $observasi->petunjuk }}</p>
        <dl class="mt-4 grid grid-cols-1 gap-3 text-sm sm:grid-cols-2">
            <div><dt class="text-slate-400">Lokasi</dt><dd class="text-slate-700">{{ $observasi->lokasi_observasi }}</dd></div>
            <div><dt class="text-slate-400">Durasi</dt><dd class="text-slate-700">{{ $observasi->durasi }}</dd></div>
            <div><dt class="text-slate-400">Alat dan Bahan</dt><dd class="text-slate-700">{{ $observasi->alat_dan_bahan }}</dd></div>
            <div><dt class="text-slate-400">Aspek Keselamatan</dt><dd class="text-slate-700">{{ $observasi->aspek_keselamatan }}</dd></div>
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
            <h2 class="font-semibold text-slate-800">Instrumen Observasi</h2>
            @foreach($observasi->butirObservasi as $butir)
                @php($jawabanAda = $pengumpulan?->jawaban->firstWhere('id_butir_observasi', $butir->id))
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        {{ $butir->pertanyaan }} @if($butir->wajib)<span class="text-rose-600">*</span>@endif
                    </label>

                    @if(in_array($butir->tipe_pertanyaan->value, ['teks_pendek']))
                        <input type="text" name="jawaban[{{ $butir->id }}]" value="{{ $jawabanAda?->jawaban_teks }}" {{ $sudahDinilai ? 'disabled' : '' }} class="block w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm">
                    @elseif($butir->tipe_pertanyaan->value === 'teks_panjang')
                        <textarea name="jawaban[{{ $butir->id }}]" rows="3" {{ $sudahDinilai ? 'disabled' : '' }} class="block w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm">{{ $jawabanAda?->jawaban_teks }}</textarea>
                    @elseif($butir->tipe_pertanyaan->value === 'angka')
                        <input type="number" name="jawaban[{{ $butir->id }}]" value="{{ $jawabanAda?->jawaban_angka }}" {{ $sudahDinilai ? 'disabled' : '' }} class="block w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm">
                    @elseif($butir->tipe_pertanyaan->value === 'ya_tidak')
                        <select name="jawaban[{{ $butir->id }}]" {{ $sudahDinilai ? 'disabled' : '' }} class="block w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm">
                            <option value="Ya" @selected($jawabanAda?->jawaban_teks === 'Ya')>Ya</option>
                            <option value="Tidak" @selected($jawabanAda?->jawaban_teks === 'Tidak')>Tidak</option>
                        </select>
                    @elseif(in_array($butir->tipe_pertanyaan->value, ['pilihan_tunggal', 'pilihan_ganda']))
                        <div class="space-y-1.5">
                            @foreach($butir->opsi as $opsi)
                                <label class="flex items-center gap-2 text-sm text-slate-600">
                                    <input type="radio" name="jawaban_opsi[{{ $butir->id }}]" value="{{ $opsi->id }}" {{ $sudahDinilai ? 'disabled' : '' }} @checked($jawabanAda?->id_opsi_butir_observasi === $opsi->id)>
                                    {{ $opsi->teks_opsi }}
                                </label>
                            @endforeach
                        </div>
                    @elseif($butir->tipe_pertanyaan->value === 'unggah_foto')
                        <input type="file" name="dokumentasi[]" accept="image/*" {{ $sudahDinilai ? 'disabled' : '' }} class="block w-full text-sm">
                    @else
                        <input type="text" name="jawaban[{{ $butir->id }}]" value="{{ $jawabanAda?->jawaban_teks }}" {{ $sudahDinilai ? 'disabled' : '' }} class="block w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm">
                    @endif
                </div>
            @endforeach
        </x-kartu>

        @unless($sudahDinilai)
            <x-tombol type="submit">{{ $pengumpulan ? 'Perbarui Jawaban' : 'Kirim Hasil Observasi' }}</x-tombol>
        @endunless
    </form>
</x-layout-dashboard>
