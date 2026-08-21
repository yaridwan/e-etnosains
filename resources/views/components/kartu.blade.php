@props(['padat' => false])

<div {{ $attributes->merge(['class' => 'rounded-2xl border border-slate-200 bg-white shadow-sm ' . ($padat ? 'p-4' : 'p-6')]) }}>
    {{ $slot }}
</div>
