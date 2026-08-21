<x-layout-dashboard judul-seo="Detail Kelas" :menu="\App\Support\MenuDashboard::guru()">
    <a href="{{ route('guru.kelas.index') }}" class="text-sm text-teal-700 hover:underline">&larr; Kembali</a>

    <div class="mt-2 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-900">{{ $kelas->nama_kelas }}</h1>
        <x-badge warna="teal">Kode: {{ $kelas->kode_kelas }}</x-badge>
    </div>

    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="space-y-6 lg:col-span-2">
            <x-kartu>
                <h2 class="font-semibold text-slate-800">Anggota Kelas ({{ $kelas->anggota->count() }})</h2>
                <div class="mt-3 divide-y divide-slate-100">
                    @forelse($kelas->anggota as $siswa)
                        <div class="flex items-center justify-between py-2 text-sm">
                            <span class="font-medium text-slate-700">{{ $siswa->nama_lengkap }}</span>
                            <form method="POST" action="{{ route('guru.kelas.keluarkan-anggota', [$kelas, $siswa]) }}">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-rose-600 hover:underline">Keluarkan</button>
                            </form>
                        </div>
                    @empty
                        <p class="py-2 text-sm text-slate-400">Belum ada siswa. Bagikan kode kelas <strong>{{ $kelas->kode_kelas }}</strong> kepada siswa Anda.</p>
                    @endforelse
                </div>
            </x-kartu>

            <x-kartu>
                <div class="flex items-center justify-between">
                    <h2 class="font-semibold text-slate-800">Konten Kelas</h2>
                    <x-tombol type="button" varian="sekunder" x-data @click="$dispatch('buka-modal', 'tambah-konten')">Tambah Konten</x-tombol>
                </div>
                <div class="mt-3 divide-y divide-slate-100">
                    @forelse($kelas->kontenKelas as $konten)
                        <div class="flex items-center justify-between gap-3 py-2 text-sm">
                            <span class="min-w-0 flex-1 text-slate-700">
                                <x-badge warna="slate">{{ $konten->labelJenis }}</x-badge>
                                <span class="ml-1">{{ $konten->judulKonten ?? '(konten telah dihapus)' }}</span>
                            </span>
                            <form method="POST" action="{{ route('guru.kelas.hapus-konten', [$kelas, $konten->id]) }}">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-rose-600 hover:underline">Hapus</button>
                            </form>
                        </div>
                    @empty
                        <p class="py-2 text-sm text-slate-400">Belum ada konten yang ditambahkan.</p>
                    @endforelse
                </div>
            </x-kartu>

            <x-kartu>
                <div class="flex items-center justify-between">
                    <h2 class="font-semibold text-slate-800">Tugas Kelas</h2>
                    <x-tombol :href="route('guru.tugas.create', ['kelas' => $kelas->id])" varian="sekunder">Buat Tugas</x-tombol>
                </div>
                <div class="mt-3 divide-y divide-slate-100">
                    @forelse($kelas->tugasKelas as $tugas)
                        <div class="flex items-center justify-between py-2 text-sm">
                            <span class="font-medium text-slate-700">{{ $tugas->judul }}</span>
                            <a href="{{ route('guru.tugas.show', $tugas) }}" class="text-teal-700 hover:underline">Lihat</a>
                        </div>
                    @empty
                        <p class="py-2 text-sm text-slate-400">Belum ada tugas untuk kelas ini.</p>
                    @endforelse
                </div>
            </x-kartu>
        </div>

        <x-kartu>
            <h2 class="font-semibold text-slate-800">Info Kelas</h2>
            <dl class="mt-3 space-y-2 text-sm">
                <div><dt class="text-slate-400">Tahun Ajaran</dt><dd class="font-medium text-slate-700">{{ $kelas->tahun_ajaran }}</dd></div>
                <div><dt class="text-slate-400">Deskripsi</dt><dd class="text-slate-600">{{ $kelas->deskripsi }}</dd></div>
            </dl>
        </x-kartu>
    </div>

    <x-modal nama="tambah-konten" judul="Tambah Konten Kelas">
        <form method="POST" action="{{ route('guru.kelas.tambah-konten', $kelas) }}" class="space-y-4" x-data="{ jenis: 'e_modul' }">
            @csrf
            <div>
                <label class="mb-1.5 block text-sm font-medium text-slate-700">Jenis Konten</label>
                <select name="jenis_konten" x-model="jenis" class="block w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm">
                    <option value="e_modul">E-Modul</option>
                    <option value="lkpd">LKPD</option>
                    <option value="observasi">Observasi</option>
                </select>
            </div>

            <div x-show="jenis === 'e_modul'" x-bind:class="jenis === 'e_modul' ? '' : 'hidden'">
                <x-select label="Pilih E-Modul" name="id_referensi_e_modul" :opsi="$eModulSaya->pluck('judul', 'id')" x-bind:name="jenis === 'e_modul' ? 'id_referensi' : 'nonaktif_e_modul'" />
            </div>
            <div x-show="jenis === 'lkpd'" x-cloak>
                <x-select label="Pilih LKPD" name="id_referensi_lkpd" :opsi="$lkpdSaya->pluck('judul', 'id')" x-bind:name="jenis === 'lkpd' ? 'id_referensi' : 'nonaktif_lkpd'" />
            </div>
            <div x-show="jenis === 'observasi'" x-cloak>
                <x-select label="Pilih Observasi" name="id_referensi_observasi" :opsi="$observasiSaya->pluck('judul', 'id')" x-bind:name="jenis === 'observasi' ? 'id_referensi' : 'nonaktif_observasi'" />
            </div>

            <x-tombol type="submit" class="w-full">Tambahkan</x-tombol>
        </form>
    </x-modal>
</x-layout-dashboard>
