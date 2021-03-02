export default {
    methods: {
        getUrlProduct(obj) {
            let url = '';
            for(let secObj of obj) {
                url += secObj.slug
            }
            return url;
        }
    }
}