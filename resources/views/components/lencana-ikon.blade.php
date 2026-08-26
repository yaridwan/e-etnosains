@props(['nama', 'warna' => 'teal'])

@php
    $peta = [
        'teal' => 'bg-teal-50 text-teal-700 dark:bg-teal-950 dark:text-teal-300',
        'sky' => 'bg-sky-50 text-sky-700 dark:bg-sky-950 dark:text-sky-300',
        'violet' => 'bg-violet-50 text-violet-700 dark:bg-violet-950 dark:text-violet-300',
        'amber' => 'bg-amber-50 text-amber-700 dark:bg-amber-950 dark:text-amber-300',
    ][$warna] ?? '';
@endphp

<span {{ $attributes->merge(['class' => "flex h-11 w-11 items-center justify-center rounded-xl $peta"]) }}>
    <x-ikon :nama="$nama" class="h-5 w-5" />
</span>
