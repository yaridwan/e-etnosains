<x-layout-dashboard judul-seo="Detail Tugas" :menu="\App\Support\MenuDashboard::siswa()">
    <a href="{{ route('siswa.tugas.index') }}" class="text-sm text-teal-700 hover:underline">&larr; Kembali</a>
    <h1 class="mt-2 text-2xl font-bold text-slate-900">{{ $tugas->judul }}</h1>

    <x-kartu class="mt-6">
        <h2 class="font-semibold text-slate-800">Petunjuk</h2>
        <p class="mt-2 text-sm text-slate-600">{{ $tugas->petunjuk }}</p>
        <p class="mt-2 text-xs text-slate-400">Batas waktu: {{ $tugas->batas_waktu?->translatedFormat('d M Y, H:i') ?? '-' }}</p>
        @if($tugas->berkas)
            <a href="{{ \Illuminate\Support\Facades\Storage::url($tugas->berkas) }}" target="_blank" rel="noopener" class="mt-3 inline-block text-sm font-medium text-teal-700 hover:underline">Unduh Berkas Pendukung dari Guru</a>
        @endif
    </x-kartu>

    @if($pengumpulan?->nilai)
        <x-alert jenis="sukses" class="mt-6">
            Tugas Anda telah dinilai: {{ $pengumpulan->nilai->nilai }}.
            @if($pengumpulan->nilai->catatan_guru) Catatan: {{ $pengumpulan->nilai->catatan_guru }} @endif
        </x-alert>
    @endif

    <x-kartu class="mt-6">
        <h2 class="font-semibold text-slate-800">{{ $pengumpulan ? 'Kumpulan Anda' : 'Kumpulkan Tugas' }}</h2>

        @if($pengumpulan)
            <p class="mt-2 text-sm text-slate-500">Dikirim pada {{ $pengumpulan->dikirim_pada?->translatedFormat('d M Y, H:i') }}</p>
            @if($pengumpulan->berkas)
                <a href="{{ \Illuminate\Support\Facades\Storage::url($pengumpulan->berkas) }}" target="_blank" rel="noopener" class="mt-1 inline-block text-sm font-medium text-teal-700 hover:underline">Lihat Berkas yang Dikumpulkan</a>
            @endif
        @endif

        @unless($pengumpulan?->nilai)
            <form method="POST" action="{{ route('siswa.tugas.kumpul', $tugas) }}" enctype="multipart/form-data" class="mt-4 space-y-4">
                @csrf
                <x-textarea label="Catatan (opsional)" name="catatan_siswa">{{ $pengumpulan?->catatan_siswa }}</x-textarea>
                <x-input type="file" label="Berkas Tugas" name="berkas" wajib />
                <x-tombol type="submit">{{ $pengumpulan ? 'Kumpulkan Ulang' : 'Kumpulkan Tugas' }}</x-tombol>
            </form>
        @endunless
    </x-kartu>
</x-layout-dashboard>
