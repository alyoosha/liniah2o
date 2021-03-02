<template>
    <div class="header__catalog catalog-dropdown collapse" id="catalog-dropdown">
        <div class="container">
            <div class="catalog-dropdown__content bg_white">
                <div class="row no-gutters">
                    <div class="col-4">
                        <div class="scrollbar-inner">
                            <ul class="list list_unstyled nav nav-tabs catalog-dropdown__nav catalog-dropdown__nav_lvl1" role="tablist">
                                <!-- 1 -->
                                <li class="list__item" v-for="first_level_category in first_level_categories" :key="first_level_category.id">
                                    <a
                                        class="link catalog-link catalog-link_main"
                                        :class="classObject(first_level_category.id, first_level_category.color_class_prefix)"
                                        :href="`#first-level-${first_level_category.id}`"
                                        data-toggle="tab"
                                        role="tab"
                                        :aria-controls="`first-level-${first_level_category.id}`"
                                        aria-selected="true"
                                        :aria-label="first_level_category['name_'+language]"
                                        @click="go_to_second_category(first_level_category)"
                                    >
                                    <div class="link__bg" aria-hidden="true" :style="`background-image: url('${storage_path+first_level_category.logo}');`"></div>
                                        <span v-if="first_level_category.svg_logo" class="link__icon" aria-hidden="true">
                                            <svg role="img" aria-hidden="true" width="30" height="30">
                                                <use :xlink:href="`#svg-icon-${get_svg_logo(first_level_category.svg_logo)}`"></use>
                                            </svg>
                                        </span>
                                        <span class="link__text">{{ first_level_category['name_'+language] }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="tab-content">
                            <div
                                class="tab-pane active"
                                :id="`first-level-${first_level_active_category.id}`"
                                role="tabpanel"
                                :aria-label="first_level_active_category['name_'+language]"
                            >
                            <!-- <div
                                v-for="first_level_category in first_level_categories"
                                :key="first_level_category.id"
                                class="tab-pane fade"
                                :class="{show: first_level_category.id === first_level_active_category, active:first_level_category.id === first_level_active_category}"
                                :id="`first-level-${first_level_category.id}`"
                                role="tabpanel"
                                :aria-label="first_level_category['name_'+language]"
                            > -->
                                <div class="row no-gutters">
                                    <div class="col-6">
                                        <div class="scrollbar-inner">
                                            <ul class="list list_unstyled nav nav-tabs catalog-dropdown__nav catalog-dropdown__nav_lvl2" role="tablist">
                                                <!-- 2 -->
                                                <li
                                                    class="list__item"
                                                    v-for="second_level_category in second_level_categories"
                                                    :key="second_level_category.id"
                                                >
                                                    <a
                                                        v-if="Number.parseInt(first_level_active_category.id) === 10382"
                                                        class="link catalog-link catalog-link_inner catalog-link_inner_wi"
                                                        :class="{active: second_level_category.id === second_level_active_category.id}"
                                                        :aria-label="second_level_category['name_'+language]"
                                                        :href="'/'+language+'/catalog/'+first_level_active_category.slug+'/collections/'+second_level_category.slug"
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
                                                        class="link catalog-link catalog-link_inner catalog-link_inner_wi"
                                                        :class="{active: second_level_category.id === second_level_active_category.id}"
                                                        :href="`#second-level-${second_level_category.id}`"
                                                        data-toggle="tab"
                                                        role="tab"
                                                        :aria-controls="`second-level-${second_level_category.id}`"
                                                        aria-selected="true"
                                                        :aria-label="second_level_category['name_'+language]"
                                                        @click="go_to_third_category(first_level_active_category.slug, second_level_category.slug, second_level_category)"
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
                                                        class="link catalog-link  catalog-link_inner_wi"
                                                        :class="{active: second_level_category.id === second_level_active_category.id}"
                                                        :href="'/'+language+'/catalog/'+first_level_active_category.slug"
                                                        :aria-label="second_level_category['name_'+language]"
                                                    >
                                                        <span class="link__icon" aria-hidden="true" v-if="second_level_category.svg_logo">
                                                            <svg role="img" aria-hidden="true" width="30" height="30">
                                                                <use :xlink:href="`#svg-icon-${get_svg_logo(second_level_category.svg_logo)}`"></use>
                                                            </svg>
                                                            </span>
                                                        <span class="link__text">{{ second_level_category['name_'+language] }}</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="tab-content">
                                            <div
                                                class="tab-pane active"
                                                :id="`second-level-${second_level_active_category.id}`"
                                                role="tabpanel"
                                                :aria-label="second_level_active_category['name_'+language]"
                                            >
                                            <!-- <div
                                                v-for="second_level_category in second_level_categories"
                                                :key="second_level_category.id"
                                                class="tab-pane fade"
                                                :class="{show: second_level_category.id === second_level_active_category, active: second_level_category.id === second_level_active_category}"
                                                :id="`second-level-${second_level_category.id}`"
                                                role="tabpanel"
                                                :aria-label="second_level_category['name_'+language]"
                                            > -->
                                                <div class="scrollbar-inner">
                                                    <ul class="list list_unstyled catalog-dropdown__nav catalog-dropdown__nav_lvl3">
                                                        <!-- 3 -->
                                                        <li class="list__item" v-for="third_level_category in third_level_categories" :key="third_level_category.id">
                                                            <a class="link catalog-link catalog-link_inner" :href="third_level_category.path_to_ternary_index_catalog_page">{{ third_level_category['name_'+language] }}</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                first_level_active_category: {},
                second_level_categories: [],
                second_level_active_category: {},
                third_level_categories: []
            }
        },
        beforeMount() {
            const checkWidthAndLoad = _.debounce(() => {
                if((window.innerWidth
                    || document.documentElement.clientWidth
                    || document.body.clientWidth) > 768) {
                    axios.get('/api/header/getFirstLevelCategories')
                        .then(response => {
                            this.first_level_categories = response.data;
                            this.first_level_active_category = this.first_level_categories[0];

                            axios.post('/api/header/getSecondLevelCategories', {
                                id: this.first_level_categories[0].id
                            })
                                .then(response => {
                                    this.second_level_categories = response.data;
                                    this.second_level_active_category = this.second_level_categories[0];

                                    axios.post('/api/header/getThirdLevelCategories', {
                                        id: this.second_level_categories[0].id,
                                        lang: this.language,
                                        first_level_category_slug: this.first_level_categories[0].slug,
                                        second_level_category_slug: this.second_level_categories[0].slug,
                                    })
                                        .then(response => {
                                            this.third_level_categories = response.data;
                                        })
                                        .catch(error => console.log(error));
                                })
                                .catch(error => console.log(error));
                        })
                        .catch(error => console.log(error));
                }
            }, 300);
            checkWidthAndLoad();
            window.addEventListener('resize', checkWidthAndLoad);
        },
        updated() {
            if ($(".scrollbar-inner").length) {
                $(".scrollbar-inner").scrollbar({
                    ignoreMobile: true,
                    ignoreOverlay: true,
                    disableBodyScroll: true
                });
            }
        },
        methods: {
            get_svg_logo(svg_path) {
                let matches = svg_path.match(/icon-(.*)\.svg$/);

                return matches[1];
            },
            classObject: function (id, prefix) {
                return {
                    active: this.first_level_active_category.id === id,
                    ['catalog-link_main_'+prefix] : true
                }
            },
            go_to_second_category(first_level) {
                this.first_level_active_category = first_level;
                let first_level_slug = first_level.slug;

                this.third_level_categories = [];

                axios.post('/api/header/getSecondLevelCategories', {
                    id: first_level.id
                })
                    .then(response => {
                        this.second_level_categories = response.data;
                        this.second_level_active_category = this.second_level_categories[0];

                        if(this.second_level_categories[0].childs.length == 0) {
                            for(let category of this.second_level_categories) {
                                category.link = '/' + first_level.parent.slug + '/' +
                                    first_level.slug +
                                    '/collections/' + category.slug;
                            }
                            return;
                        }

                        this.go_to_third_category(first_level_slug, this.second_level_categories[0].slug, this.second_level_categories[0])
                    })
                    .catch(error => console.log(error));
            },
            go_to_third_category(first_level_slug, second_level_slug, second_level) {
                this.second_level_active_category = second_level;

                axios.post('/api/header/getThirdLevelCategories', {
                    id: second_level.id,
                    lang: this.language,
                    first_level_category_slug: first_level_slug,
                    second_level_category_slug: second_level_slug,
                })
                    .then(response => {
                        this.third_level_categories = response.data;
                    })
                    .catch(error => console.log(error));
            }
        },
    }
</script>

<style scoped>
    a:not([href]):not([tabindex]) {
        color: #ffffff;
    }
    .header .catalog-link svg {
        width: 30px;
    }
</style>
