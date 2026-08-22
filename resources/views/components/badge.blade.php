@props(['warna' => 'slate'])

@php
    $peta = [
        'slate' => 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300',
        'amber' => 'bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300',
        'orange' => 'bg-orange-100 text-orange-800 dark:bg-orange-950 dark:text-orange-300',
        'sky' => 'bg-sky-100 text-sky-800 dark:bg-sky-950 dark:text-sky-300',
        'emerald' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300',
        'rose' => 'bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300',
        'gray' => 'bg-gray-200 text-gray-700 dark:bg-gray-800 dark:text-gray-300',
        'teal' => 'bg-teal-100 text-teal-800 dark:bg-teal-950 dark:text-teal-300',
        'violet' => 'bg-violet-100 text-violet-800 dark:bg-violet-950 dark:text-violet-300',
    ][$warna] ?? 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300';
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center whitespace-nowrap rounded-full px-2.5 py-1 text-xs font-medium $peta"]) }}>
    {{ $slot }}
</span>
