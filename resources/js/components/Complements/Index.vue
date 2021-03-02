<template>
	<div class="product-block__complect section_complect section_complect_inner">
		<div class="complect-block">
			<div class="complect-block__header">
				<div class="container">
					<div class="complect-block__info bg_white">
						<div
								class="complect-block__contains section__title section__title_style7">{{__('kit_contains')}}: {{ allQuantity }} {{ allPositionName }} </div>
						<div class="complect-block__descr"
						v-if="(Array.isArray(kit) && kit.length != 0) &&
						(Array.isArray(singly) && singly.length != 0)">
							{{__("this_kit_can_be_purchased_in_parts") }}
						</div>
					</div>
				</div>
			</div>
			<div class="complect-block__body">
				<form name="complect-form" method="post">
					<div class="container">
						<div class="complect-block__controls">
							<div class="row align-items-center">
								<div class="col-7 col-sm-auto">
									<div class="checkbox">
										<label class="checkbox__label"
										       for="checked-all">
											<input class="checkbox__hidden js-input-all"
											       type="checkbox"
											       id="checked-all"
											       name="checked-all"
											       value="all"
											       @change="chooseAll($event)">
											<span class="checkbox__custom" aria-hidden="true"></span>
											<span class="checkbox__text">{{ __('choose_all') }}</span>
										</label>
									</div>
								</div>
								<div class="col-5 col-sm-auto">
									<div class="controls-quantity">
										<span class="controls-quantity__title">{{ __('selected') }}:</span>
										<span class="controls-quantity__text">{{ selectedQuantity }} {{ positionName }}</span></div>
								</div>
							</div>
						</div>
						<div class="row justify-content-between">
							<div class="col-12 col-lg-8 col-xl-9">
								<div v-if="kit" class="complect-block__items complect-block__items_merge">
									<div class="checkbox checkbox_merge">
										<label class="checkbox__label" for="checked-merge-products">
											<input class="checkbox__hidden js-input-complement kit"
											       type="checkbox"
											       id="checked-merge-products"
											       name="checked-merge-products"
											       value="kit"
											       @change="chooseKit($event)">
											<span class="checkbox__custom" aria-label="Пенал с левым открыванием"></span>
										</label>
									</div>
									<div class="complect-block__item complect-block__item_no-slider" v-for="product of kit">
										<div class="complect-product">
											<div class="complect-product__cell complect-product__cell_check">
											</div>
											<div class="complect-product__cell complect-product__cell_img">
												<div class="complect-product__img">
													<picture class="image__wrapper" v-lazyload>
														<source v-if="product['imagesResized'] != undefined && product['imagesResized'].length > 0"
														        :srcset="product['imagesResized'][1]"
														        media="(min-width: 535px)">
														<source v-if="product['imagesResized'] != undefined && product['imagesResized'].length > 0"
														        :srcset="product['imagesResized'][0]"
														        media="(min-width: 0px)">
														<img v-if="product['imagesResized'] != undefined && product['imagesResized'].length > 0"
														     :data-src="product['imagesResized'][1]"
														     :alt="product['name_'
                                                              + lang]">
														<img v-else :data-src="product['imgPreview']"
														     :alt="product['name_' + lang]">
													</picture>
												</div>
											</div>
											<div class="complect-product__cell complect-product__cell_content">
												<div class="complect-product__title">{{ product['name_' + lang] }}</div>
												<div class="complect-product__code">{{ __('articul') }} {{ product.articul }}</div>
												<ul class="list list_unstyled complect-product__params-list">
													<li class="list__item"
													    v-if="product.color">
														<div class="list__param-title">{{ __('color') }}:</div>
														<div class="list__param-value">
															<span v-if="product.color.split(',').length == 1"
															    class="list__param-color"
															    :style="'background-color: ' + product.color + ';'"
															>
															</span>
															<span
																v-else-if="product.color.split(',').length == 2"
																class="list__param-color"
																:style="'color: ' +  product.color.split(',')[0]
																+'; background-color:' +  product.color.split(',')[1] +
																';'"
															>
                                                            </span>
															<span v-else class="complementary-color multi-color" aria-hidden="true"></span>
															<span class="list__param-descr">{{ product.color_name }}</span>
														</div>
													</li>
													<li class="list__item"
													    v-if="product.sizes">
														<div class="list__param-title">{{ __('size') }}:</div>
														<div class="list__param-value">
															<span class="list__param-descr">
																{{
																	product.sizes.width ?
																	product.sizes.width : ''
																}}{{
																	product.sizes.height ?
																	' x ' + product.sizes.height : ''
																}}{{
																	product.sizes.depth ?
																	' x ' + product.sizes.depth : ''
																}}{{
																	' ' + product.sizes.unit
																}}
															</span>
														</div>
													</li>
												</ul>
											</div>
											<div class="complect-product__cell complect-product__cell_price">
												<div class="complect-product__price">
						                             <span class="old"
						                                   v-if="Number(product.discount_price) > 0">
							                             {{ getPriceForHtml(product.price) }}
						                             </span>
													 <span class="cost cost_new"
													       v-if="Number(product.discount_price) > 0">
													 			{{ getPriceForHtml(product.discount_price) }}
													 		</span>
													 <span class="cost" v-else>{{ getPriceForHtml(product.price)
													                           }}</span>
													 <span class="currency">{{ __('currency_name') }}{{ product['unit_'+lang] }}</span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div v-if="singly" class="complect-block__items" v-for="(product, key) of singly">
									<div v-if="!Array.isArray(product)" class="complect-block__item complect-block__item-similar">
										<div class="complect-product">
											<div class="complect-product__cell complect-product__cell_check">
												<div class="checkbox">
													<label class="checkbox__label" :for="'checked-product-' + key">
														<input
                                                            class="checkbox__hidden js-input-complement js-input-singly singly"
														    type="checkbox"
														    :id="'checked-product-' +  key"
														    :name="'checked-product-' +  key"
														    :value="key"
															@change="chooseSingly($event, product)">
														<span class="checkbox__custom" :aria-label="product['name_' + lang]"></span>
													</label>
												</div>
											</div>
											<div class="complect-product__cell complect-product__cell_img">
												<div class="complect-product__img">
													<picture class="image__wrapper" v-lazyload>
														<source v-if="product['imagesResized'] != undefined && product['imagesResized'].length > 0"
														        :srcset="product['imagesResized'][1]"
														        media="(min-width: 535px)">
														<source v-if="product['imagesResized'] != undefined && product['imagesResized'].length > 0"
														        :srcset="product['imagesResized'][0]"
														        media="(min-width: 0px)">
														<img v-if="product['imagesResized'] != undefined && product['imagesResized'].length > 0"
														     :data-src="product['imagesResized'][1]"
														     :alt="product['name_'
                                                              + lang]">
														<img v-else :data-src="product['imgPreview']"
														     :alt="product['name_' + lang]">
													</picture>
												</div>
											</div>
											<div class="complect-product__cell complect-product__cell_content">
												<div class="complect-product__title">{{ product['name_' +lang] }}</div>
												<div class="complect-product__code">{{ __('articul') }}
												                                    {{ product.articul }}</div>
												<ul class="list list_unstyled complect-product__params-list">
													<li class="list__item"
													    v-if="product.color">
														<div class="list__param-title">{{ __('color') }}:</div>
														<div class="list__param-value">
															<span v-if="product.color.split(',').length == 1"
															    class="list__param-color"
															    aria-hidden="true"
															    style="background-color: #2fa360;"
															    :style="'background-color: ' + product.color + ';'"
															>
															</span>
															<span
																v-else-if="product.color.split(',').length == 2"
															    class="list__param-color"
																aria-hidden="true"
																:style="'color: ' +  product.color.split(',')[0]
															    +'; background-color:' +  product.color.split(',')[1] +
															    ';'"
															>
                                                            </span>
                                                            <span v-else class="complementary-color multi-color" aria-hidden="true">
                                                            </span>
															<span class="list__param-descr">{{ product.color_name }}</span>
														</div>
													</li>
													<li class="list__item"
														v-if="product.sizes">
														<div class="list__param-title">{{ __('size') }}:</div>
														<div class="list__param-value">
															<span class="list__param-descr">
																{{
															    	product.sizes.width ?
																	product.sizes.width : ''
																}}{{
															    	product.sizes.height ?
																	' x ' + product.sizes.height : ''
																}}{{
															    	product.sizes.depth ?
																	' x ' + product.sizes.depth : ''
																}}{{
																	product.sizes.unit ? ' ' + product.sizes.unit : ''
																}}
															</span>
														</div>
													</li>
												</ul>
											</div>
											<div class="complect-product__cell complect-product__cell_price">
												<div class="complect-product__price">
							                        <span class="old"
							                              v-if="Number(product.discount_price) > 0">
								                        {{ getPriceForHtml(product.price) }}
							                        </span>
													<span class="cost cost_new"
													      v-if="Number(product.discount_price) > 0">
														{{ getPriceForHtml(product.discount_price) }}
													</span>
													<span class="cost" v-else>{{ getPriceForHtml(product.price) }}</span>
													<span class="currency">{{ __('currency_name') }}{{ product['unit_'+lang] }}</span>
												</div>
											</div>
										</div>
									</div>
									<div v-else class="complect-block__item">
										<div class="swiper-container js-complect-inner-slider">
											<div class="swiper-wrapper">
												<div class="swiper-slide" v-for="(p, key) in product">
													<div class="complect-product">
														<div class="complect-product__cell complect-product__cell_check">
															<div class="checkbox">
																<label class="checkbox__label">
																	<input
																			class="checkbox__hidden js-input-complement js-input-singly similar-singly"
																			type="checkbox"
																			:name="'similar-checked-product-' +  key"
																			:value="key"
																			@change="chooseSingly($event, p)">
																	<span class="checkbox__custom" :aria-label="p['name_' + lang]"></span>
																</label>
															</div>
														</div>
														<div class="complect-product__cell complect-product__cell_img">
															<div class="complect-product__img">
																<picture class="image__wrapper" v-lazyload>
																	<source v-if="p['imagesResized'] != undefined && p['imagesResized'].length > 0"
																	        :srcset="p['imagesResized'][1]"
																	        media="(min-width: 535px)">
																	<source v-if="p['imagesResized'] != undefined && p['imagesResized'].length > 0"
																	        :srcset="p['imagesResized'][0]"
																	        media="(min-width: 0px)">
																	<img v-if="p['imagesResized'] != undefined && p['imagesResized'].length > 0"
																	     :data-src="p['imagesResized'][1]"
																	     :alt="p['name_' + lang]">
																	<img v-else :data-src="p['imgPreview']"
																	     :alt="p['name_' + lang]">
																</picture>
															</div>
														</div>
														<div class="complect-product__cell complect-product__cell_content">
															<div class="complect-product__title">{{ p['name_' +lang] }}</div>
															<div class="complect-product__code">
                                                                {{ __('articul') }}
                                                                {{ p.articul }}
                                                            </div>
															<ul class="list list_unstyled complect-product__params-list">
																<li v-if="p.color" class="list__item">
																	<div class="list__param-title">{{ __('color') }}:</div>
																	<div class="list__param-value">
																		<span v-if="p.color.split(',').length == 1"
																		      class="list__param-color"
																		      aria-hidden="true"
																		      style="background-color: #2fa360;"
																		      :style="'background-color: ' + p.color + ';'"
																		>
																		</span>
																		<span
																				v-else-if="p.color.split(',').length == 2"
																				class="list__param-color"
																				aria-hidden="true"
																				:style="'color: ' +  p.color.split(',')[0]
																		    +'; background-color:' +  p.color.split(',')[1] +
																		    ';'"
																		>
                                                                        </span>
																		<span v-else class="complementary-color multi-color" aria-hidden="true">
                                                                        </span>
																		<span class="list__param-descr">{{ lang == 'ru' ? ntc.name(p.color)[2] : ntc.name(p.color)[3]}}</span>
																	</div>
																</li>
																<li class="list__item"
																    v-if="p.sizes">
																	<div class="list__param-title">{{ __('size') }}:</div>
																	<div class="list__param-value">
																		<span class="list__param-descr">
																			{{
																		        JSON.parse(p.sizes).width ?
																				JSON.parse(p.sizes).width : ''
																			}}{{
																		        JSON.parse(p.sizes).height ?
																				' x ' + JSON.parse(p.sizes).height : ''
																			}}{{
																		        JSON.parse(p.sizes).depth ?
																				' x ' + JSON.parse(p.sizes).depth : ''
																			}}{{
																				JSON.parse(p.sizes).unit ? ' ' +
																			JSON.parse(p.sizes).unit : ''
																			}}
																		</span>
																	</div>
																</li>
															</ul>
														</div>
														<div class="complect-product__cell complect-product__cell_price">
															<div class="complect-product__price">
							                                    <span class="old"
							                                          v-if="Number(p.discount_price) > 0">
								                                    {{ getPriceForHtml(p.price) }}
							                                    </span>
																<span class="cost cost_new"
																      v-if="Number(p.discount_price) > 0">
																	{{ getPriceForHtml(p.discount_price) }}
																</span>
																<span class="cost" v-else>{{ getPriceForHtml(p.price) }}</span>
																<span class="currency">{{ __('currency_name') }}{{ p['unit_'+lang] }}</span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="swiper-nav">
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
							<div class="col-12 col-lg-4 col-xl-3">
								<div class="complect-block__buy">
									<div class="complect-block__price product-block__price">
										<span class="old" v-if="totalSumDiscount && totalSumDiscount !== totalSum">{{ getPriceForHtml(totalSum) }}</span>
										<span class="cost cost_new" v-if="totalSumDiscount && totalSumDiscount !== totalSum">{{ getPriceForHtml(totalSumDiscount) }}</span>
                                        <span v-else class="cost">{{ getPriceForHtml(totalSum) }}</span>
										<span class="currency">{{ __('currency_name') }}{{ __('pieces_cutted') }}</span>
									</div>
									<div class="complect-block__quantity product-block__quantity">
										<div class="section__title product-block__subtitle">{{ __('quantity') }}</div>
										<div class="form-group form-group_inline">
											<button class="btn btn_minus js-btn-minus-complement"
                                                    type="button"
											        :aria-label="__('less')"
													@click="reduceQuantityProduct"
                                            >
												<svg role="img" width="25" height="25">
													<use xlink:href="#svg-icon-minimize"></use>
												</svg>
											</button>
											<label class="form-label form-label_hidden" for="complect-count">{{ __('quantity') }}</label>
											<input class="form-control" type="number" id="complect-count"
											       name="complect-count"
											       min="1"
											       step="1"
											       :max="limit"
											       v-model="totalQuantity"
											       @input.prevent="validateQuantityOnInput()"
											       @change.prevent="validateQuantityOnChange()"
                                                   data-oldvalue=""
											>
											<button class="btn btn_plus js-btn-plus-complement"
                                                    type="button"
											        :aria-label="__('more')"
											        @click="increaseQuantityProduct"
                                            >
												<svg role="img" width="25" height="25">
													<use xlink:href="#svg-icon-add"></use>
												</svg>
											</button>
										</div>
									</div>
									<div class="btn-group" :class="{dnone: Number.parseInt(product.stock) === 0}">
										<div class="row">
											<div class="col-12">
												<button
														class="btn btn_default btn_dark btn_with-icon js-to-cart"
														type="button"
                                                        :disabled="Number.parseInt(product.stock) === 0"
														@click="clickByBtnToCart($event)"
												>
                                                  <span class="btn__icon" aria-hidden="true">
                                                    <svg role="img" width="30" height="30">
                                                      <use xlink:href="#svg-icon-shop"/>
                                                    </svg>
                                                  </span>
													<span class="btn__text">{{ __('add_to_cart') }}</span>
												</button>
											</div>
											<div class="col-12">
												<span class="window-message">{{ __('last_instance_in_cart') }}</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</template>

<script>
    import Swiper from 'swiper';
    import {ntc} from "../../ntc.js";
    import getPriceForHtml from "../../mixins/getPriceForHtml";

    export default {
        name: "Index",
        props: {
            raw_product: {
                type: String,
                default: []
            },
            lang: {
                type: String
            }
        },
        data: () => {
            return {
                ntc: {},
                product: [],
                kit: [],
                singly: [],
                strPosition: '',
                allQuantity: 0,
	            allInput: 0,
	            selectedQuantity: 0,
	            totalSum: 0,
	            totalSumDiscount: 0,
                single_price: 0,
                single_discount_price: 0,
	            limit: Infinity,
	            totalQuantity: 1,
	            balance: 0,
	            selectedProducts: [],
	            productFromStore: null,
	            allPositionName: '',
	            positionName: '',
	            productsForCart: []
            }
        },
        mixins: [getPriceForHtml],
        beforeMount() {
            this.product = JSON.parse(this.raw_product);
            this.kit = this.product.kit;
            this.singly = this.product.singly;
            this.ntc = ntc;

            if(Array.isArray(this.kit)) {
                this.kit.forEach((product) => {
                    if(this.limit > product.stock) {
						this.limit = product.stock;
                    }

                    product.sizes = product.sizes ? JSON.parse(product.sizes) : null;

                    if(product.color) {
                        if(this.lang == 'ru') {
                            product.color_name = ntc.name(product.color)[2];
                        }
                        else {
                            product.color_name = ntc.name(product.color)[3];
                        }
                    }
                });
            }

            if(Array.isArray(this.singly)) {
                this.singly.forEach((product) => {
                    if(this.limit > product.stock) {
                        this.limit = product.stock;
                    }

                    product.sizes = product.sizes ? JSON.parse(product.sizes) : null;

                    if(product.color) {
                        if(this.lang == 'ru') {
                            product.color_name = ntc.name(product.color)[2];
                        }
                        else {
                            product.color_name = ntc.name(product.color)[3];
                        }
                    }
                });

                this.sortComplement(this.singly);
            }

            this.setBalance();
            this.setAllPositionName();
            this.setPositionName();
        },
        computed: {
            getAllQuantity() {
                if(Array.isArray(this.kit)) {
                    this.allQuantity += this.kit.length;
                }
                if(Array.isArray(this.singly)) {
                    this.allQuantity += this.singly.length;
                }
            }
        },
        mounted() {
            $(".js-complect-inner-slider").each(function () {
                var $slider = $(this);

                let complectInnerSwiper = new Swiper($slider, {
                    speed: 1200,
                    spaceBetween: 0,
                    slidesPerView: 1,
                    observer: true,
                    pagination: false,
                    effect: "fade",
                    fadeEffect: {
                        crossFade: true
                    },
                    navigation: {
                        nextEl: $slider.parents(".complect-block__item").find('.swiper-button-next'),
                        prevEl: $slider.parents(".complect-block__item").find('.swiper-button-prev')
                    },
                });
            });
            this.getAllQuantity;
            this.allInput =
	            document.querySelectorAll('input.kit, input.singly, .swiper-slide-active input.similar-singly').length;
        },
        watch: {
            raw_product: function(value) {
                this.product = JSON.parse(value);
                this.kit = this.product.kit;
                this.singly = this.product.singly;
                this.ntc = ntc;

                if(Array.isArray(this.kit)) {
                    this.kit.forEach((product) => {
                        if(this.limit > product.stock) {
                            this.limit = product.stock;
                        }

                        product.sizes = product.sizes ? JSON.parse(product.sizes) : null;

                        if(product.color) {
                            if(this.lang == 'ru') {
                                product.color_name = ntc.name(product.color)[2];
                            }
                            else {
                                product.color_name = ntc.name(product.color)[3];
                            }
                        }
                    });
                }

                if(Array.isArray(this.singly)) {
                    this.singly.forEach((product) => {
                        if(this.limit > product.stock) {
                            this.limit = product.stock;
                        }

                        product.sizes = product.sizes ? JSON.parse(product.sizes) : null;

                        if(product.color) {
                            if(this.lang == 'ru') {
                                product.color_name = ntc.name(product.color)[2];
                            }
                            else {
                                product.color_name = ntc.name(product.color)[3];
                            }
                        }
                    });

                    this.sortComplement(this.singly);
                }

                this.setBalance();
                this.setAllPositionName();
                this.setPositionName();
            },
            selectedQuantity: function(value) {
                if(Number.parseInt(value) === 0) {
                    $('.js-input-all').prop('checked', false)
                }
            }
        },
	    methods: {
            chooseAll(event) {
                let allInput = document.querySelectorAll('.js-input-complement');

                document.querySelector('.js-input-all').setAttribute('checked', true);

                $(".window-message").removeClass("show");

                if(event.target.checked) {
                    allInput.forEach((input) => {
                        if($(input).hasClass('similar-singly')) {
                            let closest = $(input).closest('.swiper-slide-active');

                            if(closest.length) {
                                let siblings = $(closest).siblings();

                                $(siblings).each(function() {
                                    const item = $(this)[0];
                                    const input = $(item).find('input.similar-singly')[0];
                                    if(input.checked) {
                                        input.click();
                                    }
                                });

                                input.checked = true;
                            }
                        }

                        if($(input).hasClass('singly')) {
                            input.checked = true;
                        }

                        if($(input).hasClass('kit')) {
                            input.checked = true;
                        }
                    });

                    if(Array.isArray(this.singly)) {
                        this.singly.forEach(product => {
                            if(Array.isArray(product)) {
                                for(let [k, i] of Object.entries(product)) {
                                    if(Number.parseInt(k) === 0) {
                                        if(!i['isAdded']) {
                                            this.addSum(i);
                                            this.addSumDiscount(i);
                                            this.addSelectedProducts(i);
                                            ++this.selectedQuantity;
                                            i['isAdded'] = true;
                                        }
                                    } else if(i && Number.parseInt(k) !== 0 && i['isAdded']) {
                                        this.deductSum(product[0]);
                                        this.deductSumDiscount(product[0]);
                                        this.removeSelectedProducts(product[0]);
                                        --this.selectedQuantity;
                                        product[0]['isAdded'] = false;
                                    }
                                }
                            } else {
                                if(!product['isAdded']) {
                                    this.addSum(product);
                                    this.addSumDiscount(product);
                                    this.addSelectedProducts(product);
                                    ++this.selectedQuantity;
                                    product['isAdded'] = true;
                                }
                            }
                        });
                    }

                    if(Array.isArray(this.kit)) {
                        this.kit.forEach(product => {
                            if(!product['isAdded']) {
                                this.addSum(product);
                                this.addSumDiscount(product);
                                this.addSelectedProducts(product);
                                ++this.selectedQuantity;
                                product['isKit'] = true;
                                product['isAdded'] = true;
                            }
                        });
                    }

                    this.single_price = this.totalSum;
                    this.single_discount_price = this.totalSumDiscount;
                } else {
                    allInput.forEach((input) => {
                        input.checked = false;
                    });

                    if(Array.isArray(this.singly)) {
                        this.singly.forEach((product) => {
                            if(Array.isArray(product)) {
                                for(let [k, i] of Object.entries(product)) {
                                    if(i && i['isAdded']) {
                                    // if(Number.parseInt(k) === 0) {
                                        --this.selectedQuantity;
                                        this.deductSum(i);
                                        this.deductSumDiscount(i);
                                        this.removeSelectedProducts(i);
                                        i['isAdded'] = false;
                                    }
                                }
                            } else {
                                --this.selectedQuantity;
                                this.deductSum(product);
                                this.deductSumDiscount(product);
                                this.removeSelectedProducts(product);
                                product['isAdded'] = false;
                            }
                        });
                    }

                    if(Array.isArray(this.kit)) {
                        this.kit.forEach((product) => {
                            --this.selectedQuantity;
                            this.deductSum(product);
                            this.deductSumDiscount(product);
                            this.removeSelectedProducts(product);
                            product['isKit'] = true;
                            product['isAdded'] = false;
                        });
                    }

                    this.totalSum = 0;
                    this.totalSumDiscount = 0;
                    this.totalQuantity = 1;
                    this.selectedQuantity = 0;
                }

                this.setAllPositionName();
                this.setPositionName();
            },
			chooseKit(event) {
                $(".window-message").removeClass("show");

                if(event.target.checked) {
                    this.markInputAll(event.target.checked);

                    this.kit.forEach((product) => {
                        ++this.selectedQuantity;

                        product['isKit'] = true;
                        product['isAdded'] = true;
                        this.addSum(product);
                        this.addSumDiscount(product);
                        this.addSelectedProducts(product);
                    });

                    this.single_price = this.totalSum;
                    this.single_discount_price = this.totalSumDiscount;
                } else {
                    this.markInputAll(event.target.checked);

                    this.kit.forEach((product) => {
                        --this.selectedQuantity;

                        this.deductSum(product);
                        this.deductSumDiscount(product);
                        this.removeSelectedProducts(product);
                        product['isAdded'] = false;

                        if(this.selectedProducts.length == 0) {
                            this.totalSum = 0;
                            this.totalSumDiscount = 0;
                            this.totalQuantity = 1;
                        }
                    });
                }

                this.setAllPositionName();
                this.setPositionName();
            },
			chooseSingly(event, selected_product) {
                $(".window-message").removeClass("show");

                if(event.target.checked) {
                    ++this.selectedQuantity;
                    this.markInputAll(event.target.checked);

                        if($(event.target).hasClass('similar-singly')) {

                            $(event.target).closest('.complect-block__item')
                            .find('input.similar-singly')
                            .each(function() {
                                const checkbox = $(this)[0];
                                if (event.target !== checkbox && checkbox.checked) {
                                    $(this)[0].click();
                                }
                            });

                            $(event.target).attr('checked', true);
                        }

                    this.addSum(selected_product);
                    this.addSumDiscount(selected_product);
                    this.addSelectedProducts(selected_product);

                    for(let [key, item] of Object.entries(this.singly)) {
                        if(Array.isArray(item)) {
                            for(let [k, i] of Object.entries(item)) {
                                if(i && selected_product.articul === i.articul) {
                                    this.singly[key][k]['isAdded'] = true;
                                }
                            }
                        } else {
                            if(selected_product.articul === item.articul) {
                                this.singly[key]['isAdded'] = true;
                            }
                        }
                    }

                    this.single_price = this.totalSum;
                    this.single_discount_price = this.totalSumDiscount;
                } else {
                    this.markInputAll(event.target.checked);
                    --this.selectedQuantity;

                    this.deductSum(selected_product);
                    this.deductSumDiscount(selected_product);
                    this.removeSelectedProducts(selected_product);

                    for(let [key, item] of Object.entries(this.singly)) {
                        if(Array.isArray(item)) {
                            for(let [k, i] of Object.entries(item)) {
                                if(i && selected_product.articul === i.articul) {
                                    this.singly[key][k]['isAdded'] = false;
                                }
                            }
                        } else {
                            if(selected_product.articul === item.articul) {
                                this.singly[key]['isAdded'] = false;
                            }
                        }
                    }

                    if(this.selectedProducts.length == 0) {
                        this.totalSum = 0;
                        this.totalSumDiscount = 0;
                        this.totalQuantity = 1;
                    }
                }

                this.setAllPositionName();
                this.setPositionName();
            },
		    addSelectedProducts(product) {
                this.selectedProducts.push(product);
		    },
		    removeSelectedProducts(product) {
                this.selectedProducts.forEach((item, key) => {
                    if(item.id == product.id) {
                        this.selectedProducts.splice(key,1)
                    }
                });
		    },
		    addSum(product) {
				this.totalSum += product.price * this.totalQuantity;
		    },
            deductSum(product) {
                this.totalSum -= product.price * this.totalQuantity;
            },
            addSumDiscount(product) {
                if(product.discount_price > 0) {
                    this.totalSumDiscount += product.discount_price * this.totalQuantity;
                } else {
                    this.totalSumDiscount += product.price * this.totalQuantity;
                }
            },
            deductSumDiscount(product) {
                if(product.discount_price > 0) {
                    this.totalSumDiscount -= product.discount_price * this.totalQuantity;
                } else {
                    this.totalSumDiscount -= product.price * this.totalQuantity;
                }
            },
		    markInputAll(flag) {
                if(flag) {
                    if(this.allInput == this.selectedQuantity) {
                        $('.js-input-all').prop('checked', 'true')
                    }
                } else {
                    if(this.allInput == this.selectedQuantity) {
                        $('.js-input-all').prop('checked', false)
                    }
                }

		    },
            increaseQuantityProduct() {
                if(this.selectedProducts.length == 0) return;

                if(this.balance > this.totalQuantity) {
                    ++this.totalQuantity;
                    this.updateTotalSum('increase');
                    this.updateTotalSumDiscount('increase');
                }
            },
            reduceQuantityProduct() {
                if(this.totalQuantity > 1) {
                    --this.totalQuantity;
                    this.updateTotalSum('reduce');
                    this.updateTotalSumDiscount('reduce');
                }
            },
            updateTotalSum(flag) {
                if(flag == 'increase') {
                    this.selectedProducts.forEach((product) => {
						this.totalSum += Math.round(Number(product.price));
                    });
                } else {
                    this.selectedProducts.forEach((product) => {
                        this.totalSum -= Math.round(Number(product.price));
                    });
                }
            },
            updateTotalSumDiscount(flag) {
                if(flag == 'increase') {
                    this.selectedProducts.forEach((product) => {
                        if(product.discount_price > 0) {
                            this.totalSumDiscount += Math.round(Number(product.discount_price));
                        } else {
                            this.totalSumDiscount += Math.round(Number(product.price));
                        }
                    });
                }
                else {
                    this.selectedProducts.forEach((product) => {
                        if(product.discount_price > 0) {
                            this.totalSumDiscount -= Math.round(Number(product.discount_price));
                        } else {
                            this.totalSumDiscount -= Math.round(Number(product.price));
                        }
                    });
                }
            },
            validateQuantityOnChange: function () {
                if (this.totalQuantity === '' || Number.parseInt(this.totalQuantity) === 0) {
                    this.totalQuantity = 1;
                }

                if(Number.parseInt(this.totalQuantity) === 0) {
                    this.totalSum = 0;
                    this.totalSumDiscount = 0;
                }

                if(Number.parseInt(this.totalQuantity) <= this.balance && Number.parseInt(this.totalQuantity) > 0 && this.totalQuantity !== '') {
                    this.totalSum = this.single_price * this.totalQuantity;
                    this.totalSumDiscount = this.single_discount_price * this.totalQuantity;
                }
            },
            validateQuantityOnInput: _.debounce(function () {
                const totalQuantity = Number(this.totalQuantity);

                if (Number.parseInt(totalQuantity) > this.balance) {
                    this.totalQuantity = this.balance;
                } else if (Number.parseInt(totalQuantity) < 0) {
                    this.totalQuantity = 1;
                } else if (this.totalQuantity === "") {
                    this.totalQuantity = '';
                } else {
                    this.totalQuantity = totalQuantity
                }
            }, 500),
            clickByBtnToCart(event) {
                this.sortProductsForCart();

                this.productsForCart.forEach((p) => {
                    if(p.product_id_for_kit != undefined) {
                        this.productFromStore = this.$store.getters.get_complement(p);
                    } else {
                        this.productFromStore = this.$store.getters.get_product_by_articul(p.articul);
                    }

                    let hasProduct = false,
                        product = {},
                        articules = [];

                    if (!this.productFromStore) {
                        if(p.product_id_for_kit != undefined) {

                            for(let art in p) {
                                if(art != 'product_id_for_kit') articules.push(p[art]);
                            }

	                        product = {
	                            articul: articules,
	                            count: this.totalQuantity,
		                        product_id_for_kit: p.product_id_for_kit,
                                parent_url: this.product.link
	                        };

                        } else {
                            product = {
                                articul: p.articul,
                                count: this.totalQuantity,
                                product_id_for_kit: this.product.articul
                            };
                        }

                        this.balance -= this.totalQuantity;

                        this.addToCart(product);
                        $("#modal-success-set").modal("show");
                    } else {
                        hasProduct = true;

                        if(p.product_id_for_kit != undefined) {
                            for(let art in p) {
                                if(art != 'product_id_for_kit')articules.push(p[art]);
                            }

                            product = {
                                articul: articules,
                                count: this.totalQuantity,
                                product_id_for_kit: p.product_id_for_kit
                            };
                        } else {
                            product = {
                                articul: p.articul,
                                count: this.totalQuantity
                            };
                        }

                        if (this.balance >= this.totalQuantity) {
                            this.balance -= this.totalQuantity;

                            if(p.product_id_for_kit != undefined) {
                                this.updateCartForKit(product);
                            }
                            else {
                                this.updateCart(product);
                            }

                            $("#modal-success-set").modal("show");
                        } else {
                            $(".window-message").addClass("show");
                            return;
                        }
                    }

                    this.selectedProducts = [];
                    this.productsForCart = [];
                    this.addOrUpdateCookie(product, hasProduct);
                });

                this.totalQuantity = 1;
                this.totalSum = 0;
                this.totalSumDiscount = 0;
                $('.js-input-complement, .js-input-all').prop('checked', false)
            },
		    sortProductsForCart() {
                let productsKit = [];

                for(let i = 0; i < this.selectedProducts.length; ++i) {
                    if(this.selectedProducts[i].isKit && this.selectedProducts[i].isAdded) {
                        this.selectedProducts[i].isAdded = true;
                        productsKit.push(this.selectedProducts[i].articul);
                    } else if(this.selectedProducts[i].isKit == undefined && this.selectedProducts[i].isAdded) {
                        this.productsForCart.push(this.selectedProducts[i]);
                    }
                }

                if(productsKit.length !== 0) {
                    productsKit.product_id_for_kit = this.product.articul;
                    this.productsForCart.push(productsKit);
                }
		    },
            addToCart(product) {
                this.$store.commit("add_to_cart", product);
            },
            updateCart(product) {
                this.$store.commit("update_product_counter", product);
            },
            updateCartForKit(products) {
                this.$store.commit("update_kit_counter", products);
            },
            addOrUpdateCookie(product, hasProduct) {
                let user = JSON.parse($.cookie("user")),
                    p;
                $.removeCookie("user", {expires: 30, path: "/"});

                if (hasProduct) {
                    if(product.product_id_for_kit != undefined) {

                        user.cart.forEach((item, key) => {
                            if(item.product_id_for_kit != undefined && item.product_id_for_kit == product.product_id_for_kit) {
                                item.count = item.count  + Number(product.count);
                                p = user.cart.splice(key, 1);
                            }
                        });
                    } else {
                        user.cart.forEach((item, key) => {
                            if (item.articul == product.articul) {
                                item.count = item.count + Number(product.count);
                                p = user.cart.splice(key, 1);
                            }
                        });
                    }

                    user.cart.push(p[0]);
                } else {
                    user.cart.push(product);
                }

                $.cookie("user", JSON.stringify(user), {expires: 30, path: "/"});
            },
            setPositionName() {
                let q = this.selectedQuantity;

                if (this.lang == "ru") {
                    if (q == 1) {
                        this.positionName = this.__("pieces_position") + "я";
                    } else if (q > 1 && q < 5) {
                        this.positionName = this.__("pieces_position") + "и";
                    } else {
                        this.positionName = this.__("pieces_position") + "й";
                    }
                } else {
                    if (q == 1) {
                        this.positionName = this.__("pieces_position") + "ie";
                    } else {
                        this.positionName = this.__("pieces_position") + "ii";
                    }
                }
            },
            setAllPositionName() {
                let q = this.allQuantity;

                if (this.lang == "ru") {
                    if (q == 1) {
                        this.allPositionName = this.__("pieces_position") + "я";
                    } else if (q > 1 && q < 5) {
                        this.allPositionName = this.__("pieces_position") + "и";
                    } else {
                        this.allPositionName = this.__("pieces_position") + "й";
                    }
                } else {
                    if (q == 1) {
                        this.allPositionName = this.__("pieces_position") + "ie";
                    } else {
                        this.allPositionName = this.__("pieces_position") + "ii";
                    }
                }
            },
            setBalance() {
                let productsFromStore = [];

                if($.cookie("user")) {
                    let user = JSON.parse($.cookie("user"));

                    if(Array.isArray(this.singly)) {
                        this.singly.forEach((product) => {
                            user.cart.forEach((item) => {
                                if (item.articul == product.articul) {
                                    productsFromStore.push(item);
                                }
                            });

                        });
                    }

                    if(Array.isArray(this.kit)) {
                        this.kit.forEach((product) => {
                            user.cart.forEach((item) => {
                                if (item.articul == product.articul) {
                                    productsFromStore.push(item);
                                }
                            });
                        });
                    }
                }

                if (productsFromStore.length != 0) {
                    let count = 0;

                    productsFromStore.forEach((item) => {
                        if(count < item.count) {
                            count = item.count;
                        }
                    });

                    this.balance = this.limit - count;
                } else {
                    this.balance = this.limit;
                }
            },
		    sortComplement(complement) {
                if(Array.isArray(complement)) {
                    complement.sort(a => {
                        if(Array.isArray(a)) {
                            return 1;
                        }
                        else {
                            return -1;
                        }
                    });
                }
                else {
	                return null;
                }
		    }
	    }
    }
</script>

<style scoped>
	.window-message {
		opacity: 0;
		display: block;
		padding: 0 10px;
		font-size: 14px;
		color: black;
		background-color: white;
		border-radius: 3px;
		cursor: default;
		transition: opacity 0.3s linear;
		margin-top: 10px;
	}

	.window-message.show {
		opacity: 1;
	}

    .complect-block__item-similar {
        padding-right: 0;
    }

    .dnone {
        display: none;
    }
</style>
