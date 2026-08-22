import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Sertakan token CSRF pada setiap permintaan AJAX (dipakai antara lain oleh
// fitur simpan draf otomatis) agar tidak ditolak dengan galat 419.
const csrfToken = document.querySelector('meta[name="csrf-token"]');
if (csrfToken) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken.content;
}
