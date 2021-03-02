<div class="product-block__collection" id="collection-block">
    <div class="container">
        <div class="collection-block">
            <div class="collection-block__header">
                <button class="btn collection-block__toggler" type="button" data-toggle="collapse" data-target="#collection1" aria-expanded="true" aria-controls="collection1">
                    <span class="btn__icon" aria-hidden="true">
                        <svg role="img" width="30" height="30">
                            <use xlink:href="#svg-icon-collection"></use>
                        </svg>
                    </span>
                    <h2 class="btn__text">
                        <span class="btn__category">{{ $collection['name_' . $lang] }}</span>
                    </h2>
                    <span class="btn__arrow" aria-hidden="true">
                        <svg role="img" width="20" height="20">
                            <use xlink:href="#svg-icon-down-arrow"></use>
                        </svg>
                    </span>
                </button>
            </div>
            <div class="collection-block__body collapse show" id="collection1">
                <div class="collection-block__content">
                    <div class="row no-gutters">
                        @foreach($collection['products'] as $product)
                            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                                <div class="product-card" tabindex="0">
                                    <div class="product-card__content">
                                        <div class="product-card__header">
                                            <a class="product-card__img" href="{{ $product['link'] }}">
                                                @if(!empty($product['imagesResized']))
                                                    <picture>
                                                        @if(isset($product['imagesResized'][0]))
                                                            <source srcset="{{$product['imagesResized'][0]}}" media="(min-width: 535px)">
                                                        @endif
                                                        @if(isset($product['imagesResized'][1]))
                                                            <source srcset="{{$product['imagesResized'][1]}}" media="(min-width: 0px)">
                                                        @endif
                                                        @if(isset($product['imagesResized'][0]))
                                                            <img src="{{$product['imagesResized'][0]}}" alt="{{$product['name_'.$lang]}}">
                                                        @endif
                                                    </picture>
                                                @else
                                                    <img src="{{$product['imgPreview']}}" alt="{{$product['name_'.$lang]}}">
                                                @endif
                                            </a>
                                            <a class="product-card__brand" href="/{{ $lang }}/brands" aria-label="{{ __('go_to_brand') }} {{ $product['brand_name'] }}" title="{{ $product['brand_name'] }}">
                                                <img src="{{ asset('storage/brands/' . $product['brand_image']) }}" alt="{{ $product['brand_name'] }}">
                                            </a>
                                            <ul class="list list_unstyled product-card__marks marks-list">
                                                @foreach($product['tags'] as $tag)
                                                    @if($tag['discount'] == 0)
                                                        <li class="list__item {{ $tag['class'] ? $tag['class'] : '' }}">
                                                            @if($tag['show_name'])
                                                                {{ $tag['name_' . $lang] }}
                                                            @endif
                                                            @empty(!$tag['icon'])
                                                                <span class="marks-list__icon" aria-label="{{ $tag['name_' . $lang] }}">
                                                                    <svg role="img" aria-hidden="true" width="16" height="16">
                                                                        <use xlink:href="#{{ $tag['icon'] }}"></use>
                                                                    </svg>
                                                                </span>
                                                            @endempty
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="product-card__body">
                                            <a class="product-card__title" href="{{ $product['link'] }}">{{ $product['name_' . $lang] }}</a>
                                            <div class="product-card__price">
                                                @if($product['discount_price'] > 0)
                                                    <span class="old">{{ get_price_for_html($product['price']) }}</span>
                                                    <span class="cost cost_new">{{ get_price_for_html($product['discount_price']) }}</span>
                                                @else
                                                    <span class="cost">{{ get_price_for_html($product['price']) }}</span>
                                                @endif
                                                <span class="currency">{{ __('currency_name') }}{{ $product['unit_'.$lang] }}</span>
                                            </div>
                                        </div>
                                        <div class="product-card__footer">
                                            <div class="product-card__info">
                                                @if($product['stock'] > 0)
                                                    <div class="product-card__availability  product-card__availability_true">{{ __('in_stock') }}</div>
                                                @else
                                                    <div class="product-card__availability">{{ __('out_of_stock') }}</div>
                                                @endif
                                                <div class="product-card__code">{{ __('articul') }} {{ $product['articul'] }}</div>
                                            </div>
                                            <btn-to-cart-collection
                                                raw_product="{{ json_encode($product, JSON_UNESCAPED_UNICODE)}}"
                                                lang="{{ $lang }}"
                                                cart_path="{{ route('pages.cart.index') }}">
                                            </btn-to-cart-collection>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
