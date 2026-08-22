<x-layout-dashboard judul-seo="Detail Tugas" :menu="\App\Support\MenuDashboard::guru()">
    <a href="{{ route('guru.tugas.index') }}" class="text-sm text-teal-700 dark:text-teal-400 hover:underline">&larr; Kembali</a>
    <div class="mt-2 flex flex-wrap items-start justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">{{ $tugas->judul }}</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">Kelas: {{ $tugas->kelasBelajar->nama_kelas }}</p>
        </div>
        <x-tombol-ekspor rute="guru.tugas.ekspor-nilai" :parameter="['tugas' => $tugas]" />
    </div>

    <x-kartu class="mt-6">
        <h2 class="font-semibold text-slate-800 dark:text-slate-100">Pengumpulan Siswa</h2>
        <table class="mt-4 w-full text-left text-sm">
            <thead class="text-xs uppercase text-slate-400 dark:text-slate-500">
                <tr><th class="pb-2">Siswa</th><th class="pb-2">Status</th><th class="pb-2">Nilai</th><th class="pb-2">Berkas</th><th class="pb-2 text-right">Aksi</th></tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($tugas->pengumpulan as $pengumpulan)
                    <tr>
                        <td class="py-3 font-medium text-slate-700 dark:text-slate-300">{{ $pengumpulan->pengguna->nama_lengkap }}</td>
                        <td class="py-3"><x-badge :warna="$pengumpulan->status === 'dinilai' ? 'emerald' : 'amber'">{{ ucfirst($pengumpulan->status) }}</x-badge></td>
                        <td class="py-3 text-slate-500 dark:text-slate-400">{{ $pengumpulan->nilai?->nilai ?? '-' }}</td>
                        <td class="py-3">
                            @if($pengumpulan->berkas)
                                <a href="{{ \Illuminate\Support\Facades\Storage::url($pengumpulan->berkas) }}" target="_blank" rel="noopener" class="text-sm text-teal-700 dark:text-teal-400 hover:underline">Lihat</a>
                            @else
                                <span class="text-sm text-slate-400 dark:text-slate-500">-</span>
                            @endif
                        </td>
                        <td class="py-3 text-right">
                            <button type="button" x-data @click="$dispatch('buka-modal', 'nilai-{{ $pengumpulan->id }}')" class="text-sm font-medium text-teal-700 dark:text-teal-400 hover:underline">Nilai</button>
                        </td>
                    </tr>

                    <x-modal :nama="'nilai-'.$pengumpulan->id" judul="Beri Nilai">
                        <form method="POST" action="{{ route('guru.tugas.nilai', [$tugas, $pengumpulan->id]) }}" class="space-y-4">
                            @csrf
                            <x-input label="Nilai (0-100)" name="nilai" type="number" :value="$pengumpulan->nilai?->nilai" wajib />
                            <x-textarea label="Catatan" name="catatan_guru">{{ $pengumpulan->nilai?->catatan_guru }}</x-textarea>
                            <x-tombol type="submit" class="w-full">Simpan Nilai</x-tombol>
                        </form>
                    </x-modal>
                @empty
                    <tr><td colspan="5"><x-empty-state judul="Belum ada pengumpulan tugas." /></td></tr>
                @endforelse
            </tbody>
        </table>
    </x-kartu>
</x-layout-dashboard>
