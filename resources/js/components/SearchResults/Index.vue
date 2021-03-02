<template>
	<div class="main-block">
		<div class="main-block__header">
			<div class="title section__title">{{ __('products') }}
				<span class="counter">({{ products.length }})</span>
			</div>
		</div>

		<div class="main-block__body">
			<div class="row no-gutters">
				<div class="col-12 col-sm-6 col-xl-3"
					v-for="(product, name) of paginatedProducts">
					<div class="product-card" tabindex="0">
						<div class="product-card__content">
							<div class="product-card__header">
								<a class="product-card__img"
								   :href="product.link">
									<picture>
										<source v-if="product['imagesResized'] != undefined &&
										product['imagesResized'].length > 0"
										        :srcset="product['imagesResized'][1]" media="(min-width: 535px)">
										<source v-if="product['imagesResized'] != undefined &&
										product['imagesResized'].length > 0"
										        :srcset="product['imagesResized'][0]" media="(min-width: 0px)">
										<img v-if="product['imagesResized'] != undefined &&
										product['imagesResized'].length > 0"
										     :src="product['imagesResized'][1]" :alt="product['name_' + lang]">
										<img v-else :src="product['imagePreview']" :alt="product['name_' + lang]">
									</picture>
								</a>

								<a class="product-card__brand"
								   :href="'/' + lang + '/brands'"
								   :aria-label="__('go_to_brand') + ' ' + product.brand_name">
									<img :src="'/storage/brands/' + product.brand_image"
									     :alt="product.brand_name">
								</a>

								<ul class="list list_unstyled product-card__marks marks-list">
                                    <li
                                        class="list__item list__item_num"
                                        :class="tag.class"
                                        v-for="tag in product['tags']"
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
								<a class="product-card__title"
								   :href="product.link">{{ product['name_' + lang] }}</a>

								<div class="product-card__price">
									<span class="old" v-if="Number(product.discount_price) > 0"> {{
									                                                  getPriceForHtml(product.price) }}</span>
									<span class="cost cost_new" v-if="Number(product.discount_price) > 0"> {{
									                                                            getPriceForHtml(product.discount_price) }}</span>
									<span class="cost" v-else> {{ getPriceForHtml(product.price) }} </span>
                                    <span class="currency">{{ __('currency_name') }}{{ product['unit_'+lang] }}</span>
                                </div>
							</div>

							<div class="product-card__footer">
								<div class="product-card__info">
									<div class="product-card__availability"
									     v-if="product.stock === 0">{{ __('out_of_stock') }}
									</div>

									<div class="product-card__availability product-card__availability_true"
									     v-else>{{ __('in_stock') }}
									</div>

									<div class="product-card__code">{{ __('articul') }} {{ product.articul }}</div>
								</div>

								<div class="product-card__controls" :class="{dnone: product.stock <= 0}">
									<button
											class="btn product-card__btn product-card__btn_mvp product-card__btn_cart js-to-cart"
									        type="button"
									        :aria-label="__('to_cart')">
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

		<div class="main-block__footer pagination-block">
			<div class="row">
				<div class="show-more" v-show="page_number !== pageCount">
					<!--все кнопки с классом btn_loader при добавлении класса .btn_loader_show меняют иконку на прелоадер-->
					<button class="btn btn_show-more btn_bordered btn_loader js-show-more"
					        type="button"
					        @click="show_more()">
						<span class="btn__text">{{ __('show_more') }}</span>

						<span class="btn__icon" aria-hidden="true">
							<svg class="loader-icon" role="img" aria-hidden="true" width="10" height="10">
								<use xlink:href="#svg-icon-loader"></use>
							</svg>
						</span>
					</button>
				</div>

				<div class="pagination">
					<div class="pagination__current" v-show="pageCount > raw_per_page">
						<button class="btn pagination__current-btn btn_bordered js-pagination-opener" type="button"
						        :aria-label="__('change_page')">
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
										<a class="link btn js-pagination-link"
										:class="{ active : page === page_number }"
										:disabled="page === page_number"
										:aria-label="__('page')+page"
										@click="go_to(page)">{{ page }}
										</a>
									</div>
								</ul>
							</div>
						</div>

						<div class="pagination__control">
							<button class="btn pagination__control-btn js-pagination-closer"
							        type="button"
							        :aria-label="__('close')">
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
</template>

<script>
    import getPriceForHtml from '../../mixins/getPriceForHtml'

    export default {
        name: "Index",
        props: {
            raw_products: {
                type: String, default: []
            },
            raw_per_page: {
                type: String, default: 8
            },
            raw_input: {
                type: String, default: ''
            },
            lang: {
                type: String
            }
        },
	    mixins: [
	        getPriceForHtml
	    ],
        data: function () {
            return {
                products: null,
                paginatedProducts: null,
                page_number: 0,
                product_per_page: null,
                skip: 0,
            }
        },
        beforeMount() {
            this.products = JSON.parse(this.raw_products);
            this.product_per_page = Number(this.raw_per_page);
            this.sortProduct();
            this.paginatedProducts = this.sliceProducts(this.products);
        },
        computed: {
            pageCount() {
                return Math.ceil(this.products.length/this.product_per_page)
            }
        },
        methods: {
            skipUp() {
                ++this.skip;
            },
            sortProduct() {
                this.products.sort((a, b) => {
                    return a.id - b.id;
                });
            },
	        sliceProducts() {
				let start = this.skip;

                if(this.skip != 0) start = this.skip * this.product_per_page;

                let ps = this.products.slice(start, (this.skip + 1) * this.product_per_page);
				this.skipUp();

				return ps;
	        },
            show_more() {
                if(this.page_number === 0) {
                    this.page_number += 2;
                } else {
                    this.page_number++;
                }

                let products = this.sliceProducts();

                for(let p of products) {
                    this.paginatedProducts.push(p);
                }
            },
            go_to(page) {
                this.page_number = page;
                this.skip = page - 1;
                this.paginatedProducts = this.sliceProducts();
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
                    return tag['name_'+this.lang]
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
