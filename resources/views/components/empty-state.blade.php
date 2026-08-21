@props(['judul' => 'Belum ada data.', 'deskripsi' => null, 'teksTombol' => null, 'tautanTombol' => null])

<div class="flex flex-col items-center justify-center rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-6 py-14 text-center dark:border-slate-700 dark:bg-slate-900/50">
    <svg class="mb-4 h-12 w-12 text-slate-300 dark:text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 3.75H6.912a2.25 2.25 0 0 0-2.15 1.588L2.35 13.177a2.25 2.25 0 0 0-.1.661V18a2.25 2.25 0 0 0 2.25 2.25h15.5A2.25 2.25 0 0 0 22 18v-4.162c0-.226-.035-.45-.1-.661L19.24 5.338a2.25 2.25 0 0 0-2.15-1.588H15M2.25 13.5h3.86a2.25 2.25 0 0 1 2.012 1.244l.256.512a2.25 2.25 0 0 0 2.012 1.244h3.22a2.25 2.25 0 0 0 2.012-1.244l.256-.512a2.25 2.25 0 0 1 2.012-1.244h3.86M12 3.75V15" />
    </svg>
    <p class="text-base font-semibold text-slate-700 dark:text-slate-200">{{ $judul }}</p>
    @if($deskripsi)
        <p class="mt-1 max-w-sm text-sm text-slate-500 dark:text-slate-400">{{ $deskripsi }}</p>
    @endif
    @if($teksTombol && $tautanTombol)
        <div class="mt-5">
            <x-tombol :href="$tautanTombol">{{ $teksTombol }}</x-tombol>
        </div>
    @endif
</div>
