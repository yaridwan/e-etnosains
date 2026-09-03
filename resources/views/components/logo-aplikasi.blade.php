@props(['ukuran' => 'h-9 w-9', 'bulat' => 'rounded-xl', 'teks' => 'text-sm'])

{{--
    Lambang aplikasi. Menampilkan logo yang diunggah Administrator lewat
    Pengaturan Aplikasi bila tersedia, jika tidak jatuh kembali ke lencana
    huruf "E" bawaan supaya aplikasi tetap tampil rapi tanpa logo kustom.
--}}
@php($logo = pengaturan('logo_utama'))

@if($logo)
    <img
        src="{{ \Illuminate\Support\Facades\Storage::url($logo) }}"
        alt="{{ pengaturan('nama_singkat', 'E-ETNOSAINS') }}"
        {{ $attributes->merge(['class' => "$ukuran $bulat shrink-0 object-cover"]) }}
    >
@else
    <span {{ $attributes->merge(['class' => "flex $ukuran shrink-0 items-center justify-center $bulat bg-teal-700 $teks font-bold text-white shadow-sm"]) }}>E</span>
@endif
