@props(['ikon', 'warna' => 'teal'])

@php
    $peta = [
        'teal' => 'bg-teal-50 text-teal-700 dark:bg-teal-950 dark:text-teal-300',
        'sky' => 'bg-sky-50 text-sky-700 dark:bg-sky-950 dark:text-sky-300',
        'violet' => 'bg-violet-50 text-violet-700 dark:bg-violet-950 dark:text-violet-300',
        'amber' => 'bg-amber-50 text-amber-700 dark:bg-amber-950 dark:text-amber-300',
        'rose' => 'bg-rose-50 text-rose-700 dark:bg-rose-950 dark:text-rose-300',
        'emerald' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300',
        'slate' => 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300',
    ][$warna] ?? '';
@endphp

<div class="flex items-center gap-2.5">
    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg {{ $peta }}">
        <x-ikon :nama="$ikon" class="h-4 w-4" />
    </span>
    <h2 class="font-semibold text-slate-800 dark:text-slate-100">{{ $slot }}</h2>
</div>
