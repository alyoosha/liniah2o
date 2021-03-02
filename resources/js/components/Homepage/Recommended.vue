<template>
    <div class="row no-gutters align-items-start">
        <div class="col-12 col-md-6 col-lg-5 col-xl-4 tab-controls color_white">
            <div aria-hidden="true" class="tab-controls__bg bg_gray-dark">
            </div>
            <div class="tab-controls__title section__title section__title_style1">
                <h2>{{ __('recommend') }}</h2>
            </div>
            <ul
                v-if="recommended_products.length > 0"
                class="list list_unstyled nav nav-tabs tab-controls__nav"
                role="tablist"
            >
                <li class="list__item" v-for="(recommended_product, index) in recommended_products" :key="index">
                    <a
                        :aria-controls="recommended_product[1].category_info.slug"
                        :aria-label="recommended_product[1].category_info['name_'+language]"
                        aria-selected="true"
                        class="link js-rec-tab"
                        :class="{active: index === 0}"
                        data-toggle="tab"
                        :href="`#${recommended_product[1].category_info.slug}`"
                        :id="`${recommended_product[1].category_info.slug}-tab`"
                        role="tab"
                        @click="change_catalog_link(recommended_product[1].category_info.slug)"
                    >
                        <div v-if="recommended_product[1].category_info.svg_logo" aria-hidden="true" class="link__icon">
                            <svg role="img" aria-hidden="true" width="30" height="30">
                                <use :xlink:href="`#svg-icon-${get_svg_logo(recommended_product[1].category_info.svg_logo)}`"></use>
                            </svg>
                        </div>
                        <div class="link__text">{{ recommended_product[1].category_info['name_'+language] }}</div>
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-12 col-md-6 col-lg-7 col-xl-8 tab-content">
            <div
                v-if="recommended_products.length > 0"
                v-for="(recommended_product, index) in recommended_products" :key="index"
                :aria-labelledby="`${recommended_product[1].category_info.slug}-tab`"
                class="tab-pane fade show"
                :class="{active: index === 0}"
                :id="`${recommended_product[1].category_info.slug}`"
                role="tabpanel"
            >
                <div class="swiper-container js-rec-slider">
                    <div class="section__controls">
                        <div class="section__controls-all">
                            <a :href="catalog_path">{{ __('see_all') }}</a>
                        </div>
                        <div class="section__controls-nav swiper-nav">
                            <button class="swiper-button-prev" type="button">
                                <svg aria-hidden="true" height="30" role="img" width="30">
                                    <use xlink:href="#svg-icon-down-arrow">
                                    </use>
                                </svg>
                            </button>
                            <button class="swiper-button-next" type="button">
                                <svg aria-hidden="true" height="30" role="img" width="30">
                                    <use xlink:href="#svg-icon-down-arrow">
                                    </use>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="swiper-wrapper">
                        <div class="swiper-slide" v-for="([key, product], index) of Object.entries(recommended_product[1])" :key="index">
                            <div v-if="key !== 'category_info'" class="product-card" tabindex="0">
                                <div class="product-card__content">
                                    <div class="product-card__header">
                                        <a class="product-card__img" :href="product[0].link">
                                            <img :alt="product[0]['name_'+language]" :src="product[0].preview_picture"/>
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
                                        <div v-if="product[0].complements" class="product-card__controls" :class="{dnone: !product[0].in_stock}">
                                            <button
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
                                        </div>
                                        <div v-else class="product-card__controls" :class="{dnone: !product[0].in_stock}">
                                            <button
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
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            language: {
                type: String
            },
            catalog_path_default: {
                type: String, default: ''
            },

            recommended_products_default: {
                type: String, default: ''
            }
        },
        data: () => {
            return {
                catalog_path: '',
                recommended_products: []
            }
        },
        beforeMount() {
            this.catalog_path = this.$props.catalog_path_default;
            this.recommended_products = Object.entries(JSON.parse(this.$props.recommended_products_default));
            this.catalog_path = this.catalog_path+'/'+this.recommended_products[0][1].category_info.slug;
        },
        methods: {
            change_catalog_link(slug) {
                this.catalog_path = this.$props.catalog_path_default+'/'+slug;
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
            get_svg_logo(svg_path) {
                let matches = svg_path.match(/icon-(.*)\.svg$/);

                return matches[1];
            },
            show_tag_name(tag) {
                if (Number.parseInt(tag.discount) != 0 && Number.parseInt(tag.show_name) == 1) {
                    let promotion_tag_name = tag['name_ru'].match(/[0-9]{1,2}%/i);

                    if(promotion_tag_name) {
                        return promotion_tag_name[0]+' %';
                    } else {
                        return Number.parseInt(tag.discount)+' %';
                    }
                }

                if(Number.parseInt(tag.show_name) == 1) {
                    return tag['name_'+this.$props.language]
                }
            },
        }
    }
</script>

<style scoped>
    .dnone {
        display: none;
    }
</style>
