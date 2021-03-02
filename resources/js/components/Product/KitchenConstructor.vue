<template>
	<div class="product-block__constructor constructor" id="constructor">
		<div class="section__header">
			<div class="container">
				<div class="section__title section__title_style7">
					<h3>Выберите цвет кухни</h3>
				</div>
			</div>
		</div>
		<div class="section__body">
			<div class="container">
				<div class="constructor__wrapper">
					<div class="constructor__header d-block d-lg-none">
						<div class="product-block__title section__title constructor__title">
							<h2>Угловая кухня 1500-2700</h2>
						</div>
						<ul
							class="list list_unstyled product-block__info-list constructor__info-list row align-items-center"
						>
							<li class="col-12 col-md-auto">
								<div class="product-block__code">Артикул: 90858</div>
							</li>
						</ul>
						<div class="controls__descr">
							<span class="controls__descr-icon" aria-hidden="true"
								><svg role="img" width="24" height="24">
									<use xlink:href="#svg-icon-doorhandle"></use></svg></span
							><span class="controls__descr-text">Кухня с ручками</span>
						</div>
					</div>

					<div class="constructor__model">
						<div id="kitchen-viewer-container" class="model">
							<div id="kitchen-viewer-overlay" class="model-prev"></div>
						</div>
					</div>

					<div class="constructor__info">
						<div class="constructor__header d-none d-lg-block">
							<div
								class="product-block__title section__title constructor__title"
							>
								<h2>{{ kitchenData.title }}</h2>
							</div>
							<ul
								class="list list_unstyled product-block__info-list constructor__info-list row align-items-center"
							>
								<li class="col-12 col-md-auto">
									<div class="product-block__code">
										Артикул: {{ kitchenData.article }}
									</div>
								</li>
							</ul>
						</div>

						<div class="constructor__body">
							<div class="constructor__controls controls">
								<div class="controls__header d-none d-lg-flex">
									<div
										class="controls__title section__title section__title_style8"
									>
										Выберите цвет
									</div>
									<div class="controls__descr">
										<span class="controls__descr-icon" aria-hidden="true">
											<svg role="img" width="24" height="24">
												<use xlink:href="#svg-icon-doorhandle"></use>
											</svg>
										</span>
										<span
											v-if="kitchenData.handles"
											class="controls__descr-text"
											>Кухня с ручками</span
										>
									</div>
								</div>
								<div class="controls__body">
									<div class="controls__tabs d-none d-md-block">
										<ul
											class="list list_unstyled nav nav-tabs tab-list"
											role="tablist"
										>
											<!--
												
												Переключатели табов
												
											-->
											<li
												class="list__item"
												v-for="(part, index) in kitchenData.parts"
												:key="part.id"
											>
												<a
													:class="['tab-link', { active: !index }]"
													:id="`controls-part-tab-${part.id}`"
													:href="`#part-tab-${part.id}`"
													data-toggle="tab"
													role="tab"
													:aria-controls="`part-tab-${part.id}`"
													:aria-selected="!index"
													:aria-label="part.title"
												>
												
													<!-- если глянец, то tab-link__icon gloss-->
													<!-- если цвет белый и глянец, то tab-link__icon gloss gloss_dark-->
													<!-- если фрезеровка, то tab-link__icon milling-->
													<span
														:class="[
															'tab-link__icon',
															{
																milling:
																	activeMaterial[part.id] &&
																	activeMaterial[part.id].milling,
																gloss:
																	activeMaterial[part.id] &&
																	!activeMaterial[part.id].texture && //т.к. текстура не глянцевая
																	activeMaterial[part.id].roughness <= 0.15,
																gloss_dark:
																	activeMaterial[part.id] &&
																	!activeMaterial[part.id].texture && //т.к. текстура не глянцевая
																	activeMaterial[part.id].roughness <= 0.15 &&
																	activeMaterial[part.id].color === '#ffffff',
															},
														]"
														aria-hidden="true"
														:style="[
															activeMaterial[part.id] &&
															activeMaterial[part.id].color
																? {
																		'background-color':
																			activeMaterial[part.id].color,
																  }
																: '',

															activeMaterial[part.id] &&
															activeMaterial[part.id].texture
																? {
																		'background-image': `url('${
																			activeMaterial[part.id].texture
																		}')`,
																  }
																: '',
														]"
													></span>
													<span class="tab-link__content">
														<span class="tab-link__title">
															{{ part.title }}
														</span>
														<span class="tab-link__color">
															{{
																(activeMaterial[part.id] &&
																	activeMaterial[part.id].title) ||
																"Выберите цвет"
															}}
														</span>
													</span>
												</a>
											</li>
										</ul>
									</div>

									<div class="controls__content tab-content">
										<form name="form-constructor" method="post">
											<!--
												
												Табы с материалами
												
											-->
											<div
												v-for="(part, index) in kitchenData.parts"
												:key="part.id"
												:class="['tab-pane fade show', { active: !index }]"
												:id="`part-tab-${part.id}`"
												role="tabpanel"
												:aria-labelledby="`controls-part-tab-${part.id}`"
											>
												<!--

													Кнопка раскрытия аккордеона (Mobile)

												-->
												<button
													:class="[
														'tab-link collapse-link',
														{ collapsed: !!index },
													]"
													type="button"
													data-toggle="collapse"
													:data-target="`#controls-part-collapse-${part.id}`"
													:aria-controls="`controls-part-collapse-${part.id}`"
													:aria-expanded="!index"
													:aria-label="part.title"
												>
													<span
														:class="[
															'tab-link__icon',
															{
																milling:
																	activeMaterial[part.id] &&
																	activeMaterial[part.id].milling,
																gloss:
																	activeMaterial[part.id] &&
																	!activeMaterial[part.id].texture && //т.к. текстура не глянцевая
																	activeMaterial[part.id].roughness <= 0.15,

																gloss_dark:
																	activeMaterial[part.id] &&
																	!activeMaterial[part.id].texture && //т.к. текстура не глянцевая
																	activeMaterial[part.id].roughness <= 0.15 &&
																	activeMaterial[part.id].color === '#ffffff',
															},
														]"
														aria-hidden="true"
														:style="[
															activeMaterial[part.id] &&
															activeMaterial[part.id].color
																? {
																		'background-color':
																			activeMaterial[part.id].color,
																  }
																: '',

															activeMaterial[part.id] &&
															activeMaterial[part.id].texture
																? {
																		'background-image': `url('${
																			activeMaterial[part.id].texture
																		}')`,
																  }
																: '',
														]"
													></span>

													<span class="tab-link__content">
														<span class="tab-link__title">
															{{ part.title }}
														</span>
														<span class="tab-link__color">
															{{
																(activeMaterial[part.id] &&
																	activeMaterial[part.id].title) ||
																"Выберите цвет"
															}}
														</span>
													</span>
												</button>
												<div
													:class="['collapse', { show: !index }]"
													:id="`controls-part-collapse-${part.id}`"
												>
													<div class="tab-form">
														<div class="row">
															<!--
												
															Категории материалов
												
														-->
															<div
																v-for="materialCategory in part.materialCategories"
																:key="materialCategory.id"
																class="col-6"
															>
																<div class="controls__subtitle">
																	{{ materialCategory.title }}
																</div>
																<ul
																	class="list list_unstyled radio-list radio-list_color row"
																>
																	<!--
												
																	Материалы
												
																-->
																	<!-- если глянец, то tab-link__icon gloss-->
																	<!-- если цвет белый и глянец, то tab-link__icon gloss gloss_dark-->
																	<!-- если фрезеровка, то tab-link__icon milling-->
																	<li
																		v-for="(material,
																		index) in materialCategory.materials"
																		:key="index"
																		:class="[
																			'list__item radio radio_color',
																			{
																				milling: material.milling,

																				gloss:
																					!material.texture && //т.к. текстура не глянцевая
																					material.roughness <= 0.15,
																				gloss_dark:
																					!material.texture && //т.к. текстура не глянцевая
																					material.roughness <= 0.15 &&
																					material.color === '#ffffff',
																			},
																		]"
																	>
																		<label
																			class="radio__label"
																			:title="material.title"
																			@click="applyMaterial(part, material)"
																		>
																			<input
																				class="radio__hidden"
																				type="radio"
																				:name="`part-${part.id}-material`"
																				:value="material.title"
																			/>
																			<span
																				class="radio__custom"
																				:aria-label="material.title"
																				:style="[
																					material.color
																						? {
																								'background-color':
																									material.color,
																						  }
																						: '',
																					material.texture
																						? {
																								'background-image': `url('${material.texture}')`,
																						  }
																						: '',
																				]"
																			>
																				<span
																					class="complementary-color"
																					aria-hidden="true"
																				></span>
																				<span
																					v-if="material.milling"
																					class="milling-popover"
																					>Данный цвет выполняется только с
																					фрезеровкой</span
																				>
																			</span>
																		</label>
																	</li>
																</ul>
															</div>
														</div>
													</div>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
							<div class="constructor__downloads">
								<div class="row">
									<div class="col-12 col-sm-6">
										<a
											class="link"
											href="javascript: void(0);"
											download
											aria-label="Скачать проект кухни PDF"
											@click="downloadProject()"
											><span class="link__icon" aria-hidden="true"
												><svg role="img" width="24" height="24">
													<use
														xlink:href="#svg-icon-documents"
													></use></svg></span
											><span class="link__text"
												>Скачать проект кухни PDF</span
											></a
										>
									</div>
									<div class="col-12 col-sm-6">
										<a
											class="link"
											href="javascript: void(0);"
											download
											aria-label="Сохранить изображение"
											@click="saveImage()"
											><span class="link__icon" aria-hidden="true"
												><svg role="img" width="24" height="24">
													<use
														xlink:href="#svg-icon-save-photo"
													></use></svg></span
											><span class="link__text">Сохранить изображение</span></a
										>
									</div>
								</div>
							</div>
							<div class="constructor__fittings">
								<div class="fittings">
									<span class="fittings__icon" aria-hidden="true"
										><svg role="img" width="24" height="24">
											<use
												xlink:href="#svg-icon-measuring-tape"
											></use></svg></span
									><span class="fittings__text">Фурнитура “Стандарт”</span
									><span class="fittings__popover">
										<button
											class="btn btn_popover"
											type="button"
											data-container="body"
											data-toggle="popover"
											data-placement="top"
											data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus."
										>
											<svg role="img" width="20" height="20">
												<use xlink:href="#svg-icon-popover"></use>
											</svg></button
									></span>
								</div>
							</div>
						</div>
						<div class="constructor__footer">
							<div class="product-block__price constructor__price">
								<span class="cost">3 567</span
								><span class="currency">лей / шт</span>
							</div>
							<div class="product-block__form">
								<div class="btn-group">
									<div class="row">
										<div class="col-12 col-sm-auto">
											<button
												class="btn btn_default btn_dark btn_with-icon"
												type="submit"
											>
												<span class="btn__icon" aria-hidden="true"
													><svg role="img" width="30" height="30">
														<use xlink:href="#svg-icon-shop"></use></svg></span
												><span class="btn__text">В корзину</span>
											</button>
										</div>
										<div class="col-12 col-sm-auto">
											<button
												class="btn btn_default btn_transparent btn_flex"
												type="button"
												data-toggle="modal"
												data-target="#modal-consultation"
											>
												<span class="btn__icon" aria-hidden="true"
													><svg role="img" width="30" height="30">
														<use
															xlink:href="#svg-icon-call-center2"
														></use></svg></span
												><span class="btn__text">Заказать консультацию</span>
											</button>
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
import KitchenViewer from "../../KitchenViewer.js"; //1.4 Mb

export default {
	data() {
		return {
			kitchenData: {}, // Данные о кухне
			kitchenViewer: {}, // Объект просмотрщика
			activeMaterial: {}, // Выбранные материалы (отображаются на вкладках)
		};
	},
	computed: {
		// Параметры для KitchenViewer
		kitchenViewerParams() {
			// Контейнер
			const CONTAINER = document.getElementById("kitchen-viewer-container");
			// Путь к HDR изображению
			const HDR_PATH = "/public/kitchen/hdr/studio_sm.hdr";
			// Определение начального положения камеры в зависимости от типа кухни
			const CAMERA_START_POSITION = {
				corner: [-20, 0, 12], //Угловая
				straight: [-22, 0, 0], //Прямая
			};

			/**
			 * Собрать все текстуры и карты нормалей
			 */
			let textures = [];
			let normalMaps = [];
			this.kitchenData.parts.forEach((part) => {
				part.materialCategories.forEach((category) => {
					category.materials.forEach((material) => {
						if (
							material.texture &&
							!textures.find((texture) => texture === material.texture)
						) {
							textures.push(material.texture);
						}
						if (
							material.normalMap &&
							!normalMaps.find((normalMap) => normalMap === material.normalMap)
						) {
							normalMaps.push(material.normalMap);
						}
					});
				});
			});

			return {
				container: CONTAINER,
				hdrPath: HDR_PATH,
				cameraPosition: CAMERA_START_POSITION[this.kitchenData.category],
				modelPath: this.kitchenData.modelURL,
				textures,
				normalMaps,
				onstart(url, itemsLoaded, itemsTotal) {
					// Спрятать контейнер до полной загрузки
					this.container.style.opacity = 0;
				},
				// onprogress(url, itemsLoaded, itemsTotal) {},
				onload() {
					// Отобразить контейнер после загрузки
					this.container.style.removeProperty("opacity");

					// Взаимодействие с оврелеем
					const container = document.querySelector("#kitchen-viewer-container");
					const canvas = container.querySelector("canvas");
					const overlay = container.querySelector("#kitchen-viewer-overlay");
					const hideOverlay = () => {
						overlay.style.opacity = 0;
						setTimeout(() => (overlay.style.display = "none"), 300);
					};
					canvas.addEventListener("pointerdown", hideOverlay, { once: true });
					canvas.addEventListener("wheel", hideOverlay, { once: true });
				},
			};
		},
	},
	beforeMount() {
		fetch("/public/kitchen/kitchenDataExample.json")
			.then((response) => response.json())
			.then((data) => (this.kitchenData = data))
			.then(this.initModelViewer)
			.catch((e) =>
				console.error("KitchenConstructor.vue >> beforeMount()", e)
			);
	},
	methods: {
		initModelViewer() {
			this.kitchenViewer = new KitchenViewer(this.kitchenViewerParams);
			this.activeMaterials = {};
		},
		applyMaterial(part, material) {
			this.activeMaterial[part.id] = material;
			this.$forceUpdate();

			if (material.color) {
				this.kitchenViewer.changeColor(part.meshName, material.color);
			} else {
				this.kitchenViewer.clearColor(part.meshName);
			}

			if (material.texture) {
				this.kitchenViewer.changeTexture(part.meshName, material.texture);
			} else {
				this.kitchenViewer.clearTexture(part.meshName);
			}

			if (material.normalMap) {
				this.kitchenViewer.changeNormalMap(part.meshName, material.normalMap);
			} else {
				this.kitchenViewer.clearNormalMap(part.meshName);
			}

			if (material.roughness != undefined) {
				this.kitchenViewer.changeRoughness(part.meshName, material.roughness);
			} else {
				this.kitchenViewer.changeRoughness(part.meshName, 1);
			}
		},
		downloadProject() {
			console.log("Скачать проект кухни");
		},
		saveImage() {
			this.kitchenViewer.saveImage(this.kitchenData.title);
		},
		addToCart() {
			// Передать событие 'add-to-cart' для родительского компонента по нажатию на кнопку "В корзину"
			this.$emit("add-to-cart", {
				/* ... */
			});
		},
	},
};
</script>

<style lang="scss">
.model {
	position: relative;
	width: 100%;
	padding-top: 100%;
	transition: opacity 0.5s ease;
	filter: saturate(1.5); // Важная настройка насыщенности картинки

	& > * {
		position: absolute;
		top: 0;
		left: 0;
	}

	.model-prev {
		background-size: 400px 400px;
		transition: opacity 0.3s ease;
		pointer-events: none;
	}
}
</style>