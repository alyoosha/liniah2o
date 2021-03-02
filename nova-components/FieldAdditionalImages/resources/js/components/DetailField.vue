<template>
    <div class="flex border-b border-40">
        <div class="w-1/4 py-4">
            <slot>
                <h4 class="font-normal text-80">{{ field.name }}</h4>
            </slot>
        </div>
        <div class="w-3/4 py-4 break-words">
            <slot name="value">
                <div class="wrap" v-if="images.length > 0">
                    <div class="card relative card relative border border-lg border-50 overflow-hidden px-0 py-0"
                        style=""
                        v-for="image of images"
                        >
                        <img style="flex: 1 1 100%" :src="path + image"
                             class="block w-full"
                             draggable="false"
                        @error="removeImage($event)">
                    </div>
                </div>
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
          images: [],
          path: ''
      }
    },
    beforeMount() {
        this.path = this.field.value.path;
        try {
            this.images = JSON.parse(this.field.value.images);
            this.images.shift();
        }
        catch (e) {
            console.log(e);
        }
    },
    methods: {
        removeImage(event) {
            let path = event.target.src.split('/').reverse()[0];
            event.target.insertAdjacentHTML('afterend',
                '<p style="font-size: 18px; margin: 5% 2%; text-align: center">Изображение отсутствует: ' + '<b>' +
                path + '</b>' + '</p>');
            event.target.remove();
        }
    }
}
</script>

<style scoped>
    .wrap {
        display: flex;
        flex-wrap: wrap;
        height: 100%;
    }
    .card {
        display: flex;
        align-items: center;
        max-width: 320px;
        margin-right: 10px;
        margin-bottom: 10px;
        flex: 1 1 100%;
        align-self: stretch
    }
</style>