@extends('layouts.main')

@php
    $company_name = get_setting_by_key('company_name');
    $title = $company_name. ' - '. __('promotions');
@endphp
@section('title', $title)
@section('description', __('promotions'))
@section('keywords', __('promotions'))

@section('content')
    <main class="main-content" id="main-content">
        <section class="section section_inner-page section_promotions">
            <div class="section__header">
                <div class="container">
                    <div class="section__breadcrumbs">
                        <ul class="list list_unstyled breadcrumbs-list">
                            <li class="list__item"><a class="link" href="{{ route('homepage').'/'.$lang }}">{{ __('homepage') }}</a></li>
                            <li class="list__item"><a class="link active" href="javascript: void(0);">{{ __('promotions') }}</a></li>
                        </ul>
                    </div>
                    <div class="section__title section__title_style1 header-title">
                        <h1>{{ __('promotions') }}</h1>
                    </div>
                </div>
            </div>
            <div class="section__body">
                <promotions-index
                    :default_promotions="{{ $promotions }}"
                    storage_path_default="{{ $storage_path }}"
                    language="{{ $lang }}"
                ></promotions-index>
            </div>
        </section>
    </main>
@endsection
