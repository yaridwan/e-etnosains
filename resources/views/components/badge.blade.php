@props(['warna' => 'slate'])

@php
    $peta = [
        'slate' => 'bg-slate-100 text-slate-700',
        'amber' => 'bg-amber-100 text-amber-800',
        'orange' => 'bg-orange-100 text-orange-800',
        'sky' => 'bg-sky-100 text-sky-800',
        'emerald' => 'bg-emerald-100 text-emerald-800',
        'rose' => 'bg-rose-100 text-rose-800',
        'gray' => 'bg-gray-200 text-gray-700',
        'teal' => 'bg-teal-100 text-teal-800',
    ][$warna] ?? 'bg-slate-100 text-slate-700';
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium $peta"]) }}>
    {{ $slot }}
</span>
