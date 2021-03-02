<template>
    <div>
        <div>
            <span>{{ product }}</span>
        </div>
    </div>
</template>

<script>
export default {
    props: ['resourceName', 'field'],
    data() {
        return {
            products: [],
        }
    },
    computed: {
        product() {
            let product = Array.from(JSON.parse(JSON.stringify(this.$props.field.value))).pop();
            return product.name_ru
        }
    },
    beforeMount() {
       //
    }
}
</script>
