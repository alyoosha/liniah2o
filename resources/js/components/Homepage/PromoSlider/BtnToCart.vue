<template>
	<div class="col-auto" :class="{dnone: product.in_stock <= 0}">
        <button
            v-if="product.complements"
            class="link banner-block__link banner-block__link_with-icon js-to-cart" type="button"
            :class="{active: isInCartKit(product.articul)}"
            :aria-label="__('add_to_cart')"
            @click="addToCart($event, product)"
        >
            <span class="link__icon" aria-hidden="true">
                <svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24">
                    <use xlink:href="#svg-icon-shop"></use>
                </svg>
                <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24">
                    <use xlink:href="#svg-icon-shop-added"></use>
                </svg>
            </span>
            <span class="link__text">{{ __('add_to_cart') }}</span>
        </button>
		<button
            v-else
            class="link banner-block__link banner-block__link_with-icon js-to-cart" type="button"
           :class="{active: isInCart(product.articul)}"
           :aria-label="__('add_to_cart')"
           @click="addToCart($event, product)"
		>
            <span class="link__icon" aria-hidden="true">
                <svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24">
                    <use xlink:href="#svg-icon-shop"></use>
                </svg>
                <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24">
                    <use xlink:href="#svg-icon-shop-added"></use>
                </svg>
            </span>
			<span class="link__text">{{ __('add_to_cart') }}</span>
		</button>
	</div>
</template>

<script>
    import functionalBtnToCart from '../../../mixins/functionalBtnToCart'

    export default {
        props: {
            raw_product: {
                type: String, default: []
            },
            lang: {
                type: String, default: 'ru'
            },
            cart_path: {
                type: String, default: '/'
            }
        },
        mixins: [
            functionalBtnToCart
        ]
    }
</script>

<style scoped>
    .dnone {
        display: none;
    }
</style>
