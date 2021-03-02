@extends('layouts.main')

@php
    $company_name = get_setting_by_key('company_name');
    $title = $company_name. ' - '. __('search_results');
@endphp
@section('title', $title)
@section('description', '')
@section('keywords', '')

@section('content')

    <main class="main-content" id="main-content">
        <section class="section section_inner-page section_search-results">
            <div class="section__header">
                <div class="container">
                    <div class="section__breadcrumbs">
                        <ul class="list list_unstyled breadcrumbs-list">
                            <li class="list__item"><a class="link" href="/{{ $lang }}">{{ __('homepage') }}</a></li>

                            <li class="list__item"><a class="link active" href="/{{ $lang }}/search-result">{{ __('search_results') }}</a></li>
                        </ul>
                    </div>

                    <div class="header-title-wrapper">
                        <div class="section__title section__title_style1 main-title">
                            <h1>{{ __('search_results') }}</h1>
                        </div>
                        <span class="add-text section__title_style5">{{ ucfirst($inputStr) }}</span>
                    </div>
                </div>
            </div>

            @if(!empty($categories) || !empty($products))
                <div class="section__body">
                    <div class="container">
                        <div class="wrapper-block">
                            <div class="sidebar-block">
                                <div class="sidebar-block__header">
                                    <div class="title section__title">{{ __('categories') }}
                                        <span class="counter">( {{ count($categories) }} )</span>
                                    </div>
                                </div>

                                <div class="sidebar-block__body">
                                    @empty(!$categories)
                                        @foreach($categories as $category)
                                            <div class="breadcrumbs-block">{{ ucfirst($inputStr) }}
                                                <div class="section__breadcrumbs">
                                                    <span>в</span>
                                                    <ul class="list list_unstyled breadcrumbs-list">
                                                        @foreach($category['breadcrumbs'] as $key => $item)
                                                            <li class="list__item">
                                                                <a class="link" href="/{{$lang}}{{ $item['link'] }}">{{ $item['name' ] }}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endempty
                                </div>
                            </div>

                            <search-results
                                lang="{{ $lang }}"
                                raw_products="{{ json_encode($products, JSON_UNESCAPED_UNICODE) }}"
                                raw_per_page="{{ $perPage }}"
                                raw_input="{{ $inputStr }}">
                            </search-results>

                        </div>
                    </div>
                </div>
            @endif
        </section>
    </main>

@endsection
