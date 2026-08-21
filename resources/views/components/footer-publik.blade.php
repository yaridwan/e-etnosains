@php($sosial = collect([
    'Facebook' => pengaturan('facebook'),
    'Instagram' => pengaturan('instagram'),
    'YouTube' => pengaturan('youtube'),
    'TikTok' => pengaturan('tiktok'),
])->filter())

<footer class="border-t border-slate-200 bg-slate-50 dark:border-slate-800 dark:bg-slate-900/50">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-10 md:grid-cols-4">
            <div class="md:col-span-2">
                <div class="flex items-center gap-2.5">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-teal-700 text-sm font-bold text-white">E</span>
                    <span class="text-base font-bold tracking-tight text-teal-800 dark:text-teal-300">
                        {{ pengaturan('nama_singkat', 'E-ETNOSAINS') }}
                    </span>
                </div>
                <p class="mt-4 max-w-md text-sm leading-relaxed text-slate-500 dark:text-slate-400">
                    {{ pengaturan('deskripsi', 'Platform e-modul pembelajaran berbasis etnosains dan kearifan lokal.') }}
                </p>

                @if($sosial->isNotEmpty())
                    <div class="mt-5 flex flex-wrap gap-2">
                        @foreach($sosial as $nama => $tautan)
                            <a href="{{ $tautan }}" target="_blank" rel="noopener"
                               class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-medium text-slate-600 transition hover:border-teal-600 hover:text-teal-700 dark:border-slate-700 dark:text-slate-400 dark:hover:border-teal-500 dark:hover:text-teal-300">
                                {{ $nama }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <div>
                <p class="text-sm font-semibold text-slate-800 dark:text-slate-200">Navigasi</p>
                <ul class="mt-4 space-y-2 text-sm text-slate-500 dark:text-slate-400">
                    @foreach($menuNavigasi as $menu)
                        @if($menu->anak->isNotEmpty())
                            @foreach($menu->anak->take(5) as $submenu)
                                <li><a href="{{ $submenu->tautan }}" class="transition hover:text-teal-700 dark:hover:text-teal-300">{{ $submenu->label }}</a></li>
                            @endforeach
                        @else
                            <li><a href="{{ $menu->tautan }}" class="transition hover:text-teal-700 dark:hover:text-teal-300">{{ $menu->label }}</a></li>
                        @endif
                    @endforeach
                </ul>
            </div>

            <div>
                <p class="text-sm font-semibold text-slate-800 dark:text-slate-200">Kontak</p>
                <ul class="mt-4 space-y-2 text-sm text-slate-500 dark:text-slate-400">
                    <li>{{ pengaturan('email', 'hello@e-etnosains.test') }}</li>
                    <li>{{ pengaturan('nomor_telepon', '') }}</li>
                    <li>{{ pengaturan('alamat', '') }}</li>
                </ul>
            </div>
        </div>

        <div class="mt-10 flex flex-col items-center justify-between gap-4 border-t border-slate-200 pt-6 text-sm text-slate-500 sm:flex-row dark:border-slate-800 dark:text-slate-400">
            <p>&copy; {{ now()->year }} {{ pengaturan('nama_aplikasi', 'E-ETNOSAINS') }}. Seluruh hak cipta dilindungi.</p>
            <div class="flex gap-4">
                <a href="{{ route('halaman-statis', 'kebijakan-privasi') }}" class="transition hover:text-teal-700 dark:hover:text-teal-300">Kebijakan Privasi</a>
                <a href="{{ route('halaman-statis', 'syarat-penggunaan') }}" class="transition hover:text-teal-700 dark:hover:text-teal-300">Syarat Penggunaan</a>
            </div>
        </div>
    </div>
</footer>
