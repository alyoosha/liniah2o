@extends('layouts.main')

@section('content')
    <main class="main-content" id="main-content">
        <section class="section section_inner-page section_error section_error-500">
            <div class="section__header">
                <div class="container">
                    <div class="section__breadcrumbs">
                        <ul class="list list_unstyled breadcrumbs-list">
                            <li class="list__item"><a class="link" href="{{ route('homepage') }}">{{ __('homepage') }}</a></li>
                            <li class="list__item"><a class="link active" href="javascript: void(0);">500</a></li>
                        </ul>
                    </div>
                    <div class="section__title section__title_style1 error-title">
                        <h1>500</h1><span class="add-text">{{ __('server_error') }}</span>
                    </div>
                </div>
            </div>
            <div class="section__body">
                <div class="error-description">
                    <div class="container">
                        <div class="error-description__title section__title">
                            <h2>{{ __('page_unavailable') }}</h2>
                        </div>
                        <a href="{{ url()->current() }}">
                            <button class="reload-btn btn btn_default btn_dark btn_with-icon" type="button">
                            <span class="btn__icon" aria-hidden="true">
                                <svg role="img" width="30" height="30">
                                    <use xlink:href="#svg-icon-refresh"></use>
                                </svg>
                            </span>
                                <span class="btn__text">{{ __('reload_page') }}</span>
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
