@props(['label' => null, 'name', 'type' => 'text', 'wajib' => false, 'petunjuk' => null])

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

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $attributes->get('value')) }}"
        @if($adaGalat) aria-invalid="true" aria-describedby="{{ $name }}-galat" @endif
        {{ $attributes->except('value')->merge(['class' => "$kelasDasar $kelasWarna"]) }}
    >

    @if($petunjuk && ! $adaGalat)
        <p class="mt-1.5 text-xs text-slate-500 dark:text-slate-400">{{ $petunjuk }}</p>
    @endif

    @error($name)
        <p id="{{ $name }}-galat" class="mt-1.5 text-sm text-rose-600 dark:text-rose-400">{{ $message }}</p>
    @enderror
</div>
