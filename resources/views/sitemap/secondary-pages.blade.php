<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" {{--xmlns:xhtml="http://www.w3.org/1999/xhtml"--}}>
    <url>
        <loc>{{ route('show-payment-and-delivery.get') }}</loc>
        <changefreq>monthly</changefreq>
        <lastmod>{{ $paymentAndDelivery->updated_at ? $paymentAndDelivery->updated_at->tz('UTC')->toAtomString() : '' }}</lastmod>
        <priority>0.5</priority>
    </url>
    <url>
        <loc>{{ route('show-warranty-periods.get') }}</loc>
        <changefreq>monthly</changefreq>
        <lastmod>{{ $warrantyPeriods->updated_at ? $warrantyPeriods->updated_at->tz('UTC')->toAtomString() : '' }}</lastmod>
        <priority>0.5</priority>
    </url>
    <url>
        <loc>{{ route('show-exploitation-rules.get') }}</loc>
        <changefreq>monthly</changefreq>
        <lastmod>{{ $explotationRuleLatest->updated_at ? $explotationRuleLatest->updated_at->tz('UTC')->toAtomString() : '' }}</lastmod>
        <priority>0.5</priority>
    </url>
    @if($explotationRulesList->count() > 0)
        @foreach($explotationRulesList as $explotationRule)
            <url>
                <loc>{{ route('show-exploitation-rule.get', [$explotationRule->id]) }}</loc>
                <changefreq>daily</changefreq>
                <lastmod>{{ $explotationRule->updated_at ? $explotationRule->updated_at->tz('UTC')->toAtomString() : '' }}</lastmod>
                <priority>0.5</priority>
            </url>
        @endforeach
    @endif
    @if($pagesList->count() > 0)
        @foreach($pagesList as $page)
            <url>
                <loc>{{ route('show-secondary-page.get', [$page->slug]) }}</loc>
                <changefreq>daily</changefreq>
                <lastmod>{{ $page->updated_at ? $page->updated_at->tz('UTC')->toAtomString() : '' }}</lastmod>
                <priority>0.5</priority>
            </url>
        @endforeach
    @endif
</urlset>
