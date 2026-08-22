@props(['nama'])

{{--
    Kamus ikon terpusat bergaya garis (outline), 24x24, agar seluruh ikon di
    sidebar dan tombol aksi konsisten tanpa perlu menambah pustaka ikon
    eksternal. Tambahkan kunci baru di sini saat dibutuhkan.
--}}
@php
    $isi = match ($nama) {
        // Navigasi & menu dashboard
        'grid' => '<rect x="3.75" y="3.75" width="7" height="7" rx="1.5"/><rect x="13.25" y="3.75" width="7" height="7" rx="1.5"/><rect x="3.75" y="13.25" width="7" height="7" rx="1.5"/><rect x="13.25" y="13.25" width="7" height="7" rx="1.5"/>',
        'perisai' => '<path d="M12 3.5 5.5 6v5.25c0 4.5 2.8 7.2 6.5 8.75 3.7-1.55 6.5-4.25 6.5-8.75V6L12 3.5Z"/><path d="m9 12 2 2 4-4"/>',
        'cari' => '<circle cx="10.5" cy="10.5" r="6.25"/><path d="m19.5 19.5-4.65-4.65"/>',
        'topi' => '<path d="m3 9 9-4 9 4-9 4-9-4Z"/><path d="M7 11v4.5c0 1 2.2 2 5 2s5-1 5-2V11"/><path d="M20 9v5.5"/>',
        'buku' => '<path d="M4 5.5c1.8-1 4.4-1.2 8-.3v13c-3.6-.9-6.2-.7-8 .3v-13Z"/><path d="M20 5.5c-1.8-1-4.4-1.2-8-.3v13c3.6-.9 6.2-.7 8 .3v-13Z"/>',
        'lampu' => '<path d="M9 18.5h6"/><path d="M9.5 21h5"/><path d="M12 3.5a5.75 5.75 0 0 0-3.2 10.55c.6.42 1.2 1.2 1.2 2.2v.25h4v-.25c0-1 .6-1.78 1.2-2.2A5.75 5.75 0 0 0 12 3.5Z"/>',
        'lokasi' => '<path d="M12 21s7-6.1 7-11.5a7 7 0 0 0-14 0C5 14.9 12 21 12 21Z"/><circle cx="12" cy="9.5" r="2.5"/>',
        'gedung' => '<path d="M4 20.5V9.5l8-4.5 8 4.5v11"/><path d="M4 20.5h16"/><path d="M9 20.5v-6h6v6"/><path d="M9 12.75h.01M12 12.75h.01M15 12.75h.01"/>',
        'label' => '<path d="M11.5 4h6a1.5 1.5 0 0 1 1.5 1.5v6L10.5 20 4 13.5 11.5 4Z"/><circle cx="14.75" cy="8.25" r="1.25"/>',
        'gambar' => '<rect x="3.5" y="4.5" width="17" height="15" rx="2"/><circle cx="9" cy="10" r="1.75"/><path d="m5 18 5-5 3.5 3.5L18 12l1.5 1.5"/>',
        'obrolan' => '<path d="M4 6.5A2.5 2.5 0 0 1 6.5 4h11A2.5 2.5 0 0 1 20 6.5v7A2.5 2.5 0 0 1 17.5 16H10l-4.5 4v-4H6.5A2.5 2.5 0 0 1 4 13.5v-7Z"/>',
        'tanya' => '<circle cx="12" cy="12" r="8.25"/><path d="M9.7 9.6a2.3 2.3 0 1 1 3.4 2c-.8.55-1.35 1-1.35 2.15"/><path d="M12 17h.01"/>',
        'dokumen' => '<path d="M7 3.5h7l4 4v12.5a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1v-15.5a1 1 0 0 1 1-1Z"/><path d="M14 3.5V8h4"/><path d="M9 12.5h6M9 15.5h6M9 18h4"/>',
        'corong' => '<path d="M4 10.5v3a1.5 1.5 0 0 0 1.5 1.5H7l3.5 4V5l-3.5 4H5.5A1.5 1.5 0 0 0 4 10.5Z"/><path d="M14 9.5a3.5 3.5 0 0 1 0 5M17 7a7 7 0 0 1 0 10"/>',
        'pengguna' => '<circle cx="9" cy="8.5" r="3"/><path d="M3.5 19c.7-3 2.7-4.5 5.5-4.5s4.8 1.5 5.5 4.5"/><circle cx="17" cy="9" r="2.25"/><path d="M15.8 14.75c2 .35 3.3 1.6 3.8 3.75"/>',
        'bintang' => '<path d="m12 4 2.35 4.9 5.4.7-3.9 3.75.95 5.35L12 16.1l-4.8 2.6.95-5.35-3.9-3.75 5.4-.7L12 4Z"/>',
        'lonceng' => '<path d="M6 17.5v-6a6 6 0 0 1 12 0v6l1.5 2h-15l1.5-2Z"/><path d="M10 21a2 2 0 0 0 4 0"/>',
        'gerigi' => '<circle cx="12" cy="12" r="3"/><path d="M12 3.5v2M12 18.5v2M20.5 12h-2M5.5 12h-2M17.6 6.4l-1.4 1.4M7.8 16.2l-1.4 1.4M17.6 17.6l-1.4-1.4M7.8 7.8 6.4 6.4"/>',
        'clipboard-list' => '<rect x="5.5" y="4.5" width="13" height="16" rx="1.75"/><path d="M9 4.5V3.75a1.25 1.25 0 0 1 1.25-1.25h3.5A1.25 1.25 0 0 1 15 3.75V4.5"/><path d="M8.5 10.5h7M8.5 13.5h7M8.5 16.5h4"/>',
        'tumpukan' => '<rect x="6" y="3.75" width="12" height="6" rx="1.25"/><rect x="4" y="10.75" width="16" height="6" rx="1.25"/><path d="M8 20.25h8"/>',
        'clipboard-centang' => '<rect x="5.5" y="4.5" width="13" height="16" rx="1.75"/><path d="M9 4.5V3.75a1.25 1.25 0 0 1 1.25-1.25h3.5A1.25 1.25 0 0 1 15 3.75V4.5"/><path d="m9 13 2 2 4-4"/>',
        'folder' => '<path d="M4 7.25A1.75 1.75 0 0 1 5.75 5.5h4l2 2.25h8A1.75 1.75 0 0 1 21.5 9.5v8.25a1.75 1.75 0 0 1-1.75 1.75H5.75A1.75 1.75 0 0 1 4 17.75V7.25Z"/>',
        'putar' => '<circle cx="12" cy="12" r="8.25"/><path d="M10.25 9v6l5-3-5-3Z"/>',
        'mata' => '<path d="M2.75 12S6 5.75 12 5.75 21.25 12 21.25 12 18 18.25 12 18.25 2.75 12 2.75 12Z"/><circle cx="12" cy="12" r="2.5"/>',
        'kelompok' => '<circle cx="8.5" cy="9" r="3"/><circle cx="16" cy="9.5" r="2.5"/><path d="M3.25 19c.6-3 2.6-4.6 5.25-4.6s4.65 1.6 5.25 4.6"/><path d="M14.25 14.9c2 .35 3.5 1.75 4 4.1"/>',
        'lencana-centang' => '<path d="M12 3.5 15 5l3-.25.75 2.9L21 9.5l-1.5 2.5 1.5 2.5-2.25 1.85-.75 2.9L15 19l-3 1.5-3-1.5-3 .25-.75-2.9L3 14.5l1.5-2.5L3 9.5l2.25-1.85.75-2.9L9 5l3-1.5Z"/><path d="m9.25 12 1.85 1.85 3.65-3.85"/>',
        'kotak-masuk' => '<path d="M4 12.5h4l1.5 2.5h5l1.5-2.5h4"/><path d="M6 6.5h12l2 6v6a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 4 18.5v-6l2-6Z"/>',
        'lingkaran-pengguna' => '<circle cx="12" cy="12" r="8.25"/><circle cx="12" cy="10" r="2.75"/><path d="M6.6 18.2c.9-2.4 2.8-3.7 5.4-3.7s4.5 1.3 5.4 3.7"/>',
        'hati' => '<path d="M12 20s-7.25-4.35-9.25-8.9C1.4 7.9 3.2 4.75 6.4 4.4c2-.2 3.6.8 5.6 2.85 2-2.05 3.6-3.05 5.6-2.85 3.2.35 5 3.5 3.65 6.7C19.25 15.65 12 20 12 20Z"/>',
        'jam' => '<circle cx="12" cy="12" r="8.25"/><path d="M12 7.5V12l3.25 2"/>',
        'magnet' => '<path d="M6 4h4v8a2 2 0 1 0 4 0V4h4v8a6 6 0 1 1-12 0V4Z"/><path d="M6 8h4M14 8h4"/>',
        'pensil' => '<path d="M4 19.5 4.75 16 15.5 5.25a1.75 1.75 0 0 1 2.5 0l.75.75a1.75 1.75 0 0 1 0 2.5L8.5 19.25 4 20l0-.5Z"/><path d="m14 6.75 3.25 3.25"/>',
        'pensil-kotak' => '<path d="M11 5H6a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-5"/><path d="M18.4 4.6a1.75 1.75 0 0 1 2.5 2.5L13 15l-3.25.75L10.5 12.5 18.4 4.6Z"/>',
        'sampah' => '<path d="M4.5 7h15"/><path d="M9.5 7V5.25A1.25 1.25 0 0 1 10.75 4h2.5a1.25 1.25 0 0 1 1.25 1.25V7"/><path d="M6.5 7 7.3 19a1.5 1.5 0 0 0 1.5 1.4h6.4a1.5 1.5 0 0 0 1.5-1.4L17.5 7"/><path d="M10.25 11v6M13.75 11v6"/>',
        'centang' => '<circle cx="12" cy="12" r="8.25"/><path d="m8.25 12.25 2.5 2.5 5-5.5"/>',
        'silang' => '<circle cx="12" cy="12" r="8.25"/><path d="m9 9 6 6M15 9l-6 6"/>',
        'unduh' => '<path d="M12 3.5v11.5M8 11.5l4 4 4-4"/><path d="M4.5 17v2A1.5 1.5 0 0 0 6 20.5h12a1.5 1.5 0 0 0 1.5-1.5v-2"/>',
        default => '',
    };
@endphp

<svg
    {{ $attributes->merge(['class' => 'h-5 w-5']) }}
    viewBox="0 0 24 24"
    fill="none"
    stroke="currentColor"
    stroke-width="1.75"
    stroke-linecap="round"
    stroke-linejoin="round"
    aria-hidden="true"
>
    {!! $isi !!}
</svg>
