<footer class="footer">
    <button class="btn btn_dark scroll-top js-scrolltop" type="button" aria-label="{{ __('up') }}">
        <svg role="img" width="30" height="30">
            <use xlink:href="#svg-icon-top-arrow"></use>
        </svg>
    </button>
    <div class="footer__top">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-12">
                    <div class="footer__nav">
                        <div class="section__title footer__nav-title">@lang('Navigation')</div>
                        <ul class="list list_unstyled footer__nav-list">
                            @foreach($menu as $menu_item)
                                <li class="list__item">
                                    <a class="link" href="{{ '/'.$lang.$menu_item->url }}">@lang($menu_item->name)</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-12">
                    <div class="footer__nav">
                        <div class="section__title footer__nav-title">@lang('Information')</div>
                        <ul class="list list_unstyled footer__nav-list">
                            <li class="list__item"><a class="link" href="/{{ $lang }}/payment-and-delivery">{{ __('payment_and_delivery') }}</a></li>
                            <li class="list__item"><a class="link" href="/{{ $lang }}/warranty-and-return">{{ __('warranty_and_return') }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer__bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-lg-8">
                    <ul class="list list_unstyled footer__bottom-nav row">
                        <li class="col-12 col-sm-auto list__item">&copy; {{ get_setting_by_key('company_name') }}</li>

                        @empty(!$addItemList)
                            @foreach($addItemList as $item)
                                @if($item['link_location']  == 'footer')

                                    <li class="col-12 col-sm-auto list__item">
                                        <a class="link" href="/{{ $lang }}/{{ $item['slug'] }}">
                                            {{ $item['seo_title_' . $lang] }}
                                        </a>
                                    </li>

                                @endif
                            @endforeach
                        @endempty

                    </ul>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="footer__dev">
                        {{ __('site_development') }} - <a href="{{ get_setting_by_key('developed_by_site') }}" target="_blank" rel="noopener">{{ get_setting_by_key('developed_by') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
