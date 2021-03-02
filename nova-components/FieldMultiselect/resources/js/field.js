Nova.booting((Vue, router, store) => {
  Vue.component('index-field-multiselect', require('./components/IndexField'))
  Vue.component('detail-field-multiselect', require('./components/DetailField'))
  Vue.component('form-field-multiselect', require('./components/FormField'))
})
