@php($menu = auth()->user()->isAdministrator()
    ? \App\Support\MenuDashboard::administrator()
    : (auth()->user()->isGuru() ? \App\Support\MenuDashboard::guru() : \App\Support\MenuDashboard::siswa()))

<x-layout-dashboard judul-seo="Notifikasi" :menu="$menu">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Notifikasi</h1>
            <p class="mt-1 text-sm text-slate-500">Pemberitahuan terkait aktivitas akun dan konten Anda.</p>
        </div>

        @if($notifikasi->contains(fn ($item) => ! $item->sudahDibaca()))
            <form method="POST" action="{{ route('notifikasi.tandai-semua-dibaca') }}">
                @csrf
                <x-tombol type="submit" varian="sekunder">Tandai Semua Dibaca</x-tombol>
            </form>
        @endif
    </div>

    <x-kartu class="mt-6">
        @if($notifikasi->isEmpty())
            <x-empty-state judul="Belum ada notifikasi." deskripsi="Pemberitahuan akan muncul di sini saat ada aktivitas baru." />
        @else
            <div class="divide-y divide-slate-100">
                @foreach($notifikasi as $item)
                    <div class="flex items-start justify-between gap-4 py-4 {{ $item->sudahDibaca() ? '' : 'bg-teal-50/40' }}">
                        <div class="flex gap-3">
                            <span class="mt-1.5 h-2 w-2 shrink-0 rounded-full {{ $item->sudahDibaca() ? 'bg-slate-200' : 'bg-teal-600' }}"></span>
                            <div>
                                <p class="text-sm font-semibold text-slate-800">{{ $item->judul }}</p>
                                <p class="mt-0.5 text-sm text-slate-600">{{ $item->pesan }}</p>
                                <p class="mt-1 text-xs text-slate-400">{{ $item->dibuat_pada?->diffForHumans() }}</p>
                            </div>
                        </div>

                        @unless($item->sudahDibaca())
                            <form method="POST" action="{{ route('notifikasi.tandai-dibaca', $item) }}">
                                @csrf
                                <button type="submit" class="shrink-0 text-sm font-medium text-teal-700 hover:underline">Tandai dibaca</button>
                            </form>
                        @endunless
                    </div>
                @endforeach
            </div>

            <div class="mt-4">{{ $notifikasi->links() }}</div>
        @endif
    </x-kartu>
</x-layout-dashboard>
