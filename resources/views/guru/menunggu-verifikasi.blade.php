<x-layout-auth judul-seo="Menunggu Verifikasi">
    <div class="text-center">
        <svg class="mx-auto mb-4 h-14 w-14 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m6-2a10 10 0 1 1-20 0 10 10 0 0 1 20 0Z" />
        </svg>
        <h1 class="text-xl font-bold text-slate-900">Akun Anda Sedang Diverifikasi</h1>

        @if($verifikasi?->status->value === 'perlu_perbaikan')
            <x-alert jenis="peringatan" class="mt-4 text-left">
                Administrator meminta perbaikan data: {{ $verifikasi->catatan }}
            </x-alert>
        @elseif($verifikasi?->status->value === 'ditolak')
            <x-alert jenis="bahaya" class="mt-4 text-left">
                Pendaftaran Anda ditolak. Alasan: {{ $verifikasi->catatan }}
            </x-alert>
        @else
            <p class="mt-3 text-sm text-slate-500">
                Terima kasih telah mendaftar sebagai guru. Administrator sedang meninjau data Anda.
                Anda akan dapat mengakses dashboard setelah akun disetujui.
            </p>
        @endif

        <form method="POST" action="{{ route('keluar') }}" class="mt-6">
            @csrf
            <x-tombol type="submit" varian="hantu" class="w-full">Keluar</x-tombol>
        </form>
    </div>
</x-layout-auth>
