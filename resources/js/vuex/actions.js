export let actions = {
    fetchCartPath({commit}) {
        axios.get('/api/cart/getCartLink')
            .then(response => {
                commit('updateCartPath', response.data)
            })
            .catch(error => {
                console.log(error)
            });
    }
};
