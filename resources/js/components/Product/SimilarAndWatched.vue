<template>
    <section class="section section_sliders-in-tabs" id="sliders-in-tabs">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-10">
                    <div class="section__nav" role="tablist" aria-owns="popular-tab viewed-tab">
                        <div class="scrollbar-inner">
                            <ul class="list list_unstyled nav nav-tabs section__nav-list row no-gutters flex-nowrap">
                                <li v-if="similar_products.length > 0" class="col-auto list__item">
                                    <a
                                        class="link section__title active js-product-tab"
                                        :class="{active: similar_products.length > 0}"
                                        id="popular-tab"
                                        href="#popular-products"
                                        data-toggle="tab"
                                        role="tab"
                                        aria-controls="popular-products"
                                        aria-selected="true"
                                    >
                                        <h2>{{ __('similar_products') }}</h2>
                                    </a>
                                </li>
                                <li v-if="watched_products.length > 0" class="col-auto list__item" @click="changeToWatchedTab()">
                                    <a
                                        class="link section__title js-product-tab"
                                        :class="{active: similar_products.length == 0}"
                                        id="viewed-tab"
                                        href="#viewed-products"
                                        data-toggle="tab"
                                        role="tab"
                                        aria-controls="viewed-products"
                                        aria-selected="false"
                                    >
                                        <h2>{{ __('you_recently_watched') }}</h2>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-content">
                <div
                    v-if="similar_products.length > 0"
                    class="tab-pane fade show active"
                    :class="isActiveTab()"
                    id="popular-products"
                    role="tabpanel"
                    aria-labelledby="popular-tab"
                >
                    <div class="swiper-container js-product-slider">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide" v-for="product in similar_products">
                                <div class="product-card" tabindex="0">
                                    <div class="product-card__content">
                                        <div class="product-card__header">
                                            <a class="product-card__img product-card__img_full" :href="product.link">
                                                <picture>
                                                    <source v-if="product['imagesResized'] != undefined && product['imagesResized'].length > 0"
                                                            :srcset="product['imagesResized'][1]"
                                                            media="(min-width: 535px)">
                                                    <source v-if="product['imagesResized'] != undefined && product['imagesResized'].length > 0"
                                                            :srcset="product['imagesResized'][0]"
                                                            media="(min-width: 0px)">
                                                    <img v-if="product['imagesResized'] != undefined && product['imagesResized'].length > 0"
                                                         :src="product['imagesResized'][1]"
                                                         :alt="product['name_'
                                                              + language]">
                                                    <img v-else :src="product['preview_picture']"
                                                         :alt="product['name_' + language]">
                                                </picture>
                                            </a>
                                            <a class="product-card__brand" :href="product.link_to_brands_page" :aria-label="__('go_to_brand')+product.brand_name" :title="product.brand_name">
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
                    <div class="section__controls">
                        <div class="section__controls-nav swiper-nav">
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
                <div
                    v-if="watched_products.length > 0"
                    class="tab-pane fade"
                    :class="isWatchedActiveTab()"
                    id="viewed-products"
                    role="tabpanel"
                    aria-labelledby="viewed-tab"
                >
                    <div class="swiper-container js-product-slider">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide" v-for="product in watched_products">
                                <div class="product-card" tabindex="0">
                                    <div class="product-card__content">
                                        <div class="product-card__header">
                                            <a class="product-card__img product-card__img_full" :href="product.link">
                                                <picture>
                                                    <source v-if="product['imagesResized'] != undefined && product['imagesResized'].length > 0"
                                                            :srcset="product['imagesResized'][1]"
                                                            media="(min-width: 535px)">
                                                    <source v-if="product['imagesResized'] != undefined && product['imagesResized'].length > 0"
                                                            :srcset="product['imagesResized'][0]"
                                                            media="(min-width: 0px)">
                                                    <img v-if="product['imagesResized'] != undefined && product['imagesResized'].length > 0"
                                                         :src="product['imagesResized'][1]"
                                                         :alt="product['name_'
                                                              + language]">
                                                    <img v-else :src="product['preview_picture']"
                                                         :alt="product['name_' + language]">
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
                    <div class="section__controls">
                        <div class="section__controls-nav swiper-nav">
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
            </div>
        </div>
    </section>
</template>

<script>
    import Swiper from 'swiper';

    export default {
        props: {
            default_similar_products: {
                type: String, default: ''
            },
            default_watched_products: {
                type: String, default: ''
            },
            language: {
                type: String
            }
        },
        data: () => {
            return {
                similar_products: [],
                watched_products: []
            }
        },
        beforeMount() {
            this.similar_products = JSON.parse(this.default_similar_products);
            this.watched_products = JSON.parse(this.default_watched_products);
        },
        mounted() {
            setTimeout(this.sliderInicializing, 10);
        },
        methods: {
            isActiveTab: function () {
                return {
                    active: this.similar_products.length > 0,
                    show: this.similar_products.length > 0
                }
            },
            isWatchedActiveTab() {
                return {
                    active: !this.similar_products.length > 0,
                    show: !this.similar_products.length > 0
                }
            },
            changeToWatchedTab() {
                this.sliderInicializing();
            },
            sliderInicializing() {
                if( $('.js-product-slider').length ) {
                    var ps = [];

                    $(".js-product-slider").each(function (index) {
                        var $slider = $(this);

                        var productSwiper = new Swiper($slider, {
                            speed: 1200,
                            spaceBetween: 0,
                            slidesPerView: 1,
                            followFinger: false,
                            watchSlidesProgress: true,
                            watchSlidesVisibility: true,
                            observer: true,
                            watchOverflow: true,
                            pagination: false,
                            navigation: {
                                nextEl: $slider.parents(".tab-pane").find(".swiper-button-next"),
                                prevEl: $slider.parents(".tab-pane").find(".swiper-button-prev")
                            },
                            breakpoints: {
                                576: {
                                    slidesPerView: 2,
                                },
                                1025: {
                                    slidesPerView: 3,
                                },
                                1200: {
                                    slidesPerView: 4,
                                },
                                1550: {
                                    slidesPerView: 5,
                                }
                            },
                            on: {
                                init: function () {
                                    ps.push(this);
                                },
                                resize: function () {
                                    var tabId = $(".js-product-tab.active").attr("href");
                                    var tabIndex = $(".js-product-tab.active").parent("li").index();
                                    var tabSlider = ps[tabIndex];
                                    tabSlider.update();
                                },
                            }
                        });

                    });

                    $('.js-product-tab').on('shown.bs.tab', function (e) {
                        var tabId = $(e.target).attr("href");
                        var tabIndex = $(e.target).parent("li").index();
                        var tabSlider = ps[tabIndex];
                        tabSlider.update();
                    })
                }
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
        }
    }
</script>
