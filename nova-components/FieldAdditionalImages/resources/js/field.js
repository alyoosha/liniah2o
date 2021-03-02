Nova.booting((Vue, router, store) => {
  Vue.component('index-field-additional-images', require('./components/IndexField'))
  Vue.component('detail-field-additional-images', require('./components/DetailField'))
  Vue.component('form-field-additional-images', require('./components/FormField'))
})
