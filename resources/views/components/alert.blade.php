@props(['jenis' => 'info'])

@php
    $gaya = [
        'info' => 'bg-sky-50 text-sky-800 border-sky-200',
        'sukses' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
        'peringatan' => 'bg-amber-50 text-amber-800 border-amber-200',
        'bahaya' => 'bg-rose-50 text-rose-800 border-rose-200',
    ][$jenis] ?? '';
@endphp

<div {{ $attributes->merge(['class' => "rounded-lg border px-4 py-3 text-sm $gaya"]) }} role="alert">
    {{ $slot }}
</div>
