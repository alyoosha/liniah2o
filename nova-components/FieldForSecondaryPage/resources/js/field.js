Nova.booting((Vue, router, store) => {
  Vue.component('index-field-for-secondary-page', require('./components/IndexField'))
  Vue.component('detail-field-for-secondary-page', require('./components/DetailField'))
  Vue.component('form-field-for-secondary-page', require('./components/FormField'))
})
