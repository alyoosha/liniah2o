export default {
    data: () => {
        return {
            product: []
        }
    },
    beforeMount() {
        this.product = JSON.parse(this.raw_product);
    },
    methods: {
        addToCart(event, product) {
            let articul = product.articul;

            if(product.complements) {
                let complements = JSON.parse(product.complements);

                if(complements.kit.length > 0) {
                    if(this.isInCartKit(articul)) {
                        window.location.href = this.cart_path;
                    } else {
                        let articles = [];

                        for(let kit_item of complements.kit) {
                            articles.push(kit_item.toString());
                        }

                        let p = {
                            articul: articles,
                            count: 1,
                            product_id_for_kit: articul,
                            parent_url: product.link
                        };

                        this.$store.commit('add_to_cart', p);

                        let user = JSON.parse($.cookie('user'));
                        $.removeCookie('user', { expires: 30, path: '/' });
                        user.cart.push(p);
                        $.cookie('user', JSON.stringify(user), { expires: 30, path: '/' });
                        console.log(JSON.parse($.cookie('user')));

                        // $("#modal-added-to-cart").modal("show");
                    }
                }

                if(complements.singly.length > 0) {
                    for(let singly_item of complements.singly) {
                        if(Array.isArray(singly_item)) {
                            // if(this.isInCart(singly_item[0].toString())) {
                            //     this.remove_from_cart(singly_item[0].toString())
                            // } else {
                                let product = {
                                    articul: singly_item[0].toString(),
                                    product_id_for_kit: articul,
                                    count: 1
                                };

                                this.$store.commit('add_to_cart', product);

                                let user = JSON.parse($.cookie('user'));
                                $.removeCookie('user', { expires: 30, path: '/' });
                                user.cart.push(product);
                                $.cookie('user', JSON.stringify(user), { expires: 30, path: '/' });
                                console.log(JSON.parse($.cookie('user')));

                                // $("#modal-added-to-cart").modal("show");
                            // }
                        } else {
                            // if(this.isInCart(singly_item.toString())) {
                            //     this.remove_from_cart(singly_item.toString())
                            // } else {
                                let product = {
                                    articul: singly_item.toString(),
                                    product_id_for_kit: articul,
                                    count: 1
                                };

                                this.$store.commit('add_to_cart', product);

                                let user = JSON.parse($.cookie('user'));
                                $.removeCookie('user', { expires: 30, path: '/' });
                                user.cart.push(product);
                                $.cookie('user', JSON.stringify(user), { expires: 30, path: '/' });
                                console.log(JSON.parse($.cookie('user')));
                            // }
                        }
                    }
                }
            } else {
                if(this.isInCart(articul)) {
                    window.location.href = this.cart_path;
                } else {
                    let p = {
                        articul,
                        count: 1
                    };

                    this.$store.commit('add_to_cart', p);

                    let user = JSON.parse($.cookie('user'));
                    $.removeCookie('user', { expires: 30, path: '/' });
                    user.cart.push(p);
                    $.cookie('user', JSON.stringify(user), { expires: 30, path: '/' });
                    console.log(JSON.parse($.cookie('user')));

                    $("#modal-added-to-cart").modal("show");
                }
            }
        },
        remove_from_cart(articul) {
            this.$store.commit('remove_from_cart', articul);

            let user = JSON.parse($.cookie('user'));
            $.removeCookie('user', { expires: 30, path: '/' });

            user.cart.forEach((item, key) => {
                if(item.articul === articul) {
                    user.cart.splice(key, 1);
                }
            });

            $.cookie('user', JSON.stringify(user), { expires: 30, path: '/' });
        },
        isInCart(articul) {
            let length = this.$store.state.user.cart.length;

            for (let i = 0; i < length; i++) {
                if (this.$store.state.user.cart[i].articul === articul) {
                    return true;
                }
            }

            return false;
        },
        isInCartKit(articul) {
            let length = this.$store.state.user.cart.length;

            for (let i = 0; i < length; i++) {
                if (this.$store.state.user.cart[i].product_id_for_kit && this.$store.state.user.cart[i].product_id_for_kit === articul) {
                    return true;
                }
            }

            return false;
        },
    }
}
