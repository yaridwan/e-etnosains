@props(['name', 'value' => '1', 'checked' => false, 'petunjuk' => null])

{{--
    Checkbox bergaya kotak-centang kustom (bukan kotak polos bawaan
    peramban) agar konsisten dengan tampilan tombol dan input lain.
    Selalu menyertakan input hidden bernilai "0" agar status tidak
    tercentang tetap terkirim ke server (checkbox HTML tidak mengirim
    apa pun saat kosong).
--}}
<div>
    <label class="group flex cursor-pointer items-start gap-2.5 text-sm text-slate-600 dark:text-slate-400">
        <input type="hidden" name="{{ $name }}" value="0">
        <span class="relative mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center">
            <input
                type="checkbox"
                name="{{ $name }}"
                value="{{ $value }}"
                @checked($checked)
                {{ $attributes->merge(['class' => 'peer absolute inset-0 h-5 w-5 shrink-0 cursor-pointer appearance-none rounded-md border border-slate-300 bg-white transition checked:border-teal-700 checked:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-600/30 dark:border-slate-600 dark:bg-slate-900 dark:checked:border-teal-500 dark:checked:bg-teal-500']) }}
            >
            <svg class="pointer-events-none relative hidden h-3.5 w-3.5 text-white peer-checked:block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
            </svg>
        </span>
        <span class="leading-5">{{ $slot }}</span>
    </label>

    @if($petunjuk)
        <p class="ml-7 mt-1 text-xs text-slate-500 dark:text-slate-400">{{ $petunjuk }}</p>
    @endif
</div>
