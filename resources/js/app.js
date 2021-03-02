require('./bootstrap');
require('./leaflet');
require('jquery.cookie');
require('select2/dist/js/i18n/ru.js');
require('select2/dist/js/i18n/ro.js');

window.Vue = require('vue');

import Vuex from 'vuex';
import VeeValidate, { Validator } from 'vee-validate';
import Vuelidate from 'vuelidate';

import 'jquery.scrollbar';
import 'jquery-drilldown';
import 'select2';
import 'jquery-touch-events';
import 'lightcase';

import {dictionary} from "./veevalidate/dictionary";
import {state} from './vuex/state.js'
import {getters} from './vuex/getters.js'
import {mutations} from './vuex/mutations.js'
import {actions} from './vuex/actions.js'

import LazyLoadDirective from "./directives/LazyLoadDirective";
import Select2 from "./directives/Select2";

Vue.use(Vuex);
Vue.use(Vuelidate);
Vue.use(VeeValidate, {
    locale: 'ru',
    dictionary
});

Vue.prototype.__ = str => _.get(window.i18n, str); // Объявляем функцию для перевода

Vue.component('desktop-search', require('./components/DesktopSearch.vue').default);
Vue.component('mobile-search', require('./components/MobileSearch.vue').default);

// Vue.component('picker', require('./components/ColorPicker.vue').default);

Vue.component('brands-index', require('./components/Brands/Index.vue').default);

Vue.component('regulations-index', require('./components/Regulations/Index.vue').default);

Vue.component('promotions-index', require('./components/Promotions/Index.vue').default);
Vue.component('promotions-products', require('./components/Promotions/PromotionProducts.vue').default);

Vue.component('header-desktop', require('./components/Header/Desktop.vue').default);
Vue.component('header-mobile', require('./components/Header/Mobile.vue').default);

Vue.component('search-results', require('./components/SearchResults/Index.vue').default);

Vue.component('ternary-index', require('./components/Catalog/TernaryIndex.vue').default);
Vue.component('catalog-collections', require('./components/Catalog/Collections.vue').default);

Vue.component('add-to-cart', require('./components/Modals/AddToCart.vue').default);

Vue.component('cart-count', require('./components/Cart/CartCount.vue').default);

Vue.component('cart-index', require('./components/Cart/Index.vue').default);
Vue.component('cart-order', require('./components/Cart/Order.vue').default);
Vue.component('cart-odds', require('./components/Cart/OddsSection.vue').default);
Vue.component('cart-recommended', require('./components/Cart/Recommended.vue').default);
Vue.component('cart-purchased-successfully', require('./components/Cart/SuccessPurchase.vue').default);
Vue.component('cart-recommended-onsuccess', require('./components/Cart/RecommendedOnSuccess.vue').default);
Vue.component('cart-products-in-order', require('./components/Modals/ProductsInOrder.vue').default);

Vue.component('product-card', require('./components/Product/Card.vue').default);
Vue.component('also-buy-with-card', require('./components/Product/AlsoBuyWith.vue').default);
Vue.component('similar-and-watched-card', require('./components/Product/SimilarAndWatched.vue').default);
Vue.component('btn-to-cart-collection', require('./components/Collections/BtnToCart.vue').default);

Vue.component('complements-index', require('./components/Complements/Index.vue').default);

Vue.component('btn-to-cart-promo-slider', require('./components/Homepage/PromoSlider/BtnToCart.vue').default);
Vue.component('homepage-recommended', require('./components/Homepage/Recommended.vue').default);

Vue.component('cookie-banner', require('./components/CookieBanner.vue').default);


// Vue.component('kitchen-constructor', require('./components/Product/KitchenConstructor.vue').default);
// Vue.component('kitchen-ar', require('./components/Product/KitchenAR.vue').default);


// Данная директива позволяет прослушивать событие изменения selected на select2,
// так как select2 не может прослушивать события native DOM, а только jquery
// Поэтому, чтобы записать в v-model значение, необходимо указать данную директиву v-select2=value
Vue.directive('select2', Select2);
Vue.directive('lazyload', LazyLoadDirective);

const store = new Vuex.Store({
    state,
    mutations,
    getters,
    actions
});

var location = window.history.location || window.location;

const app = new Vue({
    el: '#app',
    data: ()=>{
        return {
            count: 0,
            user: {},
            lang: 'ru',
            location
        }
    },
    store,
    beforeCreate() {
        axios.get('/api/getSessionUser')
            .then(response => {
                this.user = JSON.parse(response.data);
                this.$store.state.user = this.user;
            })
            .catch(error => {
                console.log(error.message)
            });
    },
    created() {
        this.$store.dispatch('fetchCartPath');
    }
});

require('./main.js');
