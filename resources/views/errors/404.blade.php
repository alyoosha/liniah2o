@extends('layouts.main')

@section('content')
    <main class="main-content" id="main-content">
        <section class="section section_inner-page section_error-404 section_error section_error-404">
            <div class="section__header">
                <div class="container">
                    <div class="section__breadcrumbs">
                        <ul class="list list_unstyled breadcrumbs-list">
                            <li class="list__item"><a class="link" href="{{ route('homepage') }}">{{ __('homepage') }}</a></li>
                            <li class="list__item"><a class="link active" href="javascript: void(0);">404</a></li>
                        </ul>
                    </div>
                    <div class="section__title section__title_style1 error-title">
                        <h1>404</h1>
                        <span class="add-text">{{ __('page_not_found') }}</span>
                    </div>
                </div>
            </div>
            <div class="section__body">
                <div class="error-description">
                    <div class="container">
                        <div class="error-description__title section__title">
                            <h2>{{ __('page_not_found_maybe_missed') }}</h2>
                        </div>
                        <a class="reload-btn btn btn_default btn_dark btn_with-icon" href="{{ route('homepage') }}">
                            <span class="btn__icon" aria-hidden="true">
                                <svg role="img" width="30" height="30">
                                    <use xlink:href="#svg-icon-home"></use>
                                </svg>
                            </span>
                            <span class="btn__text">{{ __('to_homepage') }}</span>
                        </a>
                    </div>
                </div>
                <div class="error-popular-goods" style="padding-top: 20px;">
                    <cart-recommended-onsuccess language="{{ $lang }}" recommended_products_default="{{ $json_encoded_recommended_products }}"></cart-recommended-onsuccess>
                </div>
            </div>
        </section>
    </main>
@endsection
