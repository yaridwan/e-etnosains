<footer class="border-t border-slate-100 bg-slate-50">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-10 md:grid-cols-4">
            <div class="md:col-span-2">
                <div class="flex items-center gap-2 font-bold text-teal-800">
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-teal-700 text-white">E</span>
                    <span class="text-lg">{{ pengaturan('nama_singkat', 'E-ETNOSAINS') }}</span>
                </div>
                <p class="mt-4 max-w-md text-sm text-slate-500">
                    {{ pengaturan('deskripsi', 'Platform e-modul pembelajaran berbasis etnosains dan kearifan lokal.') }}
                </p>
            </div>

            <div>
                <p class="text-sm font-semibold text-slate-800">Navigasi</p>
                <ul class="mt-4 space-y-2 text-sm text-slate-500">
                    @foreach($menuNavigasi->take(6) as $menu)
                        <li><a href="{{ $menu->tautan }}" class="hover:text-teal-700">{{ $menu->label }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <p class="text-sm font-semibold text-slate-800">Kontak</p>
                <ul class="mt-4 space-y-2 text-sm text-slate-500">
                    <li>{{ pengaturan('email', 'hello@e-etnosains.test') }}</li>
                    <li>{{ pengaturan('nomor_telepon', '') }}</li>
                    <li>{{ pengaturan('alamat', '') }}</li>
                </ul>
            </div>
        </div>

        <div class="mt-10 flex flex-col items-center justify-between gap-4 border-t border-slate-200 pt-6 text-sm text-slate-500 sm:flex-row">
            <p>&copy; {{ now()->year }} {{ pengaturan('nama_aplikasi', 'E-ETNOSAINS') }}. Seluruh hak cipta dilindungi.</p>
            <div class="flex gap-4">
                <a href="{{ route('halaman-statis', 'kebijakan-privasi') }}" class="hover:text-teal-700">Kebijakan Privasi</a>
                <a href="{{ route('halaman-statis', 'syarat-penggunaan') }}" class="hover:text-teal-700">Syarat Penggunaan</a>
            </div>
        </div>
    </div>
</footer>
