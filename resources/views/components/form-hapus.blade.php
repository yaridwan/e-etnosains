@props(['aksi', 'pesan' => 'Yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.'])

<form
    method="POST"
    action="{{ $aksi }}"
    @submit.prevent="$dispatch('minta-konfirmasi', { form: $el, pesan: @js($pesan) })"
>
    @csrf
    @method('DELETE')
    <button type="submit" {{ $attributes->merge(['class' => 'text-sm font-medium text-rose-600 hover:text-rose-800']) }}>
        {{ $slot->isEmpty() ? 'Hapus' : $slot }}
    </button>
</form>
