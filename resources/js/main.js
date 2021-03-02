import Swiper from 'swiper';
import _ from 'lodash';

function __(str) {
	return _.get(window.i18n, str); // Объявляем функцию для перевода
}

var xhr = undefined;

$(document).ready(function () {

	// map
	initMap();

	// скрываем фокус на десктопе
	$("a, button, .product-card").on("mouseup", function () {
		$(this).blur();
	});

	//dropdowns
	$('.dropdown .dropdown-menu').on('click.bs.dropdown', function () {
		return $('.dropdown').one('hide.bs.dropdown', function () {
			return false;
		});
	});

	//open search panel
	if ($('.header__desktop .header__search').length) {
		$('.header__desktop .header__search .form-control').on("focus", function (e) {
			var searchField = $(this);

			searchField.parents('.header__desktop .header__search').addClass("header__search_open");

			searchField.parents('.header__desktop .header__search_open').on("mouseleave", function (e) {
				$(this).removeClass("header__search_open");
				searchField.blur();
			});
		});

		$('.header__desktop .header__search .form-control').on("input", function (e) {
			var searchField = $(this);

			// searchAjaxRequest(searchField);
		});
	}

	//toggle catalog panel
	if ($('.js-catalog-toggle').length) {

		const header = $(".header__main-nav .container")[0];
		const toggler = $('.js-catalog-toggle')[0];
		const $dropdown = $("#catalog-dropdown");
		const container = $("#catalog-dropdown > .container")[0];
		let timeout;

		toggler.addEventListener("mouseenter", () => {
			timeout = setTimeout(() =>
				$dropdown.collapse("show"), 200);
		});

		header.addEventListener("mouseleave", () =>
			clearTimeout(timeout));

		[container, header].forEach(el =>
			el.addEventListener("mouseleave", () => {
				timeout = setTimeout(() => {
					$dropdown.collapse("hide");
				}, 100);
			})
		);
	}

	//toggle catalog filter category
	if ($(".js-filter-panel-toggler").length) {
		$('.js-filter-panel-toggler').on("click", function (e) {
			e.preventDefault();
			var btn = $(this);

			btn.next(".collapse").collapse("toggle");
			btn.toggleClass("collapsed");
		});
	}

	//clear filters
	if ($(".js-filter-clean-open").length) {
		$('.js-filter-clean-open').on("click", function (e) {
			e.preventDefault();

			$(".filter-panel__footer").addClass("clean");

			function cleanHidden() {
				$(".filter-panel__footer").removeClass("clean")
			}

			setTimeout(cleanHidden, 3000);
		});
	}

	if ($(".js-filter-clean").length) {
		$(".js-filter-clean").on("mouseleave", function (e) {
			$(".filter-panel__footer").removeClass("clean")
		});
	}

	//custom scrollbar
	if ($('.scrollbar-inner').length) {
		$('.scrollbar-inner').scrollbar({
			ignoreMobile: true,
			ignoreOverlay: true,
			disableBodyScroll: true,
		});
	}

	//scroll to top
	if ($('.js-scrolltop').length) {
		$(window).scroll(function () {
			var distanceTop = 600;
			if ($(window).scrollTop() > distanceTop) {
				$('.js-scrolltop').addClass('active');
			}
			else {
				$('.js-scrolltop').removeClass('active');
			}
		});

		$('.js-scrolltop').on("click", function (e) {
			e.preventDefault();

			$('body,html').animate({ scrollTop: 0 }, 600);

		});
	}

	//smooth scroll on click
	if ($(".js-scroll-link").length) {
		$('.js-scroll-link[href^="#"]').unbind().on('click', function (e) {
			e.preventDefault();
			var link = $(this);
			var target = link.attr("href");
			var distanceTop = $(target).offset().top - 80;

			if (!!target) {
				$('body,html').animate({ scrollTop: distanceTop }, 600);
			}
		});
	}

	// show blocks by radio checkout-states
	if ($(".js-form-checkout-states-mvp").length) {
		// состояние по умолчанию (загрузка страницы):
		// Убраны все списки способов оплаты и восстановлен список способов оплаты через магазин
		if ($("#checkout-payment-1").prop("checked", true)) {
			$(".checkout-states-block__methods .radio-list").each(function () {
				$(this).css("display", "none");
			});
			$(".params-block__list_shop").fadeIn(500);

			$("#checkout-delivery-1").prop("checked", false);
			$("#checkout-delivery-2").prop("checked", true);

			$(".checkout-states-block__delivery .delivery-form-block").each(function () {
				$(this).css("display", "none");
			})

			$(".delivery-form-block_pickup").fadeIn(500);

		}

		// изменение блока способа оплаты в зависимости от выбранного чекбокса оплаты - повешены события на радио-кнопки оплаты
		$(".checkout-states-block__payment input").change(function () {
			let target = $(this);

			if (target.prop("id") === "checkout-payment-1") {
				$("#checkout-delivery-1").prop("checked", false);
				$("#checkout-delivery-2").prop("disabled", false);
				$("#checkout-delivery-2").prop("checked", true);

				$(".checkout-states-block__delivery .delivery-form-block").each(function () {
					$(this).css("display", "none");
				})

				$(".delivery-form-block_pickup").fadeIn(500);
			}

			if (target.prop("id") === "checkout-payment-2") {
				$("#checkout-delivery-2").prop("checked", false);
				$("#checkout-delivery-2").prop("disabled", true);
				$("#checkout-delivery-1").prop("checked", true);

				$(".checkout-states-block__delivery .delivery-form-block").each(function () {
					$(this).css("display", "none");
				})

				$(".delivery-form-block_courier").fadeIn(500);
			}

		})

		// Повешены события на радио-кнопки доставки
		$(".checkout-states-block__delivery input").change(function () {
			let target = $(this);

			if (target.prop("id") === "checkout-delivery-1") {
				$(".delivery-form-block_pickup").css("display", "none");
				$(".delivery-form-block_courier").fadeIn(500);
			}

			if (target.prop("id") === "checkout-delivery-2") {
				$(".delivery-form-block_courier").css("display", "none");
				$(".delivery-form-block_pickup").fadeIn(500);

				// Убрать форму доставки самовывоз при выбранном способе оплаты курьером:
				if ($("#checkout-payment-2").prop("checked")) {
					$(".delivery-form-block_pickup").css("display", "none");
				}
			}
		})
	}

	//banners slider
	if ($(".js-banners-slider").length) {
		var bannersSwiper = new Swiper('.js-banners-slider', {
			speed: 1200,
			spaceBetween: 0,
			slidesPerView: 1,
			followFinger: false,
			effect: "fade",
			fadeEffect: {
				crossFade: true
			},
			autoplay: {
				delay: 3000,
			},
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},
			//loop: true,
			//loopedSlides: 3,
			pagination: {
				el: '.js-banners-slider .swiper-pagination',
				type: 'bullets',
				bulletElement: 'button',
				clickable: true,
			},
			on: {
				resize: function () {
					bannersSwiper.update();
				},
			}
		});
	}

	//collections slider
	/*if ($(".js-collections-slider").length) {
		var collectionsSwiper = new Swiper('.js-collections-slider', {
			speed: 1200,
			spaceBetween: 0,
			slidesPerView: 1,
			followFinger: false,
			watchSlidesProgress: true,
			watchSlidesVisibility: true,
			loop: true,
			loopedSlides: 4,
			pagination: false,
			navigation: {
				nextEl: '.section_collections .swiper-button-next',
				prevEl: '.section_collections .swiper-button-prev',
			},
			breakpoints: {
				576: {
					slidesPerView: 2,
				},
				1025: {
					slidesPerView: 3,
				},
				1200: {
					slidesPerView: 4,
				}
			},
			on: {
				resize: function () {
					collectionsSwiper.update();
				},
			}
		});
	}*/

	//blog slider
	/*if ($(".js-blog-slider").length) {
		var blogSwiper = new Swiper('.js-blog-slider', {
			speed: 1200,
			spaceBetween: 0,
			slidesPerView: 1,
			followFinger: false,
			watchSlidesProgress: true,
			watchSlidesVisibility: true,
			loop: true,
			loopedSlides: 3,
			pagination: false,
			navigation: {
				nextEl: '.section_blog .swiper-button-next',
				prevEl: '.section_blog .swiper-button-prev',
			},
			breakpoints: {
				576: {
					slidesPerView: 2,
				},
				1200: {
					slidesPerView: 3,
				}
			},
			on: {
				resize: function () {
					blogSwiper.update();
				},
			}
		});
	}*/

	//brands slider
	if ($(".js-brands-slider").length) {
		var brandsSwiper = new Swiper('.js-brands-slider', {
			speed: 1200,
			spaceBetween: 0,
			slidesPerView: 1,
			followFinger: false,
			watchSlidesProgress: true,
			watchSlidesVisibility: true,
			autoplay: {
				delay: 3000,
			},
			loop: true,
			loopedSlides: 1,
			pagination: false,
			navigation: {
				nextEl: '.section_brands .swiper-button-next',
				prevEl: '.section_brands .swiper-button-prev',
			},
			breakpoints: {
				576: {
					slidesPerView: 2,
				},
				768: {
					slidesPerView: 3,
				},
				1025: {
					slidesPerView: 4,
				},
				1200: {
					slidesPerView: 5,
				},
				1550: {
					slidesPerView: 6,
				}
			},
			on: {
				resize: function () {
					brandsSwiper.update();
				},
			}
		});
	}

	//recomendation slider
	if ($(".js-rec-slider").length) {
		var rs = [];

		$(".js-rec-slider").each(function (index) {

			var recSwiper = new Swiper('.js-rec-slider', {
				speed: 1200,
				spaceBetween: 0,
				slidesPerView: 1,
				slidesPerColumn: 1,
				followFinger: false,
				watchSlidesProgress: true,
				watchSlidesVisibility: true,
				pagination: false,
				navigation: {
					nextEl: '.swiper-button-next',
					prevEl: '.swiper-button-prev',
				},
				breakpoints: {
					576: {
						sslidesPerView: 2,
						slidesPerColumn: 1,
					},
					768: {
						slidesPerView: 1,
						slidesPerColumn: 1,
					},
					1025: {
						slidesPerView: 2,
						slidesPerColumn: 2,
					},
					1200: {
						slidesPerView: 3,
						slidesPerColumn: 2,
					}
				},
				on: {
					init: function () {
						rs.push(this);
					},
					resize: function () {
						var tabId = $(".js-rec-tab.active").attr("href");
						var tabIndex = $(".js-rec-tab.active").parent("li").index();
						var tabSlider = rs[tabIndex];
						tabSlider.update();
					},
				}
			});

		});

		$('.js-rec-tab').on('shown.bs.tab', function (e) {
			var tabId = $(e.target).attr("href");
			var tabIndex = $(e.target).parent("li").index();
			var tabSlider = rs[tabIndex];
			tabSlider.update();
		})
	}


	if ($('.js-product-buy-slider').length) {
		$(".js-product-buy-slider").each(function (index) {

			var $slider = $(this);

			var productBuySwiper = new Swiper($slider, {
				speed: 1200,
				spaceBetween: 0,
				slidesPerView: 1,
				followFinger: false,
				watchSlidesProgress: true,
				watchSlidesVisibility: true,
				pagination: false,
				navigation: {
					nextEl: $slider.parents(".section").find(".swiper-button-next"),
					prevEl: $slider.parents(".section").find(".swiper-button-prev")
				},
				breakpoints: {
					576: {
						slidesPerView: 2,
					},
					1025: {
						slidesPerView: 3,
					},
					1200: {
						slidesPerView: 4,
					},
					1550: {
						slidesPerView: 5,
					}
				},
				on: {
					resize: function () {
						productBuySwiper.update();
					},
				}
			});

		});

	}

	if ($('.js-elements-slider').length) {
		$(".js-elements-slider").each(function (index) {

			var $slider = $(this);

			var productElementsSwiper = new Swiper($slider, {
				speed: 1200,
				spaceBetween: 1,
				slidesPerView: 1,
				followFinger: false,
				watchOverflow: true,
				watchSlidesProgress: true,
				watchSlidesVisibility: true,
				pagination: false,
				navigation: {
					nextEl: $slider.parents(".section").find(".swiper-button-next"),
					prevEl: $slider.parents(".section").find(".swiper-button-prev")
				},
				breakpoints: {
					576: {
						slidesPerView: 2,
					},
					1025: {
						slidesPerView: 3,
					},
					1200: {
						slidesPerView: 4,
					},
					1550: {
						slidesPerView: 5,
					}
				},
				on: {
					resize: function () {
						productElementsSwiper.update();
					},
				}
			});

		});

	}

	if ($('.js-product-order-slider').length) {

		var productOrderSwiper = new Swiper('.js-product-order-slider', {
			speed: 1200,
			spaceBetween: 0,
			slidesPerView: 1,
			followFinger: false,
			watchSlidesProgress: true,
			watchSlidesVisibility: true,
			pagination: false,
			navigation: {
				nextEl: '.section_slider-order .swiper-button-next',
				prevEl: '.section_slider-order .swiper-button-prev',
			},
			breakpoints: {
				576: {
					slidesPerView: 2,
				},
				1025: {
					slidesPerView: 3,
				},
				1200: {
					slidesPerView: 4,
				},
				1550: {
					slidesPerView: 5,
				}
			},
			on: {
				resize: function () {
					productOrderSwiper.update();
				},
			}
		});

	}

	//interior slider
	/*if ($(".js-interior-slider").length) {

		var interiorSlider = new Swiper('.js-interior-slider', {
			speed: 1200,
			spaceBetween: 0,
			slidesPerView: 1,
			width: 280,
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},
			breakpoints: {
				1550: {
					width: 320,
				}
			},
		})

		let interiorSliderJs = document.querySelector('.js-interior-slider').swiper;

		let markers = document.querySelectorAll('.slider-marker');

		let arrMarkers = Array.from(markers);

		arrMarkers.forEach((marker, markerIndex) => {

			marker.addEventListener('click', function () {
				arrMarkers.forEach(marker => {
					marker.classList.remove('active');
				})

				arrMarkers[markerIndex].classList.add('active');
				interiorSliderJs.slideTo(markerIndex);
			})
		})

		interiorSliderJs.on('slideChangeTransitionEnd', function () {
			arrMarkers.forEach(marker => {
				marker.classList.remove('active');
			});
			arrMarkers[interiorSliderJs.activeIndex].classList.add('active');
		})

		interiorSliderJs.on('resize', function () {
			interiorSliderJs.update();
		})
	}*/

	//complect slider
	if ($(".js-complect-slider").length) {
		$(".js-complect-slider").each(function () {
			var $slider = $(this);

			complectSwiper = new Swiper($slider, {
				speed: 1200,
				spaceBetween: 0,
				slidesPerView: 1,
				watchOverflow: true,
				observer: true,
				pagination: false,
				effect: "fade",
				fadeEffect: {
					crossFade: true
				},
				allowTouchMove: false,
				navigation: {
					nextEl: $slider.find('.js-complect-slider-nav .swiper-button-next'),
					prevEl: $slider.find('.js-complect-slider-nav .swiper-button-prev')
				},
			});
		});
	}

	//collection previews slider
	if ($(".js-collection-previews").length) {
		var collectionPreviewsSwiper = new Swiper('.js-collection-previews', {
			speed: 1200,
			autoplay: 5000,
			spaceBetween: 1,
			slidesPerView: 3,
			followFinger: false,
			centerInsufficientSlides: true,
			watchSlidesProgress: true,
			watchSlidesVisibility: true,
			pagination: false,
			navigation: {
				nextEl: '.collection .swiper-button-next',
				prevEl: '.collection .swiper-button-prev',
			},
			breakpoints: {
				576: {
					slidesPerView: 4,
					centerInsufficientSlides: true,
				},
				768: {
					slidesPerView: 6,
					centerInsufficientSlides: true,
				},
				1200: {
					slidesPerView: 4,
					centerInsufficientSlides: true,
				},
				1550: {
					slidesPerView: 5,
					centerInsufficientSlides: true,
				}
			},
		});
	}

	//pagination
	if ($(".js-pagination-opener").length) {
		$(".js-pagination-opener").unbind().on('click', function (e) {
			e.preventDefault();

			$(this).parents(".pagination").addClass("pagination_opened");

		});
	}
	if ($(".js-pagination-closer").length) {
		$(".js-pagination-closer").unbind().on('click', function (e) {
			e.preventDefault();

			$(this).parents(".pagination").removeClass("pagination_opened");

		});
	}

	//alphabet pagination
	if ($(".js-pagination-alphabet-opener").length) {
		$(".js-pagination-alphabet-opener").unbind().on('click', function (e) {
			e.preventDefault();

			$(this).parents(".pagination").addClass("pagination_opened");

			$(".js-pagination-alphabet-nav").addClass("pagination_index-opened");

		});
	}
	if ($(".js-pagination-alphabet-closer").length) {
		$(".js-pagination-alphabet-closer").unbind().on('click', function (e) {
			e.preventDefault();

			$(this).parents(".pagination").removeClass("pagination_opened");

			$(".js-pagination-alphabet-nav").removeClass("pagination_index-opened");
		});
	}

	// modal show delivery clause
	if ($(".js-delivery-clause").length) {
		$(".js-delivery-clause").unbind().on('click', function (e) {
			e.preventDefault();

			$("#modal-delivery-clause").modal("show");
		});
	}

	// modal show profile history
	if ($(".js-profile-history1").length) {
		$(".js-profile-history1").unbind().on('click', function (e) {
			e.preventDefault();

			$("#modal-profile-history1").modal("show");
		});
	}

	//modal preorder
	if ($(".js-to-preorder:not(.active)").length) {
		$(".js-to-preorder:not(.active)").unbind().on('click', function (e) {
			e.preventDefault();

			var btn = $(this);
			$("#modal-preorder").modal("show");
		});
	}

	//modal cheaper
	if ($(".js-find-cheaper").length) {
		$(".js-find-cheaper").unbind().on('click', function (e) {
			e.preventDefault();

			var btn = $(this);
			$("#modal-cheaper").modal("show");
		});
	}

	//modal cheaper
	if ($(".js-to-notify").length) {
		$(".js-to-notify").unbind().on('click', function (e) {
			e.preventDefault();

			var btn = $(this);
			$("#modal-notify").modal("show");
		});
	}

	//popovers
	if ($('[data-toggle="popover"]').length) {
		$('[data-toggle="popover"]').popover();
	}

	// Закрытие popover по клику на документ
	$('html').on('click', function (e) {
		if (typeof $(e.target).data('original-title') == 'undefined' && !$(e.target).parents().is('.popover')) {
			$('[data-original-title]').popover('hide');
		}
	});

	//counters
	if ($('.js-btn-minus').length || $('.js-btn-plus').length) {
		$('.js-btn-minus').unbind().on("click", function (e) {
			e.preventDefault();
			var input = $(this).siblings(".form-control");
			var value = parseInt(input.val());

			if (value >= 2) {
				input.val(value - 1);
			}
		});

		$('.js-btn-plus').unbind().on("click", function (e) {
			e.preventDefault();
			var input = $(this).siblings(".form-control");
			var value = parseInt(input.val());

			input.val(value + 1);
		});

		$(".js-btn-minus, .js-btn-plus").on("mouseup", function () {
			$(this).blur();
		});
	}

	//slider on product page
	if ($('.product-block__slider').length) {
		var galleryThumbs = new Swiper('.js-product-slider-thumbs', {
			spaceBetween: 1,
			slidesPerView: 7,
			navigation: false,
			pagination: false,
			watchSlidesVisibility: true,
			watchSlidesProgress: true,
			//observer: true,
			watchOverflow: true,
			preventClicks: false,
			preventClicksPropagation: false,
			slideToClickedSlide: false,

		});
		var galleryTop = new Swiper('.js-product-slider-main', {
			spaceBetween: 0,
			navigation: false,
			slidesPerView: 1,
			navigation: false,
			pagination: false,
			effect: "fade",
			fadeEffect: {
				crossFade: true
			},
		});

		galleryTop.on('slideChange', function () {
			var indxMain = galleryTop.activeIndex;
			galleryThumbs.slideTo(indxMain);

			$('.js-product-slider-thumbs').find(".swiper-slide").removeClass("swiper-slide-active");
			$('.js-product-slider-thumbs').find(".swiper-slide").eq(indxMain).addClass("swiper-slide-active");
		});

		galleryThumbs.on('click', function () {
			var indxThumb = $(galleryThumbs.clickedSlide).index();
			galleryTop.slideTo(indxThumb);
			galleryThumbs.slideTo(indxThumb);

			$('.js-product-slider-thumbs').find(".swiper-slide").removeClass("swiper-slide-active");
			$('.js-product-slider-thumbs').find(".swiper-slide").eq(indxThumb).addClass("swiper-slide-active");
		});
	}

	if ($(".js-lightbox-gallery").length) {
		$('.js-lightbox-gallery').lightcase({
			transition: 'elastic',
			showSequenceInfo: false,
			showTitle: false,
			maxWidth: "100%",
			maxHeight: 1000,
			slideshowAutoStart: false,
			timeout: 3500,
			swipe: true,
		});
	}

	//product timer (and promotion-inner timer)
	if ($(".timer").length) {

		$(".timer").each(function (index) {
			var elem = $(this);
			var time = elem.attr("data-finish");
			timer(time, elem);
		});

	}

	//slider in block Together and Package
	if ($(".js-slider-attached-product").length) {
		$(".js-slider-attached-product").each(function () {
			var $slider = $(this);

			if (!!customSwiper) {
				customSwiper.update();
			} else {
				var customSwiper = new Swiper($slider, {
					spaceBetween: 0,
					slidesPerView: 1,
					watchOverflow: true,
					observer: true,
					watchSlidesProgress: true,
					watchSlidesVisibility: true,
					effect: "flip",
					pagination: false,
					navigation: {
						nextEl: $slider.parent().find(".swiper-button-next"),
						prevEl: $slider.parent().find(".swiper-button-prev")
					},
					flipEffect: {
						rotate: 30,
						slideShadows: false,
					},
					on: {
						resize: function () {
							customSwiper.update();
						}
					}
				});
			}
		});
	}

	// slider on map-shops page
	if ($('.shop-block__slider').length) {
		var galleryThumbs = new Swiper('.js-shop-slider-thumbs', {
			spaceBetween: 1,
			slidesPerView: 4,
			navigation: false,
			pagination: false,
			watchSlidesVisibility: true,
			watchSlidesProgress: true,
		});
		var galleryTop = new Swiper('.js-shop-slider-main', {
			spaceBetween: 0,
			navigation: false,
			slidesPerView: 1,
			navigation: false,
			pagination: false,
			effect: "fade",
			fadeEffect: {
				crossFade: true
			},
		});

		galleryTop.on('slideChange', function () {
			var indxMain = galleryTop.activeIndex;
			galleryThumbs.slideTo(indxMain);

			$('.js-shop-slider-thumbs').find(".swiper-slide").removeClass("swiper-slide-active");
			$('.js-shop-slider-thumbs').find(".swiper-slide").eq(indxMain).addClass("swiper-slide-active");
		});

		galleryThumbs.on('click', function () {
			var indxThumb = $(galleryThumbs.clickedSlide).index();
			galleryTop.slideTo(indxThumb);
			galleryThumbs.slideTo(indxThumb);

			$('.js-shop-slider-thumbs').find(".swiper-slide").removeClass("swiper-slide-active");
			$('.js-shop-slider-thumbs').find(".swiper-slide").eq(indxThumb).addClass("swiper-slide-active");
		});
	}

	if ($(".js-lightbox-shop").length) {
		$('.js-lightbox-shop').lightcase({
			transition: 'elastic',
			showSequenceInfo: false,
			showTitle: false,
			maxWidth: "100%",
			maxHeight: 1000,
			slideshowAutoStart: false,
			timeout: 3500,
			swipe: true,
		});
	}

	// promotions-inner selectors
	if ($(".js-example-classic-single").length) {
		$('.js-example-classic-single').select2({
			width: '100%',
			theme: 'classic',
			placeholder: function () {
				$(this).data('placeholder');
			}
		})

		$('.category').on('change', function () {
			$('.category_1').prop('disabled', false);
			$('.select-wrapper_category_1').css({ "color": "#9FA5B9" });
		})

		$('.category_1').on('change', function () {
			$('.category_2').prop('disabled', false);
			$('.select-wrapper_category_2').css({ "color": "#9FA5B9" });
		})
	}

	//закрытие бокса с подтверждением	email/tel
	if ($('.js-btn-cancel-confirm').length > 0) {
		$('.js-btn-cancel-confirm').click(function (e) {
			e.preventDefault();

			$(this).closest('.confirm-box').removeClass('opened');
		});
	}

	//открытие бокса с подтверждением email/tel
	if ($('.js-data-verified').length > 0) {
		$('.js-data-verified').click(function (e) {
			e.preventDefault();

			if ($('.confirm-box').hasClass('opened')) {
				$('.confirm-box').toggleClass('opened');
				return;
			}

			if ($(this).attr('data-target') === 'email') {
				$('.confirm-box_email').addClass('opened');
			}
			else {
				$('.confirm-box_tel').addClass('opened');
			}
		});
	}

	//открытие бокса редактирования адресов (добавление)
	if ($('.js-open-form-edit').length > 0) {
		$('.js-open-form-edit').click(function (e) {
			e.preventDefault();

			$('.edit-address-box').addClass('opened');
		});
	}

	//открытие бокса редактирования адресов (редактирование)
	if ($('.js-edit-address').length > 0) {
		$('.js-edit-address').click(function (e) {
			e.preventDefault();

			$('.edit-address-box').addClass('opened');

			let indItem = $(this).closest('.list-addresses__item').index();

			arValue = pullDataAddress(indItem);

			$('.edit-address-box').find(".form-control").each(function (i, e) {
				e.value = arValue[i];
			})
		});
	}

	//открытие бокса редактирования адресов (редактирование)
	if ($('.js-add-address').length > 0) {
		$('.js-add-address').click(function (e) {
			e.preventDefault();

			let dataValue = [];

			$(this).closest('.edit-address-box__form').find('.form-control').each(function (i, e) {
				dataValue[i] = e.value;
			});

			strFullAddress = dataValue.join(", ");

			console.log($(".list-addresses").append(generateAddressItem(strFullAddress)));
		});
	}

	//закрытие бокса редактирования адресов
	if ($('.js-cancel-address').length > 0) {
		$('.js-cancel-address').click(function (e) {
			e.preventDefault();

			$('.edit-address-box').removeClass('opened');

			setTimeout(() => {
				$('.edit-address-box').find(".form-control").each(function (i, e) {
					e.value = '';
				})
			}, 300)
		});
	}

	//удаление адреса
	if ($('.js-remove-address').length > 0) {
		$('.js-remove-address').click(function (e) {
			e.preventDefault();

			console.log($(this).closest('.list-addresses__item').remove());
		});
	}

	resizeDependent();

	$(window).resize(function () {
		resizeDependent();
	});

	$(window).scroll(function () {
		stickyFilter();
	});

	//Preloader
	$('body').removeClass('preloader-show');
	$(".preloader").fadeOut(600);
});

function pullDataAddress(ind) {
	let dataValue = [];
	$('.list-addresses__item').eq(ind).find('.list-addresses__hidden-data .data-hdn').each(function (i, e) {
		dataValue[i] = e.value;
	});

	return dataValue;
}

function resizeDependent() {
	var widthWndw = $(window).width();
	$(".preloader").width(widthWndw);

	//mobile menu open
	if ($(".js-menu-panel-opener").length) {
		$(".js-menu-panel-opener").unbind().on('click', function (e) {
			e.preventDefault();

			$("body").removeClass('search-panel-opened').addClass('menu-panel-opened');

			if ($(".mobile-nav .drilldown").length) {
				$('.mobile-nav .drilldown').drilldown();
			}

		});
	}

	//mobile menu close
	if ($(".js-menu-panel-closer").length) {
		$(".js-menu-panel-closer").unbind().on('click', function (e) {
			e.preventDefault();

			$("body").removeClass('menu-panel-opened');

		});
	}

	//mobile search-panel open
	if ($(".js-search-panel-opener").length) {
		$(".js-search-panel-opener").unbind().on('click', function (e) {
			e.preventDefault();

			$("body").removeClass('menu-panel-opened').addClass('search-panel-opened');

		});
	}

	//mobile search-panel close
	if ($(".js-search-panel-closer").length) {
		$(".js-search-panel-closer").unbind().on('click', function (e) {
			e.preventDefault();

			$("body").removeClass('search-panel-opened');

		});
	}

	//mobile search
	if ($('.panel_search .header__search').length) {

		$('.panel_search .header__search .form-control').on("input", function (e) {
			var searchField = $(this);

			// searchAjaxRequest(searchField);
		});
	}


	//mobile filter-panel open
	if ($(".js-filter-panel-opener").length) {
		$(".js-filter-panel-opener").unbind().on('click', function (e) {
			e.preventDefault();

			$("body").addClass('filter-panel-opened');

		});
	}

	//mobile filter-panel close
	if ($(".js-filter-panel-closer").length) {
		$(".js-filter-panel-closer").unbind().on('click', function (e) {
			e.preventDefault();

			$("body").removeClass('filter-panel-opened');

		});
	}

	//mobile categories-panel open
	if ($(".js-categories-panel-opener").length) {
		$(".js-categories-panel-opener").unbind().on('click', function (e) {
			e.preventDefault();

			$("#categories-menu").collapse("show");

		});
	}

	//mobile categories-panel close
	if ($(".js-categories-panel-closer").length) {
		$(".js-categories-panel-closer").unbind().on('click', function (e) {
			e.preventDefault();

			$("#categories-menu").collapse("hide");

		});
	}

	stickyFilter();
	stickyNav();

}

//search ajax request
function searchAjaxRequest(input) {
	var searchField = input;

	if (xhr) {
		// Abort previous AJAX request.
		xhr.abort();
	}

	if (searchField.val() && searchField.val().length > 2) {
		// YOUR AJAX REQUEST HERE.
		xhr = $.ajax({
			url: 'suggestions.html',
			beforeSend: function () {
				searchField.parents(".header__search").find(".btn_loader").addClass("btn_loader_show");
			},
			success: function (data) {
				xhr = null;
				searchField.parents(".header__search").find(".results-panel__results").html(data);
				searchField.parents(".header__search").find(".btn_loader").removeClass("btn_loader_show");
			},
			error: function (data) {
				searchField.parents(".header__search").find(".results-panel__results").html("<div class='results-panel__category'>" + __('No results were found for this request') + "</div>");
				searchField.parents(".header__search").find(".btn_loader").removeClass("btn_loader_show");
			},
		});
	} else {
		// Remove suggestions.
		searchField.parents(".header__search").find(".results-panel__results").html("<div class='results-panel__category'>" + __('No results were found for this request') + "</div>");
		searchField.parents(".header__search").find(".btn_loader").removeClass("btn_loader_show");
	}
}

//fixed filters block on desktop
var stickyFilter = function () {
	if ($(".filter-panel__footer").length && $(window).width() > 1024) {

		var $filter_form = $('.filter-panel');

		var $sticky_panel = $('.filter-panel__footer');

		var body = document.body;
		var docElem = document.documentElement;
		var scrollBottom = $(window).height() + (window.pageYOffset || docElem.scrollTop || body.scrollTop) //высота окна + scrollTop

		var filterTop = $filter_form.offset().top; //верхняя точка фильтра
		var filterBottom = filterTop + $filter_form.innerHeight(); //нижняя точка фильтра

		if (scrollBottom > filterBottom || scrollBottom < filterTop + 160) {
			$sticky_panel.removeClass('fixed');
		}
		else {
			$sticky_panel.addClass('fixed');
		}
	} else if ($(".filter-panel__footer").length) {
		$(".filter-panel__footer").removeClass('fixed');
	}
}

//fixed filters block on desktop
var stickyNav = function () {
	if ($(".section_catalog .easy-nav").length) {
		var $container = $('.section_catalog .section__body');

		var $sticky_nav = $('.section_catalog .easy-nav');

		var containerTop = $container.offset().top; //верхняя точка контейнера
		var containerBottom = containerTop + $container.outerHeight(); //нижняя точка контейнера

		var body = document.body;
		var docElem = document.documentElement;

		$(window).on("scroll", function (e) {
			var scrollTop = (window.pageYOffset || docElem.scrollTop || body.scrollTop); // scrollTop

			if (scrollTop > $container.outerHeight() || scrollTop < containerTop + $sticky_nav.position().top) {
				$sticky_nav.removeClass('sticky');
			}
			else {
				$sticky_nav.addClass('sticky');
			}
		});
	}
}

//calc timer
function timer(f_time, f_timer) {
	function timer_go() {
		var n_time = Date.now();
		var diff = f_time - n_time;
		if (diff <= 0) return false;
		var left = diff % 1000;

		//секунды
		diff = parseInt(diff / 1000);
		var s = diff % 60;

		//минуты
		diff = parseInt(diff / 60);
		var m = diff % 60;
		if (m < 10) {
			f_timer.find(".minutes_1").html(0);
			f_timer.find(".minutes_2").html(m);
		} else {
			f_timer.find(".minutes_1").html(parseInt(m / 10));
			f_timer.find(".minutes_2").html(m % 10);
		}
		//часы
		diff = parseInt(diff / 60);
		var h = diff % 24;
		if (h < 10) {
			f_timer.find(".hours_1").html(0);
			f_timer.find(".hours_2").html(h);
		} else {
			f_timer.find(".hours_1").html(parseInt(h / 10));
			f_timer.find(".hours_2").html(h % 10);
		}
		//дни
		var d = parseInt(diff / 24);
		if (d < 10) {
			f_timer.find(".days_1").html(0);
			f_timer.find(".days_2").html(d);
		} else {
			f_timer.find(".days_1").html(parseInt(d / 10));
			f_timer.find(".days_2").html(d % 10);
		}
		setTimeout(timer_go, left);
	}
	setTimeout(timer_go, 0);
}


// init map
function initMap() {

	if ($(".js-map").length) {
		$(".js-map").each(function () {

			var mapId = $(this).attr("id");
			var mapLat = parseFloat($(this).attr("data-map-lat"));
			var mapLng = parseFloat($(this).attr("data-map-lng"));

			// Leaflet map
			var lmap = L.map(mapId, {
				scrollWheelZoom: false,
				zoomControl: false
			}).setView([mapLat, mapLng], 13);

			// Тайлы (уже подключены те что необходимы)
			L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
				maxZoom: 19,
				attribution: '&copy; <a href="https://www.openstreetmap.org/copyright" target="_blank" rel="noindex">OpenStreetMap</a> contributors',
			})
				.addTo(lmap);


			// Добавляет кстомную картинку для иконки маркера
			var svgIcon = L.icon({
				iconUrl: '../images/svg/icon-maps-flag.svg',
				iconSize: [40, 40],
				iconAnchor: [20, -10]
			});

            let markerPos = [];

            $('.shop-pin').each((index, item) => {
                markerPos.push([
                    $(item).text(),
                    $(item).attr('data-lat'),
                    $(item).attr('data-lng'),
                ]);
            });

			markerPos.forEach(item => {
				let marker = L.marker([item[1], item[2]], { icon: svgIcon })
					.addTo(lmap);

				marker.bindPopup(item[0]);
			});

			// Если необходимо добавить кастомную иконку маркера
			// Добавляет div.pulse

			// var pulseAnimation = L.divIcon({ className: 'pulse' });
			// L.marker([mapLat, mapLng], { icon: pulseAnimation })
			// 	.addTo(lmap);


			if ($(".js-zoom-map").length) {
				$(".js-zoom-map").on('click', function (e) {
					e.preventDefault();

					let addr = $(this);
					let lat = parseFloat(addr.data("lat"));
					let lng = parseFloat(addr.data("lng"));

					let distanceTop = $("#" + mapId).offset().top - 60;
					$("body,html").animate({ scrollTop: distanceTop }, 600);

					lmap.flyTo([lat, lng], 13);

				});
			}

		});
	}

}
