@extends('layouts.main')

@php
    $company_name = get_setting_by_key('company_name');
    $title = $company_name. ' - '. __('order_status');
@endphp
@section('title', $title)
@section('description', __('order_status') ?? '')
@section('keywords', __('checkout_order').__('order_current_status', ['id' => $order->id, 'status_display_value' => $order->status_display_value]))

@section('content')
    <main class="main-content" id="main-content">
        <section class="section section_inner-page section_error-404 section_error section_error-404">
            <div class="section__header">
                <div class="container">
                    <div class="section__breadcrumbs">
                        <ul class="list list_unstyled breadcrumbs-list">
                            <li class="list__item"><a class="link" href="{{ route('homepage').'/'.$lang }}">{{ __('homepage') }}</a></li>
                            <li class="list__item"><a class="link" href="{{ route('pages.cart.index') }}">{{ __('basket') }}</a></li>
                            <li class="list__item"><a class="link active" href="javascript: void(0);">{{ __('order_status') }}</a></li>
                        </ul>
                    </div>
                    <div class="section__title section__title_style1 error-title">
                        <h1>{{ __('order_status') }}</h1>
                    </div>
                </div>
            </div>
            <div class="section__body">
                <div class="error-description">
                    <div class="container">
                        <div class="error-description__title section__title">
                            <h2>{{ __('order_current_status', ['id' => $order->id, 'status_display_value' => $order->status_display_value]) }}</h2>
                        </div>
                        <a class="home-btn btn btn_default btn_dark btn_with-icon" href="{{ route('homepage') }}">
                            <span class="btn__icon" aria-hidden="true">
                                <svg role="img" width="30" height="30">
                                    <use xlink:href="#svg-icon-home"></use>
                                </svg>
                            </span>
                            <span class="btn__text">{{ __('to_homepage') }}</span>
                        </a>
                    </div>
                </div>
                <div class="error-popular-goods" style="padding-top: 30px">
                    <cart-recommended-onsuccess language="{{ $lang }}" recommended_products_default="{{ $json_encoded_recommended_products }}"></cart-recommended-onsuccess>
                </div>
            </div>
        </section>
    </main>
@endsection
