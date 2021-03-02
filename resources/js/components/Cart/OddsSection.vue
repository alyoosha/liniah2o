<template>
    <section class="section section_odds bg_gray-dark" id="odds">
        <div class="container">
            <ul class="list list_unstyled odds-list row no-gutters">
                <li class="list__item col-12 col-sm-6 col-lg-3">
                    <div class="odd-block">
                        <div class="odd-block__icon" aria-hidden="true">
                            <svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="60" height="60">
                                <use xlink:href="#svg-icon-delivery2"></use>
                            </svg>
                        </div>
                        <div class="section__title odd-block__text">
                            <h2>{{ __('delivery_all_around_Moldova') }}</h2>
                        </div>
                    </div>
                </li>
                <li class="list__item col-12 col-sm-6 col-lg-3">
                    <div class="odd-block">
                        <div class="odd-block__icon" aria-hidden="true">
                            <svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="60" height="60">
                                <use xlink:href="#svg-icon-delivery"></use>
                            </svg>
                        </div>
                        <div class="section__title odd-block__text">
                            <h2>{{ __('free_delivery_in_Kishinev') }}</h2>
                        </div>
                    </div>
                </li>
                <li class="list__item col-12 col-sm-6 col-lg-3">
                    <div class="odd-block">
                        <div class="odd-block__icon" aria-hidden="true">
                            <svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="60" height="60">
                                <use xlink:href="#svg-icon-credit-card2"></use>
                            </svg>
                        </div>
                        <div class="section__title odd-block__text">
                            <h2>{{ __('convenient_and_sage_ways_to_pay') }}</h2>
                        </div>
                    </div>
                </li>
                <li class="list__item col-12 col-sm-6 col-lg-3">
                    <div class="odd-block">
                        <div class="section__title odd-block__icon" aria-hidden="true">
                            <svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="60" height="60">
                                <use xlink:href="#svg-icon-support"></use>
                            </svg>
                        </div>
                        <div class="section__title odd-block__text">
                            <h2>{{ __('advices_and_consulting_by_phone') }} {{ phone }}</h2>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </section>
</template>

<script>
    export default {
        props: {
            language: {
                type: String
            }
        },
        data: () => {
            return {
                phone: '',
            }
        },
        beforeCreate() {
            axios.get('/api/cart/getDeliveryPhone')
                .then(response => {
                    this.phone = response.data;
                })
                .catch(error => {
                    console.log(error)
                });
        },
    }
</script>

<style scoped>

</style>
