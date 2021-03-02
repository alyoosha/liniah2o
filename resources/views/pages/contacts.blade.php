@extends('layouts.main')

@section('title', $contactsInfo->seo_title ?? '')
@section('description', $contactsInfo->seo_description)
@section('keywords', $contactsInfo->seo_keywords)

@section('content')
    <main class="main-content" id="main-content">
        <section class="section section_inner-page section_map-contacts">
            <div class="section__header">
                <div class="container">
                    <div class="section__breadcrumbs">
                        <ul class="list list_unstyled breadcrumbs-list">
                            <li class="list__item"><a class="link" href="{{ route('homepage').'/'.$lang }}">{{ __('homepage') }}</a></li>
                            <li class="list__item"><a class="link active" href="javascript: void(0);">{{ __('contacts') }}</a></li>
                        </ul>
                    </div>
                    <div class="header-title">
                        <div class="header-title__main section__title section__title_style1">
                            <h1>{{ __('contacts') }}<span class="header-title__add-text section__title">LiniaH2O</span></h1>
                        </div>
                        <div class="header-title__shops">
                            <p class="link">
                                <div class="link__icon">
                                    <svg role="img" aria-hidden="true" width="30" height="30">
                                        <use xlink:href="#svg-icon-pin"></use>
                                    </svg>
                                </div>
                                <div class="link__text section__title">{{ __('shops') }} LiniaH2O</div>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section__body bg_white">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5">
                            <div class="info-block">
                                <div class="info-content address-block">
                                    <div class="title section__title">
                                        <h3>{{ __('address') }}</h3>
                                    </div>
                                    <address class="address">
                                        <div class="address__icon">
                                            <svg role="img" aria-hidden="true" width="26" height="26">
                                                <use xlink:href="#svg-icon-pin"></use>
                                            </svg>
                                        </div>
                                        <a class="address__text js-pin js-zoom-map shop-pin" href="javascript: void(0);" data-lat="{{ $contactsInfo->address_coords_first_map_pin_lat }}" data-lng="{{ $contactsInfo->address_coords_first_map_pin_lng }}">{{ $contactsInfo['address_coords_first_'.$lang] }}</a>
                                    </address>
                                    <address class="address">
                                        <div class="address__icon">
                                            <svg role="img" aria-hidden="true" width="26" height="26">
                                                <use xlink:href="#svg-icon-pin"></use>
                                            </svg>
                                        </div>
                                        <a class="address__text js-pin js-zoom-map shop-pin" href="javascript: void(0);" data-lat="{{ $contactsInfo->address_coords_second_map_pin_lat }}" data-lng="{{ $contactsInfo->address_coords_second_map_pin_lng }}">{{ $contactsInfo['address_coords_second_'.$lang] }}</a>
                                    </address>
                                    <address class="address">
                                        <div class="address__icon">
                                            <svg role="img" aria-hidden="true" width="26" height="26">
                                                <use xlink:href="#svg-icon-pin"></use>
                                            </svg>
                                        </div>
                                        <a class="address__text js-pin js-zoom-map shop-pin" href="javascript: void(0);" data-lat="{{ $contactsInfo->address_coords_third_map_pin_lat }}" data-lng="{{ $contactsInfo->address_coords_third_map_pin_lng }}">{{ $contactsInfo['address_coords_third_'.$lang] }}</a>
                                    </address>
                                    <address class="address">
                                        <div class="address__icon">
                                            <svg role="img" aria-hidden="true" width="26" height="26">
                                                <use xlink:href="#svg-icon-pin"></use>
                                            </svg>
                                        </div>
                                        <a class="address__text js-pin js-zoom-map shop-pin" href="javascript: void(0);" data-lat="{{ $contactsInfo->address_coords_forth_map_pin_lat }}" data-lng="{{ $contactsInfo->address_coords_forth_map_pin_lng }}">{{ $contactsInfo['address_coords_forth_'.$lang] }}</a>
                                    </address>
                                </div>
                                <div class="info-content address-block">
                                    <div class="title section__title">
                                        <h3>{{ __('online_shop') }}</h3>
                                    </div>
                                    <address class="address">
                                        <div class="address__icon">
                                            <svg role="img" aria-hidden="true" width="26" height="26">
                                                <use xlink:href="#svg-icon-pin"></use></svg>
                                        </div>
                                        <a class="address__text js-pin js-zoom-map" href="javascript: void(0);" data-lat="{{ $contactsInfo->online_shop_address_coords_map_pin_lat }}" data-lng="{{ $contactsInfo->online_shop_address_coords_map_pin_lng }}">{{ $contactsInfo['online_shop_address_'.$lang] }}</a>
                                    </address>
                                    <div class="phone-email-wrapper">
                                        <div class="phone">
                                            <div class="phone__icon"><svg role="img" aria-hidden="true" width="26" height="26"><use xlink:href="#svg-icon-phone"></use></svg></div>
                                            <div class="phone__text">
                                                <a class="line" href="tel:{{ str_replace([' ', '(', ')'], ['', '', ''], $contactsInfo->online_shop_phone) }}">{{ $contactsInfo->online_shop_phone }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="info-content service-block">
                                    <div class="title section__title">
                                        <h3>{{ __('service_center') }}</h3>
                                    </div>
                                    <address class="address">
                                        <div class="address__icon">
                                            <svg role="img" aria-hidden="true" width="26" height="26">
                                                <use xlink:href="#svg-icon-pin"></use></svg>
                                        </div>
                                        <a class="address__text js-pin js-zoom-map" href="javascript: void(0);" data-lat="{{ $contactsInfo->service_address_coords_map_pin_lat }}" data-lng="{{ $contactsInfo->service_address_coords_map_pin_lng }}">{{ $contactsInfo['service_coords_'.$lang] }}</a>
                                    </address>
                                    <div class="phone-email-wrapper">
                                        <div class="phone">
                                            <div class="phone__icon"><svg role="img" aria-hidden="true" width="26" height="26"><use xlink:href="#svg-icon-phone"></use></svg></div>
                                            <div class="phone__text">
                                                <a class="line" href="tel:{{ str_replace([' ', '(', ')'], ['', '', ''], $contactsInfo->service_phone) }}">{{ $contactsInfo->service_phone }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
{{--                                <div class="info-content delivery-block">--}}
{{--                                    <div class="title section__title">--}}
{{--                                        <h3>{{ __('delivery_dep') }}</h3>--}}
{{--                                    </div>--}}
{{--                                    <div class="phone">--}}
{{--                                        <div class="phone__icon"><svg role="img" aria-hidden="true" width="26" height="26"><use xlink:href="#svg-icon-phone"></use></svg></div>--}}
{{--                                        <div class="phone__text"><a class="line" href="tel:{{ str_replace([' ', '(', ')'], ['', '', ''], $contactsInfo->delivery_phone) }}">{{ $contactsInfo->delivery_phone }}</a></div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                <div class="info-content service-block">
                                    <div class="title section__title">
                                        <h3>{{ __('requisites') }}</h3>
                                    </div>
                                    <address class="address">
                                        <div class="address__icon">
                                            <svg role="img" aria-hidden="true" width="26" height="26">
                                                <use xlink:href="#svg-icon-pin"></use>
                                            </svg>
                                        </div>
                                        <a href="javascript: void(0);" class="address__text js-pin js-zoom-map" data-lat="47.040665" data-lng="28.829008">{{ $contactsInfo['requisites_coords_'.$lang] }}</a>
                                    </address>
                                    <div class="phone-email-wrapper">
                                        <div class="phone">
                                            <div class="phone__icon">
                                                <svg role="img" aria-hidden="true" width="26" height="26">
                                                    <use xlink:href="#svg-icon-order2"></use>
                                                </svg>
                                            </div>
                                            <div class="phone__text">
                                                <div class="line">{!! $contactsInfo->requisites_number !!}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-7">
                            <div class="shop-reference-block">
                                <div class="shop-reference-block__wrapper bg_gray-dark">
                                    <div class="row no-gutters">
                                        <div class="col-xl-6">
                                            <div class="announcement-block">
                                                <div class="section__title">
                                                    <h3>
                                                        <div class="line">{{ __('any_questions') }}</div>
                                                        <div class="line">{{ __('contact_us') }}</div>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="schedule-block">
                                                <div class="phone">
                                                    <div class="phone__icon"><svg role="img" aria-hidden="true" width="26" height="26"><use xlink:href="#svg-icon-phone"></use></svg></div>
                                                    <div class="phone__text"><a class="line" href="tel:{{ str_replace([' ', '(', ')'], ['', '', ''], $contactsInfo->map_phone) }}">{{ $contactsInfo->map_phone }}</a></div>
                                                 </div>
                                                <div class="schedule" style="margin-bottom: 10px;">
                                                    <div class="schedule__icon"><svg role="img" aria-hidden="true" width="26" height="26"><use xlink:href="#svg-icon-wall-clock"></use></svg></div>
                                                    <div class="schedule__text">{{ $contactsInfo['working_hours_first_'.$lang] }}</div>
                                                </div>
                                                <div class="schedule">
                                                    <div style="padding-left: 40px;" class="schedule__text">{{ $contactsInfo['working_hours_second_'.$lang] }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="section__map shop-reference-block__map">
                                    <div class="map-block js-map shop-reference-block__map" id="map-block" data-map-lat="{{ $contactsInfo->map_pin_lat }}" data-map-lng="{{ $contactsInfo->map_pin_lng }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    {{--<script id="google-map-script" defer="" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCsq4WafTF6GmiZvsnq7FWgEoiAfrYU1cs"></script>--}}
    <script>
        let h1 = document.querySelector('h1');

        if(document.title.length === 0) {
            document.title = h1.firstChild.textContent + ' ' + h1.firstElementChild.textContent;
        }
    </script>
@endpush
