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
        <section class="section section_inner-page {{$menuSecPage ? 'section_warranty-terms' : 'section_personal-data'}}">
            <div class="section__header">
                <div class="container">

                    <div class="section__breadcrumbs">
                        <ul class="list list_unstyled breadcrumbs-list">
                            <li class="list__item"><a class="link" href="/{{ $lang }}">{{ __('homepage') }}</a></li>
                            @if( @isset($guarantee) && $guarantee['instruction'])
                                <li class="list__item"><a class="link" href="/{{ $lang }}/exploitation-rules">{{ __('exploitation_rules') }}</a></li>
                                <li class="list__item"><a class="link active" href="/{{ $lang }}/exploitation-rules">{{ $page['title_' . $lang] }}</a></li>

                            @else
                            <li class="list__item"><a class="link active" href="/{{ $lang }}/{{ $page['slug'] }}">{{ $page['title_' . $lang] }}</a></li>
                            @endif
                        </ul>
                    </div>

                    <div class="header-title-wrapper">
                        <div class="section_warranty-title section__title section__title_style1 {{ $menuSecPage ? '' : 'personal-data-title' }}">
                            <h1>{{ $page['title_' . $lang] }}</h1>
                        </div>

                        @empty(!$menuSecPage)
                            @include($menuSecPage)
                        @endempty

                    </div>
                </div>
            </div>

            <div class="section__body section_simple-text">
                <div class="container">

                    @if($oneColumn)

                        <div class="row">
                            <div class="col-xl-8 col-lg-7 order-lg-1 order-2">

                                @php
                                    echo html_entity_decode($page['body_' . $lang])
                                @endphp

                            </div>
                        </div>

                    @else

                        <div class="row">

                            <div class="col-xl-8 col-lg-7 order-lg-1 order-2">

                                @php
                                    echo html_entity_decode($page['body_' . $lang])
                                @endphp

                            </div>

                            <div class="col-xl-3 col-lg-4 offset-lg-1 order-lg-2 order-1">

                                @empty(!$guarantee['instruction'])

                                    <a class="btn btn_gray btn_pdf" href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url('/secondary-pages/installation-instructions/' . $guarantee['instruction']) }}">
                                        <span class="btn__icon" aria-hidden="true">
                                            <svg role="img" width="24" height="24">
                                                <use xlink:href="#svg-icon-documents"></use>
                                            </svg>
                                        </span>
                                        <span class="btn__text">{{ __('installation_instructions') }}.pdf</span>
                                    </a>

                                @endempty

                            </div>
                        </div>

                    @endif

                </div>
            </div>
        </section>
    </main>

@endsection
