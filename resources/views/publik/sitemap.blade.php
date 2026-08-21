<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach($tautan as $item)
    <url>
        <loc>{{ $item['loc'] }}</loc>
        <lastmod>{{ optional($item['lastmod'])->toAtomString() ?? now()->toAtomString() }}</lastmod>
    </url>
@endforeach
</urlset>
