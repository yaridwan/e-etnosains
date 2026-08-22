@props(['label', 'nilai', 'ikon', 'warna' => 'teal'])

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

<x-kartu padat>
    <div class="flex items-center gap-3">
        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl {{ $peta }}">
            <x-ikon :nama="$ikon" class="h-5 w-5" />
        </span>
        <div class="min-w-0">
            <p class="truncate text-xs font-medium uppercase tracking-wide text-slate-400 dark:text-slate-500">{{ $label }}</p>
            <p class="mt-0.5 text-2xl font-bold text-slate-900 dark:text-slate-100">{{ $nilai }}</p>
        </div>
    </div>
</x-kartu>
