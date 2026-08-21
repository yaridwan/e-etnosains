@props(['href' => null, 'varian' => 'utama', 'type' => 'button'])

@php
    $dasar = 'inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-lg px-4 py-2.5 text-sm font-semibold transition focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 dark:focus:ring-offset-slate-950';
    $gaya = [
        'utama' => 'bg-teal-700 text-white shadow-sm hover:bg-teal-800 focus:ring-teal-700 dark:bg-teal-600 dark:hover:bg-teal-500',
        'sekunder' => 'border border-teal-700 bg-white text-teal-700 hover:bg-teal-50 focus:ring-teal-700 dark:border-teal-500 dark:bg-transparent dark:text-teal-300 dark:hover:bg-teal-950',
        'putih' => 'border border-slate-200 bg-white text-slate-800 hover:bg-slate-50 focus:ring-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:hover:bg-slate-800',
        'bahaya' => 'bg-rose-600 text-white hover:bg-rose-700 focus:ring-rose-600 dark:bg-rose-600 dark:hover:bg-rose-500',
        'hantu' => 'text-slate-600 hover:bg-slate-100 focus:ring-slate-300 dark:text-slate-300 dark:hover:bg-slate-800',
    ][$varian] ?? '';
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => "$dasar $gaya"]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => "$dasar $gaya"]) }}>
        {{ $slot }}
    </button>
@endif
