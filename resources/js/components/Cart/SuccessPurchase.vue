<template>
    <div>
        <section class="section section_inner-page section_profile section_congratulation">
            <div class="section__header">
                <div class="container">
                    <div class="section__breadcrumbs">
                        <ul class="list list_unstyled breadcrumbs-list">
                            <li class="list__item"><a class="link" :href="homepage_link">{{ __('homepage') }}</a></li>
                            <li class="list__item"><a class="link active" href="javascript: void(0);">{{ __('checkout_order') }}</a></li>
                        </ul>
                    </div>
                    <div class="section__title section__title_style1">
                        <h1>{{ __('congrats') }}</h1>
                    </div>
                    <div class="section__title section__title_style5">{{ __('your_order') }} № {{ order.id }} {{ __('applied') }}</div>
                </div>
            </div>
            <div class="section__body">
                <div class="container">
                    <div class="section__content section__content_congratulation">
                        <div class="section__description">
                            <p>{{ __('our_manager_call_you') }}</p>
                            <p>
                                {{ __('check_order_status_by_url') }}
                                <a :href="homepage_link+'/'+order.url">{{ homepage_link+'/'+order.url }}</a>
                            </p>
                            <p>
                                {{ __('in_case_any_questions_call_us') }}
                                <a class="link" :href="`tel:${ phone.replace(' ', '').replace('(', '').replace(')', '')}`">
                                    <span class="link__icon" aria-hidden="true">
                                        <svg role="img" aria-hidden="true" width="26" height="26">
                                            <use xlink:href="#svg-icon-phone"></use>
                                        </svg>
                                    </span>
                                    <span class="link__text">{{ phone }}</span>
                                </a>
                            </p>
                        </div>
                        <div class="btn-wrapper">
                            <a class="btn btn_default btn_dark btn_with-icon" :href="homepage_link">
                                <span class="btn__icon" aria-hidden="true">
                                    <svg role="img" width="30" height="30">
                                        <use xlink:href="#svg-icon-home"></use>
                                    </svg>
                                </span>
                                <span class="btn__text">{{ __('to_homepage') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <cart-recommended-onsuccess :language="language" :recommended_products_default="recommended_products_default"></cart-recommended-onsuccess>
    </div>
</template>

<script>
    import RecommendedOnSuccess from "./RecommendedOnSuccess";

    export default {
        props: {
            language: {
                type: String
            },
            homepage_link: {
                type: String, default: ''
            },
            order: {
                type: Object, default: {}
            },
            recommended_products_default: {
                type: String, default: ''
            },
            online_phone_default: {
                type: String, default: ''
            }
        },
        components: {
            'cart-recommended-onsuccess': RecommendedOnSuccess
        },
        data: () => {
            return {
                phone: '',
            }
        },
        beforeMount() {
            this.phone = this.$props.online_phone_default;
        }
    }
</script>
