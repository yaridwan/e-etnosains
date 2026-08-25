@props(['nomor' => null, 'deskripsi' => null])

<div class="mb-4">
    <h2 class="font-semibold text-slate-800 dark:text-slate-100">
        @if($nomor){{ $nomor }}. @endif{{ $slot }}
    </h2>
    @if($deskripsi)
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $deskripsi }}</p>
    @endif
</div>
