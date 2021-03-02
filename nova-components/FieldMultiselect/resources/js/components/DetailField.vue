<template>
    <div class="flex border-b border-40">
        <div class="w-1/4 py-4">
            <slot>
                <h4 class="font-normal text-80">{{ field.name }}</h4>
            </slot>
        </div>
        <div class="w-3/4 py-4 break-words">
            <slot name="value">
                <ul class='list' v-if="value.length > 0">
                    <li class="item" v-for="v of value"><span class="wrap-style">{{ v.name_ru }}</span></li>
                </ul>
                <p v-else>&mdash;</p>
            </slot>
        </div>
    </div>
</template>

<script>
export default {
    props: ['resource', 'resourceName', 'resourceId', 'field'],
    data() {
        return {
            value: []
        }
    },
    beforeMount() {
        console.log(this.field.value);
        this.value = this.field.value.tags;
    }
}
</script>

<style scoped>
    .list {
        padding: 0;
        list-style-type: none;
    }
    .item {
        padding: 5px 10px;
    }
    .item:not(last-child) {
        margin-bottom: 10px;
    }
    .wrap-style {
        border-radius: 5px;
        background-color: rgb(65, 184, 131);
        padding: 5px 8px;
        color: white;
    }
</style>
