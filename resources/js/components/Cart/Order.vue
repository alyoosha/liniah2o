<template>
    <main class="main-content" id="main-content">
        <cart-purchased-successfully
            v-if="created_successfully"
            :language="language"
            :homepage_link="homepage_link"
            :order="created_order"
            :online_phone_default = "online_phone_default"
            :recommended_products_default="recommended_products_default"
        ></cart-purchased-successfully>
        <section v-else class="section section_inner-page section_error-404 section_error section_checkout-mvp section_checkout-states">
            <div class="section__header">
                <div class="container">
                    <div class="section__breadcrumbs">
                        <ul class="list list_unstyled breadcrumbs-list">
                            <li class="list__item"><a class="link" :href="homepage_link">{{ __('homepage') }}</a></li>
                            <li class="list__item"><a class="link" :href="cart_link">{{ __('basket') }}</a></li>
                            <li class="list__item"><a class="link active" href="javascript: void(0);">{{ __('checkout_order') }}</a></li>
                        </ul>
                    </div>
                    <div class="header-title">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="header-title__main section__title section__title_style1">
                                    <h1>{{ __('checkout_order') }}</h1>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 header-title__wrapper">
                                <div class="header-title__link"><a :href="back_to_cart_link">{{ __('back_to_cart') }}</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section__body">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-xl-6">
                            <div class="checkout-states-block">
                                <div class="checkout-states-block__cart-button">
                                    <button class="cart-table__button cart-table__button_states js-profile-history1">{{ __('products_in_order') }}</button>
                                </div>
                                <form class="js-form-checkout-states-mvp" name="form-checkout-states-mvp" method="post" id="form-checkout-states-mvp">
                                    <input type="hidden" name="_token" :value="csrf">
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-xl-10">
                                            <div class="checkout-states-block__table-wrapper">
                                                <div class="checkout-states-block__payment">
                                                    <div class="params-block">
                                                        <div class="params-block__title">{{ __('payment') }}</div>
                                                        <ul class="list list_unstyled radio-list params-block__list">
                                                            <li class="list__item radio">
                                                                <label class="radio__label">
                                                                    <input class="radio__hidden" type="radio" id="checkout-payment-1" name="checkout-payment" v-model="checkout_data.payment" value="in_shop" @click="checkout_data.delivery.method = 'pickup'" checked>
                                                                    <span class="radio__custom" aria-hidden="true"></span>
                                                                    <span class="radio__text">{{ __('in_shop') }}</span>
                                                                </label>
                                                            </li>
                                                            <li class="list__item radio">
                                                                <label class="radio__label">
                                                                    <input class="radio__hidden" type="radio" id="checkout-payment-2" name="checkout-payment" v-model="checkout_data.payment" value="courier" @click="checkout_data.delivery.method = 'courier'">
                                                                    <span class="radio__custom" aria-hidden="true"></span>
                                                                    <span class="radio__text">{{ __('courier') }}</span>
                                                                </label>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="checkout-states-block__methods">
                                                    <div class="params-block">
                                                        <div class="params-block__title">{{ __('payment_method') }}</div>
                                                        <ul class="list list_unstyled radio-list params-block__list_shop">
                                                            <li class="list__item radio">
                                                                <label class="radio__label">
                                                                    <input class="radio__hidden" type="radio" id="checkout-method-shop-1" v-model="checkout_data.payment_method" name="checkout-method-shop" value="card" checked>
                                                                    <span class="radio__custom" aria-hidden="true"></span>
                                                                    <span class="radio__text">{{ __('card') }}</span>
                                                                </label>
                                                            </li>
                                                            <li class="list__item radio">
                                                                <label class="radio__label">
                                                                    <input class="radio__hidden" type="radio" id="checkout-method-shop-2" v-model="checkout_data.payment_method" name="checkout-method-shop" value="cash">
                                                                    <span class="radio__custom" aria-hidden="true"></span>
                                                                    <span class="radio__text">{{ __('cash') }}</span>
                                                                </label>
                                                            </li>
                                                        </ul>
                                                        <ul class="list list_unstyled radio-list params-block__list_courier">
                                                            <li class="list__item radio">
                                                                <label class="radio__label">
                                                                    <input class="radio__hidden" type="radio" id="checkout-method-courier-1" v-model="checkout_data.payment_method" name="checkout-method-courier" value="card" checked>
                                                                    <span class="radio__custom" aria-hidden="true"></span>
                                                                    <span class="radio__text">{{ __('card') }}</span>
                                                                </label>
                                                            </li>
                                                            <li class="list__item radio">
                                                                <label class="radio__label">
                                                                    <input class="radio__hidden" type="radio" id="checkout-method-courier-2" v-model="checkout_data.payment_method" name="checkout-method-courier" value="cash">
                                                                    <span class="radio__custom" aria-hidden="true"></span>
                                                                    <span class="radio__text">{{ __('cash') }}</span>
                                                                </label>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-xl-8">
                                            <div class="checkout-states-block__delivery">
                                                <div class="params-block">
                                                    <div class="params-block__title">{{ __('delivery') }}</div>
                                                    <div class="row">
                                                        <div class="col-12 col-sm-6">
                                                            <ul class="list list_unstyled radio-list params-block__list_sait">
                                                                <li class="list__item radio">
                                                                    <label class="radio__label">
                                                                        <input class="radio__hidden" type="radio" id="checkout-delivery-1" v-model="checkout_data.delivery.method" name="checkout-delivery" value="courier" checked>
                                                                        <span class="radio__custom" aria-hidden="true"></span>
                                                                        <span class="radio__text">{{ __('courier_delivery') }}</span>
                                                                    </label>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-12 col-sm-6">
                                                            <ul class="list list_unstyled radio-list params-block__list_sait">
                                                                <li class="list__item radio radio-margin-top">
                                                                    <label class="radio__label">
                                                                        <input class="radio__hidden" type="radio" id="checkout-delivery-2" v-model="checkout_data.delivery.method" name="checkout-delivery" value="pickup">
                                                                        <span class="radio__custom" aria-hidden="true"></span>
                                                                        <span class="radio__text">{{ __('pickup_delivery') }}</span>
                                                                    </label>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- COURIER -->
                                                <div class="delivery-form-block delivery-form-block_courier">
                                                    <div class="form-group">
                                                        <label class="form-label form-label_hidden" for="checkout-delivery-courier-name">{{ __('Name') }}</label>
                                                        <input class="form-control"
                                                               type="text"
                                                               name="delivery-username"
                                                               id="checkout-delivery-courier-name"
                                                               v-model.trim="checkout_data.delivery.common_data.name"
                                                               :placeholder="__('Name')"
                                                               v-validate="{ rules: { required: true, min: 2 } }"
                                                               required>
                                                        <div v-show="errors.has('delivery-username')" class="validation-msg form-validator_error">{{ errors.first('delivery-username') }}</div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label form-label_hidden"
                                                               for="checkout-delivery-courier-phone">{{ __('mobile_phone') }}</label>
                                                        <input class="form-control" type="text"
                                                               name="delivery-phone"
                                                               id="checkout-delivery-courier-phone"
                                                               v-model.trim="checkout_data.delivery.common_data.phone"
                                                               v-validate="{ rules: { required: true, min: 2 } }"
                                                               :placeholder="__('mobile_phone')"
                                                               required>
                                                        <div v-show="errors.has('delivery-phone')" class="validation-msg form-validator_error">{{ errors.first('delivery-phone') }}</div>
                                                    </div>
                                                    <div
                                                        v-if="isCourierDelivery"
                                                        class="form-group"
                                                    >
                                                        <label class="form-label form-label_hidden"
                                                               for="checkout-delivery-courier-email">{{ __('email') }}</label>
                                                        <ValidationProvider ref="email" :rules="{ required: true, regex:/^[a-z0-9-_\.]+@[a-z0-9-_]+\.[a-z]{1,10}$/i, min: 2 }" mode="lazy">
                                                            <div slot-scope="{ errors }">
                                                                <input
                                                                    class="form-control"
                                                                    type="text"
                                                                    name="delivery-email"
                                                                    id="checkout-delivery-courier-email"
                                                                    v-model.trim="checkout_data.delivery.common_data.email"
                                                                    :placeholder="__('email')"
                                                                    required
                                                                >
                                                                <div class="validation-msg form-validator_error">{{ errors[0] }}</div>
                                                            </div>
                                                        </ValidationProvider>
                                                    </div>

                                                    <div class="select-block form-group">
                                                        <svg role="img" width="16" height="16">
                                                            <use xlink:href="#svg-icon-down-arrow"></use>
                                                        </svg>
                                                        <select
                                                            name="checkout-delivery-courier-region"
                                                            id="checkout-delivery-courier-region"
                                                            v-model.trim="checkout_data.delivery.courier_form_data.region"
                                                            v-select2="checkout_data.delivery.courier_form_data.region"
                                                            v-validate="{ rules: { required: this.isCourierDelivery } }"
                                                            class="brand js-example-classic-single"
                                                            :data-placeholder="__('region')"
                                                            required
                                                        >
                                                            <option selected disabled> </option>
                                                            <option :value="region.id" v-for="region in regions">{{ region['name_'+language] }}</option>
                                                        </select>
                                                        <div v-show="errors.has('checkout-delivery-courier-region') && isCourierDelivery" class="validation-msg form-validator_error">{{ errors.first('checkout-delivery-courier-region') }}</div>
                                                    </div>
                                                    <div class="select-block form-group">
                                                        <svg role="img" width="16" height="16">
                                                            <use xlink:href="#svg-icon-down-arrow"></use>
                                                        </svg>
                                                        <select
                                                            name="checkout-delivery-courier-town"
                                                            id="checkout-delivery-courier-town"
                                                            v-model.trim="checkout_data.delivery.courier_form_data.city"
                                                            v-select2="checkout_data.delivery.courier_form_data.city"
                                                            v-validate="{ rules: { required: this.isCourierDelivery } }"
                                                            class="city js-example-classic-single"
                                                            :data-placeholder="__('city')"
                                                            required
                                                        >
                                                            <option selected disabled> </option>
                                                            <option :value="city.id" v-for="city in cities">{{ city['name_'+language] }}</option>
                                                        </select>
                                                        <div v-show="errors.has('checkout-delivery-courier-town') && isCourierDelivery" class="validation-msg form-validator_error">{{ errors.first('checkout-delivery-courier-town') }}</div>
                                                    </div>
                                                    <div
                                                        class="form-group"
                                                    >
                                                        <label class="form-label form-label_hidden" for="checkout-delivery-courier-street">{{ __('street') }}</label>
                                                        <input
                                                            class="form-control"
                                                            type="text"
                                                            name="checkout-delivery-courier-street"
                                                            id="checkout-delivery-courier-street"
                                                            v-model.trim="checkout_data.delivery.courier_form_data.street"
                                                            v-validate="{ rules: { required: this.isCourierDelivery, min: 2 } }"
                                                            :placeholder="__('street')"
                                                            required
                                                        >
                                                        <div v-show="errors.has('checkout-delivery-courier-street') && isCourierDelivery" class="validation-msg form-validator_error">{{ errors.first('checkout-delivery-courier-street') }}</div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 col-md-6">
                                                            <div
                                                                class="form-group"
                                                            >
                                                                <label class="form-label form-label_hidden" for="checkout-delivery-courier-house">{{ __('house') }}</label>
                                                                <input
                                                                    class="form-control"
                                                                    type="text"
                                                                    name="checkout-delivery-courier-house"
                                                                    id="checkout-delivery-courier-house"
                                                                    v-model.trim="checkout_data.delivery.courier_form_data.house"
                                                                    v-validate="{ rules: { required: this.isCourierDelivery } }"
                                                                    :placeholder="__('house')"
                                                                    required
                                                                >
                                                                <div v-show="errors.has('checkout-delivery-courier-house') && isCourierDelivery" class="validation-msg form-validator_error">{{ errors.first('checkout-delivery-courier-house') }}</div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <div
                                                                class="form-group"
                                                            >
                                                                <label class="form-label form-label_hidden" for="checkout-delivery-courier-flat">{{ __('flat') }}</label>
                                                                <input
                                                                    class="form-control"
                                                                    type="text"
                                                                    name="checkout-delivery-courier-flat"
                                                                    id="checkout-delivery-courier-flat"
                                                                    v-model.trim="checkout_data.delivery.courier_form_data.flat"
                                                                    v-validate="{ rules: { /*numeric: true*/ } }"
                                                                    :placeholder="__('flat')"
                                                                >
                                                                <div v-show="errors.has('checkout-delivery-courier-flat') && isCourierDelivery" class="validation-msg form-validator_error">{{ errors.first('checkout-delivery-courier-flat') }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="form-group"
                                                    >
                                                        <label class="form-label form-label_hidden" for="checkout-delivery-courier-text">{{ __('comment') }}</label>
                                                        <textarea
                                                            type="text"
                                                            name="delivery-comment"
                                                            class="form-control"
                                                            id="checkout-delivery-courier-text"
                                                            v-model.trim="checkout_data.delivery.common_data.comment"
                                                            v-validate="{ rules: { max: 1000, min: 2 } }"
                                                            :placeholder="__('comment')"
                                                        ></textarea>
                                                        <div v-show="errors.has('delivery-comment')" class="validation-msg form-validator_error">{{ errors.first('delivery-comment') }}</div>
                                                    </div>
                                                    <div class="form-group form-group_last">
                                                        <a class="delivery-regulation-link" href="#modal-delivery-clause" data-toggle="modal">{{ __('delivery_regulation') }}</a>
                                                    </div>
                                                </div>
                                                <!-- PICKUP -->
                                                <div class="delivery-form-block delivery-form-block_pickup">
                                                    <div
                                                        class="form-group"
                                                    >
                                                        <label class="form-label form-label_hidden" for="checkout-delivery-pickup-name">{{ __('Name') }}</label>
                                                        <input
                                                            class="form-control"
                                                            type="text"
                                                            name="delivery-username"
                                                            id="checkout-delivery-pickup-name"
                                                            v-model.lazy.trim="checkout_data.delivery.common_data.name"
                                                            v-validate="{ rules: { required: true, min: 2 } }"
                                                            :placeholder="__('Name')"
                                                            required
                                                        >
                                                        <div v-show="errors.has('delivery-username')" class="validation-msg form-validator_error">{{ errors.first('delivery-username') }}</div>
                                                    </div>
                                                    <div
                                                        class="form-group"
                                                    >
                                                        <label class="form-label form-label_hidden" for="checkout-delivery-pickup-phone">{{ __('mobile_phone') }}</label>
                                                        <input
                                                            class="form-control"
                                                            type="text"
                                                            name="delivery-phone"
                                                            id="checkout-delivery-pickup-phone"
                                                            v-model.trim="checkout_data.delivery.common_data.phone"
                                                            v-validate="{ rules: { required: true, min: 2 } }"
                                                            :placeholder="__('mobile_phone')"
                                                            required
                                                        >
                                                        <div v-show="errors.has('delivery-phone')" class="validation-msg form-validator_error">{{ errors.first('delivery-phone') }}</div>
                                                    </div>
                                                    <div
                                                        v-if="isPickupDelivery"
                                                        class="form-group"
                                                    >
                                                        <label class="form-label form-label_hidden" for="checkout-delivery-pickup-email">{{ __('email') }}</label>
                                                        <ValidationProvider ref="email" :rules="{ required: true, regex:/^[a-z0-9-_\.]+@[a-z0-9-_]+\.[a-z]{1,10}$/i, min: 2 }" mode="lazy">
                                                            <div slot-scope="{ errors }">
                                                                <input
                                                                    class="form-control"
                                                                    type="text"
                                                                    name="delivery-email"
                                                                    id="checkout-delivery-pickup-email"
                                                                    v-model.trim="checkout_data.delivery.common_data.email"
                                                                    :placeholder="__('email')"
                                                                    required
                                                                >
                                                                <div class="validation-msg form-validator_error">{{ errors[0] }}</div>
                                                            </div>
                                                        </ValidationProvider>
                                                    </div>
                                                    <div
                                                        class="select-block form-group"
                                                    >
                                                        <svg role="img" width="16" height="16">
                                                            <use xlink:href="#svg-icon-down-arrow"></use>
                                                        </svg>
                                                        <select
                                                            name="pickup-shop-address"
                                                            v-model.trim="checkout_data.delivery.pickup_form_data.address"
                                                            v-validate="{ rules: { required: this.isPickupDelivery } }"
                                                            v-select2="checkout_data.delivery.pickup_form_data.address"
                                                            class="brand js-example-classic-single"
                                                            :data-placeholder="__('shop_address')"
                                                        >
                                                            <option :value="address.name_ru" v-for="address in shop_addresses">{{ address['name_'+language] }}</option>
                                                        </select>
                                                        <div v-show="errors.has('pickup-shop-address') && isPickupDelivery" class="validation-msg form-validator_error">{{ errors.first('pickup-shop-address') }}</div>
                                                    </div>
                                                    <div class="form-group form-group_last">
                                                        <label class="form-label form-label_hidden" for="checkout-delivery-courier-pickup-text">{{ __('comment') }}</label>
                                                        <textarea
                                                            name="delivery-comment"
                                                            class="form-control"
                                                            id="checkout-delivery-courier-pickup-text"
                                                            v-model.trim="checkout_data.delivery.common_data.comment"
                                                            v-validate="{ rules: { max: 1000, min: 2 } }"
                                                            :placeholder="__('comment')"
                                                        ></textarea>
                                                        <div v-show="errors.has('delivery-comment')" class="validation-msg form-validator_error">{{ errors.first('delivery-comment') }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="list list_unstyled checkbox-list">
                                        <li class="list__item checkbox">
                                            <label for="personal-data-agreement" class="checkbox__label">
                                                <input type="checkbox" id="personal-data-agreement" name="personal-data-agreement" class="checkbox__hidden" v-model="personal_data_agreement">
                                                <span aria-hidden="true" class="checkbox__custom"></span>
                                                <span class="checkbox__text">{{ __('personal_data_agreement') }}</span>
                                            </label>
                                        </li>
                                    </ul>
                                </form>
                            </div>
                        </div>
                        <div class="col-12 col-xl-6">
                            <div class="checkout-cart-table checkout-cart-table_states">
                                <div class="cart-table">
                                    <div class="cart-table__row" v-for="product in products" :key="product.id">
                                        <div v-if="product.product_id_for_kit" class="cart-table__cell cart-table__cell_info">
                                            <div v-for="p in product['products']">
                                                <div class="cart-table__info">
                                                    <a class="cart-table__img" :href="p.product_link" :aria-label="p['name_'+language]">
                                                        <img :src="p.preview_picture" :alt="p['name_'+language]"/>
                                                    </a>
                                                    <div class="cart-table__content">
                                                        <a class="cart-table__title section__title" href="javascript: void(0);">{{ p['name_'+language] }}</a>
                                                        <div class="cart-table__descr section__description">{{ __('articul') }} {{ p.articul }}</div>
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
                                                        <li class="col-auto list__item">
                                                            <span class="list__param-title">{{ product.count }} {{ __('pieces_cutted') }}</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-else class="cart-table__cell cart-table__cell_info">
                                            <div class="cart-table__info">
                                                <a class="cart-table__img" :href="product.product_link" :aria-label="product['name_'+language]">
                                                    <img :src="product.preview_picture" :alt="product['name_'+language]"/>
                                                </a>
                                                <div class="cart-table__content">
                                                    <a class="cart-table__title section__title" href="javascript: void(0);">{{ product['name_'+language] }}</a>
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
                                                        <span class="list__param-title">{{ get_product_sizes(product.sizes) }}</span>
                                                    </li>
                                                    <li class="col-auto list__item">
                                                        <span class="list__param-title">{{ product.count }} {{ product['unit_'+language] }}</span>
                                                    </li>
                                                </ul>
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
                                                <span v-if="product.discount_price > 0" class="old">{{ Number.parseInt(product.price).toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ").trim() }}</span>
                                                <span v-if="product.discount_price > 0" class="cost cost_new">{{ Number.parseInt(product.discount_price).toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ").trim() }}</span>
                                                <span v-else class="cost">{{ Number.parseInt(product.price).toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ").trim() }}</span>
                                                <span class="currency">{{ __('currency_name') }}{{ product['unit_'+language] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-xl-6 offset-xl-6">
                            <div class="checkout-total checkout-total_states">
                                <div class="checkout-total__th">
                                    <div class="checkout-total__title section__title section__title_style1">{{ __('total') }}:</div>
                                </div>
                                <div class="checkout-total__value">
                                    <div class="checkout-total__number">
                                        {{ total_discount_sum }}
                                        <span class="checkout-total__add-text">{{ __('currency_name_without_part') }}</span>
                                    </div>
                                </div>
                                <button
                                    class="btn_loader checkout-total__states-button btn btn_default btn_shadow btn_dark btn_with-icon"
                                    type="submit"
                                    form="form-checkout-states-mvp"
                                    @click.prevent="checkout_order"
                                    :disabled="count === 0"
                                >
                                    <span class="btn__icon" aria-hidden="true">
                                        <svg class="verified-icon" role="img" width="30" height="30">
                                            <use xlink:href="#svg-icon-verified"></use>
                                        </svg>
                                        <svg class="loader-icon" role="img" aria-hidden="true" width="10" height="10">
                                            <use xlink:href="#svg-icon-loader"></use>
                                        </svg>
                                    </span>
                                    <span class="btn__text">{{ __('checkout') }}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</template>

<script>
    import ntc from "../../ntc";
    import SuccessPurchase from "./SuccessPurchase";
    import { ValidationProvider } from 'vee-validate';

    export default {
        props: {
            language: {
                type: String
            },
            homepage_link: {
                type: String, default: ''
            },
            cart_link: {
                type: String, default: ''
            },
            back_to_cart_link: {
                type: String, default: ''
            },
            recommended_products_default: {
                type: String, default: ''
            },
            delivery_phone_default: {
                type: String, default: ''
            },
            online_phone_default: {
                type: String, default: ''
            },
            available_delivery_regions_default: {
                type: String, default: ''
            }
        },
        components: {
            'cart-purchased-successfully': SuccessPurchase,
            ValidationProvider
        },
        data: () => {
            return {
                csrf: $('meta[name="csrf-token"]').attr('content'),
                personal_data_agreement: false,
                productsArticles: [],
                products: [],
                phone: '',
                promocode: '',
                shop_addresses: [
                    {
                        name_ru: 'г.Кишинэу, ул.Михай Витязул 21/1',
                        name_ro: 'or.Chișinău, str.Mihai Viteazul 21/1'
                    },
                    {
                        name_ru: 'г.Кишинэу, ул.Узинелор 165',
                        name_ro: 'or.Chișinău, str.Uzinelor 165'
                    },
                    {
                        name_ru: 'г.Кишинэу, ул.Алба Юлия 6/3',
                        name_ro: 'or.Chișinău, str.Alba Iulia 6/3'
                    },
                    {
                        name_ru: 'г.Бэлць, ул.Спортивэ 3',
                        name_ro: 'or.Bălți, str. Sportivă 3'
                    }
                ],
                checkout_data: {
                    payment: 'in_shop',
                    payment_method: 'card',
                    delivery: {
                        method: 'pickup',
                        common_data: {
                            name: '',
                            phone: '',
                            email: '',
                            comment: ''
                        },
                        courier_form_data: {
                            region: '',
                            city: '',
                            street: '',
                            house: '',
                            flat: '',
                        },
                        pickup_form_data: {
                            address: '',
                        },
                    },
                    products: [],
                },
                isValid: false,
                btn_clicked: false,
                created_successfully: false,
                creation_failed: false,
                created_order: {},

                regions: [],
                cities: []
            }
        },
        beforeMount() {
            this.phone = this.$props.delivery_phone_default;
            this.regions = JSON.parse(this.available_delivery_regions_default);

            this.$validator.localize(this.language);
        },
        computed: {
            count() {
                return this.$store.getters.get_total_products_in_cart;
            },
            cart_products_articles() {
                return this.$store.getters.get_cart_products;
            },
            // total_sum() {
            //     if(this.products) {
            //         let priceComplement = 0;
            //         let prices = this.products.map((product) => {
            //             if(product.product_id_for_kit) {
            //                 for(let p in product.products) {
            //                     priceComplement +=  Number(product.products[p].price);
            //                 }
            //
            //                 return priceComplement * product.count;
            //             }
            //
            //             return Number(product.price) * product.count;
            //         });
            //
            //         let total = prices.reduce((a, b) => a + b, 0);
            //
            //         return total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ").trim();
            //     }
            // },
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
            isCourierDelivery() {
                return this.checkout_data.delivery.method === 'courier';
            },
            isPickupDelivery() {
                return this.checkout_data.delivery.method === 'pickup';
            }
        },
        watch: {
            'checkout_data.delivery.courier_form_data.region': {
                handler(region) {
                    this.cities = [];

                    axios.get('/api/cart/getAvailableDeliveryCitiesByRegion', { params: { region } })
                        .then(response => {
                            this.cities = response.data;
                        })
                        .catch(error => {
                            console.log(error)
                        });
                }
            },
            'cart_products_articles': {
                handler(products) {
                    this.productsArticles = products.map(product => product.articul);

                    // redirect to homepage if already ordered but refresh page and it has not got any products
                    if(this.productsArticles.length === 0 && !this.created_successfully) {
                        window.location.replace(this.homepage_link);
                    }

                    axios.get('/api/cart/getProductsByArticlesWithComplement', { params: { articles: JSON.stringify(products), lang: this.language } })
                        .then(response => {
                            this.products = response.data;
                        })
                        .catch(error => {
                            console.log(error)
                        });
                }
            }
        },
        methods: {
            checkout_order() {
                this.btn_clicked = true;

                if(this.checkout_data.delivery.common_data.email.length > 0) {
                    this.$refs.email.setFlags({
                        dirty: true,
                        invalid: true,
                        touched: true,
                        untouched: false,
                        valid: false,
                    });
                }

                this.$refs.email.validate(this.checkout_data.delivery.common_data.email);

                this.$validator.validateAll()
                    .then(result => {
                        if(this.isCourierDelivery) {
                            this.isValid =
                                !this.errors.has('delivery-username') &&
                                !this.errors.has('delivery-phone') &&
                                !this.errors.has('delivery-email') &&
                                !this.errors.has('delivery-comment') &&

                                !this.errors.has('checkout-delivery-courier-region') &&
                                !this.errors.has('checkout-delivery-courier-town') &&

                                !this.errors.has('checkout-delivery-courier-street') &&
                                !this.errors.has('checkout-delivery-courier-house') &&
                                !this.errors.has('checkout-delivery-courier-flat')
                        } else {
                            this.isValid =
                                !this.errors.has('delivery-username') &&
                                !this.errors.has('delivery-phone') &&
                                !this.errors.has('delivery-email') &&
                                !this.errors.has('delivery-comment') &&
                                !this.errors.has('pickup-shop-address')
                        }

                        if(!this.personal_data_agreement) return;

                        if(this.isValid && this.products.length > 0 && this.personal_data_agreement) {
                            $('.verified-icon').hide();
                            $('.btn_loader').addClass('btn_loader_show');

                            let formData = new FormData();

                            this.checkout_data.products = this.products;

                            formData.append('token', $('input[name="_token"]').val());
                            formData.append('products', JSON.stringify(this.products));
                            formData.append('total_sum', this.total_discount_sum);
                            formData.append('payment', this.checkout_data.payment);
                            formData.append('payment_method', this.checkout_data.payment_method);
                            formData.append('delivery_method', this.checkout_data.delivery.method);
                            formData.append('customer_name', this.checkout_data.delivery.common_data.name);
                            formData.append('customer_phone', this.checkout_data.delivery.common_data.phone);
                            formData.append('customer_email', this.checkout_data.delivery.common_data.email);
                            formData.append('comment', this.checkout_data.delivery.common_data.comment);

                            if(this.checkout_data.delivery.method === 'courier') {
                                let delivery_form_data = JSON.stringify(this.checkout_data.delivery.courier_form_data);
                                formData.append('delivery_form_data', delivery_form_data);
                            } else {
                                let delivery_form_data = JSON.stringify(this.checkout_data.delivery.pickup_form_data);
                                formData.append('delivery_form_data', delivery_form_data);
                            }

                            axios.post('/'+this.language+'/cart/checkout', formData, {
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8',
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            })
                                .then(response => {
                                    if(response.data.success.length > 0 && response.status == 200) {
                                        this.clearCart();

                                        $('.btn_loader').removeClass('btn_loader_show');
                                        $('.verified-icon').show();
                                        this.created_successfully = true;
                                        this.created_order = response.data.order;
                                    }
                                })
                                .catch(error => console.log(error));
                        }
                    });
            },
            clearCart() {
                this.$store.commit('clear_cart');

                let user = JSON.parse($.cookie('user'));
                $.removeCookie('user', { expires: 30, path: '/' });

                user.cart = [];

                $.cookie('user', JSON.stringify(user), { expires: 30, path: '/' });
                console.log(JSON.parse($.cookie('user')));
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
        }
    }
</script>

<style scoped>
    .validation-msg {
        position: relative;
        margin-top: 10px;
        font-size: 14px;
        line-height: 16px;
    }
    .form-validator_error {
        color: #F53434;
    }
    .checkbox-list {
        /*min-width: 1000px;*/
        padding-top: 15px;
        padding-bottom: 30px;
    }
    .checkbox__text {
        font-size: 14px;
        line-height: 1.3;
        text-transform: none;
    }
</style>
