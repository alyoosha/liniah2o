<template>
    <div class="container">
        <div class="promotion-content">
            <div class="row">
                <div class="col-12 col-md-6 col-xl-4" v-for="promotion in paginatedPromotions" :key="promotion.id">
                    <div class="promotion-block bg_white">
                        <a class="promotion-block__img" :href="promotion.singlePagePath">
                            <div class="background-img">
                                <img v-if="promotion.image" :src="storage_path+'/'+promotion.image" :alt="promotion['name_'+language]">
                                <img v-else :src="storage_path+'/attachments/no-image.png'" :alt="promotion">
                            </div>
                        </a>
                        <div class="promotion-block__footer">
                            <a class="promotion-title section__title section__title_style5" :href="promotion.singlePagePath">
                                <h3>{{ promotion['name_'+language] }}</h3>
                            </a>
                            <div class="promotion-date">{{ __('from_date') }} {{ promotion.from_date }} {{ __('to_date') }} {{ promotion.to_date }}</div>
                            <a class="promotion-link" :href="promotion.singlePagePath">
                                <div class="promotion-link__icon">
                                    <svg role="img" aria-hidden="true" width="24" height="24">
                                        <use xlink:href="#svg-icon-look"></use>
                                    </svg>
                                </div>
                                <div class="promotion-link__text section__title">{{ __('watch') }}</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="promotions__footer pagination-block" v-show="pageCount > 1">
            <div class="row">
                <div class="show-more" v-show="promotions.length !== paginatedPromotions.length && page_number !== pageCount">
                    <!--все кнопки с классом btn_loader при добавлении класса .btn_loader_show меняют иконку на прелоадер-->
                    <button class="btn btn_show-more btn_bordered btn_loader js-show-more" type="button" @click="show_more()">
                        <span class="btn__text">{{ __('show_more') }}</span>
                        <span class="btn__icon" aria-hidden="true">
                            <svg class="default-icon" role="img" aria-hidden="true" width="10" height="10">
                                <use xlink:href="#svg-icon-down-arrow"></use>
                            </svg>
                            <svg class="loader-icon" role="img" aria-hidden="true" width="10" height="10">
                                <use xlink:href="#svg-icon-loader"></use>
                            </svg>
                        </span>
                    </button>
                </div>
                <div class="pagination">
                    <div class="pagination__current">
                        <button class="btn pagination__current-btn btn_bordered js-pagination-opener" type="button" :aria-label="__('change_page')">
                            <span class="btn__text">{{ page_number === 0 ? page_number + 1 : page_number }}</span>
                            <span class="btn__icon" aria-hidden="true">
                                <svg role="img" aria-hidden="true" width="10" height="10">
                                    <use xlink:href="#svg-icon-down-arrow"></use>
                                </svg>
                            </span>
                        </button>
                    </div>
                    <div class="pagination__block">
                        <div class="pagination__content">
                            <div class="scrollbar-inner">
                                <ul class="list list_unstyled pagination__list">
                                    <div class="list__item" v-for="page in pageCount" :key="page">
                                        <a
                                            class="link btn js-pagination-link"
                                            :class="{ active : page===page_number }"
                                            :disabled="page===page_number"
                                            :aria-label="__('page')+page"
                                            @click="go_to(page)">{{ page }}</a>
                                    </div>
                                </ul>
                            </div>
                        </div>
                        <div class="pagination__control">
                            <button class="btn pagination__control-btn js-pagination-closer" type="button" :aria-label="__('close')">
                                <span class="btn__icon" aria-hidden="true">
                                    <svg role="img" aria-hidden="true" width="20" height="20">
                                        <use xlink:href="#svg-icon-cancel"></use>
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            default_promotions: {
                type: Array, default: []
            },
            storage_path_default: {
                type: String, default: ''
            },
            language: {
                type: String
            },
        },
        data: () => {
            return {
                storage_path: '',
                promotions: [],
                paginatedPromotions: [],
                page_number: 0,
                promotions_per_page: 9,
            }
        },
        beforeMount() {
            this.storage_path = this.$props.storage_path_default;
            this.promotions = this.$props.default_promotions;

            this.slicePromotions();
        },
        computed: {
            pageCount() {
                let length = this.promotions.length;
                return Math.ceil(length/this.promotions_per_page)
            }
        },
        methods: {
            show_more() {
                let start = this.promotions.indexOf(this.paginatedPromotions[0]);
                let end = this.promotions.indexOf(this.paginatedPromotions[this.paginatedPromotions.length - 1]) + this.promotions_per_page + 1;

                if(this.page_number === 0) {
                    this.page_number += 2;
                } else {
                    this.page_number++;
                }

                this.paginatedPromotions = this.promotions.slice(start, end);
            },
            go_to(page) {
                this.page_number = page;

                let start = this.page_number * this.promotions_per_page - this.promotions_per_page;
                let end = start + this.promotions_per_page;

                this.paginatedPromotions = this.promotions.slice(start, end);
            },
            slicePromotions() {
                let start = this.page_number * this.promotions_per_page;
                let end = start + this.promotions_per_page;

                this.paginatedPromotions = this.promotions.slice(start, end);
            }
        },
    }
</script>
