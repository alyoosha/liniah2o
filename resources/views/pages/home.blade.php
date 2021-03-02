@extends('layouts.main')

@section('title', __('Linia H2O'))

@section('content')
    <main class="main-content" id="main-content">
        @if($blocks['promo_banner_'.$lang])
            <div class="promocode-block bg_green color_white">
                <div class="container">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-12 col-sm-auto">
                            {!! $blocks['promo_banner_'.$lang] !!}
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <section class="section section_mp-banners bg_white" id="banners">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-xl-6">
                        @if(!$slides->isEmpty())
                            <div class="swiper-container js-banners-slider">
                                <div class="swiper-wrapper">
                                    @for($s = 0; $s < count($slides); ++$s)
                                        <div class="swiper-slide">
                                            <div class="banner-block banner-block_main">
                                                <div class="background-img" aria-hidden="true">
                                                    <picture>
                                                        {{-- Desktop --}}
                                                        @php
                                                            $desktop_webp = str_replace(['.png', '.jpg', '.jpeg'], ['.webp', '.webp', '.webp'], $slides[$s]['image_' . $lang]);
                                                        @endphp
                                                        @if(\Illuminate\Support\Facades\Storage::disk('public')->exists($desktop_webp))
                                                            <source
                                                                type="image/webp"
                                                                srcset="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($desktop_webp) }}"
                                                                media="(min-width: 450px)"
                                                            >
                                                        @endif
                                                        <source
                                                            srcset="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($slides[$s]['image_' . $lang]) }}"
                                                            media="(min-width: 450px)"
                                                        >
                                                        {{-- Mobile --}}
                                                        @php
                                                            $mobile_webp = str_replace(['.png', '.jpg', '.jpeg'], ['.webp', '.webp', '.webp'], $slides[$s]['image_mobile_' . $lang]);
                                                        @endphp
                                                        @if(\Illuminate\Support\Facades\Storage::disk('public')->exists($mobile_webp))
                                                            <source
                                                                type="image/webp"
                                                                srcset="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($mobile_webp) }}"
                                                                media="(min-width: 0px)"
                                                            >
                                                        @endif
                                                        <source
                                                            srcset="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($slides[$s]['image_mobile_' . $lang]) }}"
                                                            media="(min-width: 0px)"
                                                        >
                                                        {{-- Default --}}
                                                        <img
                                                            src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($slides[$s]['image_' . $lang]) }}"
                                                            alt="{{$slides[$s]['ceo_text_' . $lang] }}"
                                                        >
                                                    </picture>
                                                </div>
                                                <div class="banner-block__footer">
                                                    <div class="row">
                                                        <a class="banner-block__link_main" href="{{ $slides[$s]['link_' . $lang] }}" aria-label="{{$slides[$s]['ceo_text_' . $lang] }}"></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                                <div class="swiper-pagination"></div>
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>
                            </div>
                        @endempty
                    </div>
                    @empty(!$blocks)
                        <div class="col-12 col-xl-6">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <!-- <div class="banner-block banner-block_inner"> -->
                                    <a class="banner-block banner-block_inner" href="{{ $blocks->{'block1_link_' . $lang} }}">
                                        <div class="banner-block__body">
                                            <!-- <a class="banner-block__title section__title section__title_style4" href="{{ $blocks->{'block1_link_' . $lang} }}"> -->
                                            <span class="banner-block__title section__title section__title_style4">
                                                <h2>
                                                    @php
                                                        echo $blocks['block1_title_' . $lang]
                                                    @endphp
                                                </h2>
                                            </span>
                                            <!-- </a> -->
                                            <div class="section__description banner-block__descr">
                                                <p>{{ $blocks->{'block1_description_' . $lang} }}</p>
                                            </div>
                                        </div>
                                        <div class="banner-block__footer">
                                            <div class="section__description banner-block__descr">
                                                <span class="banner-block__discount">{{ $blocks->{'block1_discount_' . $lang} }}</span>
                                            </div>
                                        </div>
                                        <!-- <div class="banner-block__footer">
                                            <a class="link banner-block__link banner-block__link_with-icon" href="{{ $blocks->{'block1_link_' . $lang} }}">
                                                <span class="link__icon" aria-hidden="true">
                                                    <svg role="img" aria-hidden="true" width="24" height="24">
                                                        <use xlink:href="#svg-icon-eye"></use>
                                                    </svg>
                                                </span>
                                                <span class="link__text">{{ __('watch') }}</span>
                                            </a>
                                        </div> -->
                                    </a>
                                    <!-- </div> -->
                                </div>
                                <div class="col-12 col-md-6">
                                    <!-- <div class="banner-block banner-block_inner"> -->
                                    <a class="banner-block banner-block_inner" href="{{ $blocks->{'block2_link_' . $lang} }}">
                                        <div class="banner-block__body">
                                            <!-- <a class="banner-block__title section__title section__title_style4" href="{{ $blocks->{'block2_link_' . $lang} }}"> -->
                                            <span class="banner-block__title section__title section__title_style4">
                                                <h2>
                                                    @php
                                                        echo $blocks['block2_title_' . $lang]
                                                    @endphp
                                                </h2>
                                            </span>
                                            <!-- </a> -->
                                            <div class="section__description banner-block__descr">
                                                <p>{{ $blocks->{'block2_description_' . $lang} }}</p>
                                            </div>
                                            <div class="banner-block__footer">
                                                <div class="section__description banner-block__descr">
                                                    <span class="banner-block__discount">{{ $blocks->{'block2_discount_' . $lang} }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="banner-block__footer">
                                            <a class="link banner-block__link banner-block__link_with-icon" href="{{ $blocks->{'block2_link_' . $lang} }}">
                                                <span class="link__icon" aria-hidden="true">
                                                    <svg role="img" aria-hidden="true" width="24" height="24">
                                                        <use xlink:href="#svg-icon-eye"></use>
                                                    </svg>
                                                </span>

                                                <span class="link__text">{{ __('watch') }}</span>
                                            </a>
                                        </div> -->
                                    </a>
                                    <!-- </div> -->
                                </div>
                            </div>
                        </div>
                    @endempty
                </div>
            </div>
        </section>
        <section class="section section_mp-recomendation" id="recomendation">
            <div class="container">
                <div class="section__title section__title_style3">
                    <h2>
                        <span class="line">{{ __('homepage_about_us_first_line') }}</span>
                        <span class="line">{{ __('homepage_about_us_second_line') }}</span>
                    </h2>
                </div>
                <homepage-recommended
                    language="{{ $lang }}"
                    catalog_path_default="{{ $catalog_path }}"
                    recommended_products_default="{{ $json_encoded_recommended_products }}"
                ></homepage-recommended>
            </div>
        </section>
        <section class="section section_mp-about" id="about">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-8 col-lg-7 col-xl-5">
                        <div class="section__header bg_gray-dark color_white">
                            <div class="section__title section__title_style1">
                                <h2>{{ $aboutUsBlock['srortly_about_us_title_'.$lang] }}</h2>
                            </div>
                            <div class="section__description">
                                {!! $aboutUsBlock['srortly_about_us_content_'.$lang] !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-5 col-xl-7">
                        <div class="section__controls text-right">
                            <div class="section__controls-all"><a href="{{ route('pages.about.index') }}">{{ __('know_about_us_more') }}</a></div>
                        </div>
                    </div>
                </div>
                <div class="section__img" aria-hidden="true">
                    <div class="background-img">
                        <img src="{{ \Storage::disk('public')->url($aboutUsBlock->background_image) }}" alt="Фоновое изображение">
                    </div>
                </div>
            </div>
        </section>
        <section class="section section_mp-odds" id="odds">
            <div class="container">
                <div class="row">
                    <div class="col-8 col-md-8">
                        <div class="section__title section__title_style1">
                            <h2>{{ __('odds') }} {{ get_setting_by_key('company_name') }}</h2>
                        </div>
                    </div>
                </div>
                <ul class="list list_unstyled odds-list row justify-content-start justify-content-lg-end no-gutters">
                    @isset($oddsBlock)
                        @foreach($oddsBlock as $odd)
                            <li class="list__item col-12 col-md-6 col-lg-4 col-xl-3">
                                <div class="odd-block">
                                    @if($odd['image'])
                                        <div class="odd-block__icon" aria-hidden="true">
                                            <svg role="img" aria-hidden="true" width="60" height="60">
                                                @php preg_match("/icon-(.*)\.svg$/", \Storage::disk('public')->url('/homepage/'.$odd['image']), $m); @endphp
                                                <use xlink:href="#svg-icon-{{ $m[1] }}"></use>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="odd-block__title section__title section__title_style2">
                                        <h3>{{ $odd['title_'.$lang] }}</h3>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    @endisset
                </ul>
            </div>
        </section>
        <section class="section section_brands" id="brands">
            <div class="container">
                <div class="row align-items-end">
                    <div class="col-12 col-md-8 col-xl-7">
                        <div class="section__header bg_gray-dark color_white">
                            <div class="section__title section__title_style1">
                                <h2>{{ __('worldwide_brands') }}</h2>
                            </div>
                            <div class="section__description">
                                <p>{{ __('offer_wide_choice_of_products') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-xl-5">
                        <div class="section__controls">
                            <div class="section__controls-all"><a href="{{ route('pages.brands.index') }}">{{ __('see_all') }}</a></div>
                            <div class="section__controls-nav swiper-nav">
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
                    </div>
                </div>
            </div>
            <div class="section__content bg_white">
                <div class="container">
                    <div class="swiper-container js-brands-slider">
                        <div class="swiper-wrapper">
                            @foreach($brands as $brand)
                                <div class="swiper-slide">
                                    <a class="brand-block" href="{{ $brand->link_to_brand_page }}" aria-label="{{ __('go_to_ternary_catalog_page') }}" title="{{ $brand->name }}">
                                        <img class="brand-block__img" src="{{ $brand->preview_image }}" alt="{{ $brand->name }}"/>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
