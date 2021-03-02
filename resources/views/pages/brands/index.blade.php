@extends('layouts.main')

@php
    $company_name = get_setting_by_key('company_name');
    $title = $company_name. ' - '. __('brands')
@endphp
@section('title', $title)
@section('description', __('brands'))
@section('keywords', __('brands'))

@section('content')
    <main class="main-content" id="main-content">
        <section class="section section_inner-page section_brands-page">
            <div class="section__header">
                <div class="container">
                    <div class="section__breadcrumbs">
                        <ul class="list list_unstyled breadcrumbs-list">
                            <li class="list__item"><a class="link" href="{{ route('homepage').'/'.$lang }}">{{ __('homepage') }}</a></li>
                            <li class="list__item"><a class="link active" href="javascript: void(0);">{{ __('brands') }}</a></li>
                        </ul>
                    </div>
                    <div class="section__title section__title_style1 header-title">
                        <h1>{{ __('brands') }}</h1>
                    </div>
                </div>
            </div>
            <div class="section__body">
                <brands-index
                    :categories="{{ $parent_categories }}"
                    default_brands="{{ json_encode($brands, JSON_UNESCAPED_UNICODE) }}"
                    language="{{ $lang }}"
                    catalog_path_default="{{ $catalog_path }}"
                    storage_path_default="{{ $storage_path }}"
                    russian_alphabet="{{ $russian_alphabet }}"
                    english_alphabet="{{ $english_alphabet }}"
                    recommended_products_default="{{ $json_encoded_recommended_products }}"
                ></brands-index>
            </div>
        </section>
    </main>
@endsection
