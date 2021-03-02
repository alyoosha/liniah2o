<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" {{--xmlns:xhtml="http://www.w3.org/1999/xhtml"--}}>
    <url>
        <loc>{{ route('pages.catalog.index') }}</loc>
        <changefreq>daily</changefreq>
        <lastmod>{{ $categoryLatestUpdated->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        <priority>0.8</priority>
    </url>
    @if($firstLevelcategoriesList->count() > 0)
        @foreach($firstLevelcategoriesList as $firstLevelCategory)
            <url>
                <loc>{{ route('pages.catalog.secondary_index', [$firstLevelCategory->slug]) }}</loc>
                <changefreq>weekly</changefreq>
                <lastmod>{{ $firstLevelCategory->updated_at ? $firstLevelCategory->updated_at->tz('UTC')->toAtomString() : '' }}</lastmod>
                <priority>0.6</priority>
            </url>
        @endforeach
    @endif
    @if($firstLevelcategoriesList->count() > 0)
        @foreach($firstLevelcategoriesList as $firstLevelCategory)
            {{-- 10382 - id Плитки --}}
            @if($firstLevelCategory->childs->count() > 0 && (int)$firstLevelCategory->id !== 10382)
                @foreach($firstLevelCategory->childs as $second_level_category)
                    <url>
                        <loc>{{ route('pages.catalog.ternary_index', [$firstLevelCategory->slug, $second_level_category->slug]) }}</loc>
                        <changefreq>weekly</changefreq>
                        <lastmod>{{ $second_level_category->updated_at ? $second_level_category->updated_at->tz('UTC')->toAtomString() : '' }}</lastmod>
                        <priority>0.6</priority>
                    </url>
                    @if($second_level_category->childs->count() > 0)
                        @foreach($second_level_category->childs as $third_level_category)
                            <url>
                                <loc>{{ route('pages.catalog.ternary_index', [$firstLevelCategory->slug, $second_level_category->slug, $third_level_category->slug]) }}</loc>
                                <changefreq>weekly</changefreq>
                                <lastmod>{{ $third_level_category->updated_at ? $second_level_category->updated_at->tz('UTC')->toAtomString() : '' }}</lastmod>
                                <priority>0.7</priority>
                            </url>
                            @if($third_level_category->products->count() > 0)
                                @foreach($third_level_category->products as $product)
                                    <url>
                                        <loc>{{ route('pages.product.index', [$firstLevelCategory->slug, $second_level_category->slug, $third_level_category->slug, $product->slug]) }}</loc>
                                        <changefreq>weekly</changefreq>
                                        <lastmod>{{ $product->updated_at ? $product->updated_at->tz('UTC')->toAtomString() : '' }}</lastmod>
                                        <priority>0.7</priority>
                                    </url>
                                @endforeach
                            @endif
                        @endforeach
                    @endif
                @endforeach
            @else
                @foreach($firstLevelCategory->childs as $second_level_category)
                    @if(preg_match("/(soputstvuyushhie-tovary)-[0-9]+$/", $second_level_category->slug))
                        @foreach($second_level_category->childs as $third_level_category)
                            <url>
                                <loc>{{ route('pages.catalog.ternary_index', [$firstLevelCategory->slug, $second_level_category->slug, $third_level_category->slug]) }}</loc>
                                <changefreq>weekly</changefreq>
                                <lastmod>{{ $third_level_category->updated_at ? $third_level_category->updated_at->tz('UTC')->toAtomString() : '' }}</lastmod>
                                <priority>0.7</priority>
                            </url>
                        @endforeach
                    @else
                        <url>
                            <loc>{{ route('pages.collections.catalog_index', [$firstLevelCategory->slug, $second_level_category->slug]) }}</loc>
                            <changefreq>weekly</changefreq>
                            <lastmod>{{ $second_level_category->updated_at ? $second_level_category->updated_at->tz('UTC')->toAtomString() : '' }}</lastmod>
                            <priority>0.6</priority>
                        </url>
                    @endif
                    @foreach($second_level_category->collections as $collection)
                        <url>
                            <loc>{{ route('pages.collections.index', [$firstLevelCategory->slug, $second_level_category->slug, $collection->slug]) }}</loc>
                            <changefreq>weekly</changefreq>
                            <lastmod>{{ $collection->updated_at ? $collection->updated_at->tz('UTC')->toAtomString() : '' }}</lastmod>
                            <priority>0.7</priority>
                        </url>
                    @endforeach
                @endforeach
            @endif
        @endforeach
    @endif
</urlset>
