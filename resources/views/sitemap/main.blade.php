<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" {{--xmlns:xhtml="http://www.w3.org/1999/xhtml"--}}>
    <url>
        <loc>{{ route('pages.main.index') }}</loc>
        <changefreq>daily</changefreq>
        <priority>0.9</priority>
{{--        <xhtml:link--}}
{{--            rel="alternate"--}}
{{--            hreflang="ro"--}}
{{--            href="{{ \Illuminate\Support\Facades\URL::to('/').'/ro/' }}"--}}
{{--        />--}}
    </url>
    <url>
        <loc>{{ route('pages.contacts.index') }}</loc>
        <changefreq>weekly</changefreq>
        <lastmod>{{ $contacts->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        <priority>0.5</priority>
    </url>
    <url>
        <loc>{{ route('pages.about.index') }}</loc>
        <changefreq>weekly</changefreq>
        <lastmod>{{ $about->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        <priority>0.5</priority>
    </url>
    <url>
        <loc>{{ route('pages.brands.index') }}</loc>
        <changefreq>weekly</changefreq>
        <lastmod>{{ $brand->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        <priority>0.6</priority>
    </url>
    <url>
        <loc>{{ route('pages.promotions.index') }}</loc>
        <changefreq>weekly</changefreq>
        <lastmod>{{ $promotionLatest->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        <priority>0.6</priority>
    </url>
    @if($promotions->count() > 0)
        @foreach($promotions as $promotion)
            <url>
                <loc>{{ route('pages.promotions.show', [$promotion->slug]) }}</loc>
                <changefreq>daily</changefreq>
                <lastmod>{{ $promotion->updated_at->tz('UTC')->toAtomString() }}</lastmod>
                <priority>0.7</priority>
            </url>
        @endforeach
    @endif
</urlset>
