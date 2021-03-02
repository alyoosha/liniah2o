@extends('layouts.main')

@php
    $company_name = get_setting_by_key('company_name');
    $title = $company_name. ' - '. __('catalog').' '.$first_level_category['name_'.$lang].' '.$second_level_category['name_'.$lang];
@endphp
@section('title', $title)
@section('description', __('catalog').' '.$first_level_category['name_'.$lang].' '.$second_level_category['name_'.$lang])
@section('keywords', __('catalog').' '.$first_level_category['name_'.$lang].' '.$second_level_category['name_'.$lang])

@section('content')
    <main class="main-content" id="main-content">
        <section class="section section_inner-page section_catalog">
            <div class="section__header">
                <div class="container">
                    <div class="section__breadcrumbs">
                        <ul class="list list_unstyled breadcrumbs-list">
                            <li class="list__item"><a class="link" href="{{ route('homepage').'/'.$lang }}">{{ __('homepage') }}</a></li>
                            <li class="list__item"><a class="link" href="{{ route('pages.catalog.index') }}">{{ __('catalog') }}</a></li>
                            <li class="list__item"><a class="link" href="{{ route('pages.catalog.secondary_index', $secondary_slug) }}">{{ $first_level_category['name_'.$lang] }}</a></li>
                            <li class="list__item"><a class="link" href="{{ url()->current() }}">{{ $second_level_category['name_'.$lang] }}</a></li>
                            @if($third_level_category->count() > 0)
                                <li class="list__item third_level"><a class="link active" href="javascript: void(0);">{{ $third_level_category['name_'.$lang] }}</a></li>
                            @endif
                        </ul>
                    </div>
                    <div class="section__title section__title_style1">
                        @if($third_level_category->count() > 0)
                            <h1>{{ $third_level_category['name_'.$lang] }}</h1>
                        @else
                            <h1>{{ $second_level_category['name_'.$lang] }}</h1>
                        @endif
                    </div>
                </div>
            </div>
            <ternary-index
                language="{{ $lang }}"
                link_to_secondary_catalog_page="{{ $link_to_secondary_catalog_page }}"
                second_level_category_default="{{ $second_level_category }}"
                third_level_category_default="{{ $third_level_category }}"
                second_level_category_slug="{{ $secondary_slug }}"
                third_level_category_slug="{{ $third_level_category_slug }}"
                default_products="{{ $products }}"
                slides="{{ $slides }}"
                tags_default="{{ $tags }}"
                brands_default="{{ $brands }}"
                countries_default="{{ $countries }}"
                colors_default="{{ $colors }}"
                feature_types_default="{{ $feature_types }}"
                in_stock_count="{{ $in_stock_count }}"
            ></ternary-index>
        </section>
    </main>
@endsection
