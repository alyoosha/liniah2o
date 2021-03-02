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
        <section class="section section_inner-page section_warranty-periods">
            <div class="section__header">
                <div class="container">
                    <div class="section__breadcrumbs">
                        <ul class="list list_unstyled breadcrumbs-list">
                            <li class="list__item"><a class="link" href="/{{ $lang }}">{{ __('homepage') }}</a></li>
                            <li class="list__item"><a class="link" href="/{{ $lang }}/warranty-and-return/">{{ __('warranty') }}</a></li>
                            <li class="list__item"><a class="link active" href="/{{ $lang }}/warranty-and-return/warranty-periods/">{{ __('warranty_periods') }}</a></li>
                        </ul>
                    </div>

                    <div class="header-title-wrapper">
                        <div class="section_warranty-title section__title section__title_style1">
                            <h1>{{ $page['title_' . $lang] }}</h1>
                        </div>

                        <div class="section_vertical-navigation js-vertical-navigation">
                            <div class="scrollbar-inner">
                                <ul class="list list_unstyled section__title_style8 row no-gutters">
                                    <li class="list__item col-auto js-list-item">
                                        <a class="link" href="warranty-and-return">
                                            <div class="link__text">{{ __('general_warranty_and_return_conditions') }}</div>
                                        </a>
                                    </li>

                                    <li class="list__item col-auto js-list-item  active-item">
                                        <a class="link active" href="warranty-periods">
                                            <div class="link__text">{{ __('warranty_periods') }}</div>
                                        </a>

                                    </li>

                                    <li class="list__item col-auto js-list-item">
                                        <a class="link" href="exploitation-rules">
                                            <div class="link__text">{{ __('exploitation_rules') }}</div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section__body table-wrapper">

                @empty(!$categories)

                    @for($c = 0; $c < count($categories); ++$c)

                        <div class="container">
                            <div class="table-title section__title">
                                <h2>{{ $categories[$c]['name_' . $lang] }}</h2>
                            </div>

                            <table class="table-desktop">
                                <thead>
                                <tr>
                                    <th>{{ __('brand') }}</th>
                                    <th>{{ __('warranty_months') }}</th>
                                    <th>{{ __('installation_instructions') }}</th>
                                    <th>{{ __('warranty_card') }}</th>
                                </tr>
                                </thead>

                                <tbody>
                                @php
                                    $i = 0;
                                    // $num = INF;
                                @endphp
                                @foreach($guarantees[$c] as $guarantee)
                                    @php
                                        //if($guarantee['validity'] < $num) {
                                            //$num = $guarantee['validity'];

                                            if($i % 2 === 1) {
                                                $class = 'bg_light';
                                            } else {
                                                $class = '';
                                            }
                                        //}
                                    @endphp
                                    <tr class="{{ $class }}">
                                        <td>{{ $guarantee['brand']['name'] }}</td>
                                        <td>{{ $guarantee['validity'] }}</td>
                                        <td>
                                            @if($guarantee['instruction'])
                                                <a class="link" href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($guarantee['instruction']) }}">
                                                    <div class="link__svg">
                                                        <svg role="img" width="24" height="24">
                                                            <use xlink:href="#svg-icon-documents"></use>
                                                        </svg>
                                                    </div>
                                                    <div class="link__text">{{ __('installation_instructions') }}.pdf</div>
                                                </a>
                                            @else
                                                <a class="link" href="javascript:void(0)">
                                                    <div class="link__svg"></div>
                                                    <div class="link__text"></div>
                                                </a>

                                            @endif
                                        </td>
                                        <td>

                                            @if($guarantee['ticket'])
                                                <a class="link" href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($guarantee['ticket']) }}">
                                                    <div class="link__svg">
                                                        <svg role="img" width="24" height="24">
                                                            <use xlink:href="#svg-icon-documents"></use>
                                                        </svg>
                                                    </div>
                                                    <div class="link__text">{{ __('warranty_card') }}.pdf</div>
                                                </a>
                                            @else
                                                <a class="link" href="javascript:void(0)">
                                                    <div class="link__svg"></div>
                                                    <div class="link__text"></div>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach
                                </tbody>
                            </table>

                            <table class="table-mobile">
                                <thead>
                                <tr>
                                    <th>{{ __('brand') }}</th>
                                    <th>{{ __('warranty_months') }}</th>
                                </tr>
                                </thead>

                                <tbody>
                                @php
                                    $i = 0;
                                    //$num = INF;
                                @endphp
                                @foreach($guarantees[$c] as $guarantee)
                                    @php
                                        //if($guarantee['validity'] < $num) {
                                            //$num = $guarantee['validity'];

                                            if($i % 2 == 1) {
                                                $class = 'bg_light';
                                            }
                                            else {
                                                $class = '';
                                            }
                                        //}
                                    @endphp
                                    <tr class="{{ $class }}">
                                        <td>{{ $guarantee['brand']['name'] }}</td>
                                        <td>{{ $guarantee['validity'] }}</td>
                                    </tr>
                                    <tr class="{{ $class }}">
                                        <td>
                                            @if($guarantee['instruction'])
                                                <a class="link" href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url('/secondary-pages/installation-instruction/' . $guarantee['instruction']) }}">
                                                    <div class="link__svg">
                                                        <svg role="img" width="24" height="24">
                                                            <use xlink:href="#svg-icon-documents"></use>
                                                        </svg>
                                                    </div>
                                                    <div class="link__text">{{ __('installation_instructions') }}.pdf</div>
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            @if($guarantee['instruction'])
                                                <a class="link" href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url('/secondary-pages/warranty-periods/' . $guarantee['ticket']) }}">
                                                    <div class="link__svg">
                                                        <svg role="img" width="24" height="24">
                                                            <use xlink:href="#svg-icon-documents"></use>
                                                        </svg>
                                                    </div>
                                                    <div class="link__text">{{ __('warranty_card') }}.pdf</div>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @php
                                        ++$i;
                                    @endphp
                                @endforeach
                                </tbody>
                            </table>

                        </div>

                        @if(count($categories) != $c + 1)

                            <hr class="line">

                        @endif

                    @endfor

                @endempty

            </div>
        </section>
    </main>

@endsection
