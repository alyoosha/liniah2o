<header class="header" id="header">
    <div class="header__top bg_light d-none d-lg-block">
        <div class="container">
            <!-- если находимся на соответствующей странице - ссылке добавляем класс active-->
            <ul class="list list_unstyled header__top-nav row align-items-center">

                @empty(!$addItemList)
                    @foreach($addItemList as $item)
                        @if($item['link_location']  == 'header')

                            <li class="col-auto list__item">

                             <a class="link" href="/{{ $lang }}/{{ $item['slug'] }}">
                                    <span class="link__text">{{ $item['seo_title_' . $lang] }}</span>
                                </a>
                            </li>

                        @endif
                    @endforeach
                @endempty

                <li class="col-auto list__item">
                    <a class="link" href="/{{$lang}}/payment-and-delivery">
                        <span class="link__icon" aria-hidden="true">
                            <svg role="img" aria-hidden="true" width="18" height="18">
                                <use xlink:href="#svg-icon-delivery"></use>
                            </svg>
                        </span>
                        <span class="link__text">{{ __('payment_and_delivery') }}</span>
                    </a>
                </li>
                <li class="col-auto list__item">
                    <a class="link" href="/{{$lang}}/warranty-and-return">
                        <span class="link__icon" aria-hidden="true">
                            <svg role="img" aria-hidden="true" width="18" height="18">
                                <use xlink:href="#svg-icon-warranty"></use>
                            </svg>
                        </span>
                        <span class="link__text">{{ __('warranty_and_return') }}</span>
                    </a>
                </li>
                <li class="col-auto list__item list__item_has-child dropdown">
                    <button class="link js-dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="link__icon" aria-hidden="true">
                            <svg role="img" aria-hidden="true" width="18" height="18">
                                <use xlink:href="#svg-icon-global"></use>
                            </svg>
                        </span>
                        <span class="link__text">
                            {{ $lang }}
                        </span>
                        <span class="link__control" aria-hidden="true">
                            <svg role="img" aria-hidden="true" width="10" height="10">
                                <use xlink:href="#svg-icon-down-arrow"></use>
                            </svg>
                        </span>
                    </button>
                    <ul class="list list_unstyled header__top-sublist bg_light dropdown-menu" aria-label="{{ $lang }}">
                        @foreach(config('app.locales') as $locale)
                            @if($locale != $lang)
                                <li class="list__item">
                                    <a class="link active" href="{{ Route('locale', $locale) }}">
                                        <span class="link__text">{{ $locale }}</span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <div class="header__desktop bg_white d-none d-lg-block">
        <div class="header__controls">
            <div class="container">
                <div class="controls__table">
                    <div class="controls__cell controls__cell_logo">
                        <a class="header__logo" href="{{ route('homepage').'/'.$lang }}" aria-label="{{ get_setting_by_key('company_name') }}">
                            {!! \Illuminate\Support\Facades\Storage::disk('public')->get(get_setting_by_key('site_logo')) !!}
                        </a>
                    </div>
                    <div class="controls__cell controls__cell_search">
                        <desktop-search
                            lang="{{ $lang }}"
                        ></desktop-search>
                    </div>
                    <div class="controls__cell controls__cell_bonus">
                        <a class="link header__bonus" href="tel:{{ str_replace(['(', ')', ' '], ['', '', ''], get_setting_by_key('company_phone')) }}">
                            <span class="link__icon" aria-hidden="true">
                                <svg role="img" width="30" height="30">
                                    <use xlink:href="#svg-icon-phone"></use>
                                </svg>
                            </span>
                            <span class="link__text">{{ get_setting_by_key('company_phone') }}</span>
                        </a>
                    </div>
                    <div class="controls__cell controls__cell_nav controls__cell_nav_small">
                        <ul class="list list_unstyled header__controls-nav row justify-content-between">
                            <li class="list__item col-auto">
                                <cart-count lang="{{ $lang }}"></cart-count>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <nav class="header__main-nav">
            <div class="container">
                <!-- если находимся на соответствующей странице - ссылке добавляем класс active-->
                <ul class="list list_unstyled header__nav-list">
                    <li class="list__item">
                        <a class="btn btn_catalog btn_dark js-catalog-toggle" href="{{ route('pages.catalog.index') }}">
                            <span class="btn__icon" aria-hidden="true">
                                <svg role="img" width="20" height="20"><use xlink:href="#svg-icon-menu"></use>
                                </svg>
                            </span>
                            <span class="btn__text">{{ __('catalog') }}</span>
                        </a>
                    </li>
                    @foreach($menu as $menu_item)
                        <li class="list__item">
                            <a class="link @php echo URL::to('/').'/'.$lang.$menu_item->url === url()->current() ? 'active' : '' @endphp" href="{{ URL::to('/').'/'.$lang.$menu_item->url }}">@lang($menu_item->name)</a>
                        </li>
                    @endforeach
                </ul>
                <header-desktop
                    language="{{ $lang }}"
                    storage_path="{{ \Illuminate\Support\Facades\Storage::disk('public')->url('/') }}"
                ></header-desktop>
            </div>
        </nav>
    </div>
    <div class="header__mobile bg_white d-block d-lg-none">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-auto">
                    <button class="btn btn_menu js-menu-panel-opener" type="button" aria-label="{{ __('open_menu') }}">
                        <svg role="img" width="30" height="30">
                            <use xlink:href="#svg-icon-menu"></use>
                        </svg>
                    </button>
                </div>
                <div class="col-auto d-none d-lg-block">
                    <a class="btn btn_catalog btn_dark js-catalog-toggle" href="{{ route('pages.catalog.index') }}">
                        <span class="btn__icon" aria-hidden="true">
                            <svg role="img" width="20" height="20">
                                <use xlink:href="#svg-icon-menu"></use>
                            </svg>
                        </span>
                        <span class="btn__text">{{ __('catalog') }}</span>
                    </a>
                </div>
                <div class="col-auto header__logo-wrapper">
                    <a class="header__logo" href="/" aria-label="{{ get_setting_by_key('company_name') }}">
                        {!! \Illuminate\Support\Facades\Storage::disk('public')->get(get_setting_by_key('site_logo')) !!}
                    </a>
                </div>
                <div class="col-auto">
                    <ul class="list list_unstyled header__controls-nav row justify-content-between">
                        <li class="list__item col-auto">
                            <button class="link js-search-panel-opener" type="button" aria-label="{{ __('open_search_panel') }}">
                                <span class="link__icon">
                                    <svg role="img" width="26" height="26"><use xlink:href="#svg-icon-searching"></use>
                                    </svg>
                                </span>
                            </button>
                        </li>
                        <li class="list__item col-auto">
                            <cart-count></cart-count>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel_search d-block d-lg-none">
        <div class="panel__header">
            <div class="container">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto">
                        <button class="btn btn_close js-search-panel-closer" type="button" aria-label="{{ __('close_search_panel') }}">
                            <svg role="img" width="26" height="26">
                                <use xlink:href="#svg-icon-cancel"></use>
                            </svg>
                        </button>
                    </div>
                    <div class="col-auto">
                        <ul class="list list_unstyled header__controls-nav row justify-content-between">
                            <li class="list__item col-auto">
                                <cart-count></cart-count>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel__content">
            <mobile-search
                lang="{{ $lang }}"
            ></mobile-search>
        </div>
    </div>
    <div class="panel panel_menu d-block d-lg-none">
        <div class="panel__header">
            <div class="container">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto">
                        <button class="btn btn_close js-menu-panel-closer" type="button" aria-label="{{ __('close_menu') }}">
                            <svg role="img" width="26" height="26">
                                <use xlink:href="#svg-icon-cancel"></use>
                            </svg>
                        </button>
                    </div>
                    <div class="col-auto">
                        <ul class="list list_unstyled header__controls-nav row justify-content-between">
                            <li class="list__item col-auto">
                                <button class="link js-search-panel-opener" type="button" aria-label="{{ __('open_search_panel') }}">
                                    <span class="link__icon">
                                        <svg role="img" width="26" height="26">
                                            <use xlink:href="#svg-icon-searching"></use>
                                        </svg>
                                    </span>
                                </button>
                            </li>
                            <li class="list__item col-auto">
                                <cart-count></cart-count>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel__content">
            <div class="panel__body bg_white">
                <nav class="header__mobile-nav mobile-nav">
                    <header-mobile
                        language="{{ $lang }}"
                        storage_path="{{ \Illuminate\Support\Facades\Storage::disk('public')->url('/') }}"
                    >
                    </header-mobile>
                    <ul class="list list_unstyled mobile-nav__list">
                        @foreach($menu as $menu_item)
                            <li class="list__item">
                                <a class="link link_main" href="{{ '/'.$lang.$menu_item->url }}">@lang($menu_item->name)</a>
                            </li>
                        @endforeach
                    </ul>
                </nav>
            </div>
            <div class="panel__footer">
                <ul class="list list_unstyled header__top-nav row align-items-center">
                    <li class="col-auto list__item">
                        <a class="link" href="/{{ $lang }}/payment-and-delivery">
                            <span class="link__icon" aria-hidden="true">
                                <svg role="img" aria-hidden="true" width="18" height="18">
                                    <use xlink:href="#svg-icon-delivery"></use>
                                </svg>
                            </span>
                            <span class="link__text">{{ __('payment_and_delivery') }}</span>
                        </a>
                    </li>
                    <li class="col-auto list__item">
                        <a class="link" href="/{{ $lang }}/warranty-and-return">
                            <span class="link__icon" aria-hidden="true">
                                <svg role="img" aria-hidden="true" width="18" height="18">
                                    <use xlink:href="#svg-icon-warranty"></use>
                                </svg>
                            </span>
                            <span class="link__text">{{ __('warranty_and_return') }}</span>
                        </a>
                    </li>
                    <li class="col-auto list__item list__item_has-child dropdown">
                        <button class="link js-dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="link__icon" aria-hidden="true">
                            <svg role="img" aria-hidden="true" width="18" height="18">
                                <use xlink:href="#svg-icon-global"></use>
                            </svg>
                        </span>
                            <span class="link__text">
                            {{ $lang }}
                        </span>
                            <span class="link__control" aria-hidden="true">
                            <svg role="img" aria-hidden="true" width="10" height="10">
                                <use xlink:href="#svg-icon-down-arrow"></use>
                            </svg>
                        </span>
                        </button>
                        <ul class="list list_unstyled header__top-sublist bg_light dropdown-menu" aria-label="{{ $lang }}">
                            @foreach(config('app.locales') as $locale)
                                @if($locale != $lang)
                                    <li class="list__item">
                                        <a class="link active" href="{{ Route('locale', $locale) }}">
                                            <span class="link__text">{{ $locale }}</span>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
