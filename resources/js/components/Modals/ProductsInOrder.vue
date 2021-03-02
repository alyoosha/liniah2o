<template>
    <div class="modal modal-profile-history1 fade" id="modal-profile-history1" tabindex="-1" role="dialog" aria-labelledby="modal-profile-history-title1" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="section__title modal-title" id="modal-profile-history-title1">{{ __('products_in_order') }}</div>
                    <button class="modal-close" type="button" data-dismiss="modal" :aria-label="__('close')">
                        <svg role="img" aria-hidden="true" width="26" height="26">
                            <use xlink:href="#svg-icon-cancel"></use>
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="booking-block__content">
                        <div class="row no-gutters">
                            <div class="col-12">
                                <div v-if="products.length > 0" class="cart-table-modal">
                                    <div class="cart-table-modal__row" v-for="product in products" :key="product.id">
                                        <div v-if="product.product_id_for_kit" class="cart-table-modal__cell cart-table-modal__cell_info">
                                            <div v-for="p in product['products']">
                                                <div class="cart-table-modal__info">
                                                    <a class="cart-table-modal__img" :href="p.product_link" :aria-label="p['name_'+language]">
                                                        <img :src="p.preview_picture" :alt="p['name_'+language]"/>
                                                    </a>
                                                    <div class="cart-table-modal__content">
                                                        <a class="cart-table-modal__title section__title" :href="p.product_link">{{ p['name_'+language] }}</a>
                                                        <div class="cart-table-modal__descr section__description">{{ __('articul') }} {{ p.articul }}</div>
                                                    </div>
                                                    <ul class="list list_unstyled cart-table-modal__params-list row">
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
                                        <div v-else class="cart-table-modal__cell cart-table-modal__cell_info">
                                            <div class="cart-table-modal__info">
                                                <a class="cart-table-modal__img" :href="product.product_link" :aria-label="product['name_'+language]">
                                                    <img :src="product.preview_picture" :alt="product['name_'+language]"/>
                                                </a>
                                                <div class="cart-table-modal__content">
                                                    <a class="cart-table-modal__title section__title" :href="product.product_link">{{ product['name_'+language] }}</a>
                                                    <div class="cart-table-modal__descr section__description">{{ __('articul') }} {{ product.articul }}</div>
                                                </div>
                                                <ul class="list list_unstyled cart-table-modal__params-list row">
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

                                        <div class="cart-table-modal__cell cart-table-modal__cell_price">
                                            <ul
                                                class="list list_unstyled cart-table-modal__marks marks-list"
                                                v-if="product.tags && product.tags.length > 0"
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
                                                <div class="cart-table-modal__price">
                                                    <div>
                                                        <span v-if="complementIsOnSale(product['products'])" class="old">{{ getProductPriceComplement(product['products'], product.count) }}</span>
                                                        <span v-if="complementIsOnSale(product['products'])" class="cost cost_new">{{ getProductDiscountPriceComplement(product['products'], product.count) }}</span>
                                                        <span v-else class="cost">{{ getProductPriceComplement(product['products'], product.count) }}</span>
                                                        <span class="currency">{{ __('currency_name_without_part') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div v-else class="cart-table-modal__price">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ntc from "../../ntc";

    export default {
        props: {
            language: {
                type: String
            },
        },
        data: () => {
            return {
                productsArticles: [],
                products: [],
            }
        },
        mounted() {
            $(document).on('show.bs.modal','#modal-profile-history1', () => {
                let articles = this.$store.getters.get_cart_products;
                this.productsArticles = articles.map(product => product.articul);

                axios.get('/api/cart/getProductsByArticlesWithComplement', { params: { articles: JSON.stringify(this.productsArticles), lang: this.language } })
                    .then(response => {
                        this.products = response.data;
                    })
                    .catch(error => {
                        console.log(error)
                    });
            })
        },
        methods: {
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
                        return 'nu este specificată';
                    }
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
        }
    }
</script>

<style scoped>

</style>
