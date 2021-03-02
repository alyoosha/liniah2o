<template>
	<div class="section__body">
		<div class="container">
			<div class="body-tab-nav js-body-tab-nav">
				<div class="scrollbar-inner">
					<ul class="list list_unstyled section__title nav nav-tabs active-item">
						<li class="list__item col-auto js-body-tab-item">
							<a class="link active" id="categories-tab"
							   data-toggle="tab" href="#categories" role="tab"
							   aria-controls="categories"
							   aria-selected="true"
							   data-category="all"
							   @click="changeCategory($event)"
							>{{ __('all_categories') }}</a>
						</li>

						<li class="list__item col-auto js-body-tab-item"
						    v-for="category in categories">
							<a class="link"
							   :id="category.id + '-tab'"
							   :href="'#category-' + category.id"
							   data-toggle="tab"
							   :data-category="category.id"
							   role="tab"
							   :aria-controls="category.id"
							   aria-selected="false"
							   @click="changeCategory($event)">{{ category['name_' + lang] }}
							</a>
						</li>
					</ul>
				</div>
			</div>

			<div class="inner-rules-list">
				<div class="container">
					<div class="tab-content">
						<div class="tab-pane-categories tab-pane fade active show"
						     id="categories"
						     data-category="all"
						     role="tabpanel"
						     aria-labelledby="categories-tab">

							<div class="row inner-rules-list__wrapper"
							     v-for="regulation in paginatedRegulations"
							     :key="regulations.id">

								<div class="col-xl-8 inner-rules-list__col">
									<div class="inner-rules-list__block">
										<div class="inner-rules-list__title section__title">
											<h2>{{ regulation['title_' + lang] }}</h2>
										</div>

										<div class="inner-rules-list__text section__title_style2">{{ getDescription(regulation['body_' + lang])}}</div>

										<a class="inner-rules-list__link"
										   :href="'exploitation-rules/' + regulation.id">
											<div class="inner-rules-list__link-icon">
												<svg role="img" aria-hidden="true" width="24" height="24">
													<use xlink:href="#svg-icon-look"></use>
												</svg>
											</div>
											<div class="inner-rules-list__link-text section__title">{{ __('watch') }}</div>
										</a>
									</div>
								</div>
							</div>
						</div>


						<div class="tab-pane-categories tab-pane fade"
						     v-for="category in categories"
						     :id="'category-' + category.id"
						     :data-category="category.id"
						     :key="category.id"
						     role="tabpanel"
						     aria-labelledby="categories-tab">

							<div class="row inner-rules-list__wrapper"
							     v-for="(regulation) in paginatedRegulations"
							     :key="regulations.id">


								<div class="col-xl-8 inner-rules-list__col">
									<div class="inner-rules-list__block">
										<div class="inner-rules-list__title section__title">
											<h2>{{ regulation['title_' + lang]}}</h2>
										</div>

										<div class="inner-rules-list__text section__title_style2">{{ getDescription(regulation['body_' + lang]) }}</div>

										<a class="inner-rules-list__link"
										   :href="'exploitation-rules/' + regulation.id">
											<div class="inner-rules-list__link-icon">
												<svg role="img" aria-hidden="true" width="24" height="24">
													<use xlink:href="#svg-icon-look"></use>
												</svg>
											</div>

											<div class="inner-rules-list__link-text section__title">{{ __('watch') }}</div>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="exploitation-rules__footer pagination-block">
				<div class="row">
					<div class="show-more" v-show="regulations.length !== paginatedRegulations.length && page_number !== pageCount">
						<button class="btn btn_show-more btn_bordered btn_loader js-show-more"
						        type="button"
						        @click="show_more()">

							<span class="btn__text">{{ __('show_more') }}</span>

							<span class="btn__icon" aria-hidden="true">
		                        <svg class="loader-icon" role="img" aria-hidden="true" width="10" height="10">
		                            <use xlink:href="#svg-icon-loader"></use>
		                        </svg>
		                    </span>
						</button>
					</div>

					<div class="pagination">
						<div class="pagination__current" v-show="regulations.length !== paginatedRegulations.length">
							<button class="btn pagination__current-btn btn_bordered js-pagination-opener"
							        type="button"
							        :aria-label="__('change_page')">
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
													:class="{ active : page === page_number }"
													:disabled="page === page_number"
													:aria-label="__('page')+page"
													@click="go_to(page)">{{ page }}
											</a>
										</div>
									</ul>
								</div>
							</div>

							<div class="pagination__control">
								<button class="btn pagination__control-btn js-pagination-closer"
								        type="button"
								        :aria-label="__('close')">
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
	</div>
</template>

<script>
    export default {
        name: "Index",
        props: {
            raw_categories: {
                type: String, default: []
            },
            raw_regulations: {
                type: String, default: []
            },
            raw_per_page: {
                type: String, default: 5
            },
            lang: {
                type: String
            }
        },
        data: function () {
            return {
                paginatedReguls: null,
                perPage: null,
                regulations: null,
	            categories: null,
                paginatedRegulations: null,
                page_number: 0,
                regulations_per_page: null,
            }
        },
        beforeMount() {
            this.categories = JSON.parse(this.raw_categories);
            this.regulations = JSON.parse(this.raw_regulations);
            this.regulations_per_page = Number(this.raw_per_page);
            this.regulations = this.getAllRegulations(this.regulations);
            this.sortRegulations();
            this.sliceRegulations();
        },
        computed: {
            pageCount() {
                let length = this.regulations.length;
                return Math.ceil(length/this.regulations_per_page)
            }
        },
	    methods: {
            sortRegulations() {
                this.regulations.sort((a, b) => {
                    return a.id - b.id;
                });
            },
		    getDescription(data) {
                let reg = new RegExp('(<p.*?>)(.+?)(<\/p>)', 'gi');
                let str = data.match(reg);
                return str[0].replace(/<p.*?>/, '').replace('</p>', '');
		    },
	        changeCategory(event) {
		        let data = event.target.getAttribute('data-category');
                let regulations = JSON.parse(this.raw_regulations);
                this.regulations = null;
                this.paginatedRegulations = null;
                this.page_number = 0;

                if(data != 'all') {
                    this.regulations = regulations[data];
		        }
		        else {
                    this.regulations = this.getAllRegulations(regulations);
                }

                this.sortRegulations();
		        this.sliceRegulations();
            },
			getAllRegulations(regulations) {
	            let allRegulations = [];

		        for(let regulation in regulations) {
		            for(let regul in regulations[regulation]) {
		               allRegulations.push(regulations[regulation][regul])
		            }
		        }
		        return regulations = allRegulations;
			},
            show_more() {
                let start = this.regulations.indexOf(this.paginatedRegulations[0]);
                let end = this.regulations.indexOf(this.paginatedRegulations[this.paginatedRegulations.length - 1]) +
                    this.regulations_per_page + 1;

                if(this.page_number === 0) {
                    this.page_number += 2;
                } else {
                    this.page_number++;
                }

                this.paginatedRegulations = this.regulations.slice(start, end);
            },
            go_to(page) {
                this.page_number = page;

                let start = this.page_number * this.regulations_per_page - this.regulations_per_page;
                let end = start + this.regulations_per_page;

                this.paginatedRegulations = this.regulations.slice(start, end);
            },
            sliceRegulations() {
                let start = this.page_number * this.regulations_per_page;
                let end = start + this.regulations_per_page;

                this.paginatedRegulations = this.regulations.slice(start, end);
            }
	    }
    }

</script>

<style scoped>

</style>
