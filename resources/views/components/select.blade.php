@props(['label' => null, 'name', 'wajib' => false, 'opsi' => [], 'placeholder' => 'Pilih...', 'selected' => null, 'petunjuk' => null])

@php
    $adaGalat = $errors->has($name);
    $kelasDasar = 'block w-full appearance-none rounded-lg border bg-no-repeat px-3.5 py-2.5 pr-9 text-sm shadow-sm transition focus:outline-none focus:ring-2 dark:bg-slate-900 dark:text-slate-100';
    $kelasWarna = $adaGalat
        ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500/30 dark:border-rose-500'
        : 'border-slate-300 focus:border-teal-600 focus:ring-teal-600/30 dark:border-slate-700 dark:focus:border-teal-500';
@endphp

<div class="relative">
    @if($label)
        <label for="{{ $name }}" class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">
            {{ $label }} @if($wajib)<span class="text-rose-600 dark:text-rose-400">*</span>@endif
        </label>
    @endif

    <div class="relative">
        <select
            name="{{ $name }}"
            id="{{ $name }}"
            @if($adaGalat) aria-invalid="true" aria-describedby="{{ $name }}-galat" @endif
            {{ $attributes->merge(['class' => "$kelasDasar $kelasWarna"]) }}
        >
            <option value="">{{ $placeholder }}</option>
            @foreach($opsi as $nilai => $label_opsi)
                <option value="{{ $nilai }}" @selected(old($name, $selected) == $nilai)>{{ $label_opsi }}</option>
            @endforeach
        </select>
        <svg class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400 dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 10.5 3.75 3.75 3.75-3.75" />
        </svg>
    </div>

    @if($petunjuk && ! $adaGalat)
        <p class="mt-1.5 text-xs text-slate-500 dark:text-slate-400">{{ $petunjuk }}</p>
    @endif

    @error($name)
        <p id="{{ $name }}-galat" class="mt-1.5 text-sm text-rose-600 dark:text-rose-400">{{ $message }}</p>
    @enderror
</div>
