<template>
    <div class="py-6">
        <ul>
            <li v-for="odd in odds" :key="odd.id">
                <div  style="width: 100%" :errors="errors">
                    <div class="input-group">
                        <div class="d-flex">
                            <label class="label">Текст Ru</label>
                            <input
                                type="text"
                                class="form-control form-input form-input-bordered"
                                :class="errorClasses"
                                :placeholder="odd.title_ru"
                                v-model="odd.title_ru"
                            />
                        </div>
                        <div class="d-flex">
                            <label class="label">Текст Ro</label>
                            <input
                                type="text"
                                class="form-control form-input form-input-bordered"
                                :class="errorClasses"
                                :placeholder="odd.title_ro"
                                v-model="odd.title_ro"
                            />
                        </div>
                        <div class="image-input-group">
                            <div class="py-6 px-8 w-full">
                                <div class="mb-6">
                                    <div class="card relative card relative border border-lg border-50 overflow-hidden px-0 py-0" style="max-width: 320px;">
                                        <img :src="storage_path+'/homepage/'+odd.image" class="block" draggable="false">
                                    </div>
                                    <div class="v-portal" style="display: none;"></div>
                                </div>
                                <span class="form-file mr-4">
                                    <input class="btn-input" type="file" @change="onImageSelect($event, odd.image)">
                                </span>
                                <div class="help-text help-text mt-2"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>

    </div>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'
import * as axios from 'axios'
import * as $ from 'jquery'

export default {
    mixins: [FormField, HandlesValidationErrors],
    data() {
        return {
            odds: [],
            storage_path: '',
        }
    },
    props: ['resourceName', 'resourceId', 'field'],

    beforeMount() {
        axios.get('/api/homepage/getOdds')
            .then(response => {
                this.value = this.odds = response.data;
            })
            .catch(error => console.log(error))

        axios.get('/api/getStoragePath')
            .then(response => {
                this.storage_path = response.data;
            })
            .catch(error => console.log(error))
    },

    methods: {
        onImageSelect(e, oldImage) {
            const file = e.target.files[0];

            this.putIntoStorage(file);

            for(let odd of this.odds) {
                if(odd.image === oldImage) {
                    odd.image = file.name
                }
            }

            $(e.target).parent().parent().find('div.mb-6').remove();
        },

        putIntoStorage(file) {
            let data = new FormData();
            data.append('file', file, file.name);

            let settings = { headers: { 'content-type': 'multipart/form-data' } }

            axios.post('/api/homepage/uploadImage', data, settings)
                .then(response => {
                    console.log(response)
                })
                .catch(error => console.log(error))
        },

        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill(formData) {
            formData.append(this.field.attribute, JSON.stringify(this.odds) || JSON.stringify([]))
        },

        /**
         * Update the field's internal value.
         */
        handleChange(value) {
            this.odds = value
        },
    },
}
</script>

<style>
    ul {
        list-style: none;
        padding-left: 10px;
    }

    .input-group {
        padding-left: 35px;
        margin-top: 20px;
        width: 750px;
    }
    .image-input-group div{
        padding-left: 0;
    }

    .image-input-group .card {
        width: 60px;
    }

    image.block {
        width: 100px;
        height: auto;
    }

    input {
        width: 100%;
    }

    .d-flex {
        display: flex;
        padding-top: 10px;
    }

    label.label {
        padding-right: 10px;
        width: 90px;
        position: relative;
        top: 8px;
    }
</style>
