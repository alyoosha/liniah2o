@extends('layouts.main')

@php
    $company_name = get_setting_by_key('company_name');
    $title = $company_name. ' - '. __('brands').'. '.$brand->name;
@endphp
@section('title', $title)
@section('description', __('brands').'. '.$brand->name)
@section('keywords', __('brands').'. '.$brand->name)

@section('content')
    <main class="main-content" id="main-content">
        <section class="section section_inner-page section_brands-page-inner">
            <div class="section__header">
                <div class="container">
                    <div class="section__breadcrumbs">
                        <ul class="list list_unstyled breadcrumbs-list">
                            <li class="list__item"><a class="link" href="{{ route('homepage').'/'.$lang }}">{{ __('homepage') }}</a></li>
                            <li class="list__item"><a class="link" href="{{ route('pages.brands.index') }}">{{ __('brands') }}</a></li>
                            <li class="list__item"><a class="link active" href="javascript: void(0);">{{ $brand->name }}</a></li>
                        </ul>
                    </div>
                    <div class="section__title section__title_style1 header-title">
                        <h1>{{ $brand->name }}</h1>
                    </div>
                </div>
            </div>
            <div class="section__body">
                <div class="brand-description bg_gray-medium">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8 order-lg-first order-last">
                                @if($brand['description_'.$lang])
                                    <div class="brand-description__text">{{ $brand['description_'.$lang] }}</div>
                                @else
                                    <div class="brand-description__text" style="padding-top: 150px;">
                                        {{ __('brands_default_description', ['brand_name' => $brand->name]) }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-lg-3 offset-lg-1 order-lg-last order-first">
                                <div class="brand-description__logo">
                                    <div class="brand-block"><img class="brand-block__img" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url('brands/big/'.$brand->image) }}" alt="{{ $brand->name }}"></div>
                                    <div class="brand-block__country">
                                        <span>{{ $brand->country['name_'.$lang] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="brand-info section_catalog">
                    <div class="container">
                        <div class="category-block category-block_main" id="category-tile">
                            <div class="row no-gutters">
                                <div class="col-12 col-lg-5">
                                    <a class="link category-block__header category-block__header_{{ $category->color_class_prefix }}" href="{{ route('pages.catalog.secondary_index', $category->slug) }}" aria-label="{{ $category['name_'.$lang] }}">
                                        <div class="link__bg" aria-hidden="true" style="background-image: url({{ $category->logo ? asset('storage/'.$category->logo) : '' }});"></div>
                                        <div class="link__content">
                                            @if($category->svg_logo)
                                                <span class="link__icon" aria-hidden="true">
                                            <svg role="img" aria-hidden="true" width="30" height="30">
                                                @php preg_match("/icon-(.*)\.svg$/", \Storage::disk('public')->url('/'.$category->svg_logo), $m); @endphp
                                                <use xlink:href="#svg-icon-{{ $m[1] }}"></use>
                                            </svg>
                                        </span>
                                            @endif
                                            <h2 class="link__text">
                                                <span class="line">{{ $category['name_'.$lang] }}</span>
                                            </h2>
                                            <span class="link__control" aria-hidden="true">
                                        <svg role="img" aria-hidden="true" width="20" height="20">
                                            <use xlink:href="#svg-icon-down-arrow"></use>
                                        </svg>
                                    </span>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-12 col-lg-7">
                                    <div class="row no-gutters">
                                        @php $promoCategory = $category->firstLevelCategoryPromoBlock; @endphp
                                        @php $second_level_category = $category->getFirstChild() @endphp
                                        @php $newProduct = !is_null($promoCategory) ? $promoCategory->newProduct : null @endphp
                                        @if($newProduct)
                                            <div class="col-12 col-md-4">
                                                <div class="rec-block rec-block_new">
                                                    <div class="rec-block__content d-none d-md-block">
                                                        <div class="rec-block__header">
                                                            <a
                                                                class="rec-block__img"
                                                                href="{{ $newProduct->getLink() }}"
                                                            >
                                                                <img src="{{ $newProduct->getPreviewPicture() }}" alt="{{ $newProduct['name_'.$lang] }}">
                                                            </a>
                                                            <ul class="list list_unstyled rec-block__marks marks-list">
                                                                <li class="list__item bg_blue">{{ __('new_product') }}</li>
                                                            </ul>
                                                        </div>
                                                        <div class="rec-block__body">
                                                            <a
                                                                class="rec-block__title"
                                                                href="{{ $newProduct->getLink() }}"
                                                            >
                                                                {{ $newProduct['name_'.$lang] }}
                                                            </a>
                                                            <div class="rec-block__price">
                                                                @if($newProduct['discount_price'])
                                                                    <span class="old">{{ $newProduct['price'] }}</span>
                                                                    <span class="cost cost_new">{{ $newProduct['discount_price'] }}</span>
                                                                @else
                                                                    <span class="cost">{{ $newProduct['price'] }}</span>
                                                                @endif
                                                                <span class="currency">{{ __('currency_name') }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="rec-block__footer">
                                                        <a
                                                            class="link rec-block__link"
                                                            href="{{ route('pages.catalog.ternary_index', [$category->slug, $second_level_category->slug]).'?new='.$newTag->id }}"
                                                            aria-label="{{ __('go_to_ternary_catalog_page') }}"
                                                        >
                                                            <span class="link__text">{{ __('new_products') }}</span>
                                                            <span class="link__control" aria-hidden="true">
                                                        <svg role="img" aria-hidden="true" width="20" height="20">
                                                            <use xlink:href="#svg-icon-down-arrow"></use>
                                                        </svg>
                                                    </span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @php $promotionProduct = !is_null($promoCategory) ? $promoCategory->promotionProduct : null @endphp
                                        @if($promotionProduct)
                                            <div class="col-12 col-md-4">
                                                <div class="rec-block rec-block_sale">
                                                    <div class="rec-block__content d-none d-md-block">
                                                        <div class="rec-block__header">
                                                            <a
                                                                class="rec-block__img"
                                                                href="{{ $promotionProduct->getLink() }}"
                                                            >
                                                                <img src="{{ $promotionProduct->getPreviewPicture() }}" alt="{{ $promotionProduct['name_'.$lang] }}">
                                                            </a>
                                                            @php $promotion_discount = get_promotion_discount_attribute_for_product($promotionProduct->tags) @endphp
                                                            @if((int)$promotion_discount !== 0)
                                                                <ul class="list list_unstyled rec-block__marks marks-list">
                                                                    <li class="list__item list__item_num bg_red">{{ $promotion_discount }}%</li>
                                                                </ul>
                                                            @endif
                                                        </div>
                                                        <div class="rec-block__body">
                                                            <a
                                                                class="rec-block__title"
                                                                href="{{ $promotionProduct->getLink() }}"
                                                            >
                                                                {{ $promotionProduct['name_'.$lang] }}
                                                            </a>
                                                            <div class="rec-block__price">
                                                                @if($promotionProduct['discount_price'])
                                                                    <span class="old">{{ $promotionProduct['price'] }}</span>
                                                                    <span class="cost cost_new">{{ $promotionProduct['discount_price'] }}</span>
                                                                @else
                                                                    <span class="cost">{{ $promotionProduct['price'] }}</span>
                                                                @endif
                                                                <span class="currency">{{ __('currency_name') }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="rec-block__footer">
                                                        <a
                                                            class="link rec-block__link"
                                                            href="{{ route('pages.catalog.ternary_index', [$category->slug, $second_level_category->slug]).'?sale='.$saleTag->id }}"
                                                            aria-label="{{ __('go_to_ternary_catalog_page') }}"
                                                        >
                                                            <span class="link__text">{{ __('promotions') }}</span>
                                                            <span class="link__control" aria-hidden="true">
                                                        <svg role="img" aria-hidden="true" width="20" height="20">
                                                            <use xlink:href="#svg-icon-down-arrow"></use>
                                                        </svg>
                                                    </span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-12 col-md-4">
                                            <div class="rec-block rec-block_brand">
                                                <div class="rec-block__content d-none d-md-block">
                                                    <div class="swiper-container js-slider-attached-product">
                                                        <div class="swiper-wrapper">
                                                            @php $brands = $category->getBrands() @endphp
                                                            @foreach($brands as $brand)
                                                                <div class="swiper-slide">
                                                                    {{-- 10382 -> id Плитки--}}
                                                                    @if((int)$category->id === 10382)
                                                                        <a
                                                                            class="rec-block__brand"
                                                                            href="{{ route('pages.collections.catalog_index', [$category->slug, $second_level_category->slug]).'?brand='.$brand['id'] }}"
                                                                            aria-label="{{ __('go_to_ternary_catalog_page') }}"
                                                                            title="{{ $brand['name'] }}"
                                                                        >
                                                                            <img src="{{ $brand['image'] }}" alt="{{ $brand['name'] }}">
                                                                        </a>
                                                                    @else
                                                                        <a
                                                                            class="rec-block__brand"
                                                                            href="{{ route('pages.catalog.ternary_index', [$category->slug, $second_level_category->slug]).'?brand='.$brand['id'] }}"
                                                                            aria-label="{{ __('go_to_ternary_catalog_page') }}"
                                                                            title="{{ $brand['name'] }}"
                                                                        >
                                                                            <img src="{{ $brand['image'] }}" alt="{{ $brand['name'] }}">
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <button class="swiper-button-prev" type="button">
                                                            <svg role="img" aria-hidden="true" width="30" height="30">
                                                                <use xlink:href="#svg-icon-down-arrow"></use>
                                                            </svg>
                                                        </button>
                                                        <button class="swiper-button-next" type="button">
                                                            <svg role="img" aria-hidden="true" width="30" height="30">
                                                                <use xlink:href="#svg-icon-down-arrow"></use>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="rec-block__footer">
                                                    <a class="link rec-block__link" href="{{ route('pages.brands.index') }}">
                                                        <span class="link__text">{{ __('brands') }}</span>
                                                        <span class="link__control" aria-hidden="true">
                                                        <svg role="img" aria-hidden="true" width="20" height="20">
                                                            <use xlink:href="#svg-icon-down-arrow"></use>
                                                        </svg>
                                                    </span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <section class="section section_slider-buy" id="slider-buy" style="padding-top: 20px;">
                    <cart-recommended-onsuccess language="{{ $lang }}" recommended_products_default="{{ $json_encoded_recommended_products }}"></cart-recommended-onsuccess>
                </section>
            </div>
        </section>
    </main>
@endsection
