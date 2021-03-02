@extends('layouts.main')

@php
    $company_name = get_setting_by_key('company_name');
    $title = $company_name. ' - '. $mainProduct['name_' . $lang];
@endphp
@section('title', $title)
@section('description', $mainProduct['name_' . $lang] ?? '')
@section('keywords', get_product_keywords_from_breadcrumbs($mainProduct['breadcrumbs']) . $mainProduct['name_' . $lang])

@section('content')
    <main class="main-content" id="main-content">
        <section class="section section_inner-page section_product">
            <product-card
                lang="{{ $lang }}"
                product_default="{{ $mainProduct }}"
                is_tile="{{ $isTile ? true : false }}"
                collection="{{ json_encode($collection) }}"
            >
            </product-card>
            @if($isTile)
                @empty(!$collection)
                    @include('pages.collections.block-products-in-collection')
                @endempty
            @endif

        </section>
        @if($related_products->count() > 0)
            <also-buy-with-card default_related_products="{{ $related_products }}" language="{{ $lang }}"></also-buy-with-card>
        @endif
        <similar-and-watched-card default_similar_products="{{ json_encode($similar_products, JSON_UNESCAPED_UNICODE) }}" default_watched_products="{{ json_encode($watched_products, JSON_UNESCAPED_UNICODE) }}" language="{{ $lang }}"></similar-and-watched-card>
    </main>
@endsection

