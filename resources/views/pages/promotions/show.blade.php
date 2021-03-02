@extends('layouts.main')

@php
    $company_name = get_setting_by_key('company_name');
    $title = $company_name. ' - '. __('promotions').' '.$promotion['name_'.$lang];
@endphp
@section('title', $title)
@section('description', __('promotions').' '.$promotion['name_'.$lang])
@section('keywords', __('promotions').' '.$promotion['name_'.$lang])

@section('content')
    <main class="main-content" id="main-content">
        <section class="section section_inner-page section_promotions-inner">
            <div class="section__header">
                <div class="container">
                    <div class="row no-gutters">
                        <div class="col-xl-5">
                            <div class="section__breadcrumbs">
                                <ul class="list list_unstyled breadcrumbs-list">
                                    <li class="list__item"><a class="link" href="{{ route('homepage').'/'.$lang }}">{{ __('homepage') }}</a></li>
                                    <li class="list__item"><a class="link" href="{{ route('pages.promotions.index') }}">{{ __('promotions') }}</a></li>
                                    <li class="list__item"><a class="link active" href="javascript: void(0);">{{ $promotion['name_'.$lang] }}</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-5 offset-xl-1">
                            <div class="section__title section__title_style6 header-title">
                                <h2>{{ $promotion['name_'.$lang] }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section__body">
                <div class="promotion-info bg_gray-dark">
                    <div class="container">
                        <div class="row no-gutters">
                            <div class="col-md-5">
                                <div class="promotion-img">
                                    <div class="background-img">
                                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($promotion->image) }}" alt="{{ $promotion['name_'.$lang] }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 offset-md-1">
                                <div class="main-text"><p>{{ $promotion['description_'.$lang] }}<p></div>
                                <div class="add-text">
                                    <span>{{ __('promotion_duration') }}</span>
                                    {{ __('from_date') }}
                                    {{ $promotion->from_date }}
                                    {{ __('to_date') }}
                                    {{ $promotion->to_date }}
                                    {{ $promotion->getYearOfEndingPromotion() }}
{{--                                    {{ __('promotion_year') }}--}}
                                </div>
                                <div class="stock-block">
                                    <div class="stock-block__text">{{ __('before_closing_promotion') }}</div>
                                    <div class="stock-block__timer">
                                        <div class="timer" id="timer2" data-finish="{{ $promotion->getDurationTimeInMilliseconds() }}">
                                            <div class="timer__item">
                                                <div class="timer__count timer__days"><span class="days_1">0</span><span class="days_2">0</span></div>
                                                <div class="timer__text">{{ __('days') }}</div>
                                            </div>
                                            <div class="timer__item">
                                                <div class="timer__count timer__hours"> <span class="hours_1">0</span><span class="hours_2">0</span></div>
                                                <div class="timer__text">{{ __('hours') }}</div>
                                            </div>
                                            <div class="timer__item">
                                                <div class="timer__count timer__minutes"><span class="minutes_1">0</span><span class="minutes_2">0</span></div>
                                                <div class="timer__text">{{ __('minutes') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <promotions-products
                    :default_products="{{ $products }}"
                    brands_prop="{{ $brands }}"
                    first_level_categories_prop="{{ $first_level_categories }}"
                    second_level_categories_prop="{{ $second_level_categories_for_match }}"
                    third_level_categories_prop="{{ $third_level_categories_for_match }}"
                    language="{{ $lang }}"
                    promotion="{{ $promotion->id }}"
                    catalog_path_default="{{ $catalog_path }}"
                    storage_path_default="{{ $storage_path }}"
                ></promotions-products>
            </div>
        </section>
    </main>
@endsection
