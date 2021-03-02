<template>
    <section class="section section_inner-page section_checkout-mvp section_checkout-cart">
        <div class="section__header">
            <div class="container">
                <div class="section__breadcrumbs">
                    <ul class="list list_unstyled breadcrumbs-list">
                        <li class="list__item"><a class="link" :href="homepage_path">{{ __('homepage') }}</a></li>
                        <li class="list__item"><a class="link active" href="javascript: void(0);">{{ __('basket') }}</a></li>
                    </ul>
                </div>
                <div class="header-title" v-if="count > 0">
                    <div class="header-title__main section__title section__title_style1">
                        <h1>
                            {{ __('basket') }}
                            <span class="header-title__add-text">{{ count }} {{ getMultilanguageVariant(count) }}</span>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="section__body">
            <div  v-if="count == 0" class="checkout-cart-empty__wrapper bg_white">
                <div class="container">
                    <div class="checkout-cart-empty">
                        <div class="checkout-cart-empty__title section__title section__title_style7">
                            <h2>{{ __('cart_is_empty') }}</h2>
                        </div>
                        <div class="checkout-cart-empty__text">{{ __('not_found_go_to_catalog') }}</div>
                        <a :href="catalog_path">
                            <button class="btn btn_default btn_dark btn_with-icon btn_shadow" type="button">
                                <span class="btn__icon" aria-hidden="true">
                                    <svg role="img" width="30" height="30">
                                        <use xlink:href="#svg-icon-shop2"></use>
                                    </svg>
                                </span>
                                <span class="btn__text">{{ __('products_catalog') }}</span>
                            </button>
                        </a>
                    </div>
                </div>
            </div>
            <div v-else class="container">
                <div class="row">
                    <div class="col-12 col-xl-8">
                        <div class="checkout-cart-table">
                            <div class="cart-table">
                                <div class="cart-table__row" v-for="product in products" :key="product.id">
                                    <div class="cart-table__cell cart-table__cell_button-close">
                                        <button class="cart-table__button-close" type="button"
                                            v-if="product.product_id_for_kit"
                                                @click="remove_from_cart_kit(product.product_id_for_kit)"
                                        >
                                            <svg role="img" aria-hidden="true" width="26" height="26">
                                                <use xlink:href="#svg-icon-cancel"></use>
                                            </svg>
                                        </button>
                                        <button class="cart-table__button-close" type="button"
                                            v-else
                                            @click="remove_from_cart(product.articul)"
                                        >
                                            <svg role="img" aria-hidden="true" width="26" height="26">
                                                <use xlink:href="#svg-icon-cancel"></use>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="cart-table__cell cart-table__cell_info"
                                        v-if="product.product_id_for_kit">
                                        <div v-for="p in product['products']">
                                            <div class="cart-table__info" v-if="p.id">
                                                <a class="cart-table__img" :href="product.parent_url" :aria-label="p['name_'+language]">
                                                    <img :src="p.preview_picture" :alt="p['name_'+language]"/>
                                                </a>
                                                <div class="cart-table__content">
                                                    <a class="cart-table__title section__title" :href="product.parent_url">{{ p['name_'+language] }}</a>
                                                    <div style="display: flex;">
                                                        <div class="cart-table__descr section__description" style="padding-right: 30px;">{{ __('articul') }} {{ p.articul }}</div>
                                                        <div v-if="p.discount_price > 0" class="cart-table__descr section__description">
                                                            {{ __('price') }}
                                                            {{ p.discount_price }}
                                                            {{ __('currency_name') }}
                                                            {{ p['unit_'+language] }}
                                                        </div>
                                                        <div v-else class="cart-table__descr section__description">
                                                            {{ __('price') }}
                                                            {{ p.price }}
                                                            {{ __('currency_name') }}
                                                            {{ p['unit_'+language] }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <ul class="list list_unstyled cart-table__params-list row">
                                                    <li class="col-auto list__item">
                                                    <span
                                                            v-if="twoColorProduct(p.color)"
                                                            class="list__param-color double-colors"
                                                            aria-label="Серо-голубой"
                                                            :style="`color: ${p.color.split(',')[0]}; background-color: ${p.color.split(',')[1]};`"
                                                    >
                                                        <span class="complementary-color" aria-hidden="true"></span>
                                                    </span>
                                                        <span v-else-if="multicolor(p.color)" class="list__param-color multi-color" aria-label="Голубой, фиолетовый, розовый">
                                                        <span class="complementary-color" aria-hidden="true"></span>
                                                    </span>
                                                        <span v-else class="list__param-color" aria-hidden="true" :style="`background-color: ${p.color};`"></span>
                                                        <span class="list__param-title">{{ getColorName(p.color) }}</span>
                                                    </li>
                                                    <li class="col-auto list__item">
                                                        <span class="list__param-title">{{ get_product_sizes(p.sizes) }}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cart-table__cell cart-table__cell_info"
                                        v-else>
                                        <div class="cart-table__info">
                                            <a class="cart-table__img" :href="product.product_link" :aria-label="product['name_'+language]">
                                                <img :src="product.preview_picture" :alt="product['name_'+language]"/>
                                            </a>
                                            <div class="cart-table__content">
                                                <a class="cart-table__title section__title" :href="product.product_link">{{ product['name_'+language] }}</a>
                                                <div style="display: flex;">
                                                    <div class="cart-table__descr section__description" style="padding-right: 30px;">{{ __('articul') }} {{ product.articul }}</div>
                                                    <div v-if="product.discount_price > 0" class="cart-table__descr section__description">
                                                        {{ __('price') }}
                                                        {{ product.discount_price }}
                                                        {{ __('currency_name') }}
                                                        {{ product['unit_'+language] }}
                                                    </div>
                                                    <div v-else class="cart-table__descr section__description">
                                                        {{ __('price') }}
                                                        {{ product.price }}
                                                        {{ __('currency_name') }}
                                                        {{ product['unit_'+language] }}
                                                    </div>
                                                </div>
                                            </div>
                                            <ul class="list list_unstyled cart-table__params-list row">
                                                <li class="col-auto list__item">
                                                    <span
                                                            v-if="twoColorProduct(product.color)"
                                                            class="list__param-color double-colors"
                                                            aria-label="Серо-голубой"
                                                            :style="`color: ${product.color.split(',')[0]}; background-color: ${product.color.split(',')[1]};`"
                                                    >
                                                        <span class="complementary-color" aria-hidden="true"></span>
                                                    </span>
                                                    <span v-else-if="multicolor(product.color)" class="list__param-color multi-color" aria-label="Голубой, фиолетовый, розовый">
                                                        <span class="complementary-color" aria-hidden="true"></span>
                                                    </span>
                                                    <span v-else class="list__param-color" aria-hidden="true" :style="`background-color: ${product.color};`"></span>
                                                    <span class="list__param-title">{{ getColorName(product.color) }}</span>
                                                </li>
                                                <li class="col-auto list__item">
                                                    <span class="list__param-title">{{ get_product_sizes(product.sizes) }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="cart-table__cell cart-table__cell_middle cart-table__cell_middle-quantity"
                                         v-if="product.product_id_for_kit">
                                        <div class="cart-table__quantity">
                                            <div class="section__title subtitle">{{ __('count') }}</div>
                                            <div class="form-group form-group_inline">
                                                <button class="btn btn_minus js-btn-minus" type="button"
                                                        :aria-label="__('less')"
                                                        @click="decrease_product_counter_kit(product)">
                                                    <svg role="img" width="25" height="25">
                                                        <use xlink:href="#svg-icon-minimize"></use>
                                                    </svg>
                                                </button>
                                                <label class="form-label form-label_hidden"
                                                       :for="'cart-product-count-kit' + product.products[0].articul">{{
                                                                                                           __('count_of_products') }}</label>
                                                <input
                                                    class="form-control"
                                                    type="number"
                                                    :id="'cart-product-count-kit' + product.products[0].articul"
                                                    name="cart-product-count"
                                                    @change="set_product_counter_kit($event, product)"
                                                    @click="set_old_product_counter($event, product.count)"
                                                    data-oldvalue=""
                                                    min="1"
                                                    step="1"
                                                    v-model="product.count"
                                                >
                                                <button class="btn btn_plus js-btn-plus" type="button"
                                                        :aria-label="__('more')"
                                                        @click="increase_product_counter_kit(product)">
                                                    <svg role="img" width="25" height="25">
                                                        <use xlink:href="#svg-icon-add"></use>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-else class="cart-table__cell cart-table__cell_middle cart-table__cell_middle-quantity">
                                        <div class="cart-table__quantity">
                                            <div class="section__title subtitle">{{ __('count') }}</div>
                                            <div class="form-group form-group_inline">
                                                <button class="btn btn_minus js-btn-minus" type="button" :aria-label="__('less')" @click="decrease_product_counter(product)">
                                                    <svg role="img" width="25" height="25">
                                                        <use xlink:href="#svg-icon-minimize"></use>
                                                    </svg>
                                                </button>
                                                <label class="form-label form-label_hidden"
                                                       :for="'cart-product-count-' + products.articul">{{ __('count_of_products') }}</label>
                                                <input
                                                    class="form-control"
                                                    type="number"
                                                    :id="'cart-product-count-' + products.articul"
                                                    name="cart-product-count"
                                                    @change="set_product_counter($event, product)"
                                                    @click="set_old_product_counter($event, product.count)"
                                                    data-oldvalue=""
                                                    min="1"
                                                    step="1"
                                                    v-model="product.count"
                                                >
                                                <button class="btn btn_plus js-btn-plus" type="button" :aria-label="__('more')" @click="increase_product_counter(product)">
                                                    <svg role="img" width="25" height="25">
                                                        <use xlink:href="#svg-icon-add"></use>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cart-table__cell cart-table__cell_price">
                                        <ul
                                            v-if="product.tags && product.tags.length > 0"
                                            class="list list_unstyled cart-table__marks marks-list"
                                        >
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
                                        <div v-if="product.product_id_for_kit">
                                            <div class="cart-table__price">
                                                <div>
                                                    <span v-if="complementIsOnSale(product['products'])" class="old">{{ getProductPriceComplement(product['products'], product.count) }}</span>
                                                    <span v-if="complementIsOnSale(product['products'])" class="cost cost_new">{{ getProductDiscountPriceComplement(product['products'], product.count) }}</span>
                                                    <span v-else class="cost">{{ getProductPriceComplement(product['products'], product.count) }}</span>
                                                    <span class="currency">{{ __('currency_name_without_part') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-else class="cart-table__price">
                                            <span v-if="product.discount_price > 0" class="old">{{ getProductPrice(product) }}</span>
                                            <span v-if="product.discount_price > 0" class="cost cost_new">{{ getProductDiscountPrice(product) }}</span>
                                            <span v-else class="cost">{{ getProductPrice(product) }}</span>
                                            <span class="currency">{{ __('currency_name_without_part') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4">
                        <div class="checkout-cart-info">
                            <ul class="list list_unstyled custom-list custom-list_info">
                                <li class="list__item">
                                    <div class="custom-list__th custom-list__th_bottom">
                                        <span class="custom-list__title section__title">{{ __('total_sum') }}</span>
                                    </div>
                                    <div class="custom-list__value">
                                        <div class="custom-list__price">
                                            <span v-if="Number.parseInt(total_discount_sum.replace(' ', '')) !==
                                           Number.parseInt(total_sum.replace(' ', ''))" class="old">{{ total_sum
                                           }}</span>
                                            <span v-if="Number.parseInt(total_discount_sum.replace(' ', '')) !==
                                            Number.parseInt(total_sum.replace(' ', ''))" class="cost cost_new">{{
                                            total_discount_sum }}</span>
                                            <span v-else class="cost">{{ total_sum }}</span>
                                            <span class="currency">{{ __('currency_name_without_part') }}</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="checkout-total">
                            <div class="checkout-total__th">
                                <div class="checkout-total__title section__title section__title_style1">{{ __('total') }}:</div>
                            </div>
                            <div class="checkout-total__value">
                                <div class="checkout-total__number">
                                    {{ total_discount_sum }}
                                    <span class="checkout-total__add-text">{{ __('currency_name_without_part') }}</span>
                                </div>
                            </div>
                            <a :href="orderLink">
                                <button class="checkout-total__cart-button btn btn_default btn_shadow btn_dark btn_with-icon" type="button">
                                <span class="btn__icon" aria-hidden="true">
                                    <svg role="img" width="30" height="30">
                                        <use xlink:href="#svg-icon-verified"></use>
                                    </svg>
                                </span>
                                    <span class="btn__text">{{ __('go_to_order') }}</span>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <cart-recommended :language="language" :recommended_products_default="recommended_products_default"></cart-recommended>
        </div>
    </section>
</template>

<script>
    import ntc from "../../ntc";
    import Recommended from "./Recommended";

    export default {
        props: {
            language: {
                type: String
            },
            homepage_path: {
                type: String, default: ''
            },
            recommended_products_default: {
                type: String, default: ''
            },
            catalog_path_default: {
                type: String, default: ''
            },
            order_link_default: {
                type: String, default: ''
            },
        },
        components: {
            'cart-recommended': Recommended,
        },
        data: () => {
            return {
                productsArticles: [],
                products: [],
                promocode: '',
                orderLink: '',
                catalog_path: ''
            }
        },
        beforeMount() {
            this.catalog_path = this.$props.catalog_path_default;
            this.orderLink = this.$props.order_link_default;
        },
        computed: {
            count() {
                return this.$store.getters.get_total_products_in_cart;
            },
            cart_products_articles() {
                return this.$store.getters.get_cart_products;
            },
            total_sum() {
                let prices = this.products.map((product) => {
                    if(product.product_id_for_kit) {
                        let priceComplement = 0;

                        for(let p in product.products) {
                            priceComplement += Number(product.products[p].price);
                        }

                        return priceComplement * product.count;
                    }
                    return Number(product.price) * product.count;
                });

                let total = prices.reduce((a, b) => a + b, 0);

                return total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ").trim();
            },
            total_discount_sum() {
                let discount_prices = this.products.map((product) => {
                    if(product.product_id_for_kit) {
                        let priceComplement = 0;

                        for(let p in product.products) {
                            if(product.products[p].discount_price && Number.parseInt(product.products[p].discount_price) !== 0) {
                                priceComplement += Number(product.products[p].discount_price);
                            } else {
                                priceComplement += Number(product.products[p].price);
                            }
                        }

                        return priceComplement * product.count;
                    }
                    else {
                        if(product.discount_price && Number.parseInt(product.discount_price) !== 0) {
                            return Number(product.discount_price) * product.count;
                        } else {
                            return Number(product.price) * product.count;
                        }
                    }
                });

                let total = discount_prices.reduce((a, b) => a + b, 0);

                return total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ").trim();
            },
            total() {
                let discount_prices = this.products.map((product) => {
                    if(product.product_id_for_kit) {
                        let priceComplement = 0;

                        for(let p in product.products) {
                            if(product.products[p].discount_price) {
                                priceComplement += Number(product.products[p].discount_price);
                            } else {
                                priceComplement += Number(product.products[p].price);
                            }
                        }

                        return priceComplement * product.count;
                    }
                    else {
                        if(product.discount_price) {
                            return Number(product.discount_price) * product.count;
                        } else {
                            return Number(product.price) * product.count;
                        }
                    }
                });

                let total = discount_prices.reduce((a, b) => a + b, 0);

                return total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ").trim();
            }
        },
        watch: {
            'cart_products_articles': {
                handler(products) {
                    // this.productsArticles = products.map(product => product.articul);

                    // redirect to homepage if already ordered but refresh page and it has not got any products
                    if(products.length === 0) {
                        window.location.replace(this.homepage_path+'/'+this.language);
                    }

                    products = JSON.stringify(products);

                    axios.get('/api/cart/getProductsByArticlesWithComplement', { params: { articles: products, lang: this.language } })
                        .then(response => {
                            this.products = response.data;
                        })
                        .catch(error => {
                            console.log(error);
                        });
                }
            }
        },
        methods: {
            set_old_product_counter(event, count) {
                $(event.target).data('oldvalue', count);
            },
            set_product_counter(event, product) {
                if(Number.parseInt(product.count) > Number.parseInt(product.stock) || Number.parseInt(product.count) === 0) {
                    product.count = $(event.target).data('oldvalue');

                    return false;
                }

                this.$store.commit('set_product_counter', product.articul, product.count);

                let user = JSON.parse($.cookie('user'));
                $.removeCookie('user', { expires: 30, path: '/' });

                user.cart.forEach((item) => {
                    if(item.articul === product.articul) {
                        item.count = product.count;
                    }
                });

                $.cookie('user', JSON.stringify(user), { expires: 30, path: '/' });
            },
            set_product_counter_kit(event, product) {
                let max = this.get_max_stock(product.products);

                if(Number.parseInt(product.count) > max || Number.parseInt(product.count) === 0) {
                    product.count = $(event.target).data('oldvalue');

                    return false;
                }

                this.$store.commit('set_product_counter_kit', product.product_id_for_kit, product.count);

                let user = JSON.parse($.cookie('user'));
                $.removeCookie('user', { expires: 30, path: '/' });

                user.cart.forEach((item) => {
                    if(item.product_id_for_kit === product.product_id_for_kit) {
                        item.count = product.count;
                    }
                });

                $.cookie('user', JSON.stringify(user), { expires: 30, path: '/' });
            },
            decrease_product_counter(product) {
                if(Number.parseInt(product.count) === 1) {
                    return false;
                }

                this.$store.commit('decrease_product_counter', {articul: product.articul, product_id_for_kit: product.singly_product_id_for_kit});

                let user = JSON.parse($.cookie('user'));
                $.removeCookie('user', { expires: 30, path: '/' });

                user.cart.forEach((item) => {
                    if(item.articul === product.articul && item.product_id_for_kit === product.singly_product_id_for_kit) {
                        item.count = Number.parseInt(item.count) - 1;
                    }
                });

                $.cookie('user', JSON.stringify(user), { expires: 30, path: '/' });

                product.count = Number.parseInt(product.count) - 1;
            },
            increase_product_counter(product) {
                if(Number.parseInt(product.count) === Number.parseInt(product.stock) || Number.parseInt(product.count) > Number.parseInt(product.stock)) {
                    return false;
                }

                this.$store.commit('increase_product_counter', {articul: product.articul, product_id_for_kit: product.singly_product_id_for_kit});

                let user = JSON.parse($.cookie('user'));
                $.removeCookie('user', { expires: 30, path: '/' });

                user.cart.forEach((item) => {
                    if(item.articul === product.articul && item.product_id_for_kit === product.singly_product_id_for_kit) {
                        item.count = Number.parseInt(item.count) + 1;
                    }
                });

                $.cookie('user', JSON.stringify(user), { expires: 30, path: '/' });
                console.log(JSON.parse($.cookie('user')));

                product.count = Number.parseInt(product.count) + 1;
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
            decrease_product_counter_kit(product) {
                if(Number.parseInt(product.count) === 1) {
                    return false;
                }

                this.$store.commit('decrease_product_counter_kit', product.product_id_for_kit);

                let user = JSON.parse($.cookie('user'));
                $.removeCookie('user', { expires: 30, path: '/' });

                user.cart.forEach((item) => {
                    if(item.product_id_for_kit && product.product_id_for_kit && item.product_id_for_kit === product.product_id_for_kit) {
                        item.count = Number.parseInt(item.count) - 1;
                    }
                });

                $.cookie('user', JSON.stringify(user), { expires: 30, path: '/' });

                product.count = Number.parseInt(product.count) - 1;
            },
            increase_product_counter_kit(product) {
                let max = this.get_max_stock(product.products);

                if(Number.parseInt(product.count) === max || Number.parseInt(product.count) > max) {
                    return false;
                }

                this.$store.commit('increase_product_counter_kit', product.product_id_for_kit);

                let user = JSON.parse($.cookie('user'));
                $.removeCookie('user', { expires: 30, path: '/' });

                user.cart.forEach((item) => {
                    if(item.product_id_for_kit && product.product_id_for_kit && item.product_id_for_kit === product.product_id_for_kit) {
                        item.count = Number.parseInt(item.count) + 1;
                    }
                });

                $.cookie('user', JSON.stringify(user), { expires: 30, path: '/' });
                console.log(JSON.parse($.cookie('user')));

                product.count = Number.parseInt(product.count) + 1;
            },
            remove_from_cart_kit(articul) {
                this.$store.commit('remove_from_cart_kit', articul);

                let user = JSON.parse($.cookie('user'));
                $.removeCookie('user', { expires: 30, path: '/' });

                user.cart.forEach((item, key) => {
                    if(item.product_id_for_kit && articul && item.parent_url && item.product_id_for_kit ===
                        articul) {
                        user.cart.splice(key, 1);
                    }
                });

                $.cookie('user', JSON.stringify(user), { expires: 30, path: '/' });
                console.log(JSON.parse($.cookie('user')));
            },
            get_max_stock(complement) {
                let max = Infinity;

                for(let c in complement) {
                    if(max > Number.parseInt(complement[c].stock)) {
                        max = Number.parseInt(complement[c].stock);
                    }
                }

                return max;
            },
            get_product_sizes(s) {
                let sizes = JSON.parse(s);

                if(sizes) {
                    let width = sizes.width ? sizes.width : '';
                    let height = sizes.height ? sizes.height : '';
                    let unit = sizes.unit ? sizes.unit : '';
                    return width+' x '+height+' '+unit+'.';
                } else return '';
            },
            getProductPrice(product) {
                return product.price * product.count;
            },
            getProductDiscountPrice(product) {
                return product.discount_price * product.count;
            },
            getProductPriceComplement(products, count) {
                let complement_price = 0;

                for(let p of products) {
                    if(Number.parseInt(p['price']) > 0) {
                        complement_price += Number.parseInt(p['price']);
                    }
                }

                return complement_price * count;
            },
            getProductDiscountPriceComplement(products, count) {
                let complement_discount_price = 0;

                for(let p of products) {
                    if(Number.parseInt(p['discount_price']) > 0) {
                        complement_discount_price += Number.parseInt(p['discount_price']);
                    } else {
                        complement_discount_price += Number.parseInt(p['price']);
                    }
                }

                return complement_discount_price * count;
            },
            complementIsOnSale(complement_products) {
                let is_on_sale = false;

                for(let p of complement_products) {
                    if(Number.parseInt(p['discount_price']) > 0) {
                        is_on_sale = true;
                        break;
                    }
                }

                return is_on_sale;
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
                            return 'Цвет не указан';
                        }

                        return n_match[2];
                    } else {
                        return 'Цвет не указан';
                    }
                } else {
                    if(n_match[3]) {
                        if(!n_match[3].length) {
                            return 'Culoarea nu este specificată';
                        }

                        return n_match[3];
                    } else {
                        return 'Culoarea nu este specificată';
                    }
                }
            },
            getMultilanguageVariant(length) {
                if(length <= 20) {
                    let lastDigit = +length.toString().split('').pop()
                    switch (lastDigit) {
                        case 0:
                        case 5:
                        case 6:
                        case 7:
                        case 8:
                        case 9:
                            return this.language === 'ru' ? 'позиций' : 'pozițiile';
                        case 2:
                        case 3:
                        case 4:
                            return this.language === 'ru' ? 'позиции' : 'pozițiile';
                        case 1:
                            return this.language === 'ru' ? 'позиция' : 'poziţie';
                        default:
                            return this.language === 'ru' ? 'позиций' : 'pozițiile';
                    }
                } else {
                    return this.language === 'ru' ? 'товаров' : 'pozițiile';
                }
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
            twoColorProduct(color) {
                return color.split(',').length === 2;
            },
            multicolor(color) {
                let colorList = color.split(',');

                return colorList.length > 2;
            },
            go_to_order() {
                axios.post('/'+this.language+'/cart/order', {products: this.products})
                    .then(response => {
                        console.log(response)
                    })
                    .catch(error => {
                        console.log(error)
                    });
            }
        }
    }
</script>

<style scoped>
    .section_checkout-mvp .checkout-cart-info .custom-list__th {
        padding-bottom: 0;
    }
    .section_checkout-mvp .checkout-cart-info .custom-list__value {
        padding-bottom: 0;
    }
    .checkout-cart-empty__wrapper {
        padding-top: 30px;
        padding-bottom: 30px;
    }
    .checkout-cart-empty__wrapper .checkout-cart-empty__title.section__title {
        padding-bottom: 25px;
    }
    .checkout-cart-empty__wrapper .checkout-cart-empty__text {
        padding-bottom: 20px;
    }
    .checkout-cart-empty__wrapper button {
        margin-top: 20px;
    }
</style>
