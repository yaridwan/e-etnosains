@php($sedangUbah = $evaluasi->exists)

<x-layout-dashboard :judul-seo="$sedangUbah ? 'Ubah Evaluasi' : 'Buat Evaluasi'" :menu="\App\Support\MenuDashboard::guru()">
    <a href="{{ route('guru.evaluasi.index') }}" class="text-sm text-teal-700 dark:text-teal-400 hover:underline">&larr; Kembali</a>
    <h1 class="mt-2 text-2xl font-bold text-slate-900 dark:text-slate-100">{{ $sedangUbah ? 'Ubah Evaluasi' : 'Buat Evaluasi Baru' }}</h1>

    <form method="POST" action="{{ $sedangUbah ? route('guru.evaluasi.update', $evaluasi) : route('guru.evaluasi.store') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @if($sedangUbah) @method('PUT') @endif

        <x-kartu>
            <x-judul-form-seksi :nomor="1">Informasi Dasar</x-judul-form-seksi>
            <div class="space-y-4">
                <x-input label="Judul Evaluasi" name="judul" :value="$evaluasi->judul" wajib placeholder="Contoh: Ulangan Harian Bab Perubahan Wujud Zat" />
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <x-select label="Mata Pelajaran" name="id_mata_pelajaran" wajib :opsi="$mataPelajaran->pluck('nama_mata_pelajaran', 'id')" selected="{{ $evaluasi->id_mata_pelajaran }}" />
                    <x-select label="Jenjang Pendidikan" name="id_jenjang_pendidikan" wajib :opsi="$jenjang->pluck('nama_jenjang', 'id')" selected="{{ $evaluasi->id_jenjang_pendidikan }}" />
                    <x-select label="Jenis Evaluasi" name="jenis_evaluasi" wajib :opsi="\App\Models\Evaluasi::jenisEvaluasi()" selected="{{ $evaluasi->jenis_evaluasi ?? 'formatif' }}" />
                    <x-select label="E-Modul Terkait (opsional)" name="id_e_modul" :opsi="$eModulSaya->pluck('judul', 'id')" selected="{{ $evaluasi->id_e_modul }}" />
                    <x-input label="KKM (opsional)" name="kkm" type="number" min="0" max="100" :value="$evaluasi->kkm" placeholder="Contoh: 75" />
                    <x-input label="Durasi Pengerjaan (menit, opsional)" name="durasi_menit" type="number" min="1" :value="$evaluasi->durasi_menit" placeholder="Contoh: 90" />
                </div>
            </div>
        </x-kartu>

        <x-kartu>
            <x-judul-form-seksi :nomor="2">Deskripsi &amp; Petunjuk</x-judul-form-seksi>
            <div class="space-y-4">
                <x-textarea label="Deskripsi" name="deskripsi">{{ $evaluasi->deskripsi }}</x-textarea>
                <x-textarea label="Petunjuk Pengerjaan" name="petunjuk">{{ $evaluasi->petunjuk }}</x-textarea>
            </div>
        </x-kartu>

        <x-kartu>
            <x-judul-form-seksi :nomor="3">Berkas &amp; Publikasi</x-judul-form-seksi>
            <div class="space-y-4">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <x-unggah label="Berkas Soal (PDF)" name="berkas_pdf" jenis="dokumen" accept="application/pdf" :pratinjau="$evaluasi->berkas_pdf ? \Illuminate\Support\Facades\Storage::url($evaluasi->berkas_pdf) : null" />
                    <x-unggah label="Gambar Sampul" name="gambar_sampul" jenis="gambar" accept="image/*" :pratinjau="$evaluasi->gambar_sampul ? \Illuminate\Support\Facades\Storage::url($evaluasi->gambar_sampul) : null" />
                </div>

                <x-checkbox name="izin_unduh" :checked="$evaluasi->izin_unduh ?? true">
                    Izinkan pengunjung mengunduh berkas
                </x-checkbox>
            </div>
        </x-kartu>

        <x-tombol type="submit">Simpan &amp; Publikasikan</x-tombol>
    </form>
</x-layout-dashboard>
