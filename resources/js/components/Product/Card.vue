<template>
    <div>
        <div>
            <div class="section__header">
                <div class="container">
                    <div class="section__breadcrumbs">
                        <ul class="list list_unstyled breadcrumbs-list">
                            <li class="list__item">
                                <a class="link" :href="'/' + lang">{{ __('homepage') }}</a>
                            </li>
                            <li class="list__item" v-for="(bc, key) of breadcrumbs" :key="key">
                                <a class="link" :href="bc.url">{{ bc['name_' + lang] }}</a>
                            </li>
                            <li class="list__item">
                                <a class="link active" href="javascript: void(0);">{{ product['name_' + lang] }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="section__body product-block">
                <div class="product-block__main">
                    <div class="container">
                        <div class="row no-gutters">
                            <div class="col-12">
                                <a
                                    class="product-block__brand brand-block"
                                    :href="'/' + lang + '/brands'"
                                    :aria-label="__('go_to_brand') + ' ' + product.brand.name"
                                    :title="product.brand.name"
                                >
                                    <div class="brand-block__img" aria-hidden="true">
                                        <img :src="product.pathBrand + product.brand.image" :alt="product.brand.name"/>
                                    </div>
                                    <div class="brand-block__country">{{ product.brand.country['name_'+lang] }}</div>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-5">
                                <ul class="list list_unstyled product-block__socials">
                                    <li class="list__item list__item_has-child dropdown">
                                        <button
                                            class="btn btn_share js-share"
                                            type="button"
                                            :aria-label="__('share')"
                                            data-toggle="dropdown"
                                            aria-haspopup="true"
                                            aria-expanded="false"
                                        >
                                            <svg class="btn__icon" role="img" aria-hidden="true" width="24" height="24">
                                                <use xlink:href="#svg-icon-share"/>
                                            </svg>
                                        </button>
                                        <ul class="list list_unstyled dropdown-menu bg_white" :aria-label="__('share')">
                                            <li class="list__item">
                                                <a
                                                    :href="'http://instagram.com/liniah2o?igshid=1bif5w0bd31by?ref=badge'"
                                                    class="btn btn_socials"
                                                    rel="noopener nofollow"
                                                    aria-label="Instagram"
                                                >
                                                    <svg
                                                        class="btn__icon"
                                                        role="img"
                                                        aria-hidden="true"
                                                        width="24"
                                                        height="24"
                                                    >
                                                        <use xlink:href="#svg-icon-instagram"/>
                                                    </svg>
                                                </a>
                                            </li>
                                            <li class="list__item">
                                                <a
                                                    class="btn btn_socials"
                                                    href="javascript: void(0);"
                                                    rel="noopener nofollow"
                                                    aria-label="Facebook"
                                                    @click="shareFacebook"
                                                >
                                                    <svg
                                                        class="btn__icon"
                                                        role="img"
                                                        aria-hidden="true"
                                                        width="24"
                                                        height="24"
                                                    >
                                                        <use xlink:href="#svg-icon-facebook"/>
                                                    </svg>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                                <div class="product-block__slider">
                                    <ul class="list list_unstyled marks-list" v-if="product.arTags.length > 0">
                                        <li
                                            class="list__item list__item_num"
                                            :class="tag.class ? tag.class : ''"
                                            v-for="(tag, key) of product.arTags"
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
                                    <div class="swiper-container slider_main js-product-slider-main">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide" v-for="(img, key) of images" :key="key">
                                                <a
                                                    class="product-block__slide js-lightbox-gallery"
                                                    :href="product.pathProduct + img"
                                                    data-rel="lightcase:product:slideshow"
                                                    :title="product['name_' + lang]"
                                                    :aria-label="product['name_' + lang]"
                                                >
                                                    <div class="background-img" aria-hidden="true">
                                                        <img :src="product.pathProduct  + img"
                                                             :alt="product['name_' + lang]"/>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-container slider_thumbs js-product-slider-thumbs">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide" v-for="(image, key) of images" :key="key">
                                                <div class="product-block__slide" :aria-label="product['name_' + lang]">
                                                    <div class="background-img" aria-hidden="true">
                                                        <img :src="product.pathProduct  + image"
                                                             :alt="product['name_' + lang]"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-7">
                                <div class="product-block__info">
                                    <div class="product-block__title section__title">
                                        <h1>{{ product['name_' + lang] }}</h1>
                                    </div>
                                    <ul class="list list_unstyled product-block__info-list row align-items-center">
                                        <li class="col-12 col-md-auto">
                                            <div
                                                class="product-block__availability product-block__availability_true"
                                                v-if="product.stock != 0"
                                            >
                                                {{__('in_stock') }}
                                                <span
                                                    class="count color_black"
                                                >{{ product.stock > 10 ? '10' + '+' + ' ' + product["unit_" + lang] :
                                                 product.stock + " " +
                                                 product["unit_" + lang] }}</span>
                                            </div>
                                            <div class="product-block__availability" v-else>{{ __('out_of_stock') }}</div>
                                        </li>
                                        <li class="col-12 col-md-auto">
                                            <div class="product-block__code">{{ __('articul') }} {{ product.articul }}</div>
                                        </li>
                                        <li v-if="is_tile" class="col-12">
                                            <div class="product-block__anchor anchor-block">
                                                <span class="anchor-block__title">
                                                    <span aria-hidden="true" class="anchor-block__icon">
                                                        <svg role="img" width="20" height="20"><use xlink:href="#svg-icon-collection"></use>
                                                        </svg>
                                                    </span>
                                                </span>
                                                <a :href="JSON.parse(collection)['link']"
                                                   class="anchor-block__link">{{JSON.parse(collection)['name_' + lang] }}</a>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="product-block__price">
                                          <span
                                              class="old"
                                              v-if="Number(product.discount_price) > 0"
                                          >{{ getPriceForHtml(product.price) }}</span>
                                        <span
                                            class="cost cost_new"
                                            v-if="Number(product.discount_price) > 0"
                                        >{{ getPriceForHtml(product.discount_price) }}</span>
                                        <span class="cost" v-else>{{ getPriceForHtml(product.price) }}</span>
                                        <span class="currency">{{ __('currency_name') }}{{ product['unit_'+lang] }}</span>
                                    </div>
                                    <div class="product-block__form">
                                        <div class="row">
                                            <div
                                                class="col-12 col-sm-6 col-md-auto col-lg-12 col-xl-auto"
                                                v-if="product.size && product.size.length"
                                            >
                                                <div class="params-block">
                                                    <div class="params-block__title">{{ __("size") }}</div>
                                                    <ul
                                                        class="list list_unstyled radio-list radio-list_params radio-list_params_two-col"
                                                    >
                                                        <li
                                                            class="list__item radio"
                                                            @change="changeProductBySize($event)"
                                                        >
                                                            <label class="radio__label">
                                                                <input
                                                                    class="radio__hidden"
                                                                    type="radio"
                                                                    data-id="main-size"
                                                                    id="product-size-main-size"
                                                                    name="product-size"
                                                                    :value="productStatic.size"
                                                                    checked
                                                                    :data-size="setFlagSize(default_product_sizes)"
                                                                />
                                                                <span class="radio__custom" aria-hidden="true"></span>
                                                                <span class="radio__text">
                                                                    {{
                                                                        default_product_sizes.width ?
                                                                        default_product_sizes.width : ''
                                                                    }}{{
                                                                        default_product_sizes.height ?
                                                                        ' x ' + default_product_sizes.height : ''
                                                                    }}{{
                                                                        default_product_sizes.depth ?
                                                                        ' x ' + default_product_sizes.depth : ''
                                                                    }}{{
                                                                        default_product_sizes.unit ?
                                                                        default_product_sizes.unit : ''
                                                                    }}
                                                                  </span>
                                                            </label>
                                                        </li>
                                                        <li
                                                            class="list__item radio"
                                                            @change="changeProductBySize($event)"
                                                            v-for="(p, key) of productsBySizes"
                                                            :key="key"
                                                        >
                                                            <label class="radio__label">
                                                                <input
                                                                    class="radio__hidden"
                                                                    type="radio"
                                                                    :id="'product-size-' + key"
                                                                    name="product-size"
                                                                    :data-id="key"
                                                                    :value="p.size"
                                                                    :data-size="setFlagSize(JSON.parse(p.size))"

                                                                />
                                                                <span class="radio__custom" aria-hidden="true"></span>
                                                                <span class="radio__text">
                                                                    {{
                                                                        JSON.parse(p.size).width ?
                                                                        JSON.parse(p.size).width : ''
                                                                    }}{{
                                                                        JSON.parse(p.size).height ?
                                                                        ' x ' + JSON.parse(p.size).height : ''
                                                                    }}{{
                                                                        JSON.parse(p.size).depth ?
                                                                        ' x ' + JSON.parse(p.size).depth : ''
                                                                    }}{{
                                                                        JSON.parse(p.size).unit ?
                                                                        JSON.parse(p.size).unit : ''
                                                                    }}
                                                                  </span>
                                                            </label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-auto col-lg-12 col-xl-auto" v-if="color">
                                                <div class="params-block">
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col-auto">
                                                            <div class="params-block__title">{{ __('color') }}</div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <div class="params-block__current">{{ color }}</div>
                                                        </div>
                                                    </div>
                                                    <ul class="list list_unstyled radio-list radio-list_color row">
                                                        <li class="list__item radio radio_color">
                                                            <label class="radio__label">
                                                                <input
                                                                    class="radio__hidden"
                                                                    type="radio"
                                                                    name="product-color"
                                                                    data-id="main-color"
                                                                    checked
                                                                    id="'product-color-main-color'"
                                                                    :value="colors[0]"
                                                                    @change="changeProductByColor($event)"
                                                                    :data-hsl="productStatic.color"
                                                                />
                                                                <span
                                                                    v-if="productStatic.color.split(',').length == 1"
                                                                    class="radio__custom"
                                                                    :aria-label="colors[0]"
                                                                    :style="'background-color: ' + productStatic.color + ';'"
                                                                >
                                                                </span>
                                                                <span
                                                                    v-else-if="productStatic.color.split(',').length == 2"
                                                                    class="radio__custom"
                                                                    :aria-label="colors[0]"
                                                                    :style="'color: ' +  productStatic.color.split(',')[0]
                                                                      +'; background-color:' +
                                                                       productStatic.color.split(',')[1] +
                                                                      ';'"
                                                                >
                                                                    <span class="complementary-color double-colors" aria-hidden="true"></span>
                                                                </span>
                                                                <span v-else class="radio__custom multi-color"
                                                                      :aria-label="colors[0]">
                                                                    <span class="complementary-color multi-color" aria-hidden="true"></span>
                                                              </span>
                                                            </label>
                                                        </li>
                                                        <li
                                                            class="list__item radio radio_color"
                                                            v-for="(product, key) of productsByColors"
                                                            :key="key"
                                                        >
                                                            <label class="radio__label">
                                                                <input
                                                                    class="radio__hidden"
                                                                    type="radio"
                                                                    name="product-color"
                                                                    :data-id="key"
                                                                    :id="'product-color-' + key + 1"
                                                                    :value="colors[key + 1]"
                                                                    @change="changeProductByColor($event)"
                                                                    :data-hsl="product.color"
                                                                />
                                                                <span
                                                                    v-if="product.color.split(',').length == 1"
                                                                    class="radio__custom"
                                                                    :aria-label="colors[key + 1]"
                                                                    :style="'background-color: ' + product.color + ';'"
                                                                ></span>
                                                                <span
                                                                    v-else-if="product.color.split(',').length == 2"
                                                                    class="radio__custom"
                                                                    :aria-label="colors[key + 1]"
                                                                    :style="'color: ' +  product.color.split(',')[0]
                                                                      +'; background-color:' +  product.color.split(',')[1] +
                                                                      ';'"
                                                                >
                                                                <span class="complementary-color double-colors" aria-hidden="true"></span>
                                                                </span>
                                                                <span v-else class="radio__custom" :aria-label="key + 1">
                                                                    <span class="complementary-color multi-color" aria-hidden="true"></span>
                                                                </span>
                                                            </label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-block__quantity"
                                            v-if="!product.complement">
                                            <div class="section__title product-block__subtitle">{{ __('quantity') }}</div>
                                            <div class="form-group form-group_inline">
                                                <button
                                                    class="btn btn_minus"
                                                    type="button"
                                                    :aria-label="__('less')"
                                                    @click="reduceQuantity"
                                                >
                                                    <svg role="img" width="25" height="25">
                                                        <use xlink:href="#svg-icon-minimize"/>
                                                    </svg>
                                                </button>

                                                <label
                                                    class="form-label form-label_hidden"
                                                    for="product-count"
                                                >{{ __('quantity_of_goods') }}</label>
                                                <input
                                                    class="form-control"
                                                    type="number"
                                                    id="product-count"
                                                    name="product-count"
                                                    min="1"
                                                    step="1"
                                                    :max="balance"
                                                    v-model="quantity"
                                                    @input="validateQuantityOnInput"
                                                    @change="validateQuantityOnChange"
                                                />
                                                <button
                                                    class="btn btn_plus"
                                                    type="button"
                                                    :aria-label="__('more')"
                                                    @click="increaseQuantity"
                                                >
                                                    <svg role="img" width="25" height="25">
                                                        <use xlink:href="#svg-icon-add"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="btn-group"
                                             v-if="!product.complement">
                                            <div class="row">
                                                <div class="col-12 col-sm-auto">
                                                    <button
                                                        class="btn btn_default btn_dark btn_with-icon js-to-cart"
                                                        @click="clickByBtnToCart($event, product.articul)"
                                                        type="button"
                                                                            >
                                                      <span class="btn__icon" aria-hidden="true">
                                                        <svg role="img" width="30" height="30">
                                                          <use xlink:href="#svg-icon-shop"/>
                                                        </svg>
                                                      </span>
                                                        <span class="btn__text">{{ __('add_to_cart') }}</span>
                                                    </button>
                                                </div>
                                                <div class="col-12 col-sm-auto">
                                                    <span class="window-message">{{ __('last_instance_in_cart') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="product.description_ru && product.description_ro" class="product-block__descr bg_white">
                    <div class="container">
                        <div class="row align-items-end">
                            <div class="col-12 col-md-6 col-lg-7 col-xl-8">
                                <div class="section__title section__title_style4">
                                    <h3>{{ __("description") }}</h3>
                                </div>
                                <div class="section__description"><p>{{ product['description_'+lang] }}</p></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product-block__params">
                    <div class="container">
                        <div class="section__title section__title_style4">
                            <h3>{{ __('feature') }}</h3>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-10 col-xl-8">
                                <ul class="list list_unstyled params-list">
                                    <li class="list__item" v-for="value, name in features">
                                        <div class="params-list__th">
                                            <span class="params-list__title">{{ name }}:</span>
                                        </div>
                                        <div class="params-list__value">{{ value }}</div>
                                    </li>
                                    <li class="list__item">
                                        <div class="params-list__th">
                                            <span class="params-list__title">{{ __('country') }}:</span>
                                        </div>
                                        <div class="params-list__value">
                                            {{ ucFirst(product.brand.country['name_' + lang]) }}
                                        </div>
                                    </li>
                                    <li class="list__item">
                                        <div class="params-list__th">
                                            <span class="params-list__title">{{ __('manufacturer') }}:</span>
                                        </div>
                                        <div class="params-list__value">{{ product.brand.name }}</div>
                                    </li>
                                    <li class="list__item">
                                        <div class="params-list__th">
                                            <span
                                                class="params-list__title"
                                            >{{ __('guaranty') }}, {{__(warranty.type + '_guaranty')}}:</span>
                                        </div>
                                        <div class="params-list__value">{{ warranty.value }}</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-show="product.complement">
            <complements-index
                :lang="lang"
                :raw_product="JSON.stringify(product)">
            </complements-index>
        </div>
    </div>
</template>

<script>
    import {ntc} from "../../ntc.js";
    import getPriceForHtml from "../../mixins/getPriceForHtml";

    export default {
        name: "Card",
        props: {
            product_default: {
                type: String,
                default: []
            },
            lang: {
                type: String
            },
            is_tile: {
                type: String,
            },
            collection: {
                type: String,
                default: []
            },
        },
        mixins: [getPriceForHtml],
        data: () => {
            return {
                product: [],
                products: [],
                productStatic: [],
                productFromStore: null,
                productsByColors: [],
                productsBySizes: [],
                features: [],
                warranty: [],
                breadcrumbs: [],
                images: [],
                color: null,
                colors: [],
                size: null,
                sizes: [],
                quantity: 1,
                balance: 0,
                url: "",
                ntc: null,
                default_product_sizes: []
            };
        },
        beforeMount() {
            this.product = JSON.parse(this.product_default);
            this.default_product_sizes = JSON.parse(this.product.size);
            this.productStatic = this.product;
            this.productsByColors = this.product.products.ptByColors;
            this.productsBySizes = this.product.products.ptBySizes;
            this.warranty = JSON.parse(this.product.warranty);
            this.features = this.product.arFeatures;
            this.breadcrumbs = this.product.breadcrumbs;
            this.images = JSON.parse(this.product.images);
            this.url = location.href;
            this.images[0] = this.product.preview_picture.split("/").reverse()[0];
            this.ntc = ntc;
            this.setColors();
            this.setBalance();

            if(this.product.color && this.product.color.split(",").length > 2) {
                this.color = this.__('multicolor');
            }
        },
        mounted() {
            this.add_to_watched(this.product.articul);
        },
        methods: {
            validateQuantityOnChange: function () {
                if (this.quantity === '' || this.quantity === 0) {
                    this.quantity = 1;
                }
            },
            validateQuantityOnInput: _.debounce(function () {
                const quantity = Number(this.quantity);

                if (quantity > this.balance) {
                    this.quantity = this.balance;
                } else if (quantity < 0) {
                    this.quantity = 1;
                } else if (this.quantity === "") {
                    this.quantity = '';
                } else {
                    this.quantity = quantity;
                }
            }, 500),
            reduceQuantity() {
                if (this.quantity > 1) {
                    --this.quantity;
                }
            },
            increaseQuantity() {
                if (this.quantity < this.balance) {
                    ++this.quantity;
                }
            },
            changeProductByColor(event) {
                $('input[name=product-color][checked=checked]').prop('checked', false);
                $('input[name=product-color][checked=checked]').attr('checked', false);
                $(event.target).prop('checked', true);
                $(event.target).attr('checked', true);
                let idColor = event.target.getAttribute("data-id");
                let idSize = $('input[name=product-size][checked=checked]').attr('data-size');
                let product = JSON.parse(this.product_default);
                let coincidence = false;
                let $inputColor = $('input[name=product-color][checked=checked]').attr('data-hsl');
                let $inputSize = $('input[name=product-size][checked=checked]').attr('value');

                if(product.products.ptBySizes.length == 0) {
                    if (!coincidence) {
                        if (idColor == "main-color") {
                            this.product = product;
                        }
                        else {
                            for (let i = 0; i < product.products.ptByColors.length; ++i) {
                                if (coincidence) break;

                                if (product.products.ptByColors[i].color == $inputColor) {
                                    this.product = product.products.ptByColors[i];

                                    coincidence = true;
                                }
                            }
                        }
                    }
                }
                else {
                    for (let i = 0; i < product.products.ptBySizes.length; ++i) {
                        if (coincidence) break;

                        if (product.products.ptBySizes[i].size == $inputSize &&
                            product.products.ptBySizes[i].color == $inputColor) {
                            this.product = product.products.ptBySizes[i];

                            coincidence = true;
                        }
                    }

                    if (!coincidence) {
                        for (let i = 0; i < product.products.fromSizes.length; ++i) {
                            for (let y = 0; y < product.products.fromSizes[i].length; ++y) {
                                if (coincidence) break;

                                if (product.products.fromSizes[i][y].size == $inputSize &&
                                    product.products.fromSizes[i][y].color == $inputColor) {
                                    this.product = product.products.fromSizes[i][y];

                                    coincidence = true;
                                }
                            }
                        }
                    }

                    if (!coincidence) {
                        if (idColor == "main-color") {
                            this.product = product;
                        }
                        else {
                            for (let i = 0; i < product.products.ptByColors.length; ++i) {
                                if (coincidence) break;

                                if (product.products.ptByColors[i].size == $inputSize &&
                                    product.products.ptByColors[i].color == $inputColor) {
                                    this.product = product.products.ptByColors[i];

                                    coincidence = true;
                                }
                            }
                        }
                    }
                }

                if(JSON.parse(this.product.size) != null){
                    let sizeFlag = this.setFlagSize(JSON.parse(this.product.size));
                    $("[data-size='" + sizeFlag + "']").prop('checked', true);
                }

                if(this.product.color && this.product.color.split(',').length > 2) {
                    this.color = this.__('multicolor');
                }
                else {
                    this.color = event.target.value;
                }

                this.features = this.product.arFeatures;
                this.images = JSON.parse(this.product.images);
                this.images[0] = this.product.preview_picture.split("/").reverse()[0];
                this.setBalance();
                this.setUrl(this.product.link);
            },
            changeProductBySize(event) {
                $('input[name=product-size][checked=checked]').prop('checked', false);
                $('input[name=product-size][checked=checked]').attr('checked', false);
                $(event.target).prop('checked', true);
                $(event.target).attr('checked', true);
                let idSize = event.target.getAttribute("data-id");
                let product = JSON.parse(this.product_default);
                let $inputColor = $('input[name=product-color][checked=checked]').attr('data-hsl');
                let idColor = $('input[name=product-color][checked=checked]').attr('data-id');
                let coincidence = false;

                if(product.products.ptByColors.length == 0) {
                    for (let i = 0; i < product.products.ptBySizes.length; ++i) {
                        if (coincidence) break;

                        if (product.products.ptBySizes[i].size == event.target.value) {
                            this.product = product.products.ptBySizes[i];

                            coincidence = true;
                        }
                    }

                    if (!coincidence) {
                        if (idSize == "main-size") {
                            this.product = JSON.parse(this.product_default);
                        }
                        else {
                            for (let i = 0; i < this.productStatic.products.ptBySizes.length; ++i) {
                                if (coincidence) break;

                                if (this.productStatic.products.ptBySizes[i].size == event.target.value) {
                                    this.product = this.productStatic.products.ptBySizes[i];

                                    coincidence = true;
                                }
                            }
                        }
                    }
                }
                else {
                    for (let i = 0; i < product.products.ptBySizes.length; ++i) {
                        if (coincidence) break;

                        if (product.products.ptBySizes[i].size == event.target.value &&
                            product.products.ptBySizes[i].color == $inputColor) {
                            this.product = product.products.ptBySizes[i];

                            coincidence = true;
                        }
                    }

                    if (!coincidence) {
                        for (let i = 0; i < product.products.fromSizes.length; ++i) {
                            for (let y = 0; y < product.products.fromSizes[i].length; ++y) {
                                if (coincidence) break;

                                if (product.products.fromSizes[i][y].size == event.target.value &&
                                    product.products.fromSizes[i][y].color == $inputColor) {
                                    this.product = product.products.fromSizes[i][y];

                                    coincidence = true;
                                }
                            }
                        }
                    }

                    if (!coincidence) {
                        for (let i = 0; i < product.products.ptByColors.length; ++i) {
                            if (coincidence) break;

                            if (product.products.ptByColors[i].size == event.target.value &&
                                product.products.ptByColors[i].color == $inputColor) {
                                this.product = product.products.ptByColors[i];

                                coincidence = true;
                            }
                        }
                    }

                    if (!coincidence) {
                        if (idSize == "main-size" && idColor == "main-color") {
                            this.product = JSON.parse(this.product_default);
                        }
                        else {
                            for (let i = 0; i < this.productStatic.products.ptByColors.length; ++i) {
                                if (coincidence) break;

                                if (this.productStatic.products.ptByColors[i].size == event.target.value &&
                                    this.productStatic.products.ptByColors[i].color == $inputColor) {
                                    this.product = this.productStatic.products.ptByColors[i];

                                    coincidence = true;
                                }
                            }
                        }
                    }
                }

                if (this.lang == "ru") {
                    this.color = this.ntc.name(this.product.color)[2];
                } else {
                    this.color = this.ntc.name(this.product.color)[3];
                }

                this.features = this.product.arFeatures;
                this.images = JSON.parse(this.product.images);
                this.images[0] = this.product.preview_picture.split("/").reverse()[0];
                this.setBalance();
                this.setUrl(this.product.link);
            },
            ucFirst(str) {
                if (!str) return str;
                return str[0].toUpperCase() + str.slice(1).toLowerCase();
            },
            shareFacebook() {
                open(
                    "http://www.facebook.com/sharer.php?u=" + this.url,
                    "displayWindow",
                    "width=520,height=300,left=350,top=170,status=no,toolbar=no,menubar=no"
                );
            },
            clickByBtnToCart(event, articul) {
                let hasProduct = false,
                    product = {};

                this.productFromStore = this.$store.getters.get_product_by_articul(
                    articul
                );

                if (!this.productFromStore) {
                    product = {
                        articul,
                        count: this.quantity
                    };

                    this.balance -= this.quantity;
                    this.addToCart(product);
                } else {
                    hasProduct = true;
                    product = {
                        articul,
                        count: this.quantity
                    };
                    this.$store.commit("move_product_to_end", articul);

                    if (this.balance >= this.quantity) {
                        this.balance -= this.quantity;
                        this.updateCart(this.productFromStore.articul, this.quantity);
                    } else {
                        $(".window-message").addClass("show");
                        return;
                    }
                }

                $("#modal-added-to-cart").modal("show");
                this.quantity = 1;
                this.addOrUpdateCookie(product, hasProduct);
            },
            addToCart(product) {
                this.$store.commit("add_to_cart", product);
            },
            updateCart(articul, quantity) {
                this.$store.commit("update_product_counter", articul, quantity);
            },
            addOrUpdateCookie(product, hasProduct) {
                let user = JSON.parse($.cookie("user")),
                    p;

                $.removeCookie("user", {expires: 30, path: "/"});

                if (hasProduct) {
                    user.cart.forEach((item, key) => {
                        if (item.articul == product.articul) {
                            item.count += product.count;
                            p = user.cart.splice(key, 1);
                        }
                    });

                    user.cart.push(p[0]);
                } else {
                    user.cart.push(product);
                }

                $.cookie("user", JSON.stringify(user), {expires: 30, path: "/"});
            },
            add_to_watched(articul) {
                if (this.isNotWatched(articul)) {
                    this.$store.commit("add_to_watched", articul);

                    let user = JSON.parse($.cookie("user"));
                    $.removeCookie("user", {expires: 30, path: "/"});

                    if (user.watched.length === 10) {
                        let slicedWatchedList = user.watched.slice(1);
                        slicedWatchedList.push(articul);

                        user.watched = slicedWatchedList;
                    } else {
                        user.watched.push(articul);
                    }

                    $.cookie("user", JSON.stringify(user), {expires: 30, path: "/"});
                }
            },
            isNotWatched(articul) {
                if($.cookie("user")) {
                    let user = JSON.parse($.cookie("user"));
                    let watchedList = user.watched;
                    let length = watchedList.length;
                    for (let i = 0; i < length; i++) {
                        if (watchedList[i] === articul) {
                            return false;
                        }
                    }

                    return true;
                }
            },
            setColors() {
                if (this.product.color) {
                    if (this.lang == "ru") {
                        this.colors.push(this.ntc.name(this.product.color)[2]);
                    } else {
                        this.colors.push(this.ntc.name(this.product.color)[3]);
                    }

                    for (let key in this.productsByColors) {
                        if (this.productsByColors[key].color == this.product.color) {
                            this.productsByColors.splice(key, 1);
                        }
                    }

                    for (let key in this.productsByColors) {

                        if (this.lang == "ru") {
                            this.colors.push(
                                this.ntc.name(this.productsByColors[key].color)[2]
                            );
                        } else {
                            this.colors.push(
                                this.ntc.name(this.productsByColors[key].color)[3]
                            );
                        }
                    }
                    this.color = this.colors[0];
                }
            },
            setBalance() {
                if($.cookie("user")) {
                    let user = JSON.parse($.cookie("user"));

                    user.cart.forEach(item => {
                        if (item.articul == this.product.articul) {
                            this.productFromStore = item;
                        }
                    });
                }

                if (this.productFromStore) {
                    this.balance = this.product.stock - this.productFromStore.count;
                } else {
                    this.balance = this.product.stock;
                }
            },
            setFlagSize(data) {
                let width = data.width ? data.width : '';
                let height = data.height ? data.height : '';
                let depth = data.depth ? data.depth : '';
                let str = String(width) + String(height) + String(depth);
                return str;
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
                    return tag['name_'+this.$props.lang]
                }
            },
            setUrl(url) {
                let arrUrlCurrent = location.href.split('/').slice(0, -1);
                let slug = url.split('/').slice(-1)[0];
                arrUrlCurrent.push(slug);
                let urlNext = arrUrlCurrent.join("/");
                history.pushState(null, null, urlNext);
            }
        }
    };
</script>

<style scoped>
    .btn_default.btn_with-icon.js-to-cart {
        margin-bottom: 10px;
    }

    .window-message {
        opacity: 0;
        display: block;
        padding: 0 10px;
        font-size: 14px;
        height: 50px;
        line-height: 50px;
        color: black;
        background-color: white;
        border-radius: 3px;
        cursor: default;
        transition: opacity 0.3s linear;
    }

    .window-message.show {
        opacity: 1;
    }
</style>
