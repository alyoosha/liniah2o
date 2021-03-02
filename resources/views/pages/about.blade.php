@extends('layouts.main')

@section('title', $aboutUsInfo->seo_title ?? '')
@section('description', $aboutUsInfo->seo_description)
@section('keywords', $aboutUsInfo->seo_keywords)

@section('content')
    <main class="main-content" id="main-content">
        <section class="section section_inner-page section_about section_vacancy">
            <div class="section__header">
                <div class="container">
                    <div class="section__breadcrumbs">
                        <ul class="list list_unstyled breadcrumbs-list">
                            <li class="list__item"><a class="link" href="{{ route('homepage').'/'.$lang }}">{{ __('homepage') }}</a></li>
                            <li class="list__item"><a class="link active" href="javascript: void(0);">{{ __('about_us') }}</a></li>
                        </ul>
                    </div>
                    <div class="header-title-wrapper">
                        <div class="header-title">
                            <div class="header-title__main section__title section__title_style1">
                                <h1>{{ __('about_us') }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section__body about-block color_white">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-5 col-xl-4">
                            <div class="about-block__img">
                                <div class="background-img" aria-hidden="true"><img src="{{ asset('images/content/about/about-img-1.jpg') }}" alt="Фото"></div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-7 col-xl-8">
                            <div class="about-block__content">
                                <div class="section__title section__title_style5 about-block__title">
                                    <h2><span class="line">{!! $aboutUsInfo['best_practices_content_title_'.$lang] !!}</span></h2>
                                </div>
                                <div class="about-block__descr section__description">{!! $aboutUsInfo['best_practices_content_'.$lang] !!}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section section_about-numeric">
            <div class="container">
                <div class="section__title section__title_style1">
                    <h2>{{ __('about_in_numbers') }}</h2>
                </div>
                <ul class="list list_unstyled row no-gutters numeric-list">
                    <li class="list__item">
                        <div class="numeric-block">
                            <div class="numeric-block__num"><span class="count">20</span>+</div>
                            <div class="section__title section__title_style8 numeric-block__title">{{ __('years_experience') }}</div>
                        </div>
                    </li>
                    <li class="list__item">
                        <div class="numeric-block">
                            <div class="numeric-block__num"><span class="count">4</span></div>
                            <div class="section__title section__title_style8 numeric-block__title">{{ __('offline_shops') }}</div>
                        </div>
                    </li>
                    <li class="list__item">
                        <div class="numeric-block">
                            <div class="numeric-block__num"><span class="count">24</span></div>
                            <div class="section__title section__title_style8 numeric-block__title">{{ __('support_online') }}</div>
                        </div>
                    </li>
                    <li class="list__item">
                        <div class="numeric-block">
                            <div class="numeric-block__num"><span class="count">250</span></div>
                            <div class="section__title section__title_style8 numeric-block__title">{{ __('employees') }}</div>
                        </div>
                    </li>
                    <li class="list__item">
                        <div class="numeric-block">
                            <div class="numeric-block__num"><span class="count">100+</span></div>
                            <div class="section__title section__title_style8 numeric-block__title">{{ __('trusted_brands') }}</div>
                        </div>
                    </li>
                </ul>
                <div class="section__img">
                    <div class="background-img" aria-hidden="true"><img src="{{ asset('images/content/about/about-img-2.jpg') }}" alt="Фото"></div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-7 col-xl-6">
                        <div class="section__title section__title_style4">
                            <h3>
                                {!! $aboutUsInfo['quality_and_perfection_title_'.$lang] !!}
                            </h3>
                        </div>
                        <div class="section__description">
                            {!! $aboutUsInfo['quality_and_perfection_content_'.$lang] !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section section_about-mission">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-4">
                        <div class="section__img">
                            <div class="background-img" aria-hidden="true"><img src="{{ asset('images/content/about/about-img-3.jpg') }}" alt="Фото"></div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-8">
                        <div class="section__content">
                            <div class="section__header color_white bg_gray-medium">
                                <div class="section__title section__title_style1">
                                    <h2>{{ strstr($aboutUsInfo['our_mission_content_title_'.$lang], '-', true) }} - </h2>
                                </div>
                                <div class="section__title section__title_style5">
                                    <h2>{{ str_replace('-', '', strstr($aboutUsInfo['our_mission_content_title_'.$lang], '-')) }}</h2>
                                </div>
                            </div>
                            <div class="section__description">
                                @php
                                    $count = preg_match_all('/<li[^>]*>(.*?)<\/li>/is', $aboutUsInfo['our_mission_content_'.$lang], $matches);
                                @endphp
                                <ol class="list list_unstyled section__list">
                                    @for($i = 0; $i < $count; ++$i)
                                        <li class="list__item">
                                            <div class="list__text"><p>{{ $matches[1][$i] }}</p></div>
                                        </li>
                                    @endfor
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section section_about-offer">
            <div class="section__img" aria-hidden="true">
                <div class="background-img"><img src="{{ asset('images/backgrounds/blog-bg.jpg') }}" alt="Фоновое изображение"></div>
            </div>
            <div class="container">
                <div class="row align-items-end">
                    <div class="col-12 col-md-8 col-xl-9">
                        <div class="section__title section__title_style1 color_white">
                            <h2>{{ __('for_you_we_have') }}</h2>
                        </div>
                        <div class="section__description color_white">
                            <p>{{ __('for_you_ceramic') }}</p>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-xl-3">
                        <div class="section__controls"><a href="{{ route('pages.catalog.index') }}">{{ __('go_to_catalog') }}</a></div>
                    </div>
                </div>
                <div class="section__body">
                    <div class="row no-gutters">
                        @foreach($categories as $category)
                            <div class="col-12 col-md-6 col-xl-4">
                                <a class="link category-block category-block_{{ $category->color_class_prefix }}" href="{{ route('pages.catalog.secondary_index', $category->slug) }}" aria-label="{{ $category['name_'.$lang] }}">
                                    <div class="link__bg" aria-hidden="true" style="background-image: url({{ $category->logo ? asset('storage/'.$category->logo) : '' }});"></div>
                                    <div class="link__content">
                                        @if($category->svg_logo)
                                            <span class="link__icon" aria-hidden="true">
                                                <svg role="img" aria-hidden="true" width="30" height="30">
                                                    @php preg_match("/icon-(.*)\.svg$/", \Storage::disk('public')->url('/'.$category->svg_logo), $m); @endphp
                                                    <use xlink:href="#svg-icon-{{ $m[1] }}"></use>
                                                </svg>
                                            </span>
                                        @endif
                                        <h2 class="link__text">
                                            <span class="line">{{ $category['name_'.$lang] }}</span>
                                        </h2>
                                        <span class="link__control" aria-hidden="true">
                                            <svg role="img" aria-hidden="true" width="20" height="20">
                                                <use xlink:href="#svg-icon-down-arrow"></use>
                                            </svg>
                                        </span>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script>
        let h1 = document.querySelector('h1');

        if(document.title.length === 0) {
            document.title = h1.textContent;
        }
    </script>
@endpush
