<template lang="pug">
	form(name="header-search-form" method="get" :action="'/' + lang + '/search-results'")
		.header__search
			.form-group
				label.form-label.form-label_hidden(for="header-search") {{ __('Search box') }}

				input.form-control(
				v-model="value"
				type="text"
				id="header-search"
				name="header-search"
				autocomplete="off"
				:placeholder="__('Search i') + '...'")

				button.btn.btn_dark.btn_search.btn_loader(
				type="submit"
				:aria-label="__('Look up')")
					<svg class="default-icon" role="img" width="24" height="24"><use xlink:href="#svg-icon-searching"></use></svg>
					<svg class="loader-icon" role="img" width="24" height="24"><use xlink:href="#svg-icon-loader"></use></svg>
			.results-panel.bg_white(v-if="!$v.$invalid")
				.results-panel__content.scrollbar-inner(
					@scroll="scrollResults($event)"
				)
					.results-panel__results
					.results-panel__category(v-show="response.empty") {{__('no_results_were_found_for_this_request')}}
					.results-panel__category(v-show="!response.empty && response.categories.length != 0")
						.category-results
							.category-results__row(v-for="category of response.categories")
								.category-results__cell.category-results__cell_request {{ value }}
								.category-results__cell.category-results__cell_items
									span В &nbsp;
									ul.list.list_unstyled.category-results__list
										li.list__item(v-for="item of category.breadcrumbs")
											a(:href="'/' + lang + item.link") {{ item.name }}

					.results-panel__items(v-show="!response.empty && response.products.length != 0")
						ul.list.list_unstyled.item-results
							li.list__item.item-results__row(v-for="product in productsScroll")
								.item-results__cell.item-results__cell_img
									a.item-results__img(
									:href="product.link")
										picture
											source(v-if="product['imagesResized'] != undefined && product['imagesResized'].length > 0" :srcset="product['imagesResized'][1]" media="(min-width: 535px)")
											source(v-if="product['imagesResized'] != undefined && product['imagesResized'].length > 0" :srcset="product['imagesResized'][0]" media="(min-width: 0px)")
											img(v-if="product['imagesResized'] != undefined && product['imagesResized'].length > 0"
											:src="product['imagesResized'][1]" :alt="product['name_' + lang]")
											img(v-else :src="product['imagePreview']" :alt="product['name_' + lang]")
								.item-results__cell.item-results__cell_info
									a.item-results__title(:href="product.link") {{ product['name_' + lang] }}
									.item-results__price
										span.old(v-if="product.discount_price > 0") {{ getPriceForHtml(product.price) }}
										span.cost.cost_new(v-if="product.discount_price > 0") {{ getPriceForHtml(product.discount_price) }}
										span.cost(v-else) {{ getPriceForHtml(product.price) }}
										span.currency {{ __('currency_name') }} {{ product['unit_'+lang] }}
								.item-results__cell.item-results__cell_brand
									a.item-results__brand(
									:href="'/' + lang + '/brand'"
									:aria-label="__('go_to_brand') + product.brand_name")

										img(
											:src="product.pathBrand + '/' + product.brand_image"
											:alt="product.brand_name")
</template>

<script>
    import functionalForSearch from '../mixins/functionalForSearch'
    import getPriceForHtml from '../mixins/getPriceForHtml'

    export default {
        mixins: [
            functionalForSearch,
            getPriceForHtml
        ],
        props: ['lang'],
	}
</script>
