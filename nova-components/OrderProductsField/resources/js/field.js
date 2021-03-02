Nova.booting((Vue, router, store) => {
  Vue.component('index-OrderProductsField', require('./components/IndexField'))
  Vue.component('detail-OrderProductsField', require('./components/DetailField'))
  Vue.component('form-OrderProductsField', require('./components/FormField'))
})
