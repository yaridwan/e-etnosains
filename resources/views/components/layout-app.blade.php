<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $judulSeo ?? (pengaturan('nama_aplikasi', 'E-ETNOSAINS').' | '.pengaturan('slogan', '')) }}</title>
    <meta name="description" content="{{ $deskripsiSeo ?? pengaturan('deskripsi_seo', '') }}">
    <meta name="keywords" content="{{ $kataKunciSeo ?? pengaturan('kata_kunci', '') }}">
    <link rel="canonical" href="{{ url()->current() }}">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ pengaturan('nama_aplikasi', 'E-ETNOSAINS') }}">
    <meta property="og:title" content="{{ $judulSeo ?? pengaturan('judul_seo', '') }}">
    <meta property="og:description" content="{{ $deskripsiSeo ?? pengaturan('deskripsi_seo', '') }}">
    <meta property="og:url" content="{{ url()->current() }}">

    @if(request()->is('admin/*', 'guru/*', 'siswa/*', 'masuk', 'daftar*'))
        <meta name="robots" content="noindex, nofollow">
    @endif

    <link rel="icon" href="data:image/svg+xml,{{ rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect width="24" height="24" rx="6" fill="%230f766e"/><text x="12" y="17" font-size="14" text-anchor="middle" fill="white" font-family="sans-serif">E</text></svg>') }}">

    {{-- Dijalankan sebelum render agar tidak terjadi kedip putih saat mode gelap aktif. --}}
    <script>
        (() => {
            const pilihan = localStorage.getItem('tema') || 'sistem';
            const gelap = pilihan === 'gelap'
                || (pilihan === 'sistem' && window.matchMedia('(prefers-color-scheme: dark)').matches);
            document.documentElement.classList.toggle('dark', gelap);
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white font-sans text-slate-800 antialiased dark:bg-slate-950 dark:text-slate-200">
    {{ $slot }}
</body>
</html>
