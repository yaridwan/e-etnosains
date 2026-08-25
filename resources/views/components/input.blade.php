@props(['label' => null, 'name', 'type' => 'text', 'wajib' => false, 'petunjuk' => null])

@php
    $adaGalat = $errors->has($name);
    $kelasDasar = 'block w-full rounded-lg border px-3.5 py-2.5 text-sm shadow-sm transition placeholder:text-slate-400 focus:outline-none focus:ring-2 dark:bg-slate-900 dark:text-slate-100 dark:placeholder:text-slate-500';
    $kelasWarna = $adaGalat
        ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500/30 dark:border-rose-500'
        : 'border-slate-300 focus:border-teal-600 focus:ring-teal-600/30 dark:border-slate-700 dark:focus:border-teal-500';
    $kataSandi = $type === 'password';
@endphp

<div @if($kataSandi) x-data="{ terlihat: false }" @endif>
    @if($label)
        <label for="{{ $name }}" class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">
            {{ $label }} @if($wajib)<span class="text-rose-600 dark:text-rose-400">*</span>@endif
        </label>
    @endif

    <div class="relative">
        <input
            @if($kataSandi) :type="terlihat ? 'text' : 'password'" @else type="{{ $type }}" @endif
            name="{{ $name }}"
            id="{{ $name }}"
            value="{{ old($name, $attributes->get('value')) }}"
            @if($adaGalat) aria-invalid="true" aria-describedby="{{ $name }}-galat" @endif
            {{ $attributes->except('value')->merge(['class' => "$kelasDasar $kelasWarna" . ($kataSandi ? ' pr-10' : '')]) }}
        >

        @if($kataSandi)
            <button
                type="button"
                @click="terlihat = ! terlihat"
                :aria-label="terlihat ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'"
                class="absolute inset-y-0 right-0 flex w-10 items-center justify-center text-slate-400 transition hover:text-slate-600 dark:text-slate-500 dark:hover:text-slate-300"
            >
                <x-ikon x-show="! terlihat" nama="mata" class="h-[18px] w-[18px]" />
                <x-ikon x-show="terlihat" x-cloak nama="mata-tercoret" class="h-[18px] w-[18px]" />
            </button>
        @endif
    </div>

    @if($petunjuk && ! $adaGalat)
        <p class="mt-1.5 text-xs text-slate-500 dark:text-slate-400">{{ $petunjuk }}</p>
    @endif

    @error($name)
        <p id="{{ $name }}-galat" class="mt-1.5 text-sm text-rose-600 dark:text-rose-400">{{ $message }}</p>
    @enderror
</div>
