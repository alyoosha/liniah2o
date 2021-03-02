<template>
    <div class="product-card__controls">
        <button
            v-if="product.complements"
            class="btn product-card__btn product-card__btn_cart js-to-cart product-card__btn_mvp"
            :class="{active: isInCartKit(product.articul)}"
            type="button"
            :aria-label="__('add_to_cart')"
            @click="addToCart($event, product)"
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
            :class="{active: isInCart(product.articul)}"
            type="button"
            :aria-label="__('add_to_cart')"
            @click="addToCart($event, product)"
        >
            <svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24">
                <use xlink:href="#svg-icon-shop"></use>
            </svg>
            <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24">
                <use xlink:href="#svg-icon-shop-added"></use>
            </svg>
        </button>
    </div>
</template>

<script>
	import functionalBtnToCart from '../../mixins/functionalBtnToCart'

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

</style>
