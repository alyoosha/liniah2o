export default {
    methods: {
        getPriceForHtml(price) {
            let priceCeil = String(Math.ceil(price));
            if(priceCeil.length > 3) {
                if(priceCeil.length % 3 == 1) {
                    return priceCeil.slice(0,1) + ' ' + priceCeil.slice(1);
                }
                else if(priceCeil.length % 3 == 2) {
                    return priceCeil.slice(0,2) + ' ' + priceCeil.slice(2);
                }
                else {
                    return priceCeil.slice(0,3) + ' ' + priceCeil.slice(3);
                }
            }
            else {
                return priceCeil;
            }
        }
    }
}
