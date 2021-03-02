<template>
    <default-field :field="field" :errors="errors">
        <template slot="field">
            <input
                    :id="field.attribute"
                    type="text"
                    class="w-full form-control form-input form-input-bordered"
                    :class="errorClasses"
                    :placeholder="field.name"
                    v-model="value"
                    @input="validate"
            />
            <div class="help-text error-text mt-2 text-danger" :class="{'form-response_negative': response.error,
            'form-response_positive': !response.error}" v-if="response.message">{{ response.message }}
            </div>
        </template>
    </default-field>
</template>

<script>

import { FormField, HandlesValidationErrors } from 'laravel-nova'
import * as _ from 'lodash'

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field'],

    data: function () {
        return {
            response: {
                message: false,
                error: false,
            }
        }
    },

    created: function () {
        // _.debounce — это функция lodash, позволяющая ограничить то,
        // насколько часто может выполняться определённая операция.
        this.debouncedGetAnswer = _.debounce(this.checkValue, 500)
    },

    methods: {

        setFriendlyUrl() {
            if(this.field.attribute == 'name') {
                Nova.bus.$emit('setFriendlyUrl', this.value.trim());
            }
        },

        setResponse(msg, error){
            this.response.message = msg;
            this.response.error = error;
        },

        checkValue() {
            var vm = this,
                value = this.value.trim(),
                name = this.field.name,
                col = this.field.attribute;

            axios.get('/api/ajax/check-value', {
                params: {
                    value,
                    name,
                    col
                }
            })
                .then(function (response) {
                    vm.response.message = _.capitalize(response.data.message);
                    vm.response.error = response.data.error;
                })
                .catch(function (error) {
                    vm.response.error = true;
                    vm.response.message = 'Ошибка! Не могу связаться с API!!!'
                })
        },

        validate() {
            if(this.value.indexOf(' ') === 0) {
                this.value = this.value.trim();
            }

            this.value = this.value.replace(/\s+/g, ' ');

            if(this.value.trim() == this.field.value && this.value != null) {
                this.setResponse('', false);
                return;
            }

            if(this.field.required) {
                if(this.value.trim() == '') {
                    this.setResponse('Поле ' + this.field.name + ' является обязательным', true);
                    return
                }
            }

            if(this.field.minLength) {
                if(this.value.trim().length < this.field.minLength) {
                    this.setResponse('Длина значения поля ' + this.field.name + ' должна превышать 2 символа', true);
                    return;
                }
            }

            if(this.field.maxLength) {
                if(this.value.trim().length > this.field.maxLength) {
                    this.setResponse('Длина значения поля ' + this.field.name + ' не должна превышать 255 символа',
                        true);
                    return;
                }
            }

            if(this.field.regexp) {
                let regexp = new RegExp(this.field.regexp.value, this.field.regexp.flag);
                if(!regexp.test(this.value.trim())) {
                    this.setResponse(this.field.regexp.msg, true);
                    return;
                }
            }

            this.setFriendlyUrl();

            this.debouncedGetAnswer();

        },
        /*
         * Set the initial, internal value for the field.
         */
        setInitialValue() {
            this.value = this.field.value || ''
        },

        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill(formData) {
            formData.append(this.field.attribute, this.value || '')
        },

        /**
         * Update the field's internal value.
         */
        handleChange(value) {
            this.value = value
        },
    },
}
</script>
