<template>
    <a class="link" :href="count > 0 ? cart_path : `javascript: void(0);`" :aria-label="__('basket')">
        <span class="link__icon">
            <svg role="img" width="26" height="26">
                <use xlink:href="#svg-icon-shop"></use>
            </svg>
        </span>
        <span v-show="count > 0" class="link__counter">{{ count }}</span>
    </a>
</template>

<script>
    export default {
        props: {
            lang: {
                type: String, default: 'ro'
            }
        },
        computed: {
            count() {
                return this.$store.getters.get_total_products_in_cart;
            },
            cart_path() {
                return this.$store.state.cart_path+'/'+this.lang+'/cart'
            }
        }
    }
</script>
