<template>
    <div class="container">
        <div class="body-tab-nav js-body-tab-nav">
            <div class="scrollbar-inner">
                <ul class="list list_unstyled section__title nav nav-tabs">
                    <li
                        class="list__item col-auto js-body-tab-item"
                        :class="{ 'active-item' : active_category==='all_categories' }"
                        @click="changeCategory('all_categories')"
                    >
                        <a
                            class="link"
                            :class="{ active : active_category==='all_categories' }"
                            id="all_categories-tab"
                            data-toggle="tab"
                            href="#categories"
                            role="tab"
                            aria-controls="categories"
                            aria-selected="true"
                        >
                            {{ __('all_categories') }}
                        </a>
                    </li>
                    <li
                        class="list__item col-auto js-body-tab-item"
                        v-for="category in categories"
                        :key="category.id"
                        @click="changeCategory(category['name_ru'])"
                    >
                        <a
                            class="link"
                            :class="{ active : active_category===category['name_'+language].toLowerCase() }"
                            :id="category['name_ru'].toLowerCase()+'-tab'"
                            data-toggle="tab"
                            :href="'#'+category['name_ru'].toLowerCase()"
                            role="tab"
                            :aria-controls="category['name_ru'].toLowerCase()"
                            aria-selected="false"
                        >
                            {{ category['name_'+language] }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="alphabet-block bg_white">
            <div class="alphabet-block__language-nav js-pagination-alphabet-nav">
                <ul class="list list_unstyled section__title nav nav-tabs">
                    <li class="list__item">
                        <a
                            class="link active"
                            id="english-tab"
                            data-toggle="tab"
                            href="#english"
                            role="tab"
                            aria-controls="english"
                            aria-selected="true"
                        >
                            {{ __('a_z_en') }}
                        </a>
                    </li>
                    <li class="list__item">
                        <a
                            class="link"
                            id="russian-tab"
                            data-toggle="tab"
                            href="#russian"
                            role="tab"
                            aria-controls="russian"
                            aria-selected="false"
                        >
                            {{ __('a_z_ru') }}
                        </a>
                    </li>
                </ul>
            </div>
            <div class="alphabet-block__language-content">
                <div class="tab-content">
                    <div class="tab-pane-english tab-pane fade show active" id="english" role="tabpanel" aria-labelledby="english-tab">
                        <ul class="list list_unstyled section__title letters-list">
                            <li class="list__item" v-for="letter in eng_letters" :key="letter" data-language="english">
                                <a
                                    class="link"
                                    :class="{ active : letter===active_eng_letter }"
                                    @click="filter_brands_by_letter($event, letter)"
                                >
                                    {{ letter }}
                                </a>
                            </li>
                        </ul>
                        <div class="alphabet-block__pagination">
                            <div class="pagination">
                                <div class="pagination__current">
                                    <button class="btn pagination__current-btn btn_bordered js-pagination-alphabet-opener" type="button" :aria-label="__('change_page')">
                                        <span class="btn__text">{{ active_eng_letter.toUpperCase() }}</span>
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
                                                <li class="list__item" v-for="letter in eng_letters" :key="letter" data-language="english">
                                                    <a
                                                        class="link"
                                                        :class="{ active : letter===active_eng_letter }"
                                                        @click="filter_brands_by_letter($event, letter)"
                                                    >
                                                        {{ letter }}
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="pagination__control">
                                        <button class="btn pagination__control-btn js-pagination-alphabet-closer" type="button" :aria-label="__('close')">
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
                    <div class="tab-pane-russian tab-pane fade" id="russian" role="tabpanel" aria-labelledby="russian-tab">
                        <ul class="list list_unstyled section__title letters-list">
                            <li class="list__item" v-for="letter in rus_letters" :key="letter" data-language="russian">
                                <a
                                    class="link"
                                    :class="{ active : letter===active_rus_letter }"
                                    @click="filter_brands_by_letter($event, letter)"
                                >
                                    {{ letter }}
                                </a>
                            </li>
                        </ul>
                        <div class="alphabet-block__pagination">
                            <div class="pagination">
                                <div class="pagination__current">
                                    <button class="btn pagination__current-btn btn_bordered js-pagination-alphabet-opener" type="button" :aria-label="__('change_page')">
                                        <span class="btn__text">{{ active_rus_letter.toUpperCase() }}</span>
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
                                                <li class="list__item" v-for="letter in rus_letters" :key="letter" data-language="russian">
                                                    <a
                                                        class="link"
                                                        :class="{ active : letter===active_rus_letter }"
                                                        @click="filter_brands_by_letter($event, letter)"
                                                    >
                                                        {{ letter}}
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="pagination__control">
                                        <button class="btn pagination__control-btn js-pagination-alphabet-closer" type="button" :aria-label="__('close')">
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
        <div v-show="paginatedBrands.length === 0" class="not-results-found">
            <div class="section__title section__title_style7 not-results-found__title">{{ __('entity_not_found') }}</div>
            <div class="section__description not-results-found__descr">
                <p>{{ __('not_found_go_to_catalog') }}</p>
            </div>
            <a :href="catalog_path" class="catalog-btn btn btn_default btn_dark btn_with-icon">
                <span aria-hidden="true" class="btn__icon">
                    <svg role="img" width="30" height="30">
                        <use xlink:href="#svg-icon-shop2"></use>
                    </svg>
                </span>
                <span class="btn__text">{{ __('products_catalog') }}</span>
            </a>
        </div>
        <div class="inner-brands-block bg_white">
            <div class="tab-content">
                <div class="tab-pane-categories tab-pane fade show active" id="categories" role="tabpanel" aria-labelledby="all_categories-tab">
                    <div class="row no-gutters">
                        <div class="col-6 col-md-4 col-lg-3 col-xl-2" v-for="brand in paginatedBrands" :key="brand.id">
                            <a class="brand-block" :href="brand.singlePagePath" :aria-label="__('go_to_brand')+brand['name']" :title="brand['name']">
                                    <div class="brand-block__img-wrapper">
                                    <img class="brand-block__img" :src="brand.preview_image" :alt="brand['name']">
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div
                    class="tab-pane-tile tab-pane fade"
                    :id="category['name_ru'].toLowerCase()"
                    role="tabpanel"
                    :aria-labelledby="category['name_ru'].toLowerCase()+'-tab'"
                    v-for="category in categories">
                    <div class="row no-gutters">
                        <div class="col-6 col-md-4 col-lg-3 col-xl-2" v-for="brand in paginatedBrands" :key="brand.id">
                            <a class="brand-block" :href="brand.singlePagePath" :aria-label="__('go_to_brand')+brand['name']" :title="brand['name']">
                                <div class="brand-block__img-wrapper">
                                    <img class="brand-block__img" :src="brand.preview_image" :alt="brand['name']">
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="brands-pagination-block pagination-block" v-show="pageCount > 1">
            <div class="row">
                <!-- Скрываем кнопку показать еще если достигнут конец массива брэндов -->
                <div class="show-more" v-show="brands.length !== paginatedBrands.length && page_number !== pageCount">
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
        <cart-recommended-onsuccess :language="language" :recommended_products_default="recommended_products_default"></cart-recommended-onsuccess>
    </div>
</template>

<script>
    import * as $ from 'jquery';
    import RecommendedOnSuccess from '../Cart/RecommendedOnSuccess';

    export default {
        props: {
            categories: {
                type: Array, default: []
            },
            default_brands: {
                type: String, default: []
            },
            language: {
                type: String
            },
            catalog_path_default: {
                type: String, default: ''
            },
            storage_path_default: {
                type: String, default: ''
            },
            russian_alphabet: {
                type: String, default: ''
            },
            english_alphabet: {
                type: String, default: ''
            },
            recommended_products_default: {
                type: String, default: ''
            }
        },
        components: {
            'cart-recommended-onsuccess': RecommendedOnSuccess
        },
        data: () => {
            return {
                rus_letters: [],
                eng_letters: [],
                active_rus_letter: 'а',
                active_eng_letter: 'a',
                active_category: 'all_categories',
                storage_path: '',
                catalog_path: '',
                brands: [],
                // pagination data
                paginatedBrands: [],
                page_number: 0,
                brands_per_page: 12,
            }
        },
        beforeMount() {
            this.rus_letters = JSON.parse(this.$props.russian_alphabet);
            this.eng_letters = JSON.parse(this.$props.english_alphabet);

            this.catalog_path = this.$props.catalog_path_default;
            this.storage_path = this.$props.storage_path_default+'/brands';

            this.brands = JSON.parse(this.$props.default_brands);
            this.sortBrands();

            this.sliceBrands();
        },
        computed: {
            pageCount() {
                let length = this.brands.length;
                return Math.ceil(length/this.brands_per_page)
            }
        },
        methods: {
            sortBrands() {
                this.brands.sort((a, b) => a.slug.localeCompare(b.slug));
            },
            changeCategory(c_name) {
                // Сбрасываем фильтр по букве, когда меняем категорию
                this.active_eng_letter = 'a';
                this.active_rus_letter = 'а';

                $('.preloader').show();

                axios.get('/api/brands/getBrandsByCategory', {params: {category: c_name, lang: this.language}})
                    .then((response) => {
                        this.active_category = c_name;
                        this.brands = response.data;
                        this.sortBrands();

                        this.page_number = 0;

                        this.sliceBrands();

                        $('.preloader').hide();
                    })
                    .catch(error => console.log(error));
            },
            filter_brands_by_letter(event, letter) {
                if($(event.target.parentElement).data('language') === 'english') {
                    this.active_eng_letter = letter
                } else {
                    this.active_rus_letter = letter
                }

                $('.preloader').show();

                axios.get('/api/brands/getBrandsByCategory', {params: {category: this.active_category, lang: this.language}})
                    .then((response) => {
                        let brands = response.data;
                        const regex = new RegExp("^" + letter, "i");

                        this.brands = brands.filter(brand => regex.test(brand.slug));
                        this.sortBrands();

                        this.page_number = 0;

                        this.sliceBrands();

                        $('.preloader').hide();
                    })
                    .catch(error => console.log(error));
            },
            show_more() {
                let start = this.brands.indexOf(this.paginatedBrands[0]);
                let end = this.brands.indexOf(this.paginatedBrands[this.paginatedBrands.length - 1]) + this.brands_per_page + 1;

                if(this.page_number === 0) {
                    this.page_number += 2;
                } else {
                    this.page_number++;
                }

                this.paginatedBrands = this.brands.slice(start, end);
            },
            go_to(page) {
                this.page_number = page;

                let start = this.page_number * this.brands_per_page - this.brands_per_page;
                let end = start + this.brands_per_page;

                this.paginatedBrands = this.brands.slice(start, end);
            },
            sliceBrands() {
                let start = this.page_number * this.brands_per_page;
                let end = start + this.brands_per_page;

                this.paginatedBrands = this.brands.slice(start, end);
            }
        }
    }
</script>

<style>
    .not-results-found {
        padding-top: 50px;
    }
</style>
