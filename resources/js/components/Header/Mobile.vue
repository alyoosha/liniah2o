<template>
    <div class="drilldown">
        <div class="drilldown-container">
            <!-- если находимся на соответствующей странице - ссылке добавляем класс active-->
            <ul class="list list_unstyled mobile-nav__catalog drilldown-root">
                <li class="list__item list__item_catalog">
                    <a class="btn btn_catalog btn_dark" href="javascript: void(0);">
                        <span class="btn__icon" aria-hidden="true">
                            <svg role="img" width="20" height="20">
                                <use xlink:href="#svg-icon-menu"></use>
                            </svg>
                        </span>
                        <span class="btn__text">{{ __('catalog') }}</span>
                    </a>
                    <ul class="list list_unstyled catalog-dropdown__nav catalog-dropdown__nav_lvl1 drilldown-sub">
                        <li class="list__item drilldown-back">
                            <a class="link link_back" href="javascript: void(0);">
                                <span class="link__icon" aria-hidden="true">
                                    <svg role="img" aria-hidden="true" width="20" height="20">
                                        <use xlink:href="#svg-icon-cancel"></use>
                                    </svg>
                                </span>
                                <span class="link__text">{{ __('close_сatalog') }}</span>
                            </a>
                        </li>
                        <!-- 1 -->
                        <li class="list__item" v-for="first_level_category in first_level_categories" :key="first_level_category.id">
                            <a
                                class="link catalog-link catalog-link_main"
                                :class="`catalog-link_main_${first_level_category.color_class_prefix}`"
                                @click="getSecondLevelCategories(first_level_category)"
                                :aria-label="first_level_category['name_'+language]">
                                <div class="link__bg" aria-hidden="true" :style="`background-image: url('${storage_path+first_level_category.logo}');`"></div>
                                <span v-if="first_level_category.svg_logo" class="link__icon" aria-hidden="true">
                                    <svg role="img" aria-hidden="true" width="30" height="30">
                                        <use :xlink:href="`#svg-icon-${get_svg_logo(first_level_category.svg_logo)}`"></use>
                                    </svg>
                                </span>
                                <span class="link__text">{{ first_level_category['name_'+language] }}</span>
                            </a>
                            <ul class="list list_unstyled catalog-dropdown__nav catalog-dropdown__nav_lvl2 drilldown-sub">
                                <li class="list__item drilldown-back">
                                    <a class="link link_back" href="javascript: void(0);">
                                        <span class="link__icon link__icon_arrow" aria-hidden="true">
                                            <svg role="img" aria-hidden="true" width="20" height="20">
                                                <use xlink:href="#svg-icon-down-arrow"></use>
                                            </svg>
                                        </span>
                                        <span class="link__text">{{ __('back') }}</span>
                                    </a>
                                </li>
                                <!-- 2 -->
                                <li class="list__item" v-for="second_level_category in second_level_categories" :key="second_level_category.id">
                                    <a
                                        v-if="Number.parseInt(first_level_category.id) === 10382"
                                        class="link catalog-link catalog-link_inner catalog-link_inner_wi"
                                        :class="{active: second_level_category.id === second_level_category.id}"
                                        :aria-label="second_level_category['name_'+language]"
                                        :href="'/'+language+'/catalog/'+first_level_category.slug+'/collections/'+second_level_category.slug"
                                    >
                                        <span class="link__icon" aria-hidden="true" v-if="second_level_category.svg_logo">
                                            <svg role="img" aria-hidden="true" width="30" height="30">
                                                <use :xlink:href="`#svg-icon-${get_svg_logo(second_level_category.svg_logo)}`"></use>
                                            </svg>
                                        </span>
                                        <span class="link__text">{{ second_level_category['name_'+language] }}</span>
                                    </a>
                                    <a
                                        v-else-if="second_level_category.childs.length > 0"
                                        @click="getThirdLevelCategories(first_level_category.slug,
                                       second_level_category.slug, second_level_category.id)"
                                       class="link catalog-link catalog-link_inner catalog-link_inner_wi"
                                       href="javascript: void(0);" :aria-label="second_level_category['name_'+language]"
                                    >
                                        <span class="link__icon" aria-hidden="true" v-if="second_level_category.svg_logo">
                                            <svg role="img" aria-hidden="true" width="30" height="30">
                                                <use :xlink:href="`#svg-icon-${get_svg_logo(second_level_category.svg_logo)}`"></use>
                                            </svg>
                                        </span>
                                        <span class="link__text">{{ second_level_category['name_'+language] }}</span>
                                    </a>
                                    <a
                                        v-else
                                        class="link catalog-link catalog-link_inner catalog-link_inner_wi"
                                        :href="'/'+language+'/catalog/'+first_level_category.slug"
                                        :aria-label="second_level_category['name_'+language]"
                                    >
                                        <span class="link__icon" aria-hidden="true" v-if="second_level_category.svg_logo">
                                            <svg role="img" aria-hidden="true" width="30" height="30">
                                                <use :xlink:href="`#svg-icon-${get_svg_logo(second_level_category.svg_logo)}`"></use>
                                            </svg>
                                        </span>
                                        <span class="link__text">{{ second_level_category['name_'+language] }}</span>
                                    </a>
                                    <ul
                                        v-if="second_level_category.childs.length > 0"
                                        class="list list_unstyled catalog-dropdown__nav catalog-dropdown__nav_lvl3 drilldown-sub">
                                        <li class="list__item drilldown-back">
                                            <a class="link link_back" href="javascript: void(0);">
                                                <span class="link__icon link__icon_arrow" aria-hidden="true">
                                                    <svg role="img" aria-hidden="true" width="20" height="20">
                                                        <use xlink:href="#svg-icon-down-arrow"></use>
                                                    </svg>
                                                </span>
                                                <span class="link__text">{{ __('back') }}</span>
                                            </a>
                                        </li>
                                        <!-- 3 -->
                                        <li class="list__item" v-for="third_level_category in third_level_categories" :key="third_level_category.id">
                                            <a class="link catalog-link catalog-link_inner" :href="third_level_category.path_to_ternary_index_catalog_page">{{ third_level_category['name_'+language] }}</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            language: {
                type: String
            },
            storage_path: {
                type: String
            },
        },
        data: () => {
            return {
                first_level_categories: [],
                second_level_categories: [],
                third_level_categories: []
            }
        },
        beforeMount() {
            const checkWidthAndLoad = _.debounce(() => {
                if((window.innerWidth
                    || document.documentElement.clientWidth
                    || document.body.clientWidth) < 1025) {
                    axios.get('/api/header/getFirstLevelCategories')
                        .then(response => {
                            this.first_level_categories = response.data;
                        })
                        .catch(error => console.log(error));
                }
            }, 300);
            checkWidthAndLoad();
            window.addEventListener('resize', checkWidthAndLoad);
        },
        methods: {
            get_svg_logo(svg_path) {
                let matches = svg_path.match(/icon-(.*)\.svg$/);

                return matches[1];
            },
            getSecondLevelCategories(first_level_category) {
                axios.post('/api/header/getSecondLevelCategories', {
                    id: first_level_category.id
                })
                    .then(response => {
                        this.second_level_categories = response.data;

                        if(this.second_level_categories[0].childs.length == 0) {
                            for(let category of this.second_level_categories) {
                                category.link = '/' + first_level_category.parent.slug + '/' +
                                    first_level_category.slug +
                                    '/collections/' + category.slug;
                            }
                            return;
                        }
                    })
                    .catch(error => console.log(error));
            },
            getThirdLevelCategories(first_level_slug, second_level_slug, id) {
                axios.post('/api/header/getThirdLevelCategories', {
                    id,
                    lang: this.language,
                    first_level_category_slug: first_level_slug,
                    second_level_category_slug: second_level_slug,
                })
                    .then(response => {
                        this.third_level_categories = response.data;
                    })
                    .catch(error => console.log(error));
            }
        }
    }
</script>

<style scoped>
    a:not([href]):not([tabindex]) {
        color: #ffffff;
    }
</style>
