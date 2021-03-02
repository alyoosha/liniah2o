Nova.booting((Vue, router, store) => {
  Vue.component('index-linia-odds', require('./components/IndexField'))
  Vue.component('detail-linia-odds', require('./components/DetailField'))
  Vue.component('form-linia-odds', require('./components/FormField'))
})
