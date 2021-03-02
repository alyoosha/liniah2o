@extends('layouts.main')

@php
    $company_name = get_setting_by_key('company_name');
    $title = $company_name. ' - '. __('catalog').' '.__('collection').' '.$collection['name_' . $lang];
@endphp
@section('title', $title)
@section('description', $collection['name_' . $lang] ?? '')
@section('keywords', get_product_keywords_from_breadcrumbs($collection['breadcrumbs']) . $collection['name_' . $lang] ?? '')

@section('content')
    <main class="main-content" id="main-content">
        <section class="section section_inner-page section_product">
            <div class="section__header">
                <div class="container">
                    <div class="section__breadcrumbs">
                        <ul class="list list_unstyled breadcrumbs-list">
                            <li class="list__item">
                                <a class="link" href="/{{ $lang }}">{{ __('homepage') }}</a>
                            </li>
                            @foreach($collection['breadcrumbs'] as $bc)
                                <li class="list__item"><a class="link" href="/{{ $lang }}{{ $bc['link'] }}">{{ $bc['name'] }}</a></li>
                            @endforeach
                            <li class="list__item"><a class="link active" href="/{{ $lang }}{{$collection['link']}}">{{ $collection['name_' . $lang] }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="section__body product-block">
                <div class="product-block__main collection">
                    <div class="container">
                        <div class="row no-gutters">
                            <div class="col-12">
                                <a class="product-block__brand brand-block" href="/{{ $lang }}/brands" aria-label="{{ __('go_to_brand') }} {{ $collection['brand_name'] }}">
                                    <div class="brand-block__img" aria-hidden="true">
                                        <img src="{{ asset('storage/brands/' . $collection['brand_image']) }}" alt="{{ $collection['brand_name'] }}">
                                    </div>
                                    <div class="brand-block__country">{{ $collection['country_name_' . $lang] }}</div>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-5">
                                <ul class="list list_unstyled product-block__socials">
                                    <li class="list__item list__item_has-child dropdown">
                                        <button class="btn btn_share js-share" type="button" aria-label="{{ __('share') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <svg class="btn__icon" role="img" aria-hidden="true" width="24" height="24">
                                                <use xlink:href="#svg-icon-share"></use>
                                            </svg>
                                        </button>
                                        <ul class="list list_unstyled dropdown-menu bg_white" aria-label="{{ __('share') }}">
                                            <li class="list__item">
                                                <a :href="'http://instagram.com/liniah2o?igshid=1bif5w0bd31by?ref=badge'"
                                                   class="btn btn_socials"
                                                   rel="noopener nofollow" aria-label="Instagram">
                                                    <svg class="btn__icon" role="img" aria-hidden="true" width="24" height="24">
                                                        <use xlink:href="#svg-icon-instagram"></use>
                                                    </svg>
                                                </a>
                                            </li>
                                            <li class="list__item">
                                                <a class="btn btn_socials" href="javascript: void(0);" rel="noopener nofollow" aria-label="Facebook" onclick=" open('http://www.facebook.com/sharer.php?u=' + window.location.href,'displayWindow','width=520,height=300,left=350,top=170,status=no,toolbar=no,menubar=no');">
                                                    <svg class="btn__icon" role="img" aria-hidden="true" width="24" height="24">
                                                        <use xlink:href="#svg-icon-facebook"></use>
                                                    </svg>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                                <div class="product-block__slider">
                                    {{--@if(!empty($collection['tags']))--}}
                                        {{--<ul class="list list_unstyled marks-list">--}}
                                            {{--@foreach($collection['arTags'] as $tag)--}}
                                                {{--@if($tag['discount'] == 0)--}}
                                                    {{--<li class="list__item {{ $tag['class'] ? $tag['class'] : '' }}">--}}
                                                        {{--@if($tag['show_name'])--}}
                                                            {{--{{ $tag['name_' . $lang] }}--}}
                                                        {{--@endif--}}
                                                        {{--@empty(!$tag['icon'])--}}
                                                            {{--<span class="marks-list__icon" aria-label="{{ $tag['name_' . $lang] }}">--}}
                                                                 {{--<svg role="img" aria-hidden="true" width="16" height="16">--}}
                                                                     {{--<use xlink:href="#{{ $tag['icon ']}}"></use>--}}
                                                                 {{--</svg>--}}
                                                             {{--</span>--}}
                                                        {{--@endempty--}}
                                                    {{--</li>--}}
                                                {{--@endif--}}
                                            {{--@endforeach--}}
                                        {{--</ul>--}}
                                    {{--@endif--}}
                                    <div class="swiper-container slider_main js-product-slider-main">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <a class="product-block__slide js-lightbox-gallery" href="{{ $collection['imgPreview'] }}" alt="{{ $collection['name_' . $lang] }}" data-rel="lightcase:product:slideshow" title="{{ $collection['name_' . $lang] }}" aria-label="{{ $collection['name_' . $lang] }}">
                                                    <div class="background-img" aria-hidden="true">
                                                        <img src="{{ $collection['imgPreview'] }}" alt="{{ $collection['name_' . $lang] }}">
                                                    </div>
                                                </a>
                                            </div>
                                            @for($i = 1; $i < count($collection['images']); ++$i)
                                                <div class="swiper-slide">
                                                    <a class="product-block__slide js-lightbox-gallery" href="{{ Storage::disk('public')->url('collections/') . $collection['images'][$i]  }}" data-rel="lightcase:product:slideshow" title="{{ $collection['name_' . $lang] }}" aria-label="{{ $collection['name_' . $lang] }}">
                                                        <div class="background-img" aria-hidden="true">
                                                            <img src="{{ asset('storage/collections/' . $collection['images'][$i])  }}" alt="{{ $collection['name_' . $lang] }}"
                                                            >
                                                        </div>
                                                    </a>
                                                </div>
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="swiper-container slider_thumbs js-product-slider-thumbs">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <div class="product-block__slide" aria-label="{{ $collection['name_' . $lang] }}">
                                                    <div class="background-img" aria-hidden="true">
                                                        <img src="{{ $collection['imgPreview']  }}" alt="{{ $collection['name_' . $lang] }}">
                                                    </div>
                                                </div>
                                            </div>
                                            @for($i = 1; $i < count($collection['images']); ++$i)
                                                <div class="swiper-slide">
                                                    <div class="product-block__slide" aria-label="{{ $collection['name_' . $lang] }}">
                                                        <div class="background-img" aria-hidden="true">
                                                            <img src="{{ asset('storage/collections/' . $collection['images'][$i])  }}" alt="{{ $collection['name_' . $lang] }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-7">
                                <div class="product-block__info">
                                    <div class="product-block__title section__title collection-title">
                                        <div class="collection-title__icon" aria-hidden="true">
                                            <svg role="img" width="30" height="30">
                                                <use xlink:href="#svg-icon-collection"></use>
                                            </svg>
                                        </div>
                                        <div class="collection-title__content">
                                            <div class="collection-title__category">
                                                <h2>{{ $collection['category']['name_' . $lang] }}</h2>
                                            </div>
                                            <div class="collection-title__label">
                                                <h1>{{ $collection['name_' . $lang] }}</h1>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="list list_unstyled product-block__info-list row align-items-center">
                                        <li class="col-12 col-md-auto">
                                            <div class="product-block__code">
                                                <span class="title">{{ __('products_in_collection') }}:</span>

                                                <span class="count color_black">{{ count(json_decode(json_decode($collection['product_array'])->ids)) }}</span>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="product-block__price">
                                        <span class="text">{{ __('price_from_lowercase') }}</span>
                                        <span class="cost">{{ get_price_for_html($collection['price']) }}</span>
                                        <span class="currency">{{ __('currency_name') }}{{ $collection['unit_'.$lang] }}</span>
                                    </div>
                                    <div class="collection-previews">
                                        <div class="swiper-container js-collection-previews">
                                            <div class="swiper-wrapper">
                                                @foreach($collection['products'] as $product)
                                                    <div class="swiper-slide">
                                                        <a class="collection-previews-block" href="{{ $product['link'] }}" aria-label="{{ $product['name_' . $lang] }}" title="{{ $product['name_' . $lang] }}">
                                                            <div class="collection-previews-block__img background-img">
                                                                @if(!empty($product['imagesResized']))
                                                                    <picture>
                                                                        @if(isset($product['imagesResized'][0]))
                                                                            <source srcset="{{$product['imagesResized'][0]}}" media="(min-width: 535px)">
                                                                        @endif
                                                                        @if(isset($product['imagesResized'][1]))
                                                                            <source srcset="{{$product['imagesResized'][1]}}" media="(min-width: 0px)">
                                                                        @endif
                                                                        @if(isset($product['imagesResized'][0]))
                                                                            <img src="{{$product['imagesResized'][0]}}" alt="{{$product['name_'.$lang]}}">
                                                                        @endif
                                                                    </picture>
                                                                @else
                                                                    <img src="{{$product['imgPreview']}}" alt="{{$product['name_'.$lang]}}">
                                                                @endif
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
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
                                    <div class="collection-description section__description">
                                        <p>{{ $collection['description_'.$lang] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @include('pages.collections.block-products-in-collection')

            </div>
        </section>

        @if($related_products->count() > 0)
            <also-buy-with-card default_related_products="{{ json_encode($related_products) }}" language="{{ $lang }}"></also-buy-with-card>
        @endif
        <similar-and-watched-card default_similar_products="{{ json_encode($similar_products) }}" default_watched_products="{{ json_encode($watched_products) }}" language="{{ $lang }}"></similar-and-watched-card>
    </main>
@endsection

@push('scripts')
    <script>
        window.document.addEventListener('DOMContentLoaded', function() {
            if(window.document.querySelector('.js-collection-previews').length) {
                var collectionPreviewsSwiper = new Swiper('.js-collection-previews', {
                    speed: 1200,
                    autoplay: 5000,
                    spaceBetween: 1,
                    slidesPerView: 3,
                    followFinger: false,
                    watchSlidesProgress: true,
                    centerInsufficientSlides: true,
                    watchSlidesVisibility: true,
                    pagination: false,
                    navigation: {
                        nextEl: '.collection .swiper-button-next',
                        prevEl: '.collection .swiper-button-prev',
                    },
                    breakpoints: {
                        576: {
                            slidesPerView: 4,
                        },
                        768: {
                            slidesPerView: 6,
                        },
                        1200: {
                            slidesPerView: 4,
                        },
                        1550: {
                            slidesPerView: 5,
                        }
                    },
                });
            }
        });
    </script>
@endpush
