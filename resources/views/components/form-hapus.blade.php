@props(['aksi', 'pesan' => 'Yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.', 'label' => 'Hapus'])

<form
    method="POST"
    action="{{ $aksi }}"
    @submit.prevent="$dispatch('minta-konfirmasi', { form: $el, pesan: @js($pesan) })"
>
    @csrf
    @method('DELETE')
    <x-tombol-ikon type="submit" ikon="sampah" :label="$label" varian="bahaya" />
</form>
