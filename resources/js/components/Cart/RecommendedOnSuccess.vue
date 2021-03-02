<template>
    <section class="section section_sliders-in-tabs section_sliders-in-tabs_rec" id="sliders-in-tabs">
        <div class="container">
            <div class="section__title section__title_style6">
                <h2>{{ __('recommend_for_you') }}</h2>
            </div>
            <div class="row">
                <div class="col-12 col-lg-10">
                    <div class="section__nav" role="tablist" :aria-owns="linksIdForAria">
                        <div class="scrollbar-inner">
                            <ul class="list list_unstyled nav nav-tabs section__nav-list row no-gutters flex-nowrap">
                                <li
                                    class="col-auto list__item"
                                    v-for="recommended_product in recommended_products"
                                    :key="recommended_product[1].category_info.id"
                                    @click="changeCategory(recommended_product[1].category_info['name_'+language])"
                                >
                                    <a
                                        class="link section__title js-product-tab"
                                        :class="{ active : active_category === recommended_product[1].category_info['name_'+language] }"
                                        :id="recommended_product[1].category_info.id+'-recommended-tab'"
                                        :href="'#'+recommended_product[1].category_info.id+'-recommended'"
                                        data-toggle="tab"
                                        role="tab"
                                        :aria-controls="recommended_product[1].category_info.id+'-recommended'"
                                        aria-selected="true"
                                    >
                                        <h2>{{ recommended_product[1].category_info['name_'+language] }}</h2>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-content">
                <div
                    class="tab-pane fade"
                    :class="isActiveCategory(recommended_product[1].category_info['name_'+language])"
                    role="tabpanel"
                    :aria-labelledby="recommended_product[1].category_info.id+'-recommended-tab'"
                    :id="recommended_product[1].category_info.id+'-recommended'"
                    v-for="(recommended_product, index) in recommended_products"
                    :key="index"
                >
                    <div class="swiper-container js-product-slider">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide" v-for="([key, product], index) of Object.entries(recommended_product[1])" :key="index">
                                <div v-if="key !== 'category_info'" class="product-card" tabindex="0">
                                    <div class="product-card__content">
                                        <div class="product-card__header">
                                            <a class="product-card__img" :href="product[0].link">
                                                <img :src="product[0].preview_picture" :alt="product[0]['name_'+language]">
                                            </a>
                                            <a
                                                :aria-label="__('go_to_brand')+' '+product[0].brand_name"
                                                class="product-card__brand"
                                                :href="product[0].link_to_brands_page"
                                                :title="product[0].brand_name"
                                            >
                                                <img :alt="product[0].brand_name" :src="product[0].brand_image"/>
                                            </a>
                                            <ul class="list list_unstyled product-card__marks marks-list">
                                                <li
                                                    class="list__item list__item_num"
                                                    :class="tag.class"
                                                    v-for="tag in product[0].tags"
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
                                            <a class="product-card__title" :href="product[0].link">{{ product[0]['name_'+language] }}</a>
                                            <div class="product-card__price">
                                                <span v-if="product[0].discount_price > 0" class="old">{{ Number.parseInt(product[0].price).toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ").trim() }}</span>
                                                <span v-if="product[0].discount_price > 0" class="cost cost_new">{{ Number.parseInt(product[0].discount_price).toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ").trim() }}</span>
                                                <span v-else class="cost">{{ Number.parseInt(product[0].price).toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ").trim() }}</span>
                                                <span class="currency">{{ __('currency_name') }}{{ product[0]['unit_'+language] }}</span>
                                            </div>
                                        </div>
                                        <div class="product-card__footer">
                                            <div class="product-card__info">
                                                <div v-if="product[0].in_stock" class="product-card__availability product-card__availability_true">{{ __('in_stock') }}</div>
                                                <div v-else class="product-card__availability">{{ __('out_of_stock') }}</div>
                                                <div class="product-card__code">{{ __('articul') }} {{ product[0].articul }}</div>
                                            </div>
                                            <div class="product-card__controls" :class="{dnone: !product[0].in_stock}">
                                                <button
                                                    v-if="product[0].complements"
                                                    class="btn product-card__btn product-card__btn_cart js-to-cart product-card__btn_mvp"
                                                    :class="{active: isInCartKit(product[0].articul)}"
                                                    type="button"
                                                    :aria-label="__('add_to_cart')"
                                                    @click="addToCart(product[0])"
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
                                                    :class="{active: isInCart(product[0].articul)}"
                                                    type="button"
                                                    :aria-label="__('add_to_cart')"
                                                    @click="addToCart(product[0])"
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
            language: {
                type: String
            },
            recommended_products_default: {
                type: String, default: ''
            }
        },
        data: () => {
            return {
                active_category_index: 0,
                active_category: '',
                linksIdForAria: '',
                recommended_products: ''
            }
        },
        beforeMount() {
            this.recommended_products = Object.entries(JSON.parse(this.$props.recommended_products_default));

            this.active_category = this.recommended_products[0][1].category_info['name_'+this.language];

            for(let category of this.recommended_products) {
                this.linksIdForAria+=category[1].category_info.id+'-recommended-tab'+' ';
            }
        },
        mounted() {
            this.sliderInicializing();
        },
        methods: {
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
            isActiveCategory: function (c_name) {
                return {
                    active: this.active_category === c_name,
                    show: this.active_category === c_name,
                }
            },
            changeCategory(c_name) {
                this.active_category = c_name;

                setTimeout(this.sliderInicializing, 10);
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

                if($('.js-to-cart.active').length ) {
                    $('.js-to-cart.active').unbind().on('click', function(e) {
                        e.preventDefault();

                        var btn = $(this);
                        $("#modal-added-to-cart").modal("show");
                    });
                }

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
        }
    }
</script>

<style scoped>
    .dnone {
        display: none;
    }
</style>
