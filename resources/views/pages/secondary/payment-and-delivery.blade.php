@extends('layouts.main')

@php
    $company_name = get_setting_by_key('company_name');
    $title = $company_name. ' - '. $page['seo_title_' . $lang];
@endphp
@section('title', $title)
@section('description', $page['seo_description'])
@section('keywords', $page['seo_keywords'])

@section('content')

    <main class="main-content" id="main-content">
        <section class="section section_inner-page section_payment-delivery">
            <div class="section__header">
                <div class="container">

                    <div class="section__breadcrumbs">
                        <ul class="list list_unstyled breadcrumbs-list">
                            <li class="list__item">
                                <a class="link" href="/{{ $lang }}">{{ __('homepage') }}</a>
                            </li>

                            <li class="list__item">
                                <a class="link active" href="javascript: void(0);">{{ __('payment_and_delivery') }}</a>
                            </li>
                        </ul>
                    </div>

                    <div class="section__title section__title_style1">
                        <h1>{{ __('payment_and_delivery') }}</h1>
                    </div>
                </div>
            </div>

            <div class="section__body">
                <div class="section__payment-header">
                    <div class="container">
                        <div class="payment-title section__title section__title_style6">
                            <h2>{{ $page['payment_title_' . $lang] }}</h2>
                        </div>

                        <span class="add-text">{{ __('you_can_pay_products_in_any_way') }}</span>
                    </div>
                </div>

                <div class="section__payment-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="tab-controls section__title_style8">
                                    <ul class="list list_unstyled nav nav-tabs tab-controls__nav" role="tablist">
                                        @foreach($paymentOptions as $key => $option)
                                            <li class="list__item">
                                                <a class="link {{ $key == 0 ? 'active' : '' }}" href="#option-{{ $option['id'] }}" data-toggle="tab" role="tab" aria-controls="option-{{ $option['id'] }}" aria-selected="false" aria-label="{{ $option['name_' . $lang] }}">
                                                    <div class="link__icon" aria-hidden="true">
                                                        <svg role="img" aria-hidden="true" width="30" height="30">
                                                            <use xlink:href="#{{ $option['hash_svg'] }}"></use>
                                                        </svg>
                                                    </div>

                                                    <div class="link__text">{{ $option['name_' . $lang] }}</div>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="tab-content">
                                    @foreach($paymentOptions as $key => $option)
                                        <div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}" id="option-{{ $option['id'] }}" role="tabpanel" aria-labelledby="option-{{ $option['id'] }}-tab">
                                            @php
                                                echo html_entity_decode($option['description_' . $lang])
                                            @endphp
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section__delivery-header">
                    <div class="container wrapper">
                        <div class="section__title section__title_style6">
                            <h2>{{ $page['delivery_title_' . $lang] }}</h2>
                        </div>

                        <div class="add-text js-delivery-clause">
                            <a href="#modal-delivery-clause">{{ __('delivery_regulation') }}</a>
                        </div>
                    </div>
                </div>

                <div class="section__delivery-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-7">

                                @php
                                    echo html_entity_decode($page['delivery_description_' . $lang])
                                @endphp

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

@endsection
