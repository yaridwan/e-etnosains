@props(['label' => null, 'name', 'wajib' => false, 'baris' => 4])

@php
    $adaGalat = $errors->has($name);
    $kelasDasar = 'block w-full rounded-lg border px-3.5 py-2.5 text-sm shadow-sm transition placeholder:text-slate-400 focus:outline-none focus:ring-2 dark:bg-slate-900 dark:text-slate-100 dark:placeholder:text-slate-500';
    $kelasWarna = $adaGalat
        ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500/30 dark:border-rose-500'
        : 'border-slate-300 focus:border-teal-600 focus:ring-teal-600/30 dark:border-slate-700 dark:focus:border-teal-500';
@endphp

<div>
    @if($label)
        <label for="{{ $name }}" class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">
            {{ $label }} @if($wajib)<span class="text-rose-600 dark:text-rose-400">*</span>@endif
        </label>
    @endif

    <textarea
        name="{{ $name }}"
        id="{{ $name }}"
        rows="{{ $baris }}"
        {{ $attributes->merge(['class' => "$kelasDasar $kelasWarna"]) }}
    >{{ old($name, $slot) }}</textarea>

    @error($name)
        <p class="mt-1.5 text-sm text-rose-600 dark:text-rose-400">{{ $message }}</p>
    @enderror
</div>
