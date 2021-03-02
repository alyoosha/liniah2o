<template>
    <div class="modal modal-added-to-cart fade" id="modal-added-to-cart" tabindex="-1" role="dialog" aria-labelledby="modal-added-to-cart-title" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="section__title modal-title" id="modal-added-to-cart-title">{{ __('product_added_to_cart') }}</div>
                    <button class="modal-close" type="button" data-dismiss="modal" :aria-label="__('close')">
                        <svg role="img" aria-hidden="true" width="26" height="26">
                            <use xlink:href="#svg-icon-cancel"></use>
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="cart-table">
                        <div class="cart-table__row">
                            <div class="cart-table__cell cart-table__cell_info">
                                <div class="cart-table__info">
                                    <a class="cart-table__img" :href="product.product_link" :aria-label="product['name_'+language]">
                                        <img :src="product.preview_picture" :alt="product['name_'+language]"/>
                                    </a>
                                    <div class="cart-table__content">
                                        <a class="cart-table__title section__title" :href="product.product_link">{{ product['name_'+language] }}</a>
                                        <div class="cart-table__descr section__description">{{ __('articul') }} {{ product.articul }}</div>
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
                                            <span class="list__param-title">{{ sizes }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="cart-table__cell cart-table__cell_price">
                                <ul
                                    v-if="Object.keys(this.product).length !== 0 && this.product.constructor === Object && product.tags.length > 0"
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
                                <div class="cart-table__price">
                                    <span v-if="product.discount_price > 0" class="old">{{ product.price }}</span>
                                    <span v-if="product.discount_price > 0" class="cost cost_new">{{ product.discount_price }}</span>
                                    <span v-else class="cost">{{ product.price }}</span>
                                    <span class="currency">{{ __('currency_name') }}{{ product['unit_'+language] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row justify-content-end">
                        <div class="col-12 col-md-auto">
                            <a class="btn btn_default btn_with-icon btn_light btn_to-cart" :href="cart_path">
                                <span class="btn__icon" aria-hidden="true">
                                    <svg role="img" aria-hidden="true" width="30" height="30">
                                        <use xlink:href="#svg-icon-shop"></use>
                                    </svg>
                                </span>
                                <span class="btn__text">{{ __('go_to_cart') }}</span>
                            </a>
                        </div>
                        <div class="col-12 col-md-auto">
                            <button class="btn btn_default btn_with-icon btn_dark" type="button" data-dismiss="modal">
                                <span class="btn__icon" aria-hidden="true">
                                    <svg role="img" aria-hidden="true" width="30" height="30">
                                        <use xlink:href="#svg-icon-shop2"></use>
                                    </svg>
                                </span>
                                <span class="btn__text">{{ __('continue_shopping') }}</span>
                            </button>
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
                product: {}
            }
        },
        computed: {
            sizes() {
                if(Object.keys(this.product).length !== 0 && this.product.constructor === Object) {
                    let sizes = JSON.parse(this.product.sizes);

                    if(sizes) {
                        let width = sizes.width ? sizes.width : '';
                        let height = sizes.height ? sizes.height : '';
                        let unit = sizes.unit ? sizes.unit : '';
                        return width+' x '+height+' '+unit+'.';
                    } else return '';
                }
            },
            cart_path() {
                return this.$store.state.cart_path+'/'+this.language+'/cart'
            }
        },
        mounted() {
            $(document).on('show.bs.modal','#modal-added-to-cart', () => {
                let articul = this.$store.getters.get_last_added_product_to_cart;

                axios.get('/api/cart/getLastAddedProduct', { params: { articul, lang: this.language } })
                    .then(response => {
                        this.product = response.data;
                    })
                    .catch(error => {
                        console.log(error)
                    });
            })
        },
        methods: {
            getColorName(colorHex) {
                if(Object.keys(this.product).length !== 0 && this.product.constructor === Object) {
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
                if(Object.keys(this.product).length !== 0 && this.product.constructor === Object) {
                    return color.split(',').length === 2;
                }
            },
            multicolor(color) {
                if(Object.keys(this.product).length !== 0 && this.product.constructor === Object) {
                    let colorList = color.split(',');

                    return colorList.length > 2;
                }
            },
        }
    }
</script>
