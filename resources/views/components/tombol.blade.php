@props(['href' => null, 'varian' => 'utama', 'type' => 'button'])

@php
    $dasar = 'inline-flex items-center justify-center gap-2 rounded-lg px-4 py-2.5 text-sm font-semibold transition focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';
    $gaya = [
        'utama' => 'bg-teal-700 text-white hover:bg-teal-800 focus:ring-teal-700',
        'sekunder' => 'bg-white text-teal-700 border border-teal-700 hover:bg-teal-50 focus:ring-teal-700',
        'putih' => 'bg-white text-slate-800 border border-slate-200 hover:bg-slate-50 focus:ring-slate-300',
        'bahaya' => 'bg-rose-600 text-white hover:bg-rose-700 focus:ring-rose-600',
        'hantu' => 'text-slate-600 hover:bg-slate-100 focus:ring-slate-300',
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
