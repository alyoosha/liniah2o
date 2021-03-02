<template>
    <span>{{ field.value }}</span>
</template>

<script>
export default {
    props: ['resourceName', 'field'],
    data() {
        return {
            odds: []
        }
    },
    beforeMount() {
        axios.get('/api/homepage/getOdds')
            .then(response => {
                this.odds = response.data;
            })
            .catch(error => console.log(error))
    },
}
</script>
