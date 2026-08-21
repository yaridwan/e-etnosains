<x-layout-publik :judul-seo="$bahanAjar->judul.' | E-ETNOSAINS'" :deskripsi-seo="$bahanAjar->deskripsi">
    <div class="mx-auto max-w-4xl px-4 py-10 sm:px-6 lg:px-8">
        <nav class="text-sm text-slate-500 dark:text-slate-400">
            <a href="{{ route('beranda') }}" class="hover:text-teal-700 dark:hover:text-teal-400">Beranda</a> /
            <a href="{{ route('bahan-ajar.index') }}" class="hover:text-teal-700 dark:hover:text-teal-400">Bahan Ajar</a> /
            <span class="text-slate-700 dark:text-slate-300">{{ $bahanAjar->judul }}</span>
        </nav>

        <h1 class="mt-4 text-3xl font-bold text-slate-900 dark:text-slate-100">{{ $bahanAjar->judul }}</h1>
        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Oleh {{ $bahanAjar->pengguna->nama_lengkap }} &middot; {{ $bahanAjar->mataPelajaran->nama_mata_pelajaran }}</p>

        <p class="mt-6 text-slate-700 dark:text-slate-300">{{ $bahanAjar->deskripsi }}</p>

        <div class="mt-6 flex gap-3">
            @if($bahanAjar->tautan_eksternal)
                <x-tombol :href="$bahanAjar->tautan_eksternal" varian="sekunder">Buka Tautan Eksternal</x-tombol>
            @endif
            @if($bahanAjar->berkas)
                <x-tombol :href="\Illuminate\Support\Facades\Storage::url($bahanAjar->berkas)">Unduh Berkas</x-tombol>
            @endif
        </div>
    </div>
</x-layout-publik>
