Nova.booting((Vue, router, store) => {
  Vue.component('index-url-secondary-page', require('./components/IndexField'))
  Vue.component('detail-url-secondary-page', require('./components/DetailField'))
  Vue.component('form-url-secondary-page', require('./components/FormField'))
})
