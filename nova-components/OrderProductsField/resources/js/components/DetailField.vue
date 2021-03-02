<template>
    <div class="flex border-b border-40">
        <div class="w-3/4 py-4 break-words">
            <slot name="value">
                <ul class="list" v-if="value.length > 0">
                    <li class="item" v-for="v of value">
                        <div v-if="v.product_id_for_kit">
                            <div>
                                <span class="title">Комплект товара <span style="color: #000088; padding-left: 10px;">{{ v.product_id_for_kit }}</span></span>
                            </div>
                            <div v-for="p in v['products']" style="margin-top: 15px; padding-top: 10px; border-top: solid 1px black">
                                <div class="d-flex">
                                    <span class="title">Наименование</span>
                                    <span class="value">{{ p.name_ru }}</span>
                                </div>
                                <div class="d-flex">
                                    <span class="title">Артикул</span>
                                    <span class="value">{{ p.articul }}</span>
                                </div>
                                <div class="d-flex">
                                    <span class="title">Цена</span>
                                    <span v-if="p.discount_price > 0" class="value cost_old">{{ p.price }}</span>
                                    <span v-if="p.discount_price > 0" class="value cost cost_new">{{ p.discount_price }}</span>
                                    <span v-else class="value cost">{{ p.price }}</span>
                                    <span class="currency value">лей / шт.</span>
                                </div>
                            </div>
                            <div style="margin-top: 15px; padding-top: 20px; border-top: solid 1px black">
                                <span class="title">Количество</span>
                                <span class="value">{{ v.count }} шт.</span>
                            </div>
                        </div>
                        <div v-else>
                            <div class="d-flex">
                                <span class="title">Наименование</span>
                                <span class="value">{{ v.name_ru }}</span>
                            </div>
                            <div class="d-flex">
                                <span class="title">Артикул</span>
                                <span class="value">{{ v.articul }}</span>
                            </div>
                            <div class="d-flex">
                                <span class="title">Количество</span>
                                <span class="value">{{ v.count }} шт.</span>
                            </div>
                            <div class="d-flex">
                                <span class="title">Цена</span>
                                <span v-if="v.discount_price > 0" class="value cost cost_new">{{ v.discount_price }}</span>
                                <span v-else class="value cost">{{ v.price }}</span>
                                <span class="currency value">лей / шт.</span>
                            </div>
                        </div>
                    </li>
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
        if(typeof this.field.value === 'object') {
            this.value = this.field.value;
        } else {
            this.value = JSON.parse(this.field.value);
        }
    }
}
</script>

<style scoped>
    .d-flex {
        display: flex;
        padding-bottom: 10px;
    }
    .d-flex:last-child {
        padding-bottom: 0;
    }
    .list {
        list-style: none;
        padding-left: 0;
    }
    .item {
        max-width: 900px;

        background-color: #5a5e6930;
        padding: 20px;
        border-radius: 7px;
        margin-bottom: 15px;
    }
    .item:not(last-child) {
        margin-bottom: 10px;
    }
    .title {
        font-size: 18px;
        font-weight: bolder;
    }
    .value {
        padding-left: 7px;
        padding-top: 2px;
        font-weight: normal;
    }
    .currency {
        margin-left: 5px;
    }
    .cost {
        color: #0E1011;
        font-weight: 800;
        font-size: 16px;
    }
    .cost_old {
        color: #0E1011;
        font-weight: 800;
        font-size: 16px;
        text-decoration: line-through;
    }
    .cost_new {
        color: red;
        font-size: 14px;
    }
</style>

