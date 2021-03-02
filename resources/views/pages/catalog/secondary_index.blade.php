@extends('layouts.main')

@php
    $company_name = get_setting_by_key('company_name');
    $title = $company_name. ' - '. __('catalog').' '.$first_level_category['name_'.$lang];
@endphp
@section('title', $title)
@section('description', __('catalog').' '.$first_level_category['name_'.$lang])
@section('keywords', __('catalog').$first_level_category['name_'.$lang])

@section('content')
    <main class="main-content" id="main-content">
        <section class="section section_inner-page section_catalog section_category">
            <div class="section__header">
                <div class="container">
                    <div class="section__breadcrumbs">
                        <ul class="list list_unstyled breadcrumbs-list">
                            <li class="list__item"><a class="link" href="{{ route('homepage').'/'.$lang }}">{{ __('homepage') }}</a></li>
                            <li class="list__item"><a class="link" href="{{ route('pages.catalog.index') }}">{{ __('catalog') }}</a></li>
                            <li class="list__item"><a class="link active" href="javascript: void(0);">{{ $first_level_category['name_'.$lang] }}</a></li>
                        </ul>
                    </div>
                    <div class="section__title section__title_style1">
                        <h1>{{ $first_level_category['name_'.$lang] }}</h1>
                    </div>
                </div>
            </div>
            <div class="section__body">
                <div class="container">
                    <div class="easy-nav bg_white d-block d-xl-none">
                        <ul class="list list_unstyled easy-nav__list">
                            @if(count($categories) > 1)
                                @foreach($categories as $key => $second_level_category)
                                    <li class="list__item">
                                        <a class="btn btn_light link js-scroll-link" href="#category-{{ $second_level_category['category_info']['slug'] }}" aria-label="{{ $second_level_category['category_info']['name_'.$lang] }}">
                                            @if($second_level_category['category_info']['svg_logo'])
                                                <svg role="img" aria-hidden="true" width="30" height="30">
                                                    @php preg_match("/icon-(.*)\.svg$/", \Storage::disk('public')->url('/'.$second_level_category['category_info']['svg_logo']), $m); @endphp
                                                    <use xlink:href="#svg-icon-{{ $m[1] }}"></use>
                                                </svg>
                                            @endif
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                    <div class="category-block category-block_main" id="category-radiator">
                        <div class="row no-gutters">
                            <div class="col-12 col-lg-5">
                                <a class="link category-block__header category-block__header_{{ $first_level_category->color_class_prefix }}" href="javascript: void(0);" aria-label="{{ $first_level_category['name_'.$lang] }}">
                                    <div class="link__bg" aria-hidden="true" style="background-image: url({{ $first_level_category->logo ? asset('storage/'.$first_level_category->logo) : '' }});"></div>
                                    <div class="link__content">
                                        @if($first_level_category->svg_logo)
                                            <span class="link__icon" aria-hidden="true">
                                                <svg role="img" aria-hidden="true" width="30" height="30">
                                                    @php preg_match("/icon-(.*)\.svg$/", \Storage::disk('public')->url('/'.$first_level_category->svg_logo), $m); @endphp
                                                    <use xlink:href="#svg-icon-{{ $m[1] }}"></use>
                                                </svg>
                                            </span>
                                        @endif
                                        <h2 class="link__text">
                                            @if(preg_match('/^.* и .*$/', $first_level_category['name_'.$lang]))
                                                @php $cat_name = explode(' и ', $first_level_category['name_'.$lang]); @endphp
                                                <span class="line">{{ $cat_name[0] }} {{ __('and') }}</span>
                                                <span class="line">{{ $cat_name[1] }}</span>
                                            @else
                                                <span class="line">{{ $first_level_category['name_'.$lang] }}</span>
                                            @endif
                                        </h2>
                                        <span class="link__control" aria-hidden="true">
                                            <svg role="img" aria-hidden="true" width="20" height="20">
                                                <use xlink:href="#svg-icon-down-arrow"></use>
                                            </svg>
                                        </span>
                                    </div>
                                </a>
                            </div>
                            <div class="col-12 col-lg-7">
                                <div class="row no-gutters">
                                    @php $promoCategory = $first_level_category->firstLevelCategoryPromoBlock; @endphp
                                    @php $newProduct = !is_null($promoCategory) ? $promoCategory->newProduct : null @endphp
                                    @php
                                        if((int)$first_level_category->id === 10392) {
                                            // Шкафы с умывальниками!!!
                                            $second_level_category = $first_level_category->childs()->where('id', 10410)->first();
                                        } else {
                                            $second_level_category = $first_level_category->getFirstChild();
                                        }
                                    @endphp
                                    @if($newProduct)
                                        <div class="col-12 col-md-4">
                                            <div class="rec-block rec-block_new">
                                                <div class="rec-block__content d-none d-md-block">
                                                    <div class="rec-block__header">
                                                        <a
                                                            class="rec-block__img"
                                                            href="{{$newProduct->getLink()}}"
                                                        >
                                                            @if(!$newProduct->images_table->isEmpty())
                                                                <picture class="rec-block__img">
                                                                    <source srcset="{{$newProduct->images_table[0]->getImageResizedSmall()}}" media="(min-width: 535px)">
                                                                    <source srcset="{{$newProduct->images_table[0]->getImageResizedMiddle()}}" media="(min-width: 0px)">
                                                                    <img src="{{$newProduct->images_table[0]->getImageResizedSmall()}}" alt="{{$newProduct['name_'.$lang]}}">
                                                                </picture>
                                                            @else
                                                                <img src="{{$newProduct->getPreviewPicture()}}" alt="{{$newProduct['name_'.$lang]}}">
                                                            @endif
                                                        </a>
                                                        <ul class="list list_unstyled rec-block__marks marks-list">
                                                            <li class="list__item bg_blue">{{ __('new_product') }}</li>
                                                        </ul>
                                                    </div>
                                                    <div class="rec-block__body">
                                                        <a
                                                            class="rec-block__title"
                                                            href="{{$newProduct->getLink()}}"
                                                        >
                                                            {{ $newProduct['name_'.$lang] }}
                                                        </a>
                                                        <div class="rec-block__price">
                                                            @if($newProduct->discount_price)
                                                                <span class="old">{{ $newProduct->price }}</span>
                                                                <span class="cost cost_new">{{ $newProduct->discount_price }}</span>
                                                            @else
                                                                <span class="cost">{{ $newProduct->price }}</span>
                                                            @endif
                                                            <span class="currency">{{__('currency_name')}}{{ $newProduct['unit_'.$lang] }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="rec-block__footer">
                                                    <a
                                                        class="link rec-block__link"
                                                        href="{{
                                                            (int)$first_level_category->id !== 10382
                                                            ? route('pages.catalog.ternary_index', [$first_level_category->slug, $second_level_category->slug]).'?new='.$newTag->id
                                                            //: route('pages.collections.catalog_index', [$first_level_category->slug, $second_level_category->slug])
                                                            : 'javascript:void(0);'
                                                        }}"
                                                        aria-label="{{ __('go_to_ternary_catalog_page') }}"
                                                    >
                                                        <span class="link__text">{{ __('new_product') }}</span>
                                                        @if((int)$first_level_category->id !== 10382)
                                                            <span class="link__control" aria-hidden="true">
                                                                <svg role="img" aria-hidden="true" width="20" height="20">
                                                                    <use xlink:href="#svg-icon-down-arrow"></use>
                                                                </svg>
                                                            </span>
                                                        @endif
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @php $promotionProduct = !is_null($promoCategory) ? $promoCategory->promotionProduct : null @endphp
                                    @if($promotionProduct)
                                        <div class="col-12 col-md-4">
                                            <div class="rec-block rec-block_sale">
                                                <div class="rec-block__content d-none d-md-block">
                                                    <div class="rec-block__header">
                                                        <a
                                                            class="rec-block__img"
                                                            href="{{$promotionProduct->getLink()}}"
                                                        >
                                                            @if(!$promotionProduct->images_table->isEmpty())
                                                                <picture class="rec-block__img">
                                                                    <source srcset="{{$promotionProduct->images_table[0]->getImageResizedSmall()}}" media="(min-width: 535px)">
                                                                    <source srcset="{{$promotionProduct->images_table[0]->getImageResizedMiddle()}}" media="(min-width: 0px)">
                                                                    <img src="{{$promotionProduct->images_table[0]->getImageResizedSmall()}}" alt="{{$promotionProduct['name_'.$lang]}}">
                                                                </picture>
                                                            @else
                                                                <img src="{{$promotionProduct->getPreviewPicture()}}" alt="{{$promotionProduct['name_'.$lang]}}">
                                                            @endif
                                                        </a>
                                                        @php $promotion_discount = get_promotion_discount_attribute_for_product($promotionProduct->tags) @endphp
                                                        @if((int)$first_level_category->id !== 10382)
                                                            @if((int)$promotion_discount !== 0)
                                                                <ul class="list list_unstyled rec-block__marks marks-list">
                                                                    <li class="list__item list__item_num bg_red">{{ $promotion_discount }}%</li>
                                                                </ul>
                                                            @endif
                                                        @else
                                                            <ul class="list list_unstyled rec-block__marks marks-list">
                                                                <li class="list__item list__item_num {{$saleTag->class}}">
                                                                    {{ $saleTag['name_'.$lang] }}
                                                                </li>
                                                            </ul>
                                                        @endif
                                                    </div>
                                                    <div class="rec-block__body">
                                                        <a
                                                            class="rec-block__title"
                                                            href="{{$promotionProduct->getLink()}}"
                                                        >
                                                            {{ $promotionProduct['name_'.$lang] }}
                                                        </a>
                                                        <div class="rec-block__price">
                                                            @if($promotionProduct->discount_price)
                                                                <span class="old">{{ $promotionProduct->price }}</span>
                                                                <span class="cost cost_new">{{ $promotionProduct->discount_price }}</span>
                                                            @else
                                                                <span class="cost">{{ $promotionProduct->price }}</span>
                                                            @endif
                                                            <span class="currency">{{__('currency_name')}}{{ $promotionProduct['unit_'.$lang] }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="rec-block__footer">
                                                    <a
                                                        class="link rec-block__link"
                                                        href="{{
                                                            (int)$first_level_category->id !== 10382
                                                            ? route('pages.catalog.ternary_index', [$first_level_category->slug, $second_level_category->slug]).'?sale='.$saleTag->id
                                                            //: route('pages.collections.catalog_index', [$first_level_category->slug, $second_level_category->slug])
                                                            : 'javascript:void(0);'
                                                        }}"
                                                        aria-label="{{ __('go_to_ternary_catalog_page') }}"
                                                    >
{{--                                                        @if((int)$first_level_category->id !== 10382)--}}
{{--                                                            <span class="link__text">{{ __('promotions') }}</span>--}}
{{--                                                        @else--}}
                                                            <span class="link__text">{{ __('sale') }}</span>
{{--                                                        @endif--}}
                                                        @if((int)$first_level_category->id !== 10382)
                                                            <span class="link__control" aria-hidden="true">
                                                                <svg role="img" aria-hidden="true" width="20" height="20">
                                                                    <use xlink:href="#svg-icon-down-arrow"></use>
                                                                </svg>
                                                            </span>
                                                        @endif
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-12 col-md-4">
                                        <div class="rec-block rec-block_brand">
                                            <div class="swiper-container js-slider-attached-product">
                                                <div class="swiper-wrapper">
                                                    @php $brands = $first_level_category->getBrands() @endphp
                                                    @foreach($brands as $brand)
                                                        <div class="swiper-slide">
                                                            <a
                                                                class="rec-block__brand"
                                                                href="{{ $brand['link_to_single_brand_page'] }}"
                                                                aria-label="{{ __('go_to_ternary_catalog_page') }}"
                                                                title="{{ $brand['name'] }}"
                                                            >
                                                                <img src="{{ $brand['image'] }}" alt="{{ $brand['name'] }}">
                                                            </a>
{{--                                                            @if($isTile)--}}
{{--                                                                <a--}}
{{--                                                                    class="rec-block__brand"--}}
{{--                                                                    href="{{ route('pages.collections.catalog_index', [$first_level_category->slug, $second_level_category->slug]).'?brand='.$brand['id'] }}"--}}
{{--                                                                    aria-label="{{ __('go_to_ternary_catalog_page') }}"--}}
{{--                                                                    title="{{ $brand['name'] }}"--}}
{{--                                                                >--}}
{{--                                                                    <img src="{{ $brand['image'] }}" alt="{{ $brand['name'] }}">--}}
{{--                                                                </a>--}}
{{--                                                            @else--}}
{{--                                                                <a--}}
{{--                                                                    class="rec-block__brand"--}}
{{--                                                                    href="{{ route('pages.catalog.ternary_index', [$first_level_category->slug, $second_level_category->slug]).'?brand='.$brand['id'] }}"--}}
{{--                                                                    aria-label="{{ __('go_to_ternary_catalog_page') }}"--}}
{{--                                                                    title="{{ $brand['name'] }}"--}}
{{--                                                                >--}}
{{--                                                                    <img src="{{ $brand['image'] }}" alt="{{ $brand['name'] }}">--}}
{{--                                                                </a>--}}
{{--                                                            @endif--}}
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <button class="swiper-button-prev" type="button">
                                                    <svg role="img" aria-hidden="true" width="30" height="30">
                                                        <use xlink:href="#svg-icon-down-arrow"></use>
                                                    </svg>
                                                </button>
                                                <button class="swiper-button-next" type="button">
                                                    <svg role="img" aria-hidden="true" width="30" height="30">
                                                        <use xlink:href="#svg-icon-down-arrow"></use>
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="rec-block__footer">
                                                <a class="link rec-block__link" href="{{ route('pages.brands.index') }}">
                                                    <span class="link__text">{{ __('brands') }}</span>
                                                    <span class="link__control" aria-hidden="true">
                                                        <svg role="img" aria-hidden="true" width="20" height="20">
                                                            <use xlink:href="#svg-icon-down-arrow"></use>
                                                        </svg>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="section__subcategories">
                    <div class="container">
                        <div class="row">
                            @if(count($categories) > 1)
                                @foreach($categories as $key => $second_level_category)
                                    <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                        <div class="category-block category-block_inner @php echo !array_key_exists('children', $second_level_category) ? 'category-block_empty' : '' @endphp" id="category-{{ $second_level_category['category_info']['slug'] }}">
                                            @if($isTile && !preg_match("/(soputstvuyushhie-tovary)-[0-9]+$/", $second_level_category['category_info']['slug']))
                                                <a class="link category-block__header" href="{{ route('pages.collections.catalog_index', [$first_level_category->slug, $second_level_category['category_info']['slug']]) }}">
                                                    <div class="link__bg" aria-hidden="true" style="background-image: url({{ $second_level_category['category_info']['logo'] ? asset('storage/'.$second_level_category['category_info']['logo']) : '' }});"></div>
                                                    <div class="link__content">
                                                        @if($second_level_category['category_info']['svg_logo'])
                                                            <span class="link__icon" aria-hidden="true">
                                                                <svg role="img" aria-hidden="true" width="30" height="30">
                                                                    @php preg_match("/icon-(.*)\.svg$/", \Storage::disk('public')->url('/'.$second_level_category['category_info']['svg_logo']), $m); @endphp
                                                                    <use xlink:href="#svg-icon-{{ $m[1] }}"></use>
                                                                </svg>
                                                            </span>
                                                        @endif
                                                        <h2 class="section__title link__text">
                                                            <span class="line">{{ $second_level_category['category_info']['name_'.$lang] }}</span>
                                                        </h2>
                                                    </div>
                                                </a>
                                            @else
                                                <a class="link category-block__header" href="{{ route('pages.catalog.ternary_index', [$first_level_category->slug, $second_level_category['category_info']['slug']]) }}">
                                                    <div class="link__bg" aria-hidden="true" style="background-image: url({{ $second_level_category['category_info']['logo'] ? asset('storage/'.$second_level_category['category_info']['logo']) : '' }});"></div>
                                                    <div class="link__content">
                                                        @if($second_level_category['category_info']['svg_logo'])
                                                            <span class="link__icon" aria-hidden="true">
                                                                <svg role="img" aria-hidden="true" width="30" height="30">
                                                                    @php preg_match("/icon-(.*)\.svg$/", \Storage::disk('public')->url('/'.$second_level_category['category_info']['svg_logo']), $m); @endphp
                                                                    <use xlink:href="#svg-icon-{{ $m[1] }}"></use>
                                                                </svg>
                                                            </span>
                                                        @endif
                                                        <h2 class="section__title link__text">
                                                            <span class="line">{{ $second_level_category['category_info']['name_'.$lang] }}</span>
                                                        </h2>
                                                    </div>
                                                </a>
                                            @endif
                                            <div class="category-block__content">
                                                <ul class="list list_unstyled category-block__subcategories-list">
                                                    @if(array_key_exists('children', $second_level_category) && count($second_level_category['children']) > 0)
                                                        {{-- put related products subcategory to end --}}
                                                        @php
                                                            $related_products_subcategory = '';

                                                            foreach ($second_level_category['children'] as $key => $child) {
                                                                if(preg_match("/(soputstvuyushhie-tovary)-[0-9]+$/", $child['slug'])) {
                                                                    $related_products_subcategory = $second_level_category['children'][$key];
                                                                    unset($second_level_category['children'][$key]);
                                                                }
                                                            }

                                                            if(!empty($related_products_subcategory)) {
                                                                $second_level_category['children'][] = $related_products_subcategory;
                                                            }
                                                        @endphp
                                                        @foreach($second_level_category['children'] as $key => $third_level_category)
                                                            <li class="list__item">
                                                                <a
                                                                    class="link"
                                                                    href="{{ route('pages.catalog.ternary_index', [
                                                                $first_level_category->slug,
                                                                $second_level_category['category_info']['slug'],
                                                                $third_level_category['slug']])
                                                            }}"
                                                                >
                                                                    {{ $third_level_category['name_'.$lang] }}
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
