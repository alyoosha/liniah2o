<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" {{--xmlns:xhtml="http://www.w3.org/1999/xhtml"--}}>
    <url>
        <loc>{{ route('pages.cart.index') }}</loc>
        <changefreq>daily</changefreq>
{{--        <lastmod>{{ $paymentAndDelivery->updated_at->tz('UTC')->toAtomString() }}</lastmod>--}}
        <priority>0.7</priority>
    </url>
    <url>
        <loc>{{ route('pages.cart.order') }}</loc>
        <changefreq>daily</changefreq>
        <priority>0.6</priority>
    </url>
</urlset>
