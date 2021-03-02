<template>
    <div class="promotion-products">
        <div class="container">
            <div class="select-block-title section__title">
                <h2>{{ __('products_participated_in_promotion') }}</h2>
            </div>
            <div class="select-block">
                <div class="select-wrapper select-wrapper_brand">
                    <svg role="img" width="16" height="16">
                        <use xlink:href="#svg-icon-down-arrow"></use>
                    </svg>
                    <select v-model="filters.brand" v-select2="filters.brand" class="brand js-example-classic-single" :data-placeholder="__('brand')">
                        <option selected disabled> </option>
                        <option :value="brand.id" v-for="brand in brands">{{ brand.name }}</option>
                    </select>
                </div>
                <div class="categories-wrapper">
                    <div class="select-wrapper select-wrapper_category">
                        <svg role="img" width="16" height="16">
                            <use xlink:href="#svg-icon-down-arrow"></use>
                        </svg>
                        <select v-select2="filters.category_first" v-model="filters.category_first" class="category js-example-classic-single" :data-placeholder="__('category')">
                            <option selected disabled> </option>
                            <option :value="category.id" v-for="category in first_level_categories">{{ category['name_'+language] }}</option>
                        </select>
                    </div>
                    <div class="select-wrapper select-wrapper_category_1">
                        <svg role="img" width="16" height="16">
                            <use xlink:href="#svg-icon-down-arrow"></use>
                        </svg>
                        <select v-select2="filters.category_second" v-model="filters.category_second" class="category_1 js-example-classic-single" :data-placeholder="__('subcategory')" disabled>
                            <option selected disabled> </option>
                            <option :value="category.id" v-for="category in second_level_categories">{{ category['name_'+language] }}</option>
                        </select>
                    </div>
                    <div class="select-wrapper select-wrapper_category_2">
                        <svg role="img" width="16" height="16">
                            <use xlink:href="#svg-icon-down-arrow"></use>
                        </svg>
                        <select v-select2="filters.category_third" v-model="filters.category_third" class="category_2 js-example-classic-single" :data-placeholder="__('subsection')" disabled>
                            <option selected disabled> </option>
                            <option :value="category.id" v-for="category in third_level_categories">{{ category['name_'+language] }}</option>
                        </select>
                    </div>
                </div>
                <div class="btn-wrapper">
                    <button class="choose-btn btn btn_default btn_dark btn_with-icon" type="button" @click="filterResult()">
                        <span class="btn__icon" aria-hidden="true">
                            <svg role="img" width="30" height="30">
                                <use xlink:href="#svg-filter"></use></svg>
                        </span>
                        <span class="btn__text">{{ __('choose') }}</span>
                    </button>
                </div>
            </div>
            <div v-show="paginatedProducts.length === 0" class="not-results-found">
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
            <div class="promotion-catalog catalog-products">
                <div class="row no-gutters">
                    <div class="col-12 col-sm-6 col-xl-3" v-for="product in paginatedProducts" :key="product.id">
                        <div class="product-card" tabindex="0">
                            <div class="product-card__content">
                                <div class="product-card__header">
                                    <a class="product-card__img" :href="product.product_link">
                                        <img :src="product.preview_picture" :alt="product['name_'+language]">
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
                                    <a class="product-card__title" :href="product.product_link" @click="add_to_watched(product.articul)">{{ product['name_'+language] }}</a>
                                    <div class="product-card__price">
                                        <span v-if="product.discount_price > 0" class="old">{{ Number.parseInt(product.price).toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ").trim() }}</span>
                                        <span v-if="product.discount_price > 0" class="cost cost_new">{{ Number.parseInt(product.discount_price).toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ").trim() }}</span>
                                        <span v-else class="cost">{{ Number.parseInt(product.price).toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ").trim() }}</span>
                                        <span class="currency">{{ __('currency_name') }}{{ product['unit_'+language] }}</span>
                                    </div>
                                </div>
                                <div class="product-card__footer">
                                    <div class="product-card__info">
                                        <div v-if="product.stock > 0" class="product-card__availability product-card__availability_true">{{ __('in_stock') }}</div>
                                        <div v-else class="product-card__availability">{{ __('out_of_stock') }}</div>
                                        <div class="product-card__code">{{ __('articul') }} {{ product.articul }}</div>
                                    </div>
                                    <div class="product-card__controls" :class="{dnone: product.stock <= 0}">
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
                </div>
            </div>
            <div class="promotion-pagination pagination-block" v-show="pageCount > 1">
                <div class="row">
                    <div class="show-more" v-show="products.length !== paginatedProducts.length && page_number !== pageCount">
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
</template>

<script>
    export default {
        props: {
            default_products: {
                type: Array, default: []
            },
            brands_prop: {
                type: String, default: []
            },
            first_level_categories_prop: {
                type: String, default: []
            },
            second_level_categories_prop: {
                type: String, default: []
            },
            third_level_categories_prop: {
                type: String, default: []
            },
            language: {
                type: String
            },
            promotion: {
                type: String
            },
            catalog_path_default: {
                type: String, default: ''
            },
            storage_path_default: {
                type: String, default: ''
            },
        },
        data: () => {
            return {
                filters: {
                    promotion_id: '',
                    brand: '',
                    category_first: '',
                    category_second: '',
                    category_third: ''
                },
                brands: [],
                first_level_categories: [],
                second_level_categories: [],
                third_level_categories: [],
                storage_path: '',
                catalog_path: '',
                products: [],
                paginatedProducts: [],
                page_number: 0,
                products_per_page: 10,
            }
        },
        watch: {
            'filters.category_first': function(parent_category, oldvalue) {
                if(parent_category !== oldvalue) {
                    this.filters.category_second = '';
                    this.filters.category_third = '';
                    this.second_level_categories = [];
                    this.third_level_categories = [];

                    axios.post('/api/promotions/getSecondLevelCategories', {
                        parent_category,
                        categories: JSON.parse(this.second_level_categories_prop)
                    })
                        .then(response => {
                            this.second_level_categories = response.data;
                        })
                        .catch(error => {
                            console.log(error)
                        });
                }
            },
            'filters.category_second': function(parent_category, oldvalue) {
                if(parent_category !== oldvalue) {
                    this.filters.category_third = '';
                    this.third_level_categories = [];

                    axios.post('/api/promotions/getThirdLevelCategories', {
                        parent_category,
                        categories: JSON.parse(this.third_level_categories_prop)
                    })
                        .then(response => {
                            this.third_level_categories = response.data;
                        })
                        .catch(error => {
                            console.log(error)
                        });
                }
            },
        },
        beforeMount() {
            this.catalog_path = this.$props.catalog_path_default;
            this.storage_path = this.$props.storage_path_default;

            this.filters.promotion_id = this.$props.promotion;

            this.products = this.$props.default_products;
            this.brands = JSON.parse(this.$props.brands_prop);
            this.first_level_categories = JSON.parse(this.$props.first_level_categories_prop);

            this.sliceProducts();
        },
        computed: {
            pageCount() {
                let length = this.products.length;
                return Math.ceil(length/this.products_per_page)
            }
        },
        methods: {
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
                                //     this.remove_from_cart(singly_item[0].toString())
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
                                //     this.remove_from_cart(singly_item.toString())
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
                } else {
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
            show_tag_name(tag) {
                if (Number.parseInt(tag.discount) !== 0 && Number.parseInt(tag.show_name) === 1) {
                    let promotion_tag_name = tag['name_ru'].match(/[0-9]{1,2}%/i);

                    if(promotion_tag_name) {
                        return promotion_tag_name[0]+' %';
                    } else {
                        return Number.parseInt(tag.discount)+' %';
                    }
                }

                if(Number.parseInt(tag.show_name) === 1) {
                    return tag['name_'+this.$props.language]
                }
            },
            filterResult() {
                $('.preloader').show();

                axios.post('/api/promotions/getFilteredProducts', {
                    lang: this.language,
                    filters: this.filters
                })
                    .then((response) => {
                        this.products = response.data;
                        this.page_number = 0;
                        this.sliceProducts();

                        $('.preloader').hide();
                    })
                    .catch(error => console.log(error));
            },
            show_more() {
                let start = this.products.indexOf(this.paginatedProducts[0]);
                let end = this.products.indexOf(this.paginatedProducts[this.paginatedProducts.length - 1]) + this.products_per_page + 1;

                if(this.page_number === 0) {
                    this.page_number += 2;
                } else {
                    this.page_number++;
                }

                this.paginatedProducts = this.products.slice(start, end);
            },
            go_to(page) {
                this.page_number = page;

                let start = this.page_number * this.products_per_page - this.products_per_page;
                let end = start + this.products_per_page;

                this.paginatedProducts = this.products.slice(start, end);
            },
            sliceProducts() {
                let start = this.page_number * this.products_per_page;
                let end = start + this.products_per_page;

                this.paginatedProducts = this.products.slice(start, end);
            }
        },
    }
</script>
