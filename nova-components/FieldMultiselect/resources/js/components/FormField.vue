<template>
    <default-field :field="field" :errors="errors">
        <template slot="field">
            <multiselect v-model="values"
                         :options="options"
                         :multiple="true"
                         :close-on-select="false"
                         :clear-on-select="false"
                         :preserve-search="true"
                         :group-values="groupValue"
                         :group-label="groupLabel"
                         placeholder="Выбрать"
                         track-by="value"
                         selectedLabel="Выбрано"
                         label="value"
                         select-label="Выбрать"
                         deselectLabel="Удалить"
                         @select="setValue($event)"
                         @remove="removeValue($event)">
            </multiselect>
        </template>
    </default-field>
</template>

<script>

import { FormField, HandlesValidationErrors } from 'laravel-nova'
import Multiselect from 'vue-multiselect'

export default {
    mixins: [FormField, HandlesValidationErrors],
    components: { Multiselect },
    props: ['resourceName', 'resourceId', 'field'],
    data () {
        return {
            values: [],
            options: [],
            valuesEnd: [],
            groupValue: '',
            groupLabel: ''
        }
    },
    beforeMount() {
        let itemsAll = this.field.value.itemsAll;
        let itemsSelected = this.field.value.items;
        this.options = itemsAll;

        if(this.field.value.group) {
            this.groupValue = 'options';
            this.groupLabel = 'value';
        }

        if(itemsSelected.length > 0) {
            if(this.field.value.group) {
                for(let item of itemsAll) {
                    for(let i of itemsSelected) {
                        if(item.options != null) {
                            for(let t of item.options) {
                                if(t['id'] == i) {
                                    this.values.push(t);
                                    this.valuesEnd.push(t.id);
                                }
                            }
                        }
                    }
                }
            }
            else {
                for(let item of itemsAll) {
                    for(let i of itemsSelected) {
                        if(item['id'] == i['id']) {
                            this.valuesEnd.push(i.id);
                            this.values.push(i);
                        }
                    }
                }
            }
        }
    },
    methods: {
        setValue(event) {
            this.valuesEnd.push(event.id);
            // console.log(this.setValueFeaturesEnd(this.valuesEnd));
        },
        removeValue(event) {
            for(let v in this.valuesEnd) {
                if(this.valuesEnd[v] == event.id) {
                    this.valuesEnd.splice(v,1);
                }
            }
        },
        setValueTagsEnd(data) {
            return data.join(',')
        },
        setValueFeaturesEnd(data) {
            if(data.length == 0) return null;
            return JSON.stringify(data);
        },
        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill(formData) {
            if(this.field.value.group) {
                formData.append(this.field.attribute, this.setValueFeaturesEnd(this.valuesEnd) || '');
            }
            else {
                formData.append(this.field.attribute, this.setValueTagsEnd(this.valuesEnd)  || '');
            }
        },

        /**
         * Update the field's internal value.
         */
    },
}
</script>
