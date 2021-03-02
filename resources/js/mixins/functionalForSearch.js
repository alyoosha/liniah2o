import * as _ from 'lodash'
import * as $ from 'jquery'
import { required, minLength } from 'vuelidate/lib/validators'

export default {
    data: ()=>{
        return {
            value: null,
            response: {
                products: [],
                categories: [],
                empty: false,
            },
            productsScroll: [],
            $btnLoad: '',
            skip: 0,
            take: 20
        }
    },
    computed: {
      getBtnLoad() {
          this.$btnLoader = $(this.$el).find(".btn.btn_dark.btn_search.btn_loader");
      }
    },
    validations: {
        value: {
            required,
            minLength: minLength(3)
        }
    },
    mounted() {
        this.getBtnLoad;

        let param = decodeURI(window.location.search),
            $input = $(this.$el).find('.form-control'),
            name = $input.attr('name'),
            reg = new RegExp('(' + name + '=)([а-яА-ЯёЁa-zA-ZĂÂÎȘȚăâîșț]+)', 'g'),
            subStr = param.match(reg);

        if(Array.isArray(subStr) && subStr[0]) {
           subStr = subStr[0].split('=');
           subStr = subStr[1];
        }

        $input.attr('value', subStr);
    },
    created() {
        this.debouncedGetResult = _.debounce(this.getSearchResults, 500);
        this.debouncedAddProducts = _.debounce(this.addProducts, 80);
    },
    watch: {
        value: function () {
            this.response.empty = false;
            this.response.products = [];
            this.productsScroll = [];
            this.response.categories = [];
            this.debouncedGetResult(event);
        }
    },
    methods: {
        scrollResults(event) {
            if((event.target.scrollTop + event.target.clientHeight > event.target.scrollHeight - 300)) {
                if(this.skip != 0) this.debouncedAddProducts();
            }
        },
        addProducts() {
            let products = this.sliceProductsForScroll(this.response.products);

            for(let p of products) {
                this.productsScroll.push(p);
            }

            ++this.skip;
        },
        sliceProductsForScroll(products) {
            let start = this.skip;
            if(this.skip != 0) start = this.skip * this.take;
            return products.slice(start, (this.skip + 1) * this.take);
        },
        getSearchResults(event) {
            let vue = this;
            let $btnLoader = $(event.target).parents(".header__search").find(".btn_loader");

            this.$v.$touch();

            if(!this.$v.$invalid) {
                $btnLoader.addClass("btn_loader_show");

                axios.get(`/api/search/get-search-results`, {
                    params: {
                        lang: this.lang,
                        'header-search': this.value
                    }
                })
                    .then(function (response) {
                        vue.skip = 0;
                        let products = response.data.productsFound;
                        let categories = response.data.categoriesFound;

                        if((products.length == 0 && categories.length == 0) || response.data == null) {
                            this.response.empty = true;
                        }
                        else {
                            vue.response.products = products;
                            vue.response.categories = categories;
                            vue.productsScroll = vue.sliceProductsForScroll(products);
                            vue.response.empty = false;
                            ++vue.skip;
                        }

                        if( $('.scrollbar-inner').length ) {
                            $('.scrollbar-inner').scrollbar({
                                ignoreMobile: true,
                                ignoreOverlay: true,
                                disableBodyScroll: true,
                            });
                        }

                        $btnLoader.removeClass("btn_loader_show");
                    })
                    .catch(function () {
                        vue.response.empty = true;
                        $btnLoader.removeClass("btn_loader_show");
                    })
            }
            else {
                $btnLoader.removeClass("btn_loader_show");
            }
        }
    }
}
