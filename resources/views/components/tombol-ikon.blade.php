@props(['href' => null, 'type' => 'button', 'ikon', 'label', 'varian' => 'netral'])

{{--
    Tombol aksi berbentuk ikon bulat kecil untuk baris tabel (Detail, Ubah,
    Hapus, dst). Label tetap ada sebagai teks (sr-only) demi aksesibilitas
    dan agar tetap tertangkap oleh pengujian yang mencari teks aksi, plus
    "title" untuk tooltip native saat kursor diarahkan ke tombol.
--}}
@php
    $dasar = 'inline-flex h-8 w-8 items-center justify-center rounded-lg transition focus:outline-none focus:ring-2 focus:ring-offset-1 dark:focus:ring-offset-slate-900';
    $gaya = [
        'netral' => 'text-slate-500 hover:bg-slate-100 hover:text-teal-700 focus:ring-teal-600 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-teal-300',
        'bahaya' => 'text-slate-500 hover:bg-rose-50 hover:text-rose-600 focus:ring-rose-600 dark:text-slate-400 dark:hover:bg-rose-950 dark:hover:text-rose-400',
        'sukses' => 'text-slate-500 hover:bg-emerald-50 hover:text-emerald-600 focus:ring-emerald-600 dark:text-slate-400 dark:hover:bg-emerald-950 dark:hover:text-emerald-400',
        'peringatan' => 'text-slate-500 hover:bg-amber-50 hover:text-amber-600 focus:ring-amber-600 dark:text-slate-400 dark:hover:bg-amber-950 dark:hover:text-amber-400',
    ][$varian] ?? '';
@endphp

@if($href)
    <a href="{{ $href }}" title="{{ $label }}" aria-label="{{ $label }}" {{ $attributes->merge(['class' => "$dasar $gaya"]) }}>
        <x-ikon :nama="$ikon" class="h-[18px] w-[18px]" />
        <span class="sr-only">{{ $label }}</span>
    </a>
@else
    <button type="{{ $type }}" title="{{ $label }}" aria-label="{{ $label }}" {{ $attributes->merge(['class' => "$dasar $gaya"]) }}>
        <x-ikon :nama="$ikon" class="h-[18px] w-[18px]" />
        <span class="sr-only">{{ $label }}</span>
    </button>
@endif
