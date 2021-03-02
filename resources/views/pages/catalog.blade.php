@extends('layouts.main')

@section('content')

    <main class="main-content" id="main-content">
        <section class="section section_inner-page section_catalog">
            <div class="section__header">
                <div class="container">
                    <div class="section__breadcrumbs">
                        <ul class="list list_unstyled breadcrumbs-list">
                            <li class="list__item"><a class="link" href="javascript: void(0);">Главная</a></li>
                            <li class="list__item"><a class="link active" href="javascript: void(0);">Каталог</a></li>
                        </ul>
                    </div>
                    <div class="section__title section__title_style1">
                        <h1>Каталог</h1>
                    </div>
                </div>
            </div>
            <div class="section__body">
                <div class="container">
                    <div class="easy-nav bg_white">
                        <ul class="list list_unstyled easy-nav__list">
                            <li class="list__item"><a class="btn btn_light link js-scroll-link" href="#category-tile" aria-label="Плитка"><svg role="img" aria-hidden="true" width="30" height="30"><use xlink:href="#svg-icon-tile"></use></svg></a></li>
                            <li class="list__item"><a class="btn btn_light link js-scroll-link" href="#category-tap" aria-label="Сантехника"><svg role="img" aria-hidden="true" width="30" height="30"><use xlink:href="#svg-icon-tap"></use></svg></a></li>
                            <li class="list__item"><a class="btn btn_light link js-scroll-link" href="#category-nightstand" aria-label="Мебель для ванной комнаты"><svg role="img" aria-hidden="true" width="30" height="30"><use xlink:href="#svg-icon-nightstand"></use></svg></a></li>
                            <li class="list__item"><a class="btn btn_light link js-scroll-link" href="#category-radiator" aria-label="Водоснабжение и отопление"><svg role="img" aria-hidden="true" width="30" height="30"><use xlink:href="#svg-icon-radiator"></use></svg></a></li>
                            <li class="list__item"><a class="btn btn_light link js-scroll-link" href="#category-drop" aria-label="Вода и водоочистка"><svg role="img" aria-hidden="true" width="30" height="30"><use xlink:href="#svg-icon-drop"></use></svg></a></li>
                            <li class="list__item"><a class="btn btn_light link js-scroll-link" href="#category-kitchen" aria-label="Мебель для кухни"><svg role="img" aria-hidden="true" width="30" height="30"><use xlink:href="#svg-icon-kitchen"></use></svg></a></li>
                            <li class="list__item"><a class="btn btn_light link js-scroll-link" href="#category-conditioner" aria-label="Кондиционирование"><svg role="img" aria-hidden="true" width="30" height="30"><use xlink:href="#svg-icon-conditioner"></use></svg></a></li>
                            <li class="list__item"><a class="btn btn_light link js-scroll-link" href="#category-electric" aria-label="Освещение"><svg role="img" aria-hidden="true" width="30" height="30"><use xlink:href="#svg-icon-electric"></use></svg></a></li>
                            <li class="list__item"><a class="btn btn_light link js-scroll-link" href="#category-clining" aria-label="Клининг"><svg role="img" aria-hidden="true" width="30" height="30"><use xlink:href="#svg-icon-clining"></use></svg></a></li>
                            <li class="list__item"><a class="btn btn_light link js-scroll-link" href="#category-wrench" aria-label="Инструмент"><svg role="img" aria-hidden="true" width="30" height="30"><use xlink:href="#svg-icon-wrench"></use></svg></a></li>
                        </ul>
                    </div>
                    <div class="category-block category-block_main" id="category-tile">
                        <div class="row no-gutters">
                            <div class="col-12 col-lg-5"><a class="link category-block__header category-block__header_brown" href="javascript: void(0);" aria-label="Плитка">
                                    <div class="link__bg" aria-hidden="true" style="background-image: url('images/content/categories/category-img-1.png');"></div>

                                    <div class="link__content">
                                        <span class="link__icon" aria-hidden="true"><svg role="img" aria-hidden="true" width="30" height="30">
                                                <use xlink:href="#svg-icon-tile"></use>
                                            </svg>
                                        </span>

                                        <h2 class="link__text">
                                            <span class="line">Плитка</span>
                                        </h2>

                                        <span class="link__control" aria-hidden="true">
                                            <svg role="img" aria-hidden="true" width="20" height="20">
                                                <use xlink:href="#svg-icon-down-arrow"></use>
                                            </svg>
                                        </span>
                                    </div>
                                </a>
                            </div>

                            <div class="col-12 col-lg-7">
                                <div class="row no-gutters">
                                    <div class="col-12 col-md-4">
                                        <div class="rec-block rec-block_new">
                                            <div class="rec-block__content d-none d-md-block">
                                                <div class="rec-block__header">
                                                    <a class="rec-block__img" href="javascript: void(0);">
                                                        <img src="images/content/products/product-img-2.jpg" alt="Изображение продукта">
                                                    </a>
                                                    <ul class="list list_unstyled rec-block__marks marks-list">
                                                        <li class="list__item bg_blue">Новинка</li>
                                                    </ul>
                                                </div>

                                                <div class="rec-block__body">
                                                    <a class="rec-block__title" href="javascript: void(0);">Blome Дозатор для жидкого мыла 889</a>
                                                    <div class="rec-block__price">
                                                        <span class="cost">567</span>

                                                        <span class="currency">лей / шт</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="rec-block__footer">
                                                <a class="link rec-block__link" href="javascript:void(0);">
                                                    <span class="link__text">Новинки</span>

                                                    <span class="link__control" aria-hidden="true">
                                                        <svg role="img" aria-hidden="true" width="20" height="20">
                                                            <use xlink:href="#svg-icon-down-arrow"></use>
                                                        </svg>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <div class="rec-block rec-block_sale">
                                            <div class="rec-block__content d-none d-md-block">
                                                <div class="rec-block__header">
                                                    <a class="rec-block__img" href="javascript: void(0);">
                                                        <img src="images/content/products/product-img-3.jpg" alt="Изображение продукта"></a>
                                                    <ul class="list list_unstyled rec-block__marks marks-list">
                                                        <li class="list__item list__item_num bg_red">25%</li>
                                                    </ul>
                                                </div>

                                                <div class="rec-block__body">
                                                    <a class="rec-block__title" href="javascript: void(0);">Blome Дозатор для жидкого мыла 889</a>
                                                    <div class="rec-block__price">
                                                        <span class="cost">567</span>
                                                        <span class="currency">лей / шт</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="rec-block__footer">
                                                <a class="link rec-block__link" href="javascript:void(0);">
                                                    <span class="link__text">Акции</span>

                                                    <span class="link__control" aria-hidden="true">
                                                        <svg role="img" aria-hidden="true" width="20" height="20">
                                                            <use xlink:href="#svg-icon-down-arrow"></use>
                                                        </svg>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="rec-block rec-block_brand">
                                            <div class="rec-block__content d-none d-md-block">
                                                <div class="swiper-container js-slider-attached-product">
                                                    <div class="swiper-wrapper">
                                                        <div class="swiper-slide">
                                                            <a class="rec-block__brand" href="javascript: void(0);" aria-label="Перейти к бренду Roca">
                                                                <img src="images/content/brands/brand-img-1.png" alt="Roca">
                                                            </a>
                                                        </div>

                                                        <div class="swiper-slide">
                                                            <a class="rec-block__brand" href="javascript: void(0);" aria-label="Перейти к бренду Geberit">
                                                                <img class="brand-block__img" src="images/content/brands/brand-img-2.png" alt="Geberit">
                                                            </a>
                                                        </div>

                                                        <div class="swiper-slide">
                                                            <a class="rec-block__brand" href="javascript: void(0);" aria-label="Перейти к бренду Hansgrohe">
                                                                <img class="brand-block__img" src="images/content/brands/brand-img-3.png" alt="Hansgrohe">
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <button class="swiper-button-prev" type="button">
                                                        <svg role="img" aria-hidden="true" width="30" height="30">
                                                            <use xlink:href="#svg-icon-down-arrow"></use>
                                                        </svg>
                                                    </button>

                                                    <button class="swiper-button-next" type="button">
                                                        <svg role="img" aria-hidden="true" width="30" height="30">
                                                            <use xlink:href="#svg-icon-down-arrow"></use>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="rec-block__footer">
                                                <a class="link rec-block__link" href="javascript:void(0);">
                                                    <span class="link__text">Бренды</span>

                                                    <span class="link__control" aria-hidden="true">
                                                        <svg role="img" aria-hidden="true" width="20" height="20">
                                                            <use xlink:href="#svg-icon-down-arrow"></use>
                                                        </svg>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

@endsection
