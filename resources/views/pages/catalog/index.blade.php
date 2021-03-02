@extends('layouts.main')

@php
    $company_name = get_setting_by_key('company_name');
    $title = $company_name. ' - '. __('catalog');
@endphp
@section('title', $title)
@section('description', __('catalog'))
@section('keywords', __('catalog'))

@section('content')
    <main class="main-content" id="main-content">
    <section class="section section_inner-page section_catalog">
        <div class="section__header">
            <div class="container">
                <div class="section__breadcrumbs">
                    <ul class="list list_unstyled breadcrumbs-list">
                        <li class="list__item"><a class="link" href="{{ route('homepage').'/'.$lang }}">{{ __('homepage') }}</a></li>
                        <li class="list__item"><a class="link active" href="javascript: void(0);">{{ __('catalog') }}</a></li>
                    </ul>
                </div>
                <div class="section__title section__title_style1">
                    <h1>{{ __('catalog') }}</h1>
                </div>
            </div>
        </div>
        <div class="section__body">
            <div class="container">
                <div class="easy-nav bg_white">
                    <ul class="list list_unstyled easy-nav__list">
                        @foreach($categories as $category)
                            <li class="list__item">
                                <a class="btn btn_light link js-scroll-link" href="#category-{{ $category->slug }}" aria-label="{{ $category->slug }}">
                                    @if($category->svg_logo)
                                        <svg role="img" aria-hidden="true" width="30" height="30">
                                            @php preg_match("/icon-(.*)\.svg$/", \Storage::disk('public')->url('/'.$category->svg_logo), $m); @endphp
                                            <use xlink:href="#svg-icon-{{ $m[1] }}"></use>
                                        </svg>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                @foreach($categories as $category)
                    <div class="category-block category-block_main" id="category-{{ $category->slug }}">
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
                                    @php
                                        if((int)$category->id === 10392) {
                                            // Шкафы с умывальниками!!!
                                            $second_level_category = $category->childs()->where('id', 10410)->first();
                                        } else {
                                            $second_level_category = $category->getFirstChild();
                                        }
                                    @endphp
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
                                                            @if(!$newProduct->images_table->isEmpty())
                                                                <picture class="rec-block__img">
                                                                    <source srcset="{{$newProduct->images_table[0]->getImageResizedSmall()}}" media="(min-width: 535px)">
                                                                    <source srcset="{{$newProduct->images_table[0]->getImageResizedMiddle()}}" media="(min-width: 0px)">
                                                                    <img src="{{$newProduct->images_table[0]->getImageResizedSmall()}}" alt="{{$newProduct['name_'.$lang]}}">
                                                                </picture>
                                                            @else
                                                                <img src="{{$newProduct->getPreviewPicture()}}" alt="{{$newProduct['name_'.$lang]}}">
                                                            @endif
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
                                                            <span class="currency">{{__('currency_name')}}{{ $newProduct['unit_'.$lang] }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="rec-block__footer">
                                                    <a
                                                        class="link rec-block__link"
                                                        href="{{
                                                            (int)$category->id !== 10382
                                                            ? route('pages.catalog.ternary_index', [$category->slug, $second_level_category->slug]).'?new='.$newTag->id
                                                            //: route('pages.collections.catalog_index', [$category->slug, $second_level_category->slug])
                                                            : 'javascript:void(0);'
                                                        }}"
                                                        aria-label="{{ __('go_to_ternary_catalog_page') }}"
                                                    >
                                                        <span class="link__text">{{ __('new_product') }}</span>
                                                        @if((int)$category->id !== 10382)
                                                            <span class="link__control" aria-hidden="true">
                                                                <svg role="img" aria-hidden="true" width="20" height="20">
                                                                    <use xlink:href="#svg-icon-down-arrow"></use>
                                                                </svg>
                                                            </span>
                                                        @endif
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
                                                            @if(!$promotionProduct->images_table->isEmpty())
                                                                <picture class="rec-block__img">
                                                                    <source srcset="{{$promotionProduct->images_table[0]->getImageResizedSmall()}}" media="(min-width: 535px)">
                                                                    <source srcset="{{$promotionProduct->images_table[0]->getImageResizedMiddle()}}" media="(min-width: 0px)">
                                                                    <img src="{{$promotionProduct->images_table[0]->getImageResizedSmall()}}" alt="{{$promotionProduct['name_'.$lang]}}">
                                                                </picture>
                                                            @else
                                                                <img src="{{$promotionProduct->getPreviewPicture()}}" alt="{{$promotionProduct['name_'.$lang]}}">
                                                            @endif
                                                        </a>
                                                        @php $promotion_discount = get_promotion_discount_attribute_for_product($promotionProduct->tags) @endphp
                                                        @if((int)$category->id !== 10382)
                                                            @if((int)$promotion_discount !== 0)
                                                                <ul class="list list_unstyled rec-block__marks marks-list">
                                                                    <li class="list__item list__item_num bg_red">{{ $promotion_discount }}%</li>
                                                                </ul>
                                                            @else
                                                                <ul class="list list_unstyled rec-block__marks marks-list">
                                                                    <li class="list__item list__item_num {{$saleTag->class}}">
                                                                        {{ $saleTag['name_'.$lang] }}
                                                                    </li>
                                                                </ul>
                                                            @endif
                                                        @else
                                                            <ul class="list list_unstyled rec-block__marks marks-list">
                                                                <li class="list__item list__item_num {{$saleTag->class}}">
                                                                    {{ $saleTag['name_'.$lang] }}
                                                                </li>
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
                                                            <span class="currency">{{__('currency_name')}}{{ $newProduct['unit_'.$lang] }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="rec-block__footer">
                                                    <a
                                                        class="link rec-block__link"
                                                        href="{{
                                                            (int)$category->id !== 10382
                                                            ? route('pages.catalog.ternary_index', [$category->slug, $second_level_category->slug]).'?sale='.$saleTag->id
                                                            //: route('pages.collections.catalog_index', [$category->slug, $second_level_category->slug])
                                                            : 'javascript:void(0);'
                                                        }}"
                                                        aria-label="{{ __('go_to_ternary_catalog_page') }}"
                                                    >
{{--                                                        @if((int)$category->id !== 10382)--}}
{{--                                                            <span class="link__text">{{ __('promotions') }}</span>--}}
{{--                                                        @else--}}
                                                            <span class="link__text">{{ __('sale') }}</span>
{{--                                                        @endif--}}
                                                        @if((int)$category->id !== 10382)
                                                            <span class="link__control" aria-hidden="true">
                                                                <svg role="img" aria-hidden="true" width="20" height="20">
                                                                    <use xlink:href="#svg-icon-down-arrow"></use>
                                                                </svg>
                                                            </span>
                                                        @endif
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
                                                                <a
                                                                    class="rec-block__brand"
                                                                    href="{{ $brand['link_to_single_brand_page'] }}"
                                                                    aria-label="{{ __('go_to_ternary_catalog_page') }}"
                                                                    title="{{ $brand['name'] }}"
                                                                >
                                                                    <img src="{{ $brand['image'] }}" alt="{{ $brand['name'] }}">
                                                                </a>
                                                                {{-- 10382 -> id Плитки--}}
{{--                                                                @if((int)$category->id === 10382)--}}
{{--                                                                    <a--}}
{{--                                                                        class="rec-block__brand"--}}
{{--                                                                        href="{{ route('pages.collections.catalog_index', [$category->slug, $second_level_category->slug]).'?brand='.$brand['id'] }}"--}}
{{--                                                                        aria-label="{{ __('go_to_ternary_catalog_page') }}"--}}
{{--                                                                        title="{{ $brand['name'] }}"--}}
{{--                                                                    >--}}
{{--                                                                        <img src="{{ $brand['image'] }}" alt="{{ $brand['name'] }}">--}}
{{--                                                                    </a>--}}
{{--                                                                @else--}}
{{--                                                                    <a--}}
{{--                                                                        class="rec-block__brand"--}}
{{--                                                                        href="{{ route('pages.catalog.ternary_index', [$category->slug, $second_level_category->slug]).'?brand='.$brand['id'] }}"--}}
{{--                                                                        aria-label="{{ __('go_to_ternary_catalog_page') }}"--}}
{{--                                                                        title="{{ $brand['name'] }}"--}}
{{--                                                                    >--}}
{{--                                                                        <img src="{{ $brand['image'] }}" alt="{{ $brand['name'] }}">--}}
{{--                                                                    </a>--}}
{{--                                                                @endif--}}
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
                @endforeach
            </div>
        </div>
    </section>
</main>
@endsection
