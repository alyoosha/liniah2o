<template>
    <main class="main-content" id="main-content">
        <section class="section section_inner-page section_catalog">
            <div class="section__header">
                <div class="container">
                    <div class="section__breadcrumbs">
                        <ul class="list list_unstyled breadcrumbs-list">
                            <li class="list__item"><a class="link" :href="'/'+language">{{ __('homepage') }}</a></li>
                            <li class="list__item"><a class="link" :href="link_to_main_catalog_page">{{ __('catalog') }}</a></li>
                            <li class="list__item"><a class="link" :href="link_to_secondary_catalog_page">{{ __('tile') }}</a></li>
                            <li class="list__item"><a class="link active" href="javascript: void(0);">{{ active_category_collection['name_'+language] }}</a></li>
                        </ul>
                    </div>
                    <div class="section__title section__title_style1">
                        <h1>{{ active_category_collection['name_'+language] }}</h1>
                    </div>
                </div>
            </div>
            <div class="section__body section__body_products">
                <div class="container">
                    <div class="row">
                        <div class="col-12 aside-column">
                            <div class="filter-controls d-block d-lg-none">
                                <div class="row justify-content-between">
                                    <div class="col-auto">
                                        <button class="btn btn_dark btn_default btn_filter btn_with-icon js-filter-panel-opener" type="button">
                                            <span class="btn__icon" aria-hidden="true">
                                                <svg role="img" aria-hidden="true" width="25" height="25">
                                                    <use xlink:href="#svg-icon-settings"></use>
                                                </svg>
                                            </span>
                                            <span class="btn__text">{{ __('filter') }}</span>
                                        </button>
                                    </div>
                                    <div class="col-auto">
                                        <button class="btn btn_gray btn_icon btn_menu js-categories-panel-opener" type="button" :aria-label="__('menu')" aria-controls="categories-menu">
                                            <svg role="img" aria-hidden="true" width="25" height="25">
                                                <use xlink:href="#svg-icon-menu"></use>
                                            </svg>
                                        </button>
                                        <div class="categories-menu collapse" id="categories-menu">
                                            <button class="btn categories-menu__control js-categories-panel-closer" type="button" aria-controls="categories-menu">
                                                <span class="btn__text section__title">{{ __('categories') }}</span>
                                                <span class="btn__icon" aria-hidden="true">
                                            <svg role="img" aria-hidden="true" width="20" height="20">
                                                <use xlink:href="#svg-icon-cancel"></use>
                                            </svg>
                                        </span>
                                            </button>
                                            <div class="categories-block">
                                                <a class="categories-block__header" :href="link_to_secondary_catalog_page">
                                                    <div class="categories-block__icon" aria-hidden="true">
                                                        <svg role="img" width="20" height="20">
                                                            <use xlink:href="#svg-icon-menu"></use>
                                                        </svg>
                                                    </div>
                                                    <div class="categories-block__title section__title">{{ __('all_catalog_categories') }}</div>
                                                </a>
                                                <div class="categories-block__body">
                                                    <ul class="list list_unstyled categories-block__list">
                                                        <li
                                                            class="list__item"
                                                            v-if="Number.parseInt(collection.is_active)"
                                                            v-for="collection in tile_collections"
                                                            :key="collection.id"
                                                        >
                                                            <a
                                                                v-if="collection.slug === 'soputstvuyushhie-tovary-10390'"
                                                                class="link"
                                                                :class="{active : collection.slug === active_category_collection_slug}"
                                                                :href="additional_products_url"
                                                            >
                                                                {{ collection['name_'+language] }}
                                                            </a>
                                                            <a
                                                                v-else
                                                                class="link"
                                                                :class="{active : collection.slug === active_category_collection_slug}"
                                                                href="javascript:void(0);"
                                                                @click="changeCollection(collection)"
                                                            >
                                                                {{ collection['name_'+language] }}
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <aside class="filter-panel">
                                <div class="filter-panel__header d-block d-lg-none">
                                    <button class="btn btn_close js-filter-panel-closer" type="button">
                                <span class="btn__icon" aria-hidden="true">
                                    <svg role="img" aria-hidden="true" width="20" height="20">
                                        <use xlink:href="#svg-icon-cancel"></use>
                                    </svg>
                                </span>
                                        <span class="btn__text">{{ __('close_filter') }}</span>
                                    </button>
                                </div>
                                <div class="filter-panel__content">
                                    <div class="filter-panel__group d-none d-lg-block">
                                        <div class="categories-block">
                                            <a class="categories-block__header" :href="link_to_secondary_catalog_page">
                                                <div class="categories-block__icon" aria-hidden="true">
                                                    <svg role="img" width="20" height="20">
                                                        <use xlink:href="#svg-icon-menu"></use>
                                                    </svg>
                                                </div>
                                                <div class="categories-block__title section__title">{{ __('all_catalog_categories') }}</div>
                                            </a>
                                            <div class="categories-block__body">
                                                <ul class="list list_unstyled categories-block__list">
                                                    <li
                                                        class="list__item"
                                                        v-if="Number.parseInt(collection.is_active)"
                                                        v-for="collection in tile_collections"
                                                        :key="collection.id"
                                                    >
                                                        <a
                                                            v-if="collection.slug === 'soputstvuyushhie-tovary-10390'"
                                                            class="link"
                                                            :class="{active : collection.slug === active_category_collection_slug}"
                                                            :href="additional_products_url"
                                                        >
                                                            {{ collection['name_'+language] }}
                                                        </a>
                                                        <a
                                                            v-else
                                                            class="link"
                                                            :class="{active : collection.slug === active_category_collection_slug}"
                                                            href="javascript:void(0);"
                                                            @click="changeCollection(collection)"
                                                        >
                                                            {{ collection['name_'+language] }}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- PRICE -->
                                    <div class="filter-panel__group">
                                        <div class="filter-panel__title section__title">{{ __('price') }}</div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="form-label form-label_hidden" for="filter-start-price">{{ __('price_from') }}</label>
                                                    <input @input="setPriceFrom($event)" class="form-control" type="number" id="filter-start-price" name="filter-start-price" :placeholder="__('price_from')">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="form-label form-label_hidden" for="filter-end-price">{{ __('price_to') }}</label>
                                                    <input @input="setPriceTo($event)" class="form-control" type="number" id="filter-end-price" name="filter-end-price" :placeholder="__('price_to')">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- COUNTRY -->
                                    <div class="filter-panel__group filter-panel__group_collapsed" v-show="countriesListLength > 0">
                                        <button class="filter-panel__control collapsed js-filter-panel-toggler" :aria-label="__('show_hide_filter')+' '+__('country')">
                                            <span class="btn__text filter-panel__title section__title">{{ __('country') }}</span>
                                            <span class="btn__icon" aria-hidden="true">
                                        <svg role="img" aria-hidden="true" width="14" height="14">
                                            <use xlink:href="#svg-icon-down-arrow"></use>
                                        </svg>
                                    </span>
                                        </button>
                                        <div class="filter-panel__collapse collapse">
                                            <ul class="list list_unstyled checkbox-list">
                                                <li class="list__item checkbox" v-for="country in previewCountries" :key="country.id" @change="addFilterValue($event, 'country', country.id, country['name_'+language])">
                                                    <label class="checkbox__label">
                                                        <input class="checkbox__hidden" type="checkbox" v-model="filters.country" :name="'filter-country-top-'+country.id" :value="country.id">
                                                        <span class="checkbox__custom" aria-hidden="true"></span>
                                                        <span class="checkbox__text">{{ country['name_'+language] }} <span class="color_gray counter">{{ country.count }}</span></span>
                                                    </label>
                                                </li>
                                            </ul>
                                            <div class="btn-wrapper dropdown dropright" v-if="countriesListLength > defaultPreviewFilterLength">
                                                <!--чтобы показать прелоадер, нужно кнопке добавить класс btn_load-->
                                                <button class="btn btn_show-all btn_loader btn_full" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="btn__text">{{ __('all') }} {{ countriesListLength }} {{ getMultilanguageVariant(countriesListLength) }}</span>
                                                    <span class="btn__icon">
                                                <svg class="default-icon" role="img" aria-hidden="true" width="14" height="14">
                                                    <use xlink:href="#svg-icon-down-arrow"></use>
                                                </svg>
                                                <svg class="loader-icon" role="img" aria-hidden="true" width="14" height="14">
                                                    <use xlink:href="#svg-icon-loader"></use>
                                                </svg>
                                            </span>
                                                </button>
                                                <div class="dropdown-menu bg_white">
                                                    <div class="dropdown-menu__content scrollbar-inner">
                                                        <ul class="list list_unstyled checkbox-list checkbox-list_two-col">
                                                            <li class="list__item checkbox" v-for="country in countries" :key="country.id" @change="addFilterValue($event, 'country', country.id, country['name_'+language])">
                                                                <label class="checkbox__label">
                                                                    <input class="checkbox__hidden" type="checkbox" v-model="filters.country" :name="'filter-country-top-'+country.id" :value="country.id">
                                                                    <span class="checkbox__custom" aria-hidden="true"></span>
                                                                    <span class="checkbox__text">{{ country['name_'+language] }} <span class="color_gray counter">{{ country.count }}</span></span>
                                                                </label>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- BRANDS -->
                                    <div class="filter-panel__group filter-panel__group_collapsed" v-show="brandsListLength > 0">
                                        <button class="filter-panel__control collapsed js-filter-panel-toggler" :aria-label="__('show_hide_filter')+' '+__('brand')">
                                            <span class="btn__text filter-panel__title section__title">{{ __('brand') }}</span>
                                            <span class="btn__icon" aria-hidden="true">
                                        <svg role="img" aria-hidden="true" width="14" height="14">
                                            <use xlink:href="#svg-icon-down-arrow"></use>
                                        </svg>
                                    </span>
                                        </button>
                                        <div class="filter-panel__collapse collapse">
                                            <ul class="list list_unstyled checkbox-list">
                                                <li class="list__item checkbox" v-for="brand in previewBrands" :key="brand.id" @change="addFilterValue($event, 'brand', brand.id, brand.name)">
                                                    <label class="checkbox__label">
                                                        <input class="checkbox__hidden" type="checkbox" v-model="filters.brand" :name="'filter-brand-top-'+brand.id" :value="brand.id">
                                                        <span class="checkbox__custom" aria-hidden="true"></span>
                                                        <span class="checkbox__text">{{ brand.name }} <span class="color_gray counter">{{ brand.count }}</span></span>
                                                    </label>
                                                </li>
                                            </ul>
                                            <div class="btn-wrapper dropdown dropright" v-if="brandsListLength > defaultPreviewFilterLength">
                                                <!--чтобы показать прелоадер, нужно кнопке добавить класс btn_load-->
                                                <button class="btn btn_show-all btn_loader btn_full" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="btn__text">{{ __('all') }} {{ brandsListLength }} {{ getMultilanguageVariant(brandsListLength) }}</span>
                                                    <span class="btn__icon">
                                                <svg class="default-icon" role="img" aria-hidden="true" width="14" height="14">
                                                    <use xlink:href="#svg-icon-down-arrow"></use>
                                                </svg>
                                                <svg class="loader-icon" role="img" aria-hidden="true" width="14" height="14">
                                                    <use xlink:href="#svg-icon-loader"></use>
                                                </svg>
                                            </span>
                                                </button>
                                                <div class="dropdown-menu bg_white">
                                                    <div class="dropdown-menu__content scrollbar-inner">
                                                        <ul class="list list_unstyled checkbox-list checkbox-list_two-col">
                                                            <li class="list__item checkbox" v-for="brand in brands" :key="brand.id" @change="addFilterValue($event, 'brand', brand.id, brand.name)">
                                                                <label class="checkbox__label">
                                                                    <input class="checkbox__hidden" type="checkbox" v-model="filters.brand" :name="'filter-brand-top-'+brand.id" :value="brand.id">
                                                                    <span class="checkbox__custom" aria-hidden="true"></span>
                                                                    <span class="checkbox__text">{{ brand.name }} <span class="color_gray counter">{{ brand.count }}</span></span>
                                                                </label>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- DYNAMIC PROPS -->
                                    <div class="more-filters collapse" id="more-filters">
                                        <div class="filter-panel__group filter-panel__group_collapsed" v-show="feature_type.filtered_features.length > 0" v-for="feature_type in computedFeatureTypes" :key="feature_type.id">
                                            <button class="filter-panel__control collapsed js-filter-panel-toggler" :aria-label="__('show_hide_filter')+' '+feature_type['name_'+language]">
                                                <span class="btn__text filter-panel__title section__title">{{ feature_type['name_'+language] }}</span>
                                                <span class="btn__icon" aria-hidden="true">
                                                    <svg role="img" aria-hidden="true" width="14" height="14">
                                                        <use xlink:href="#svg-icon-down-arrow"></use>
                                                    </svg>
                                                </span>
                                            </button>
                                            <div class="filter-panel__collapse collapse">
                                                <ul class="list list_unstyled checkbox-list">
                                                    <li class="list__item checkbox" v-for="feature in feature_type.filtered_features.slice(0, defaultPreviewFilterLength)" :key="feature.id" @change="addFilterValue($event, 'features', feature.id, feature['value_'+language])">
                                                        <label class="checkbox__label">
                                                            <input class="checkbox__hidden" type="checkbox" v-model="filters.features" :name="'filter-shape-'+feature['value_'+language]" :value="feature.id">
                                                            <span class="checkbox__custom" aria-hidden="true"></span>
                                                            <span class="checkbox__text">{{ feature['value_'+language] }} <span class="color_gray counter">{{ feature.count }}</span></span>
                                                        </label>
                                                    </li>
                                                </ul>
                                                <div class="btn-wrapper dropdown dropright" v-if="feature_type.filtered_features.length > defaultPreviewFilterLength">
                                                    <!--чтобы показать прелоадер, нужно кнопке добавить класс btn_load-->
                                                    <button class="btn btn_show-all btn_loader btn_full" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <span class="btn__text">{{ __('all') }} {{ feature_type.filtered_features.length }} {{ getMultilanguageVariant(feature_type.filtered_features.length) }}</span>
                                                        <span class="btn__icon">
                                                            <svg class="default-icon" role="img" aria-hidden="true" width="14" height="14">
                                                                <use xlink:href="#svg-icon-down-arrow"></use>
                                                            </svg>
                                                            <svg class="loader-icon" role="img" aria-hidden="true" width="14" height="14">
                                                                <use xlink:href="#svg-icon-loader"></use>
                                                            </svg>
                                                        </span>
                                                    </button>
                                                    <div class="dropdown-menu bg_white">
                                                        <div class="dropdown-menu__content scrollbar-inner">
                                                            <ul class="list list_unstyled checkbox-list checkbox-list_two-col">
                                                                <li class="list__item checkbox" v-for="feature in feature_type.filtered_features" :key="feature.id" @change="addFilterValue($event, 'features', feature.id, feature['value_'+language])">
                                                                    <label class="checkbox__label">
                                                                        <input class="checkbox__hidden" type="checkbox" v-model="filters.features" :name="'filter-color-top-'+feature.id" :value="feature.id">
                                                                        <span class="checkbox__custom" aria-hidden="true"></span>
                                                                        <span class="checkbox__text">{{ feature['value_'+language] }} <span class="color_gray counter">{{ feature.count }}</span></span>
                                                                    </label>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button v-show="computedFeatureTypes.length > 0" class="btn more-filters-btn collapsed" type="button" data-toggle="collapse" data-target="#more-filters" aria-expanded="false" aria-controls="more-filters">
                                        <span class="btn__text btn__text_closed">{{ __('additional_filters') }}</span>
                                        <span class="btn__text btn__text_opened">{{ __('hide_additional_filters') }}</span>
                                    </button>
                                </div>
                                <div class="filter-panel__footer">
                                    <div class="btn-wrapper">
                                        <span class="section__title btn-wrapper__title">{{ __('found_products') }} {{ totalCount }}</span>
                                        <button v-show="filter_values_list.length > 0 || filters.price.from != '' || filters.price.to != ''" class="btn btn_icon js-filter-clean-open" type="button" :aria-label="__('clear_filter')">
                                            <svg role="img" aria-hidden="true" width="20" height="20">
                                                <use xlink:href="#svg-icon-cancel"></use>
                                            </svg>
                                        </button>
                                    </div>
                                    <button class="btn btn_clean js-filter-clean" type="button" @click="clearFilter()">
                                        <span class="btn__text">{{ __('clear_filter') }}</span>
                                    </button>
                                </div>
                            </aside>
                        </div>
                        <div v-if="paginatedCollection.length === 0" class="col-12 content-column">
                            <div class="catalog-empty">
                                <div class="catalog-empty__icon" aria-hidden="true">
                                    <svg role="img" width="100" height="100">
                                        <use xlink:href="#svg-icon-box"></use>
                                    </svg>
                                </div>
                                <div class="section__title catalog-empty__text">{{ __('catalog_is_empty') }}</div>
                            </div>
                        </div>
                        <div v-else class="col-12 content-column">
                            <div class="catalog-controls">
                                <div class="row align-items-end justify-content-between">
                                    <!-- FILTER LIST -->
                                    <div class="col-12 col-lg-6">
                                        <ul class="list list_unstyled tag-list row">
                                            <li class="col-auto list__item" v-for="(item, index) in filter_values_list" :key="index">
                                                <div class="tag-block">
                                                    <div class="tag-block__title section__title">{{ item.display_value }}</div>
                                                    <button class="tag-block__remove" type="button" :aria-label="__('delete_filter_value')" @click="removeFilterValue(item.prefix, item.filter_value)">
                                                        <svg role="img" aria-hidden="true" width="10" height="10">
                                                            <use xlink:href="#svg-icon-cancel"></use>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- SORTING -->
                                    <div class="col-12 col-lg-6">
                                        <ul class="list list_unstyled sort-list">
                                            <li class="list__item dropdown">
                                                <button class="js-dropdown-btn btn btn_current" type="button" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
                                                    <span class="btn__text">{{ active_sorting_filter['btn_display_'+language] }}</span>
                                                    <span class="btn__icon" aria-hidden="true">
                                                <svg role="img" aria-hidden="true" width="10" height="10">
                                                    <use xlink:href="#svg-icon-down-arrow"></use>
                                                </svg>
                                            </span>
                                                </button>
                                                <ul class="list list_unstyled dropdown-menu dropdown-menu-lg-right dropdown-menu-left">
                                                    <li
                                                        v-for="(sort_by_item, index) in sorting_by_filters"
                                                        :key="index"
                                                        class="list__item"
                                                    >
                                                        <a
                                                            class="link"
                                                            :class="{active: sort_by_item.value === active_sorting_filter.value}"
                                                            href="javascript: void(0);"
                                                            @click="changeSortingByFilter(sort_by_item)"
                                                        >
                                                    <span class="link__icon" aria-hidden="true">
                                                        <svg role="img" aria-hidden="true" width="14" height="14">
                                                            <use xlink:href="#svg-icon-verified2"></use>
                                                        </svg>
                                                    </span>
                                                            <span class="link__text">{{ sort_by_item['list_display_'+language] }}</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="list__item dropdown">
                                                <button class="btn btn_current" type="button" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
                                                    <span class="btn__text">{{ __('display_per') }} {{ collections_per_page }}</span>
                                                    <span class="btn__icon" aria-hidden="true">
                                                <svg role="img" aria-hidden="true" width="10" height="10">
                                                    <use xlink:href="#svg-icon-down-arrow"></use>
                                                </svg>
                                            </span>
                                                </button>
                                                <ul class="list list_unstyled dropdown-menu dropdown-menu-lg-right dropdown-menu-left">
                                                    <li class="list__item" v-for="(sort_by_item, index) in sorting_per_page_list" :key="index">
                                                        <a
                                                            class="link"
                                                            :class="{active: collections_per_page === sort_by_item}"
                                                            href="javascript: void(0);"
                                                            @click="changePerPage($event, sort_by_item)"
                                                        >
                                                    <span class="link__icon" aria-hidden="true">
                                                        <svg role="img" aria-hidden="true" width="14" height="14">
                                                            <use xlink:href="#svg-icon-verified2"></use>
                                                        </svg>
                                                    </span>
                                                            <span class="link__text">{{ sort_by_item }}</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="catalog-products catalog-collections">
                                <div class="row">
                                    <div
                                        class="col-12 col-xl-6"
                                        v-for="item in paginatedCollectionFirstPart"
                                        :key="item.id"
                                    >
                                        <div class="collection-card" tabindex="0">
                                            <div class="collection-card__content">
                                                <div class="collection-card__header">
                                                    <a v-lazyload class="collection-card__img background-img" aria-hidden="true" :href="item.collection_link">
                                                        <picture class="image__wrapper" v-lazyload>
                                                            <source v-if="item['imagesResized'] != undefined && item['imagesResized'].length > 0"
                                                                    :srcset="item['imagesResized'][1]"
                                                                    media="(min-width: 535px)">
                                                            <source v-if="item['imagesResized'] != undefined && item['imagesResized'].length > 0"
                                                                    :srcset="item['imagesResized'][0]"
                                                                    media="(min-width: 0px)">
                                                            <img v-if="item['imagesResized'] != undefined && item['imagesResized'].length > 0"
                                                                 :data-src="item['imagesResized'][1]"
                                                                 :alt="item['name_'
                                                              + language]" class="image__item">
                                                            <img v-else :data-src="item['preview_picture']"
                                                                 :alt="item['name_' + language]" class="image__item">
                                                        </picture>
                                                    </a>
                                                    <div class="collection-card__slider-wrapper">
                                                        <a class="collection-card__brand brand-block" :href="'/' + language + '/brands'" :aria-label="__('go_to_brand')+item.brand_name" :title="item.brand_name">
                                                            <div class="brand-block__img" aria-hidden="true">
                                                                <img :src="item.brand_image" :alt="item.brand_name">
                                                            </div>
                                                        </a>
                                                        <div class="collection-previews">
                                                            <div class="swiper-container js-catalog-collections-previews">
                                                                <div class="swiper-wrapper">
                                                                    <div class="swiper-slide" v-for="product in item.products">
                                                                        <a class="collection-previews-block" :href="product.link" :aria-label="product['name_'+language]" :title="product['name_'+language]">
                                                                            <div v-lazyload class="image__wrapper collection-previews-block__img background-img">
                                                                                <img class="image__item" :data-src="product.preview_picture" :alt="product['name_'+language]">
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                </div>
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
                                                    </div>
                                                </div>
                                                <div class="collection-card__body">
                                                    <div class="collection-card__info">
                                                        <div class="collection-title">
                                                            <div class="collection-title__icon" aria-hidden="true">
                                                                <svg role="img" width="30" height="30">
                                                                    <use xlink:href="#svg-icon-collection"></use>
                                                                </svg>
                                                            </div>
                                                            <div class="collection-title__content">
                                                                <div class="collection-title__category">
                                                                    <h2>{{ __('collection') }}</h2>
                                                                </div>
                                                                <a class="collection-title__label" :href="item.collection_link">
                                                                    <h1>{{ item['name_'+language] }}</h1>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="collection-card__price">
                                                        <span class="text">{{ __('price_from_lowercase') }}</span>
                                                        <span v-if="item.discount_price > 0" class="old">{{ Number.parseInt(item.price).toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ").trim() }}</span>
                                                        <span v-if="item.discount_price > 0" class="cost cost_new">{{ Number.parseInt(item.discount_price).toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ").trim() }}</span>
                                                        <span v-else class="cost">{{ Number.parseInt(item.price).toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ").trim() }}</span>
                                                        <span class="currency">
                                                            {{ __('currency_name') }}
                                                            {{ item['unit_'+language] }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="catalog-banners">
                                            <div class="swiper-container js-banners-slider">
                                                <div class="swiper-wrapper">
                                                    <div class="swiper-slide" v-for="slide in JSON.parse(slides)" :key="slide.id">
                                                        <a class="banner-block color_white bg_gray-dark" :href="slide.url">
                                                            <picture>
                                                                <source :srcset="slide.link_desktop" media="(min-width: 768px)">
                                                                <source :srcset="slide.link_mobile" media="(min-width: 0)">
                                                                <img :src="slide.link_desktop" alt="banner">
                                                            </picture>
                                                        </a>
                                                    </div>
                                                    <div class="swiper-pagination"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="col-12 col-xl-6"
                                        v-for="item in paginatedCollectionSecondPart"
                                        :key="item.id"
                                    >
                                        <div class="collection-card" tabindex="0">
                                            <div class="collection-card__content">
                                                <div class="collection-card__header">
                                                    <a v-lazyload class="collection-card__img background-img" aria-hidden="true" :href="item.collection_link">
                                                        <picture class="image__wrapper" v-lazyload>
                                                            <source v-if="item['imagesResized'] != undefined && item['imagesResized'].length > 0"
                                                                    :srcset="item['imagesResized'][1]"
                                                                    media="(min-width: 535px)">
                                                            <source v-if="item['imagesResized'] != undefined && item['imagesResized'].length > 0"
                                                                    :srcset="item['imagesResized'][0]"
                                                                    media="(min-width: 0px)">
                                                            <img v-if="item['imagesResized'] != undefined && item['imagesResized'].length > 0"
                                                                 :data-src="item['imagesResized'][1]"
                                                                 :alt="item['name_'
                                                              + language]" class="image__item">
                                                            <img v-else :data-src="item['preview_picture']"
                                                                 :alt="item['name_' + language]" class="image__item">
                                                        </picture>
                                                    </a>
                                                    <div class="collection-card__slider-wrapper">
                                                        <a class="collection-card__brand brand-block" :href="'/' + language + '/brands'" :aria-label="__('go_to_brand')+item.brand_name" :title="item.brand_name">
                                                            <div class="brand-block__img" aria-hidden="true">
                                                                <img :src="item.brand_image" :alt="item.brand_name">
                                                            </div>
                                                        </a>
                                                        <div class="collection-previews">
                                                            <div class="swiper-container js-catalog-collections-previews">
                                                                <div class="swiper-wrapper">
                                                                    <div class="swiper-slide" v-for="product in item.products">
                                                                        <a class="collection-previews-block" :href="product.link" :aria-label="product['name_'+language]" :title="product['name_'+language]">
                                                                            <div v-lazyload class="image__wrapper collection-previews-block__img background-img">
                                                                                <img class="image__item" :data-src="product.preview_picture" :alt="product['name_'+language]">
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                </div>
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
                                                    </div>
                                                </div>
                                                <div class="collection-card__body">
                                                    <div class="collection-card__info">
                                                        <div class="collection-title">
                                                            <div class="collection-title__icon" aria-hidden="true">
                                                                <svg role="img" width="30" height="30">
                                                                    <use xlink:href="#svg-icon-collection"></use>
                                                                </svg>
                                                            </div>
                                                            <div class="collection-title__content">
                                                                <div class="collection-title__category">
                                                                    <h2>{{ __('collection') }}</h2>
                                                                </div>
                                                                <a class="collection-title__label" :href="item.collection_link">
                                                                    <h1>{{ item['name_'+language] }}</h1>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="collection-card__price">
                                                        <span class="text">{{ __('price_from_lowercase') }}</span>
                                                        <span v-if="item.discount_price > 0" class="old">{{ Number.parseInt(item.price).toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ").trim() }}</span>
                                                        <span v-if="item.discount_price > 0" class="cost cost_new">{{ Number.parseInt(item.discount_price).toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ").trim() }}</span>
                                                        <span v-else class="cost">{{ Number.parseInt(item.price).toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ").trim() }}</span>
                                                        <span class="currency">
                                                            {{ __('currency_name') }}
                                                            {{ item['unit_'+language] }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="catalog-products__footer pagination-block" v-show="pageCount > 1">
                                    <div class="row">
                                        <div class="show-more" v-show="collection.length !== paginatedCollection.length && page_number !== pageCount">
                                            <!--все кнопки с классом btn_loader при добавлении класса .btn_loader_show меняют иконку на прелоадер-->
                                            <button class="btn btn_show-more btn_bordered btn_loader js-show-more" type="button" @click="show_more()">
                                                <span class="btn__text">{{ __('show_more') }}</span>
                                                <span class="btn__icon" aria-hidden="true">
                                            <svg class="default-icon" role="img" aria-hidden="true" width="10" height="10">
                                                <use xlink:href="#svg-icon-down-arrow"></use>
                                            </svg>
                                            <svg class="loader-icon" role="img" aria-hidden="true" width="10" height="10">
                                                <use xlink:href="#svg-icon-loader"></use>
                                            </svg>
                                        </span>
                                            </button>
                                        </div>
                                        <div class="pagination">
                                            <div class="pagination__current">
                                                <button class="btn pagination__current-btn btn_bordered js-pagination-opener" type="button" :aria-label="__('change_page')">
                                                    <span class="btn__text">{{ page_number === 0 ? page_number + 1 : page_number }}</span>
                                                    <span class="btn__icon" aria-hidden="true">
                                                <svg role="img" aria-hidden="true" width="10" height="10">
                                                    <use xlink:href="#svg-icon-down-arrow"></use>
                                                </svg>
                                            </span>
                                                </button>
                                            </div>
                                            <div class="pagination__block">
                                                <div class="pagination__content">
                                                    <div class="scrollbar-inner">
                                                        <ul class="list list_unstyled pagination__list">
                                                            <div class="list__item" v-for="page in pageCount" :key="page">
                                                                <a
                                                                    class="link btn js-pagination-link"
                                                                    :class="{ active : page===page_number }"
                                                                    :disabled="page===page_number"
                                                                    :aria-label="__('page')+page"
                                                                    @click="go_to(page)">{{ page }}
                                                                </a>
                                                            </div>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="pagination__control">
                                                    <button class="btn pagination__control-btn js-pagination-closer" type="button" :aria-label="__('close')">
                                                        <span class="btn__icon" aria-hidden="true">
                                                            <svg role="img" aria-hidden="true" width="20" height="20">
                                                                <use xlink:href="#svg-icon-cancel"></use>
                                                            </svg>
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</template>

<script>
    import Swiper from 'swiper';

    export default {
        props: {
            language: {
                type: String
            },
            link_to_main_catalog_page: {
                type: String, default: ''
            },
            link_to_secondary_catalog_page: {
                type: String, default: ''
            },
            category_collection: {
                type: String, default: ''
            },
            tile_collections_default: {
                type: String, default: ''
            },
            default_collection: {
                type: String, default: ''
            },
            slides: {
                type: String, default: ''
            },
            brands_default: {
                type: String, default: ''
            },
            countries_default: {
                type: String, default: ''
            },
            first_level_slug: {
                type: String, default: ''
            },
            feature_types_default: {
                type: String, default: ''
            },
            additional_products_url: {
                type: String, default: ''
            }
        },
        data: () => {
            return {
                sorting_per_page_list: [
                    16, 32, 64
                ],
                active_sorting_filter: {
                    btn_display_ru: 'Сначала популярные',
                    btn_display_ro: 'Popular prima',
                    list_display_ru: 'По популярности',
                    list_display_ro: 'După popularitate',
                    value: 'popular'
                },
                filter_values_list: [],
                sorting_by_filters: [
                    {
                        btn_display_ru: 'Сначала популярные',
                        btn_display_ro: 'Popular prima',
                        list_display_ru: 'По популярности',
                        list_display_ro: 'După popularitate',
                        value: 'popular'
                    },
                    {
                        btn_display_ru: 'По возрастанию цены',
                        btn_display_ro: 'Prețuri în creștere',
                        list_display_ru: 'По возрастанию цены',
                        list_display_ro: 'Prețuri în creștere',
                        value: 'price_up'
                    },
                    {
                        btn_display_ru: 'По убыванию цены',
                        btn_display_ro: 'Preț descendent',
                        list_display_ru: 'По убыванию цены',
                        list_display_ro: 'Preț descendent',
                        value: 'price_down'
                    }
                ],
                filters: {
                    price: {
                        'from': '',
                        'to': '',
                    },
                    country: [],
                    brand: [],
                    features: []
                },

                active_category_collection_slug: '',
                active_category_collection: {},
                tile_collections: [],
                brands: [],
                countries: [],
                feature_types: [],

                collection: [],
                paginatedCollection: [],
                paginatedCollectionFirstPart: [],
                paginatedCollectionSecondPart: [],
                page_number: 0,
                collections_per_page: 16,
                defaultPreviewFilterLength: 6,
            }
        },
        watch: {
            'filters': {
                handler() {
                    let category_slug = this.active_category_collection_slug;

                    // $('.preloader').show();

                    axios.post('/api/catalog/filterCollections', {
                        lang: this.language,
                        filters: this.filters,
                        category_slug
                    })
                        .then(response => {
                            this.collection = response.data;
                            this.sliceCollections();

                            // $('.preloader').hide();
                        })
                        .catch(error => {
                            console.log(error)
                        });
                },
                deep: true
            },
            // 'feature_types': {
            //     handler() {
            //         if(this.feature_types.length > 0) {
            //             $('#more-filters .filter-panel__group').each(function() {
            //                 console.log(123)
            //
            //                 $('.js-filter-panel-toggler').off('click').on("click", function (e) {
            //                     e.preventDefault();
            //                     var btn = $(this);
            //
            //                     btn.next(".collapse").collapse("toggle");
            //                     btn.toggleClass("collapsed");
            //                 });
            //             })
            //         }
            //     }
            // }
        },
        computed: {
            computedFeatureTypes() {
                return this.feature_types;
            },
            pageCount() {
                let length = this.collection.length;
                return Math.ceil(length/this.collections_per_page)
            },
            totalCount() {
                return this.collection.length;
            },
            previewCountries() {
                if(Object.entries(this.countries).length <= this.defaultPreviewFilterLength) {
                    return this.countries;
                } else {
                    return Object.entries(this.countries).slice(0, this.defaultPreviewFilterLength).map(elem => elem[1])
                }
            },
            countriesListLength() {
                return Object.entries(this.countries).map(elem => elem[1]).length
            },
            previewBrands() {
                if(Object.entries(this.brands).length <= this.defaultPreviewFilterLength) {
                    return this.brands;
                } else {
                    return Object.entries(this.brands).slice(0, this.defaultPreviewFilterLength).map(elem => elem[1])
                }
            },
            brandsListLength() {
                return Object.entries(this.brands).map(elem => elem[1]).length
            },
        },
        beforeMount() {
            this.active_category_collection = JSON.parse(this.category_collection);
            this.active_category_collection_slug = this.active_category_collection.slug;
            this.tile_collections = JSON.parse(this.tile_collections_default);

            this.collection = JSON.parse(this.$props.default_collection);
            this.sliceCollections();

            this.brands = JSON.parse(this.$props.brands_default);

            if(this.$props.feature_types_default.length > 0) {
                this.feature_types = JSON.parse(this.$props.feature_types_default);
            }

            // if brand is active before we load page
            Object.entries(this.brands).forEach((brand) => {
                let b = brand[1];
                if(b.checked) {
                    this.filters.brand.push(b.id);
                    this.filter_values_list.push({prefix: 'brand', filter_value: b.id, display_value: b.name});
                }
            });

            this.countries = JSON.parse(this.$props.countries_default);
        },
        updated() {
            if( $(".js-filter-panel-toggler").length ) {
                $('.js-filter-panel-toggler').on("click", function (e) {
                    e.preventDefault();
                    var btn = $(this);

                    btn.next(".collapse").collapse("toggle");
                    btn.toggleClass("collapsed");
                });
            }
        },
        mounted() {
            setTimeout(this.sliderInicializing, 15);

            // remove query params from bar
            if($('.section_catalog').length) {
                let oldUrl = window.location.href;
                let segments = oldUrl.split("?");

                if(segments[1]) {
                    let newUrl = segments.slice(0, 1);

                    window.history.pushState("new", "new", newUrl);
                }
            }

            $(window).on('popstate', (e) => {
                var href = this.$parent.location.href.split('/');
                var active_collection;

                for(let collection of this.tile_collections) {
                    if( href[href.length - 1] == collection.slug ) {
                        active_collection = collection;
                        this.changeCollection(active_collection);
                    }
                }
            });
        },
        methods: {
            sliderInicializing() {
                if( $(".js-catalog-collections-previews").length ) {

                    $(".js-catalog-collections-previews").each((i, el)  => {
                        let catalogCollectionsPreviewsSwiper = new Swiper(el, {
                            speed: 1200,
                            autoplay: 5000,
                            spaceBetween: 1,
                            slidesPerView: 3,
                            followFinger: false,
                            //loop: true,
                            //loopedSlides: 5,
                            centerInsufficientSlides: true,
                            pagination: false,
                            navigation: {
                                nextEl: $(el).parent().find('.swiper-button-next')[0],
                                prevEl: $(el).parent().find('.swiper-button-prev')[0],
                            },
                            breakpoints: {
                                576: {
                                    slidesPerView: 4,
                                },
                                768: {
                                    slidesPerView: 6,
                                },
                                1200: {
                                    slidesPerView: 4,
                                },
                                1550: {
                                    slidesPerView: 5,
                                }
                            },
                        });
                    })
                }
            },
            changeCollection(category) {
                // if (category.slug === 'soputstvuyushhie-tovary-10390') {
                //     window.location.href = this.$props.additional_products_url;
                // }
                // $('.preloader').show();

                this.active_category_collection_slug = category.slug;
                this.active_category_collection = category;

                this.products_per_page = 16;
                this.active_sorting_filter = this.sorting_by_filters[0];
                this.clearFilter();

                var href = this.$parent.location.href.split('/');
                if( href[href.length - 1] != category.slug ) {
                    history.pushState(null, null, category.slug);
                }

                axios.post('/api/catalog/sortCollectionsByCategory', {
                    lang: this.language,
                    category_slug: this.active_category_collection_slug,
                    first_level_slug: this.$props.first_level_slug
                })
                    .then(response => {
                        this.collection = response.data.collection;
                        this.sliceCollections();

                        this.brands = response.data.brands;
                        this.countries = response.data.countries;
                        this.feature_types = response.data.feature_types;

                        // $('.preloader').hide();
                    })
                    .catch(error => {
                        console.log(error)
                    });
            },
            clearFilter() {
                this.filters.price.from = '';
                this.filters.price.to = '';
                this.filters.brand = [];
                this.filters.country = [];
                this.filters.features = [];
                this.filter_values_list = [];
                this.active_sorting_filter = this.sorting_by_filters[0];
                $(".filter-panel__footer").removeClass("clean")
            },
            addFilterValue(event, prefix, filter_value, display_value) {
                if($(event.target).is(':checked')) {
                    this.filter_values_list.push({
                        prefix, filter_value, display_value
                    });

                    this.active_sorting_filter = this.sorting_by_filters[0];
                } else {
                    this.removeFilterValue(prefix, filter_value);
                }
            },
            removeFilterValue(prefix, filter_value) {
                this.filter_values_list.forEach((item, key) => {
                    if(item.filter_value === filter_value) {
                        this.filter_values_list.splice(key, 1);
                    }
                });

                this.filters[prefix].forEach((item, key) => {
                    if(item === filter_value) {
                        this.filters[prefix].splice(key, 1);
                    }
                });

                this.active_sorting_filter = this.sorting_by_filters[0];
            },
            setPriceFrom: _.debounce(function(event) {
                const priceFrom = event.target.value;
                this.filters.price.from = priceFrom.toString() === '' ? '' : Number.parseInt(priceFrom);
            }, 1000),
            setPriceTo: _.debounce(function(event) {
                const priceTo = event.target.value;
                this.filters.price.to = priceTo.toString() === '' ? '' : Number.parseInt(priceTo);
            }, 1000),
            getMultilanguageVariant(length) {
                if(length <= 20) {
                    return this.language === 'ru' ? 'вариантов' : 'de opțiuni';
                } else {
                    let lastDigit = +length.toString().split('').pop()
                    switch (lastDigit) {
                        case 0:
                        case 5:
                        case 6:
                        case 7:
                        case 8:
                        case 9:
                            return this.language === 'ru' ? 'вариантов' : 'de opțiuni';
                        case 2:
                        case 3:
                        case 4:
                            return this.language === 'ru' ? 'варианта' : 'opțiuni';
                        case 1:
                            return this.language === 'ru' ? 'вариант' : 'opțiune';
                        default:
                            return this.language === 'ru' ? 'вариантов' : 'de opțiuni';
                    }
                }
            },
            changeSortingByFilter(sort_item) {
                this.active_sorting_filter = sort_item;

                // $('.preloader').show();

                this.page_number = 1;

                axios.post('/api/catalog/sortCollectionsByFilter', {
                    lang: this.language,
                    sorting_value: sort_item.value,
                    collection: this.collection
                })
                    .then(response => {
                        this.collection = response.data;
                        this.sliceCollections();

                        // $('.preloader').hide();
                    })
                    .catch(error => {
                        console.log(error)
                    });
            },
            changePerPage(e, per_page) {
                this.collections_per_page = per_page;
                this.sliceCollections();
            },
            // Pagination methods
            show_more() {
                let start = this.collection.indexOf(this.paginatedCollection[0]);
                let end = this.collection.indexOf(this.paginatedCollection[this.paginatedCollection.length - 1]) + this.collections_per_page + 1;

                if(this.page_number === 0) {
                    this.page_number += 2;
                } else {
                    this.page_number++;
                }

                this.paginatedCollection = this.collection.slice(start, end);

                this.splitPaginatedCollectionIntoTwoParts();

                setTimeout(this.sliderInicializing, 10);
            },
            go_to(page) {
                this.page_number = page;

                let start = this.page_number * this.collections_per_page - this.collections_per_page;
                let end = start + this.collections_per_page;

                this.paginatedCollection = this.collection.slice(start, end);

                this.splitPaginatedCollectionIntoTwoParts();

                setTimeout(this.sliderInicializing, 10);
            },
            sliceCollections() {
                let start = this.page_number * this.collections_per_page;
                let end = start + this.collections_per_page;

                this.paginatedCollection = this.collection.slice(start, end);

                this.splitPaginatedCollectionIntoTwoParts();

                setTimeout(this.sliderInicializing, 10);
            },
            // Need it because of product slider between collection cards
            splitPaginatedCollectionIntoTwoParts() {
                if(this.paginatedCollection.length < 4) {
                    this.paginatedCollectionFirstPart = this.paginatedCollection.slice(0, this.paginatedCollection.length);
                    this.paginatedCollectionSecondPart = [];
                } else if(this.paginatedCollection.length < this.collections_per_page) {
                    let start = this.paginatedCollection.length % 4;
                    let end = this.paginatedCollection.length - start;

                    this.paginatedCollectionFirstPart = this.paginatedCollection.slice(0, end);
                    this.paginatedCollectionSecondPart = this.paginatedCollection.slice(end);
                } else if(this.paginatedCollection.length === this.collection.length) {
                    if(this.paginatedCollection.length % 4 === 0) {
                        let end = this.paginatedCollection.length - 4;

                        this.paginatedCollectionFirstPart = this.paginatedCollection.slice(0, end);
                        this.paginatedCollectionSecondPart = this.paginatedCollection.slice(end);
                    } else {
                        let start = this.paginatedCollection.length % 4;
                        let end = this.paginatedCollection.length - start;

                        this.paginatedCollectionFirstPart = this.paginatedCollection.slice(0, end);
                        this.paginatedCollectionSecondPart = this.paginatedCollection.slice(end);
                    }
                } else {
                    let end = this.paginatedCollection.length - 4;

                    this.paginatedCollectionFirstPart = this.paginatedCollection.slice(0, end);
                    this.paginatedCollectionSecondPart = this.paginatedCollection.slice(end);
                }
            }
        }
    }
</script>

<style scoped lang="scss">
    .image {
        &__wrapper {
            &.loaded {
                .image {
                    &__item {
                        visibility: visible;
                        opacity: 1;
                    }
                }
            }
        }

        &__item {
            transition: all 0.6s ease-in-out;
            opacity: 0;
            visibility: hidden;
            margin: 0 auto;
        }
    }
</style>
