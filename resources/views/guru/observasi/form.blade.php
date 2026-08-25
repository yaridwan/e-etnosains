@php($sedangUbah = $observasi->exists)
@php($butirAwal = $sedangUbah ? $observasi->butirObservasi->map(fn($b) => [
    'pertanyaan' => $b->pertanyaan,
    'tipe_pertanyaan' => $b->tipe_pertanyaan->value,
    'wajib' => $b->wajib,
    'opsi' => $b->opsi->pluck('teks_opsi')->all(),
])->values()->all() : [])

<x-layout-dashboard :judul-seo="$sedangUbah ? 'Ubah Observasi' : 'Buat Observasi'" :menu="\App\Support\MenuDashboard::guru()">
    <a href="{{ route('guru.observasi.index') }}" class="text-sm text-teal-700 dark:text-teal-400 hover:underline">&larr; Kembali</a>
    <h1 class="mt-2 text-2xl font-bold text-slate-900 dark:text-slate-100">{{ $sedangUbah ? 'Ubah Observasi' : 'Buat Observasi Baru' }}</h1>

    <form method="POST" action="{{ $sedangUbah ? route('guru.observasi.update', $observasi) : route('guru.observasi.store') }}" class="mt-6 space-y-6">
        @csrf
        @if($sedangUbah) @method('PUT') @endif

        <x-kartu class="space-y-4">
            <x-judul-form-seksi>Informasi Observasi</x-judul-form-seksi>
            <x-input label="Judul Observasi" name="judul" :value="$observasi->judul" wajib />
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <x-select label="E-Modul Terkait" name="id_e_modul" :opsi="$eModulSaya->pluck('judul', 'id')" selected="{{ $observasi->id_e_modul }}" />
                <x-select label="LKPD Terkait" name="id_lkpd" :opsi="$lkpdSaya->pluck('judul', 'id')" selected="{{ $observasi->id_lkpd }}" />
                <x-input label="Lokasi Observasi" name="lokasi_observasi" :value="$observasi->lokasi_observasi" />
                <x-input label="Durasi" name="durasi" :value="$observasi->durasi" placeholder="Contoh: 2 jam" />
                <x-input label="Batas Pengumpulan" name="batas_pengumpulan" type="datetime-local" :value="$observasi->batas_pengumpulan?->format('Y-m-d\TH:i')" />
            </div>
            <x-textarea label="Deskripsi" name="deskripsi">{{ $observasi->deskripsi }}</x-textarea>
            <x-textarea label="Tujuan" name="tujuan">{{ $observasi->tujuan }}</x-textarea>
            <x-textarea label="Petunjuk" name="petunjuk">{{ $observasi->petunjuk }}</x-textarea>
            <x-textarea label="Alat dan Bahan" name="alat_dan_bahan">{{ $observasi->alat_dan_bahan }}</x-textarea>
            <x-textarea label="Prosedur" name="prosedur">{{ $observasi->prosedur }}</x-textarea>
            <x-textarea label="Aspek Keselamatan" name="aspek_keselamatan">{{ $observasi->aspek_keselamatan }}</x-textarea>
        </x-kartu>

        <x-kartu x-data="{
            butir: {{ \Illuminate\Support\Js::from($butirAwal) }},
            tambah() { this.butir.push({ pertanyaan: '', tipe_pertanyaan: 'teks_pendek', wajib: true, opsi: [] }) },
            hapus(i) { this.butir.splice(i, 1) },
        }">
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-slate-800 dark:text-slate-100">Instrumen Observasi</h2>
                <x-tombol type="button" varian="sekunder" @click="tambah()">Tambah Butir</x-tombol>
            </div>

            <template x-for="(item, i) in butir" :key="i">
                <div class="mt-4 rounded-xl border border-slate-200 dark:border-slate-800 p-4">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex-1 space-y-3">
                            <input type="text" :name="`butir[${i}][pertanyaan]`" x-model="item.pertanyaan" placeholder="Tulis pertanyaan..." class="block w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm shadow-sm transition placeholder:text-slate-400 focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-600/30 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:placeholder:text-slate-500 dark:focus:border-teal-500" required>

                            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                                <select :name="`butir[${i}][tipe_pertanyaan]`" x-model="item.tipe_pertanyaan" class="rounded-lg border border-slate-300 px-3.5 py-2 text-sm shadow-sm transition focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-600/30 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:focus:border-teal-500">
                                    @foreach($jenisPertanyaan as $jenis)
                                        <option value="{{ $jenis->value }}">{{ $jenis->label() }}</option>
                                    @endforeach
                                </select>
                                <label class="flex cursor-pointer items-center gap-2.5 text-sm text-slate-600 dark:text-slate-400">
                                    <input type="hidden" :name="`butir[${i}][wajib]`" value="0">
                                    <span class="relative flex h-5 w-5 shrink-0 items-center justify-center">
                                        <input type="checkbox" :name="`butir[${i}][wajib]`" value="1" x-model="item.wajib" class="peer absolute inset-0 h-5 w-5 shrink-0 cursor-pointer appearance-none rounded-md border border-slate-300 bg-white transition checked:border-teal-700 checked:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-600/30 dark:border-slate-600 dark:bg-slate-900 dark:checked:border-teal-500 dark:checked:bg-teal-500">
                                        <svg class="pointer-events-none relative hidden h-3.5 w-3.5 text-white peer-checked:block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                                    </span>
                                    Wajib diisi
                                </label>
                            </div>

                            <div x-show="item.tipe_pertanyaan === 'pilihan_tunggal' || item.tipe_pertanyaan === 'pilihan_ganda'" x-cloak>
                                <p class="mb-1 text-xs font-medium text-slate-500 dark:text-slate-400">Opsi Jawaban (satu per baris)</p>
                                <textarea :name="`butir[${i}][opsi_teks]`" rows="3" class="block w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm shadow-sm transition focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-600/30 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:focus:border-teal-500" x-init="$el.value = item.opsi.join('\n')" @input="item.opsi = $el.value.split('\n')"></textarea>
                                <template x-for="(opsi, j) in item.opsi" :key="j">
                                    <input type="hidden" :name="`butir[${i}][opsi][${j}]`" :value="opsi">
                                </template>
                            </div>
                        </div>
                        <x-tombol-ikon type="button" @click="hapus(i)" ikon="sampah" label="Hapus" varian="bahaya" />
                    </div>
                </div>
            </template>

            <p x-show="butir.length === 0" class="mt-4 text-sm text-slate-400 dark:text-slate-500">Belum ada butir instrumen. Klik "Tambah Butir" untuk memulai.</p>
        </x-kartu>

        <x-tombol type="submit">Simpan &amp; Publikasikan</x-tombol>
    </form>
</x-layout-dashboard>
