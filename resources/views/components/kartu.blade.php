@props(['padat' => false])

<div {{ $attributes->merge([
    'class' => 'rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900 '
        . ($padat ? 'p-4' : 'p-6'),
]) }}>
    {{ $slot }}
</div>
