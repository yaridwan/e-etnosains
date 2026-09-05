@props(['label' => null, 'name', 'id' => null, 'wajib' => false, 'petunjuk' => null, 'pratinjau' => null, 'jenis' => 'gambar'])

@php
    // ID elemen boleh berbeda dari nama field — perlu unik walau beberapa
    // input berbagi nama array yang sama (mis. beberapa butir observasi
    // yang sama-sama memakai "dokumentasi[]"), agar <label for> tidak
    // bertabrakan dengan id yang ganda.
    $idElemen = $id ?? $name;
@endphp

{{--
    Input berkas dengan pratinjau. Untuk jenis="gambar", memperlihatkan
    gambar yang sudah tersimpan (saat mengubah data) dan otomatis
    menggantinya dengan gambar yang baru dipilih sebelum formulir dikirim.
    Untuk jenis="dokumen" (mis. PDF), memperlihatkan tautan ke berkas yang
    sudah tersimpan beserta nama berkas baru yang dipilih.
--}}
@php
    $adaGalat = $errors->has($name);
@endphp

<div x-data="{
    pratinjau: @js($pratinjau),
    namaBerkas: null,
    pilih(e) {
        const berkas = e.target.files[0];
        if (! berkas) { this.namaBerkas = null; return; }
        this.namaBerkas = berkas.name;
        @if($jenis === 'gambar')
        if (berkas.type.startsWith('image/')) {
            this.pratinjau = URL.createObjectURL(berkas);
        }
        @endif
    },
}">
    @if($label)
        <label for="{{ $idElemen }}" class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">
            {{ $label }} @if($wajib)<span class="text-rose-600 dark:text-rose-400">*</span>@endif
        </label>
    @endif

    <div class="flex items-center gap-4">
        @if($jenis === 'gambar')
            <div class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-xl border border-slate-200 bg-slate-50 dark:border-slate-700 dark:bg-slate-800">
                <template x-if="pratinjau">
                    <img :src="pratinjau" class="h-full w-full object-cover" alt="">
                </template>
                <template x-if="! pratinjau">
                    <x-ikon nama="gambar" class="h-6 w-6 text-slate-300 dark:text-slate-600" />
                </template>
            </div>
        @else
            <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-xl border border-slate-200 bg-slate-50 dark:border-slate-700 dark:bg-slate-800">
                <x-ikon nama="dokumen" class="h-6 w-6 text-slate-300 dark:text-slate-600" />
            </div>
        @endif

        <div class="min-w-0 flex-1">
            {{--
                Input berkas ditumpuk persis di atas label tampilan (bukan
                disembunyikan lewat sr-only) supaya saat browser mengembalikan
                fokus ke input ini setelah dialog pilih berkas ditutup, kotak
                fokusnya sudah berada tepat di posisi yang terlihat — jadi
                halaman tidak lagi ikut tergulir ke posisi lain.
            --}}
            <label @class([
                'relative flex cursor-pointer items-center justify-between gap-2 rounded-lg border border-dashed px-3.5 py-2.5 text-sm transition hover:border-teal-500 hover:bg-teal-50/50 dark:hover:bg-teal-950/20',
                'border-rose-400 dark:border-rose-500' => $adaGalat,
                'border-slate-300 dark:border-slate-700' => ! $adaGalat,
            ])>
                <span class="truncate text-slate-500 dark:text-slate-400" x-text="namaBerkas ?? 'Pilih berkas...'"></span>
                <span class="shrink-0 rounded-md bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600 dark:bg-slate-800 dark:text-slate-300">Telusuri</span>
                <input
                    type="file"
                    name="{{ $name }}"
                    id="{{ $idElemen }}"
                    @change="pilih($event)"
                    @if($adaGalat) aria-invalid="true" aria-describedby="{{ $name }}-galat" @endif
                    {{ $attributes->merge(['class' => 'absolute inset-0 h-full w-full cursor-pointer opacity-0']) }}
                >
            </label>

            @if($jenis === 'dokumen' && $pratinjau)
                <a href="{{ $pratinjau }}" target="_blank" rel="noopener" class="mt-1 inline-block text-xs font-medium text-teal-700 hover:underline dark:text-teal-400">Lihat berkas saat ini &rarr;</a>
            @endif
        </div>
    </div>

    @if($petunjuk && ! $adaGalat)
        <p class="mt-1.5 text-xs text-slate-500 dark:text-slate-400">{{ $petunjuk }}</p>
    @endif

    @error($name)
        <p id="{{ $name }}-galat" class="mt-1.5 text-sm text-rose-600 dark:text-rose-400">{{ $message }}</p>
    @enderror
</div>
