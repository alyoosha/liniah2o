<template>
    <keep-alive>
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
                                            <a class="categories-block__header" :href="linkToSecondaryCatalogPage">
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
                                                        v-for="[key, third_level_child] of Object.entries(JSON.parse(second_level_category.children_categories))"
                                                        :key="third_level_child.id"
                                                        class="list__item"
                                                    >
                                                        <a
                                                            class="link"
                                                            :class="{active : third_level_child.slug === active_category}"
                                                            @click="changeCategory(third_level_child.slug)"
                                                            href="javascript: void(0);"
                                                        >
                                                            {{ third_level_child['name_'+language] }}
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
                                        <a class="categories-block__header" :href="linkToSecondaryCatalogPage">
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
                                                    v-for="[key, third_level_child] of Object.entries(JSON.parse(second_level_category.children_categories))"
                                                    :key="third_level_child.id"
                                                    class="list__item"
                                                >
                                                    <a
                                                        class="link"
                                                        :class="{active : third_level_child.slug === active_category}"
                                                        @click="changeCategory(third_level_child.slug)"
                                                        href="javascript: void(0);"
                                                    >
                                                        {{ third_level_child['name_'+language] }}
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
                                                <input
                                                    @input="setPriceFrom($event)"
                                                    class="form-control"
                                                    type="number"
                                                    id="filter-start-price"
                                                    name="filter-start-price"
                                                    :placeholder="__('price_from')"
                                                >
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="form-label form-label_hidden" for="filter-end-price">{{ __('price_to') }}</label>
                                                <input
                                                    @input="setPriceTo($event)"
                                                    class="form-control"
                                                    type="number"
                                                    id="filter-end-price"
                                                    name="filter-end-price"
                                                    :placeholder="__('price_to')"
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- TAGS -->
                                <div class="filter-panel__group">
                                    <ul class="list list_unstyled checkbox-list">
                                        <!-- фильтр В наличии -->
                                        <li class="list__item checkbox">
                                            <label class="checkbox__label">
                                                <input class="checkbox__hidden" type="checkbox" @change="addFilterValue($event, 'tag', 1, __('in_stock'))" :value="1" v-model="filters.tag">
                                                <span class="checkbox__custom" aria-hidden="true"></span>
                                                <span class="checkbox__text">{{ __('in_stock') }} <span class="color_gray counter">{{ count_of_products_in_stock }}</span></span>
                                            </label>
                                        </li>
                                        <li class="list__item checkbox" v-for="tag in tags" :key="tag.id">
                                            <label class="checkbox__label">
                                                <input class="checkbox__hidden" type="checkbox" @change="addFilterValue($event, 'tag', tag.id, tag['name_'+language])" :value="tag.id" v-model="filters.tag">
                                                <span class="checkbox__custom" aria-hidden="true"></span>
                                                <span class="checkbox__text">{{ tag['name_'+language] }} <span class="color_gray counter">{{ tag.count }}</span></span>
                                            </label>
                                        </li>
                                    </ul>
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
                                <!-- COLOR -->
                                <div class="filter-panel__group filter-panel__group_collapsed" v-show="colorsListLength > 0">
                                    <button class="filter-panel__control collapsed js-filter-panel-toggler" :aria-label="__('show_hide_filter')+' '+__('color')">
                                        <span class="btn__text filter-panel__title section__title">{{ __('color') }}</span>
                                        <span class="btn__icon" aria-hidden="true">
                                        <svg role="img" aria-hidden="true" width="14" height="14">
                                            <use xlink:href="#svg-icon-down-arrow"></use>
                                        </svg>
                                    </span>
                                    </button>
                                    <div class="filter-panel__collapse collapse">
                                        <ul class="list list_unstyled checkbox-list">
                                            <li class="list__item checkbox" v-for="(color, index) in previewColors" :key="index" @change="addFilterValue($event, 'color', color.color, getColorName(color.color))">
                                                <label class="checkbox__label">
                                                    <input class="checkbox__hidden" type="checkbox" v-model="filters.color" :name="'filter-color-top-'+color.color" :value="color.color">
                                                    <span class="checkbox__custom" aria-hidden="true"></span>
                                                    <span class="checkbox__text">{{ getColorName(color.color) }} <span class="color_gray counter">{{ color.count }}</span></span>
                                                </label>
                                            </li>
                                        </ul>
                                        <div class="btn-wrapper dropdown dropright" v-if="colorsListLength > defaultPreviewFilterLength">
                                            <!--чтобы показать прелоадер, нужно кнопке добавить класс btn_load-->
                                            <button class="btn btn_show-all btn_loader btn_full" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="btn__text">{{ __('all') }} {{ colorsListLength }} {{ getMultilanguageVariant(colorsListLength) }}</span>
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
                                                        <li class="list__item checkbox" v-for="(color, index) in colors" :key="index" @change="addFilterValue($event, 'color', color.color, getColorName(color.color))">
                                                            <label class="checkbox__label">
                                                                <input class="checkbox__hidden" type="checkbox" v-model="filters.color" :name="'filter-color-top-'+color.color" :value="color.color">
                                                                <span class="checkbox__custom" aria-hidden="true"></span>
                                                                <span class="checkbox__text">{{ getColorName(color.color) }} <span class="color_gray counter">{{ color.count }}</span></span>
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
                                    <div class="filter-panel__group filter-panel__group_collapsed" v-if="feature_type.filtered_features.length > 0" v-for="feature_type in computedFeatureTypes" :key="feature_type.id">
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
                    <div v-if="paginatedProducts.length === 0" class="col-12 content-column">
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
                                <!-- FILTER VALUES LIST -->
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
                                                <span class="btn__text">{{ __('display_per') }} {{ products_per_page }}</span>
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
                                                        :class="{active: products_per_page === sort_by_item}"
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
                        <div class="catalog-products">
                            <div class="row no-gutters">
                                <div
                                    class="col-12 col-sm-6 col-xl-3"
                                    v-for="product in paginatedProductsFirstPart"
                                    :key="product.id"
                                >
                                    <div class="product-card" tabindex="0">
                                        <div class="product-card__content">
                                            <div class="product-card__header">
                                                <a class="product-card__img" :href="product.link">
                                                    <picture class="image__wrapper" v-lazyload>
                                                        <source v-if="product['imagesResized'] != undefined && product['imagesResized'].length > 0"
                                                                :srcset="product['imagesResized'][1]"
                                                                media="(min-width: 535px)">
                                                        <source v-if="product['imagesResized'] != undefined && product['imagesResized'].length > 0"
                                                                :srcset="product['imagesResized'][0]"
                                                                media="(min-width: 0px)">
                                                        <img v-if="product['imagesResized'] != undefined && product['imagesResized'].length > 0"
                                                             :data-src="product['imagesResized'][1]"
                                                             :alt="product['name_'
                                                              + language]" class="image__item">
                                                        <img v-else :data-src="product['preview_picture']"
                                                             :alt="product['name_' + language]" class="image__item">
                                                    </picture>
                                                </a>
                                                <a class="product-card__brand" :href="'/' + language + '/brands'" :aria-label="__('go_to_brand')+product.brand_name" :title="product.brand_name">
                                                    <img :src="product.brand_image" :alt="product.brand_name">
                                                </a>
                                                <ul class="list list_unstyled product-card__marks marks-list">
                                                    <li
                                                        class="list__item list__item_num"
                                                        :class="tag.class"
                                                        v-for="tag in product.tags"
                                                        :key="tag.id"
                                                    >
                                                        {{ show_tag_name(tag) }}
                                                        <span v-show="tag.icon" class="marks-list__icon">
                                                            <svg role="img" aria-hidden="true" width="16" height="16">
                                                                <use :xlink:href="`#${tag.icon}`"></use>
                                                            </svg>
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="product-card__body">
                                                <a class="product-card__title" :href="product.link">{{ product['name_'+language] }}</a>
                                                <div class="product-card__price">
                                                    <span v-if="product.discount_price > 0" class="old">{{ Number.parseInt(product.price).toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ").trim() }}</span>
                                                    <span v-if="product.discount_price > 0" class="cost cost_new">{{ Number.parseInt(product.discount_price).toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ").trim() }}</span>
                                                    <span v-else class="cost">{{ Number.parseInt(product.price).toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ").trim() }}</span>
                                                    <span class="currency">{{ __('currency_name') }}{{ product['unit_'+language] }}</span>
                                                </div>
                                            </div>
                                            <div class="product-card__footer">
                                                <div class="product-card__info">
                                                    <div v-if="product.in_stock" class="product-card__availability product-card__availability_true">{{ __('in_stock') }}</div>
                                                    <div v-else class="product-card__availability">{{ __('out_of_stock') }}</div>
                                                    <div class="product-card__code">{{ __('articul') }} {{ product.articul }}</div>
                                                </div>
                                                <div class="product-card__controls" :class="{dnone: !product.in_stock}">
                                                    <!--                                                <button-->
                                                    <!--                                                    class="btn product-card__btn product-card__btn_favorite js-to-favorite"-->
                                                    <!--                                                    :class="{active: isFavorite(product.articul)}"-->
                                                    <!--                                                    type="button"-->
                                                    <!--                                                    :aria-label="__('add_to_favorites')"-->
                                                    <!--                                                    @click="addToFavorites(product.articul)"-->
                                                    <!--                                                >-->
                                                    <!--                                                    <svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24">-->
                                                    <!--                                                        <use xlink:href="#svg-icon-heart"></use>-->
                                                    <!--                                                    </svg>-->
                                                    <!--                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24">-->
                                                    <!--                                                        <use xlink:href="#svg-icon-heart-fill"></use>-->
                                                    <!--                                                    </svg>-->
                                                    <!--                                                </button>-->
                                                    <!--                                                <button v-if="product.is_preorder" class="btn product-card__btn product-card__btn_preorder js-to-preorder" type="button" :aria-label="__('preorder')">-->
                                                    <!--                                                    <svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24">-->
                                                    <!--                                                        <use xlink:href="#svg-icon-order"></use>-->
                                                    <!--                                                    </svg>-->
                                                    <!--                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24">-->
                                                    <!--                                                        <use xlink:href="#svg-icon-order-added"></use>-->
                                                    <!--                                                    </svg>-->
                                                    <!--                                                    <span class="btn__text">-->
                                                    <!--                                                        <span class="line">{{ __('preorder') }}</span>-->
                                                    <!--                                                        &lt;!&ndash; TODO date preorder &ndash;&gt;-->
                                                    <!--                                                        <span class="line">20.02.2019</span>-->
                                                    <!--                                                    </span>-->
                                                    <!--                                                </button>-->
                                                    <button
                                                        v-if="product.complements"
                                                        class="btn product-card__btn product-card__btn_cart js-to-cart product-card__btn_mvp"
                                                        :class="{active: isInCartKit(product.articul)}"
                                                        type="button"
                                                        :aria-label="__('add_to_cart')"
                                                        @click="addToCart(product)"
                                                    >
                                                        <svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24">
                                                            <use xlink:href="#svg-icon-shop"></use>
                                                        </svg>
                                                        <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24">
                                                            <use xlink:href="#svg-icon-shop-added"></use>
                                                        </svg>
                                                    </button>
                                                    <button
                                                        v-else
                                                        class="btn product-card__btn product-card__btn_cart js-to-cart product-card__btn_mvp"
                                                        :class="{active: isInCart(product.articul)}"
                                                        type="button"
                                                        :aria-label="__('add_to_cart')"
                                                        @click="addToCart(product)"
                                                    >
                                                        <svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24">
                                                            <use xlink:href="#svg-icon-shop"></use>
                                                        </svg>
                                                        <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24">
                                                            <use xlink:href="#svg-icon-shop-added"></use>
                                                        </svg>
                                                    </button>
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
                                    class="col-12 col-sm-6 col-xl-3"
                                    v-for="product in paginatedProductsSecondPart"
                                    :key="product.id"
                                >
                                    <div class="product-card" tabindex="0">
                                        <div class="product-card__content">
                                            <div class="product-card__header">
                                                <a v-lazyload class="product-card__img" :href="product.link">
                                                    <picture class="image__wrapper" v-lazyload>
                                                        <source v-if="product['imagesResized'] != undefined && product['imagesResized'].length > 0"
                                                                :srcset="product['imagesResized'][1]"
                                                                media="(min-width: 535px)">
                                                        <source v-if="product['imagesResized'] != undefined && product['imagesResized'].length > 0"
                                                                :srcset="product['imagesResized'][0]"
                                                                media="(min-width: 0px)">
                                                        <img v-if="product['imagesResized'] != undefined && product['imagesResized'].length > 0"
                                                             :data-src="product['imagesResized'][1]"
                                                             :alt="product['name_'
                                                              + language]" class="image__item">
                                                        <img v-else :data-src="product['preview_picture']"
                                                             :alt="product['name_' + language]" class="image__item">
                                                    </picture>
                                                </a>
                                                <a class="product-card__brand" :href="'/' + language + '/brands'" :aria-label="__('go_to_brand')+product.brand_name">
                                                    <img :src="product.brand_image" :alt="product.brand_name">
                                                </a>
                                                <ul class="list list_unstyled product-card__marks marks-list">
                                                    <li
                                                        class="list__item list__item_num"
                                                        :class="tag.class"
                                                        v-for="tag in product.tags"
                                                        :key="tag.id"
                                                    >
                                                        {{ show_tag_name(tag) }}
                                                        <span v-show="tag.icon" class="marks-list__icon">
                                                        <svg role="img" aria-hidden="true" width="16" height="16">
                                                            <use :xlink:href="`#${tag.icon}`"></use>
                                                        </svg>
                                                    </span>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="product-card__body">
                                                <a class="product-card__title" :href="product.link">{{ product['name_'+language] }}</a>
                                                <div class="product-card__price">
                                                    <span v-if="product.discount_price > 0" class="old">{{ Number.parseInt(product.price).toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ").trim() }}</span>
                                                    <span v-if="product.discount_price > 0" class="cost cost_new">{{ Number.parseInt(product.discount_price).toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ").trim() }}</span>
                                                    <span v-else class="cost">{{ Number.parseInt(product.price).toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ").trim() }}</span>
                                                    <span class="currency">{{ __('currency_name') }}{{ product['unit_'+language] }}</span>
                                                </div>
                                            </div>
                                            <div class="product-card__footer">
                                                <div class="product-card__info">
                                                    <div v-if="product.in_stock" class="product-card__availability product-card__availability_true">{{ __('in_stock') }}</div>
                                                    <div v-else class="product-card__availability">{{ __('out_of_stock') }}</div>
                                                    <div class="product-card__code">{{ __('articul') }} {{ product.articul }}</div>
                                                </div>
                                                <div class="product-card__controls">
                                                    <!--                                                <button-->
                                                    <!--                                                    class="btn product-card__btn product-card__btn_favorite js-to-favorite"-->
                                                    <!--                                                    :class="{active: isFavorite(product.articul)}"-->
                                                    <!--                                                    type="button"-->
                                                    <!--                                                    :aria-label="__('add_to_favorites')"-->
                                                    <!--                                                    @click="addToFavorites(product.articul)"-->
                                                    <!--                                                >-->
                                                    <!--                                                    <svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24">-->
                                                    <!--                                                        <use xlink:href="#svg-icon-heart"></use>-->
                                                    <!--                                                    </svg>-->
                                                    <!--                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24">-->
                                                    <!--                                                        <use xlink:href="#svg-icon-heart-fill"></use>-->
                                                    <!--                                                    </svg>-->
                                                    <!--                                                </button>-->
                                                    <!--                                                <button v-if="product.is_preorder" class="btn product-card__btn product-card__btn_preorder js-to-preorder" type="button" :aria-label="__('preorder')">-->
                                                    <!--                                                    <svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24">-->
                                                    <!--                                                        <use xlink:href="#svg-icon-order"></use>-->
                                                    <!--                                                    </svg>-->
                                                    <!--                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24">-->
                                                    <!--                                                        <use xlink:href="#svg-icon-order-added"></use>-->
                                                    <!--                                                    </svg>-->
                                                    <!--                                                    <span class="btn__text">-->
                                                    <!--                                                        <span class="line">{{ __('preorder') }}</span>-->
                                                    <!--                                                        <span class="line">20.02.2019</span>-->
                                                    <!--                                                    </span>-->
                                                    <!--                                                </button>-->
                                                    <button
                                                        v-if="product.complements"
                                                        class="btn product-card__btn product-card__btn_cart js-to-cart product-card__btn_mvp"
                                                        :class="{active: isInCartKit(product.articul) || !product.in_stock}"
                                                        type="button"
                                                        :aria-label="__('add_to_cart')"
                                                        @click="addToCart(product)"
                                                    >
                                                        <svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24">
                                                            <use xlink:href="#svg-icon-shop"></use>
                                                        </svg>
                                                        <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24">
                                                            <use xlink:href="#svg-icon-shop-added"></use>
                                                        </svg>
                                                    </button>
                                                    <button
                                                        v-else
                                                        class="btn product-card__btn product-card__btn_cart js-to-cart product-card__btn_mvp"
                                                        :class="{active: isInCart(product.articul)}"
                                                        type="button"
                                                        :aria-label="__('add_to_cart')"
                                                        @click="addToCart(product)"
                                                    >
                                                        <svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24">
                                                            <use xlink:href="#svg-icon-shop"></use>
                                                        </svg>
                                                        <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24">
                                                            <use xlink:href="#svg-icon-shop-added"></use>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="catalog-products__footer pagination-block" v-show="pageCount > 1">
                                <div class="row">
                                    <div class="show-more" v-show="products.length !== paginatedProducts.length && page_number !== pageCount">
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
                                                                @click="go_to(page)">{{ page }}</a>
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
    </keep-alive>
</template>

<script>
    import ntc from "../../ntc";

    export default {
        props: {
            language: {
                type: String
            },
            link_to_secondary_catalog_page: {
                type: String, default: ''
            },
            second_level_category_default: {
                type: String, default: ''
            },
            third_level_category_default: {
                type: String, default: ''
            },
            second_level_category_slug: {
                type: String, default: ''
            },
            third_level_category_slug: {
                type: String, default: ''
            },
            default_products: {
                type: String, default: ''
            },
            slides: {
                type: String, default: ''
            },
            tags_default: {
                type: String, default: ''
            },
            brands_default: {
                type: String, default: ''
            },
            countries_default: {
                type: String, default: ''
            },
            colors_default: {
                type: String, default: ''
            },
            feature_types_default: {
                type: String, default: ''
            },
            in_stock_count: {
                type: String
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
                    },
                    {
                        btn_display_ru: 'Сначала новинки',
                        btn_display_ro: 'Mai întâi articole noi',
                        list_display_ru: 'По новинкам',
                        list_display_ro: 'Nou',
                        value: 'new'
                    },
                    {
                        btn_display_ru: 'По скидкам',
                        btn_display_ro: 'La reduceri',
                        list_display_ru: 'По скидкам',
                        list_display_ro: 'La reduceri',
                        value: 'sale'
                    }
                ],
                filters: {
                    price: {
                        'from': '',
                        'to': '',
                    },
                    country: [],
                    tag: [],
                    brand: [],
                    color: [],
                    features: []
                },
                active_category: 'all_categories',
                linkToSecondaryCatalogPage: '',
                second_level_category: {},
                third_level_category: {},
                products: [],
                paginatedProducts: [],
                paginatedProductsFirstPart: [],
                paginatedProductsSecondPart: [],
                page_number: 0,
                products_per_page: 16,
                defaultPreviewFilterLength: 6,
                tags: [],
                brands: [],
                countries: [],
                colors: [],
                feature_types: [],
                count_of_products_in_stock: 0,
            }
        },
        beforeMount() {
            // remove query params from bar
            if($('.section_catalog').length) {
                let oldUrl = window.location.href;
                let segments = oldUrl.split("?");

                if(segments[1]) {
                    let newUrl = segments.slice(0, 1);

                    window.history.pushState("new", "new", newUrl);
                }
            }

            this.second_level_category = JSON.parse(this.$props.second_level_category_default);

            this.third_level_category = JSON.parse(this.$props.third_level_category_default);

            this.active_category = this.$props.third_level_category_slug;

            this.products = JSON.parse(this.$props.default_products);
            this.sliceProducts();

            this.tags = JSON.parse(this.$props.tags_default);

            // if tag new or sale is active before we load page
            Object.entries(this.tags).forEach((tag) => {
                let t = tag[1];
                if(t.is_new || t.is_sale) {
                    this.filters.tag.push(t.id);
                    this.filter_values_list.push({prefix: 'tag', filter_value: t.id, display_value: t['name_'+this.language]});
                }
            });

            this.brands = JSON.parse(this.$props.brands_default);

            // if brand is active before we load page
            Object.entries(this.brands).forEach((brand) => {
                let b = brand[1];
                if(b.checked) {
                    this.filters.brand.push(b.id);
                    this.filter_values_list.push({prefix: 'brand', filter_value: b.id, display_value: b.name});
                }
            });

            this.countries = JSON.parse(this.$props.countries_default);
            this.colors = JSON.parse(this.$props.colors_default);
            this.feature_types = JSON.parse(this.$props.feature_types_default);

            this.linkToSecondaryCatalogPage = this.$props.link_to_secondary_catalog_page;

            this.count_of_products_in_stock = Number.parseInt(this.$props.in_stock_count);

            // initially sort by popular
            // axios.post('/api/catalog/sortProductsByFilter', {
            //     sorting_value: 'popular',
            //     products: this.products
            // })
            //     .then(response => {
            //         this.products = response.data;
            //         this.sliceProducts();
            //     })
            //     .catch(error => {
            //         console.log(error)
            //     });
        },
        mounted() {
            $(window).on('popstate', (e) => {
                var href = this.$parent.location.href.split('/');
                this.changeCategory(href[href.length - 1]);
            });
        },
        computed: {
            computedFeatureTypes() {
                return this.feature_types;
            },
            pageCount() {
                let length = this.products.length;
                return Math.ceil(length/this.products_per_page)
            },
            totalCount() {
                return this.products.length;
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
            previewColors() {
                if(Object.entries(this.colors).length <= this.defaultPreviewFilterLength) {
                    return this.colors;
                } else {
                    return Object.entries(this.colors).slice(0, this.defaultPreviewFilterLength).map(elem => elem[1])
                }
            },
            colorsListLength() {
                return Object.entries(this.colors).map(elem => elem[1]).length
            }
        },
        watch: {
            'filters': {
                handler() {
                    this.filterProducts(this.getCategorySlug());
                },
                deep: true
            }
        },
        methods: {
            setPriceFrom: _.debounce(function(event) {
                const priceFrom = event.target.value;
                this.filters.price.from = priceFrom.toString() === '' ? '' : Number.parseInt(priceFrom);
            }, 1000),
            setPriceTo: _.debounce(function(event) {
                const priceTo = event.target.value;
                this.filters.price.to = priceTo.toString() === '' ? '' : Number.parseInt(priceTo);
            }, 1000),
            getCategorySlug() {
                let category_slug = this.active_category;

                if(this.active_category === 'all_categories') {
                    category_slug = this.second_level_category.slug;
                }

                return category_slug;
            },
            filterProducts(category_slug) {
                // $('.preloader').show();

                axios.post('/api/catalog/filterProducts', {
                    lang: this.language,
                    filters: this.filters,
                    category_slug,
                })
                    .then(response => {
                        this.products = response.data;
                        this.sliceProducts();

                        // $('.preloader').hide();
                    })
                    .catch(error => {
                        console.log(error)
                    });
            },
            addToFavorites(product) {
                if(this.isFavorite(product)) {
                    this.remove_from_favorites(product)
                } else {
                    this.$store.commit('add_to_favorites', product);

                    let user = JSON.parse($.cookie('user'));
                    $.removeCookie('user', { expires: 30, path: '/' });
                    user.favorites.push(product);
                    $.cookie('user', JSON.stringify(user), { expires: 30, path: '/' });
                    console.log(JSON.parse($.cookie('user')));
                }
            },
            remove_from_favorites(product) {
                this.$store.commit('remove_from_favorites', product);

                let user = JSON.parse($.cookie('user'));
                $.removeCookie('user', { expires: 30, path: '/' });

                user.favorites.forEach((item, key) => {
                    if(item === product) {
                        user.favorites.splice(key, 1);
                    }
                });

                $.cookie('user', JSON.stringify(user), { expires: 30, path: '/' });
                console.log(JSON.parse($.cookie('user')));
            },
            isFavorite(product) {
                return this.$store.state.user.favorites.includes(product);
            },
            addToCart(product) {
                let articul = product.articul;

                if(product.complements) {
                    let complements = JSON.parse(product.complements);

                    if(complements.kit.length > 0) {
                        if(this.isInCartKit(articul)) {
                            this.remove_from_cart_kit(articul)
                        } else {
                            let articles = [];

                            for(let kit_item of complements.kit) {
                                articles.push(kit_item.toString());
                            }

                            let p = {
                                articul: articles,
                                count: 1,
                                product_id_for_kit: articul,
                                parent_url: product.link
                            };

                            this.$store.commit('add_to_cart', p);

                            let user = JSON.parse($.cookie('user'));
                            $.removeCookie('user', { expires: 30, path: '/' });
                            user.cart.push(p);
                            $.cookie('user', JSON.stringify(user), { expires: 30, path: '/' });
                            console.log(JSON.parse($.cookie('user')));

                            // $("#modal-added-to-cart").modal("show");
                        }
                    }

                    if(complements.singly.length > 0) {
                        for(let singly_item of complements.singly) {
                            if(Array.isArray(singly_item)) {
                                // if(this.isInCart(singly_item[0].toString())) {
                                    // let user = JSON.parse($.cookie('user'));
                                    // let userCart = user.cart;
                                    // let currentCount;
                                    //
                                    // userCart.forEach((p) => {
                                    //     if(p.articul === singly_item[0].toString()) {
                                    //         currentCount = p.count;
                                    //     }
                                    // });
                                    //
                                    // currentCount += 1;
                                    //
                                    // let product = {
                                    //     articul: singly_item[0].toString(),
                                    //     product_id_for_kit: articul,
                                    //     count: currentCount
                                    // };

                                    // this.remove_from_cart(singly_item[0].toString())

                                    // this.$store.commit('add_to_cart', product);
                                    //
                                    // // let user = JSON.parse($.cookie('user'));
                                    // $.removeCookie('user', { expires: 30, path: '/' });
                                    // user.cart.push(product);
                                    // $.cookie('user', JSON.stringify(user), { expires: 30, path: '/' });
                                // } else {
                                    let product = {
                                        articul: singly_item[0].toString(),
                                        product_id_for_kit: articul,
                                        count: 1
                                    };

                                    this.$store.commit('add_to_cart', product);

                                    let user = JSON.parse($.cookie('user'));
                                    $.removeCookie('user', { expires: 30, path: '/' });
                                    user.cart.push(product);
                                    $.cookie('user', JSON.stringify(user), { expires: 30, path: '/' });
                                    console.log(JSON.parse($.cookie('user')));

                                    // $("#modal-added-to-cart").modal("show");
                                // }
                            } else {
                                // if(this.isInCart(singly_item.toString())) {
                                    // let user = JSON.parse($.cookie('user'));
                                    // let userCart = user.cart;
                                    // let currentCount;
                                    //
                                    // userCart.forEach((p) => {
                                    //     if(p.articul === singly_item.toString()) {
                                    //         currentCount = p.count;
                                    //     }
                                    // });
                                    //
                                    // currentCount += 1;
                                    //
                                    // let product = {
                                    //     articul: singly_item.toString(),
                                    //     product_id_for_kit: articul,
                                    //     count: currentCount
                                    // };

                                    // this.remove_from_cart(singly_item.toString());

                                    // this.$store.commit('add_to_cart', product);
                                    //
                                    // // let user = JSON.parse($.cookie('user'));
                                    // $.removeCookie('user', { expires: 30, path: '/' });
                                    // user.cart.push(product);
                                    // $.cookie('user', JSON.stringify(user), { expires: 30, path: '/' });
                                // } else {
                                    let product = {
                                        articul: singly_item.toString(),
                                        product_id_for_kit: articul,
                                        count: 1
                                    };

                                    this.$store.commit('add_to_cart', product);

                                    let user = JSON.parse($.cookie('user'));
                                    $.removeCookie('user', { expires: 30, path: '/' });
                                    user.cart.push(product);
                                    $.cookie('user', JSON.stringify(user), { expires: 30, path: '/' });
                                    console.log(JSON.parse($.cookie('user')));
                                // }
                            }
                        }
                    }
                }
                else {
                    if(this.isInCart(articul)) {
                        this.remove_from_cart(articul)
                    } else {
                        let p = {
                            articul,
                            count: 1
                        };

                        this.$store.commit('add_to_cart', p);

                        let user = JSON.parse($.cookie('user'));
                        $.removeCookie('user', { expires: 30, path: '/' });
                        user.cart.push(p);
                        $.cookie('user', JSON.stringify(user), { expires: 30, path: '/' });
                        console.log(JSON.parse($.cookie('user')));

                        $("#modal-added-to-cart").modal("show");
                    }
                }
            },
            remove_from_cart(articul) {
                this.$store.commit('remove_from_cart', articul);

                let user = JSON.parse($.cookie('user'));
                $.removeCookie('user', { expires: 30, path: '/' });

                user.cart.forEach((item, key) => {
                    if(item.articul === articul) {
                        user.cart.splice(key, 1);
                    }
                });

                $.cookie('user', JSON.stringify(user), { expires: 30, path: '/' });
                console.log(JSON.parse($.cookie('user')));
            },
            remove_from_cart_kit(articul) {
                this.$store.commit('remove_from_cart_kit', articul);

                let user = JSON.parse($.cookie('user'));
                $.removeCookie('user', { expires: 30, path: '/' });

                user.cart.forEach((item, key) => {
                    if(item.product_id_for_kit && item.product_id_for_kit === articul) {
                        user.cart.splice(key, 1);
                    }
                });

                $.cookie('user', JSON.stringify(user), { expires: 30, path: '/' });
                console.log(JSON.parse($.cookie('user')));
            },
            isInCart(articul) {
                let length = this.$store.state.user.cart.length;

                for (let i = 0; i < length; i++) {
                    if (this.$store.state.user.cart[i].articul === articul) {
                        return true;
                    }
                }

                return false;
            },
            isInCartKit(articul) {
                let length = this.$store.state.user.cart.length;

                for (let i = 0; i < length; i++) {
                    if (this.$store.state.user.cart[i].product_id_for_kit && this.$store.state.user.cart[i].product_id_for_kit === articul) {
                        return true;
                    }
                }

                return false;
            },
            changeCategory(slug) {
                // $('.preloader').show();
                var catalogLevel = this.active_category;
                this.active_category = slug;
                // this.active_category_id = id;
                this.products_per_page = 16;
                this.page_number = 0;
                this.active_sorting_filter = this.sorting_by_filters[0];
                this.clearFilter();

                var href = this.$parent.location.href.split('/');
                if( href[href.length - 1] != slug ) {

                    if( catalogLevel != 'all_categories' ) {
                        history.pushState(null, null, slug);
                    } else {
                        history.pushState(null, null, href[href.length - 1]+'/'+slug);
                    }
                }

                axios.post('/api/catalog/sortProductsByCategory', {
                    category_slug: this.active_category,
                    second_level_category_slug: this.second_level_category.slug,
                    lang: this.language
                })
                    .then(response => {
                        if($('.breadcrumbs-list').find('.third_level').length > 0) {
                            $('.breadcrumbs-list').find('.third_level').find('a').text(response.data.category_name);
                        } else {
                            $('.breadcrumbs-list').append(`<li class="list__item third_level"><a class="link active" href="javascript: void(0);">${response.data.category_name}</a></li>`)
                        }
                        $('.section__title').find('h1').text(response.data.category_name);

                        this.products = response.data.products;
                        this.sliceProducts();

                        // $('.preloader').hide();

                        this.tags = response.data.tags;
                        this.brands = response.data.brands;
                        this.countries = response.data.countries;
                        this.colors = response.data.colors;
                        this.feature_types = response.data.feature_types;
                        this.count_of_products_in_stock = Number.parseInt(response.data.in_stock_count);
                    })
                    .catch(error => {
                        console.log(error)
                    });
            },
            changePerPage(e, per_page) {
                this.products_per_page = per_page;
                this.sliceProducts();
                // $(e.target).parents(".dropdown").find(".btn").dropdown('hide');
            },
            changeSortingByFilter(sort_item) {
                this.active_sorting_filter = sort_item;

                // $('.preloader').show();

                axios.post('/api/catalog/sortProductsByFilter', {
                    sorting_value: sort_item.value,
                    products: this.products,
                    lang: this.language,
                })
                    .then(response => {
                        this.products = response.data;
                        this.sliceProducts();

                        // $('.preloader').hide();
                    })
                    .catch(error => {
                        console.log(error)
                    });
            },
            clearFilter() {
                this.filters.price.from = '';
                this.filters.price.to = '';
                this.filters.tag = [];
                this.filters.brand = [];
                this.filters.country = [];
                this.filters.color = [];
                this.filters.features = [];
                this.filter_values_list = [];
                this.active_sorting_filter = this.sorting_by_filters[0];
                $(".filter-panel__footer").removeClass("clean");
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
            show_tag_name(tag) {
                if (tag.discount != 0 && tag.show_name == 1) {
                    let promotion_tag_name = tag['name_ru'].match(/[0-9]{1,2}%/i);

                    if(promotion_tag_name) {
                        return promotion_tag_name[0]+' %';
                    } else {
                        return Number.parseInt(tag.discount)+' %';
                    }
                }

                if(tag.show_name == 1) {
                    return tag['name_'+this.$props.language]
                }
            },
            getColorName(colorHex) {
                if(colorHex.split(',').length > 2) {
                    if(this.language == "ru") {
                        return 'Мультицвет';
                    } else {
                        return 'Multicolor';
                    }
                }

                let n_match  = ntc.name(colorHex);

                if(this.language == "ru") {
                    if(n_match[2]) {
                        if(!n_match[2].length) {
                            return 'не указан';
                        }

                        return n_match[2];
                    } else {
                        return 'не указан';
                    }
                } else {
                    if(n_match[3]) {
                        if(!n_match[3].length) {
                            return 'nu este specificată';
                        }

                        return n_match[3];
                    } else {
                        return 'Culoarea nu este specificată';
                    }
                }
            },
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
            // Pagination methods
            show_more() {
                let start = this.products.indexOf(this.paginatedProducts[0]);
                let end = this.products.indexOf(this.paginatedProducts[this.paginatedProducts.length - 1]) + this.products_per_page + 1;

                if(this.page_number === 0) {
                    this.page_number += 2;
                } else {
                    this.page_number++;
                }

                this.paginatedProducts = this.products.slice(start, end);

                this.splitPaginatedProductsIntoTwoParts();
            },
            go_to(page) {
                this.page_number = page;

                let start = this.page_number * this.products_per_page - this.products_per_page;
                let end = start + this.products_per_page;

                this.paginatedProducts = this.products.slice(start, end);

                this.splitPaginatedProductsIntoTwoParts();
            },
            sliceProducts() {
                let start = this.page_number * this.products_per_page;
                let end = start + this.products_per_page;

                this.paginatedProducts = this.products.slice(start, end);

                this.splitPaginatedProductsIntoTwoParts();
            },
            // Need it because of product slider between product cards
            splitPaginatedProductsIntoTwoParts() {
                if(this.paginatedProducts.length < 4) {
                    this.paginatedProductsFirstPart = this.paginatedProducts.slice(0, this.paginatedProducts.length);
                    this.paginatedProductsSecondPart = [];
                } else if(this.paginatedProducts.length < this.products_per_page) {
                    let start = this.paginatedProducts.length % 4;
                    let end = this.paginatedProducts.length - start;

                    this.paginatedProductsFirstPart = this.paginatedProducts.slice(0, end);
                    this.paginatedProductsSecondPart = this.paginatedProducts.slice(end);
                } else if(this.paginatedProducts.length === this.products.length) {
                    if(this.paginatedProducts.length % 4 === 0) {
                        let end = this.paginatedProducts.length - 4;

                        this.paginatedProductsFirstPart = this.paginatedProducts.slice(0, end);
                        this.paginatedProductsSecondPart = this.paginatedProducts.slice(end);
                    } else {
                        let start = this.paginatedProducts.length % 4;
                        let end = this.paginatedProducts.length - start;

                        this.paginatedProductsFirstPart = this.paginatedProducts.slice(0, end);
                        this.paginatedProductsSecondPart = this.paginatedProducts.slice(end);
                    }
                } else {
                    let end = this.paginatedProducts.length - 4;

                    this.paginatedProductsFirstPart = this.paginatedProducts.slice(0, end);
                    this.paginatedProductsSecondPart = this.paginatedProducts.slice(end);
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

<style scoped>
    .dnone {
        display: none;
    }
</style>
