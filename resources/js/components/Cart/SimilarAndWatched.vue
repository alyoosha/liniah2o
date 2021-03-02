<template>
    <section class="section section_sliders-in-tabs" id="sliders-in-tabs">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-10">
                    <div class="section__nav">
                        <div class="scrollbar-inner" role="tablist" aria-owns="popular-tab viewed-tab">
                            <ul class="list list_unstyled nav nav-tabs section__nav-list row no-gutters flex-nowrap">
                                <li class="col-auto list__item">
                                    <a class="link section__title active js-product-tab" id="popular-tab" href="#popular-products" data-toggle="tab" role="tab" aria-controls="popular-products" aria-selected="true">
                                        <h2>Популярные товары</h2>
                                    </a>
                                </li>
                                <li class="col-auto list__item">
                                    <a class="link section__title js-product-tab" id="viewed-tab" href="#viewed-products" data-toggle="tab" role="tab" aria-controls="viewed-products" aria-selected="false">
                                        <h2>Вы смотрели</h2>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="popular-products" role="tabpanel" aria-labelledby="popular-tab">
                    <div class="swiper-container js-product-slider">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="product-card" tabindex="0">
                                    <div class="product-card__content">
                                        <div class="product-card__header"><a class="product-card__img product-card__img_full" href="javascript: void(0);"><img src="images/content/products/product-img-11.jpg" alt="Изображение продукта"/></a><a class="product-card__brand" href="javascript: void(0);" aria-label="Перейти к бренду Roca"><img src="images/content/brands/brand-img-1.png" alt="Roca"/></a>
                                            <ul class="list list_unstyled product-card__marks marks-list">
                                                <li class="list__item list__item_num bg_red">25%</li>
                                            </ul>
                                        </div>
                                        <div class="product-card__body"><a class="product-card__title" href="javascript: void(0);">Мебель для ванны Albina Bamboo стандарт, угловая, белая</a>
                                            <div class="product-card__price"><span class="old">8 345</span><span class="cost cost_new">3 567</span><span class="currency">лей / шт</span></div>
                                        </div>
                                        <div class="product-card__footer">
                                            <div class="product-card__info">
                                                <div class="product-card__availability product-card__availability_true">В наличии</div>
                                                <div class="product-card__code">Артикул: 90858</div>
                                            </div>
                                            <div class="product-card__controls">
                                                <button class="btn product-card__btn product-card__btn_favorite js-to-favorite" type="button" aria-label="В избранное"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart-fill"></use></svg>
                                                </button>
                                                <button class="btn product-card__btn product-card__btn_cart active js-to-cart" type="button" aria-label="Добавлено в корзину. Отменить добавление"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop-added"></use></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="product-card" tabindex="0">
                                    <div class="product-card__content">
                                        <div class="product-card__header"><a class="product-card__img" href="javascript: void(0);"><img src="images/content/products/product-img-12.jpg" alt="Изображение продукта"/></a><a class="product-card__brand" href="javascript: void(0);" aria-label="Перейти к бренду Roca"><img src="images/content/brands/brand-img-1.png" alt="Roca"/></a>
                                            <ul class="list list_unstyled product-card__marks marks-list">
                                                <li class="list__item list__item_num bg_red">25%</li>
                                            </ul>
                                        </div>
                                        <div class="product-card__body"><a class="product-card__title" href="javascript: void(0);">Смеситель для раковины</a>
                                            <div class="product-card__price"><span class="old">1 345</span><span class="cost cost_new">867</span><span class="currency">лей / шт</span></div>
                                        </div>
                                        <div class="product-card__footer">
                                            <div class="product-card__info">
                                                <div class="product-card__availability product-card__availability_true">В наличии</div>
                                                <div class="product-card__code">Артикул: 90858</div>
                                            </div>
                                            <div class="product-card__controls">
                                                <button class="btn product-card__btn product-card__btn_favorite js-to-favorite" type="button" aria-label="В избранное"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart-fill"></use></svg>
                                                </button>
                                                <button class="btn product-card__btn product-card__btn_cart active js-to-cart" type="button" aria-label="Добавлено в корзину. Отменить добавление"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop-added"></use></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="product-card" tabindex="0">
                                    <div class="product-card__content">
                                        <div class="product-card__header"><a class="product-card__img" href="javascript: void(0);"><img src="images/content/products/product-img-3.jpg" alt="Изображение продукта"/></a><a class="product-card__brand" href="javascript: void(0);" aria-label="Перейти к бренду Geberit"><img src="images/content/brands/brand-img-2.png" alt="Geberit"/></a>
                                            <ul class="list list_unstyled product-card__marks marks-list">
                                                <li class="list__item bg_blue">Новинка</li>
                                            </ul>
                                        </div>
                                        <div class="product-card__body"><a class="product-card__title" href="javascript: void(0);">Blome Мыльница 892</a>
                                            <div class="product-card__price"><span class="cost">175</span><span class="currency">лей / шт</span></div>
                                        </div>
                                        <div class="product-card__footer">
                                            <div class="product-card__info">
                                                <div class="product-card__availability">Нет в наличии</div>
                                                <div class="product-card__code">Артикул: 90858</div>
                                            </div>
                                            <div class="product-card__controls">
                                                <button class="btn product-card__btn product-card__btn_favorite active js-to-favorite" type="button" aria-label="Добавлено в избранное. Отменить добавление"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart-fill"></use></svg>
                                                </button>
                                                <button class="btn product-card__btn product-card__btn_cart js-to-cart" type="button" aria-label="В корзину"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop-added"></use></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="product-card" tabindex="0">
                                    <div class="product-card__content">
                                        <div class="product-card__header"><a class="product-card__img" href="javascript: void(0);"><img src="images/content/products/product-img-1.jpg" alt="Изображение продукта"/></a><a class="product-card__brand" href="javascript: void(0);" aria-label="Перейти к бренду Roca"><img src="images/content/brands/brand-img-1.png" alt="Roca"/></a>
                                            <ul class="list list_unstyled product-card__marks marks-list">
                                                <li class="list__item list__item_num bg_red">25%</li>
                                            </ul>
                                        </div>
                                        <div class="product-card__body"><a class="product-card__title" href="javascript: void(0);">Blome Стакан для зубных щеток</a>
                                            <div class="product-card__price"><span class="cost">277</span><span class="currency">лей / шт</span></div>
                                        </div>
                                        <div class="product-card__footer">
                                            <div class="product-card__info">
                                                <div class="product-card__availability product-card__availability_true">В наличии</div>
                                                <div class="product-card__code">Артикул: 90858</div>
                                            </div>
                                            <div class="product-card__controls">
                                                <button class="btn product-card__btn product-card__btn_favorite js-to-favorite" type="button" aria-label="В избранное"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart-fill"></use></svg>
                                                </button>
                                                <button class="btn product-card__btn product-card__btn_cart js-to-cart" type="button" aria-label="В корзину"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop-added"></use></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="product-card" tabindex="0">
                                    <div class="product-card__content">
                                        <div class="product-card__header"><a class="product-card__img" href="javascript: void(0);"><img src="images/content/products/product-img-2.jpg" alt="Изображение продукта"/></a><a class="product-card__brand" href="javascript: void(0);" aria-label="Перейти к бренду Roca"><img src="images/content/brands/brand-img-1.png" alt="Roca"/></a>
                                            <ul class="list list_unstyled product-card__marks marks-list">
                                                <li class="list__item list__item_num bg_red">25%</li>
                                            </ul>
                                        </div>
                                        <div class="product-card__body"><a class="product-card__title" href="javascript: void(0);">Blome Дозатор для жидкого мыла 889</a>
                                            <div class="product-card__price"><span class="old">8 345</span><span class="cost cost_new">3 567</span><span class="currency">лей / шт</span></div>
                                        </div>
                                        <div class="product-card__footer">
                                            <div class="product-card__info">
                                                <div class="product-card__availability product-card__availability_true">В наличии</div>
                                                <div class="product-card__code">Артикул: 90858</div>
                                            </div>
                                            <div class="product-card__controls">
                                                <button class="btn product-card__btn product-card__btn_favorite js-to-favorite" type="button" aria-label="В избранное"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart-fill"></use></svg>
                                                </button>
                                                <button class="btn product-card__btn product-card__btn_cart js-to-cart" type="button" aria-label="В корзину"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop-added"></use></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="product-card" tabindex="0">
                                    <div class="product-card__content">
                                        <div class="product-card__header"><a class="product-card__img" href="javascript: void(0);"><img src="images/content/products/product-img-default.jpg" alt="Изображение продукта"/></a><a class="product-card__brand" href="javascript: void(0);" aria-label="Перейти к бренду Roca"><img src="images/content/brands/brand-img-1.png" alt="Roca"/></a>
                                            <ul class="list list_unstyled product-card__marks marks-list">
                                                <li class="list__item list__item_num bg_red">25%</li>
                                            </ul>
                                        </div>
                                        <div class="product-card__body"><a class="product-card__title" href="javascript: void(0);">Blome Щетка для унитаза 893</a>
                                            <div class="product-card__price"><span class="cost">1232</span><span class="currency">лей / шт</span></div>
                                        </div>
                                        <div class="product-card__footer">
                                            <div class="product-card__info">
                                                <div class="product-card__availability product-card__availability_true">В наличии</div>
                                                <div class="product-card__code">Артикул: 90858</div>
                                            </div>
                                            <div class="product-card__controls">
                                                <button class="btn product-card__btn product-card__btn_favorite js-to-favorite" type="button" aria-label="В избранное"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart-fill"></use></svg>
                                                </button>
                                                <button class="btn product-card__btn product-card__btn_cart js-to-cart" type="button" aria-label="В корзину"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop-added"></use></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="product-card" tabindex="0">
                                    <div class="product-card__content">
                                        <div class="product-card__header"><a class="product-card__img" href="javascript: void(0);"><img src="images/content/products/product-img-4.jpg" alt="Изображение продукта"/></a><a class="product-card__brand" href="javascript: void(0);" aria-label="Перейти к бренду Roca"><img src="images/content/brands/brand-img-1.png" alt="Roca"/></a>
                                            <ul class="list list_unstyled product-card__marks marks-list">
                                                <li class="list__item bg_blue">Новинка</li>
                                            </ul>
                                        </div>
                                        <div class="product-card__body"><a class="product-card__title" href="javascript: void(0);">Blome Стакан 891</a>
                                            <div class="product-card__price"><span class="cost">819</span><span class="currency">лей / шт</span></div>
                                        </div>
                                        <div class="product-card__footer">
                                            <div class="product-card__info">
                                                <div class="product-card__availability product-card__availability_true">В наличии</div>
                                                <div class="product-card__code">Артикул: 90858</div>
                                            </div>
                                            <div class="product-card__controls">
                                                <button class="btn product-card__btn product-card__btn_favorite js-to-favorite" type="button" aria-label="В избранное"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart-fill"></use></svg>
                                                </button>
                                                <button class="btn product-card__btn product-card__btn_cart js-to-cart" type="button" aria-label="В корзину"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop-added"></use></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="product-card" tabindex="0">
                                    <div class="product-card__content">
                                        <div class="product-card__header"><a class="product-card__img" href="javascript: void(0);"><img src="images/content/products/product-img-2.jpg" alt="Изображение продукта"/></a><a class="product-card__brand" href="javascript: void(0);" aria-label="Перейти к бренду Roca"><img src="images/content/brands/brand-img-1.png" alt="Roca"/></a>
                                            <ul class="list list_unstyled product-card__marks marks-list">
                                                <li class="list__item list__item_num bg_red">25%</li>
                                            </ul>
                                        </div>
                                        <div class="product-card__body"><a class="product-card__title" href="javascript: void(0);">Blome Дозатор для жидкого мыла 889</a>
                                            <div class="product-card__price"><span class="old">8 345</span><span class="cost cost_new">3 567</span><span class="currency">лей / шт</span></div>
                                        </div>
                                        <div class="product-card__footer">
                                            <div class="product-card__info">
                                                <div class="product-card__availability product-card__availability_true">В наличии</div>
                                                <div class="product-card__code">Артикул: 90858</div>
                                            </div>
                                            <div class="product-card__controls">
                                                <button class="btn product-card__btn product-card__btn_favorite js-to-favorite" type="button" aria-label="В избранное"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart-fill"></use></svg>
                                                </button>
                                                <button class="btn product-card__btn product-card__btn_cart js-to-cart" type="button" aria-label="В корзину"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop-added"></use></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="product-card" tabindex="0">
                                    <div class="product-card__content">
                                        <div class="product-card__header"><a class="product-card__img" href="javascript: void(0);"><img src="images/content/products/product-img-default.jpg" alt="Изображение продукта"/></a><a class="product-card__brand" href="javascript: void(0);" aria-label="Перейти к бренду Roca"><img src="images/content/brands/brand-img-1.png" alt="Roca"/></a>
                                            <ul class="list list_unstyled product-card__marks marks-list">
                                                <li class="list__item list__item_num bg_red">25%</li>
                                            </ul>
                                        </div>
                                        <div class="product-card__body"><a class="product-card__title" href="javascript: void(0);">Blome Щетка для унитаза 893</a>
                                            <div class="product-card__price"><span class="cost">1232</span><span class="currency">лей / шт</span></div>
                                        </div>
                                        <div class="product-card__footer">
                                            <div class="product-card__info">
                                                <div class="product-card__availability product-card__availability_true">В наличии</div>
                                                <div class="product-card__code">Артикул: 90858</div>
                                            </div>
                                            <div class="product-card__controls">
                                                <button class="btn product-card__btn product-card__btn_favorite js-to-favorite" type="button" aria-label="В избранное"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart-fill"></use></svg>
                                                </button>
                                                <button class="btn product-card__btn product-card__btn_cart js-to-cart" type="button" aria-label="В корзину"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop-added"></use></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="product-card" tabindex="0">
                                    <div class="product-card__content">
                                        <div class="product-card__header"><a class="product-card__img" href="javascript: void(0);"><img src="images/content/products/product-img-2.jpg" alt="Изображение продукта"/></a><a class="product-card__brand" href="javascript: void(0);" aria-label="Перейти к бренду Roca"><img src="images/content/brands/brand-img-1.png" alt="Roca"/></a>
                                            <ul class="list list_unstyled product-card__marks marks-list">
                                                <li class="list__item list__item_num bg_red">25%</li>
                                            </ul>
                                        </div>
                                        <div class="product-card__body"><a class="product-card__title" href="javascript: void(0);">Blome Дозатор для жидкого мыла 889</a>
                                            <div class="product-card__price"><span class="old">8 345</span><span class="cost cost_new">3 567</span><span class="currency">лей / шт</span></div>
                                        </div>
                                        <div class="product-card__footer">
                                            <div class="product-card__info">
                                                <div class="product-card__availability product-card__availability_true">В наличии</div>
                                                <div class="product-card__code">Артикул: 90858</div>
                                            </div>
                                            <div class="product-card__controls">
                                                <button class="btn product-card__btn product-card__btn_favorite js-to-favorite" type="button" aria-label="В избранное"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart-fill"></use></svg>
                                                </button>
                                                <button class="btn product-card__btn product-card__btn_cart js-to-cart" type="button" aria-label="В корзину"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop-added"></use></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="product-card" tabindex="0">
                                    <div class="product-card__content">
                                        <div class="product-card__header"><a class="product-card__img" href="javascript: void(0);"><img src="images/content/products/product-img-3.jpg" alt="Изображение продукта"/></a><a class="product-card__brand" href="javascript: void(0);" aria-label="Перейти к бренду Geberit"><img src="images/content/brands/brand-img-2.png" alt="Geberit"/></a>
                                            <ul class="list list_unstyled product-card__marks marks-list">
                                                <li class="list__item bg_blue">Новинка</li>
                                            </ul>
                                        </div>
                                        <div class="product-card__body"><a class="product-card__title" href="javascript: void(0);">Blome Мыльница 892</a>
                                            <div class="product-card__price"><span class="cost">175</span><span class="currency">лей / шт</span></div>
                                        </div>
                                        <div class="product-card__footer">
                                            <div class="product-card__info">
                                                <div class="product-card__availability">Нет в наличии</div>
                                                <div class="product-card__code">Артикул: 90858</div>
                                            </div>
                                            <div class="product-card__controls">
                                                <button class="btn product-card__btn product-card__btn_favorite js-to-favorite" type="button" aria-label="В избранное"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart-fill"></use></svg>
                                                </button>
                                                <button class="btn product-card__btn product-card__btn_cart js-to-cart" type="button" aria-label="В корзину"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop-added"></use></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="product-card" tabindex="0">
                                    <div class="product-card__content">
                                        <div class="product-card__header"><a class="product-card__img" href="javascript: void(0);"><img src="images/content/products/product-img-1.jpg" alt="Изображение продукта"/></a><a class="product-card__brand" href="javascript: void(0);" aria-label="Перейти к бренду Roca"><img src="images/content/brands/brand-img-1.png" alt="Roca"/></a>
                                            <ul class="list list_unstyled product-card__marks marks-list">
                                                <li class="list__item list__item_num bg_red">25%</li>
                                            </ul>
                                        </div>
                                        <div class="product-card__body"><a class="product-card__title" href="javascript: void(0);">Blome Стакан для зубных щеток</a>
                                            <div class="product-card__price"><span class="cost">277</span><span class="currency">лей / шт</span></div>
                                        </div>
                                        <div class="product-card__footer">
                                            <div class="product-card__info">
                                                <div class="product-card__availability product-card__availability_true">В наличии</div>
                                                <div class="product-card__code">Артикул: 90858</div>
                                            </div>
                                            <div class="product-card__controls">
                                                <button class="btn product-card__btn product-card__btn_favorite js-to-favorite" type="button" aria-label="В избранное"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart-fill"></use></svg>
                                                </button>
                                                <button class="btn product-card__btn product-card__btn_cart js-to-cart" type="button" aria-label="В корзину"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop-added"></use></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="product-card" tabindex="0">
                                    <div class="product-card__content">
                                        <div class="product-card__header"><a class="product-card__img" href="javascript: void(0);"><img src="images/content/products/product-img-4.jpg" alt="Изображение продукта"/></a><a class="product-card__brand" href="javascript: void(0);" aria-label="Перейти к бренду Roca"><img src="images/content/brands/brand-img-1.png" alt="Roca"/></a>
                                            <ul class="list list_unstyled product-card__marks marks-list">
                                                <li class="list__item bg_blue">Новинка</li>
                                            </ul>
                                        </div>
                                        <div class="product-card__body"><a class="product-card__title" href="javascript: void(0);">Blome Стакан 891</a>
                                            <div class="product-card__price"><span class="cost">819</span><span class="currency">лей / шт</span></div>
                                        </div>
                                        <div class="product-card__footer">
                                            <div class="product-card__info">
                                                <div class="product-card__availability product-card__availability_true">В наличии</div>
                                                <div class="product-card__code">Артикул: 90858</div>
                                            </div>
                                            <div class="product-card__controls">
                                                <button class="btn product-card__btn product-card__btn_favorite js-to-favorite" type="button" aria-label="В избранное"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart-fill"></use></svg>
                                                </button>
                                                <button class="btn product-card__btn product-card__btn_cart js-to-cart" type="button" aria-label="В корзину"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop-added"></use></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="section__controls">
                        <div class="section__controls-nav swiper-nav">
                            <button class="swiper-button-prev" type="button"><svg role="img" aria-hidden="true" width="30" height="30"><use xlink:href="#svg-icon-down-arrow"></use></svg></button>
                            <button class="swiper-button-next" type="button"><svg role="img" aria-hidden="true" width="30" height="30"><use xlink:href="#svg-icon-down-arrow"></use></svg></button>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="viewed-products" role="tabpanel" aria-labelledby="viewed-tab">
                    <div class="swiper-container js-product-slider">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="product-card" tabindex="0">
                                    <div class="product-card__content">
                                        <div class="product-card__header"><a class="product-card__img" href="javascript: void(0);"><img src="images/content/products/product-img-2.jpg" alt="Изображение продукта"/></a><a class="product-card__brand" href="javascript: void(0);" aria-label="Перейти к бренду Roca"><img src="images/content/brands/brand-img-1.png" alt="Roca"/></a>
                                            <ul class="list list_unstyled product-card__marks marks-list">
                                                <li class="list__item list__item_num bg_red">25%</li>
                                            </ul>
                                        </div>
                                        <div class="product-card__body"><a class="product-card__title" href="javascript: void(0);">Blome Дозатор для жидкого мыла 889</a>
                                            <div class="product-card__price"><span class="old">8 345</span><span class="cost cost_new">3 567</span><span class="currency">лей / шт</span></div>
                                        </div>
                                        <div class="product-card__footer">
                                            <div class="product-card__info">
                                                <div class="product-card__availability product-card__availability_true">В наличии</div>
                                                <div class="product-card__code">Артикул: 90858</div>
                                            </div>
                                            <div class="product-card__controls">
                                                <button class="btn product-card__btn product-card__btn_favorite js-to-favorite" type="button" aria-label="В избранное"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart-fill"></use></svg>
                                                </button>
                                                <button class="btn product-card__btn product-card__btn_cart active js-to-cart" type="button" aria-label="Добавлено в корзину. Отменить добавление"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop-added"></use></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="product-card" tabindex="0">
                                    <div class="product-card__content">
                                        <div class="product-card__header"><a class="product-card__img" href="javascript: void(0);"><img src="images/content/products/product-img-3.jpg" alt="Изображение продукта"/></a><a class="product-card__brand" href="javascript: void(0);" aria-label="Перейти к бренду Geberit"><img src="images/content/brands/brand-img-2.png" alt="Geberit"/></a>
                                            <ul class="list list_unstyled product-card__marks marks-list">
                                                <li class="list__item bg_blue">Новинка</li>
                                            </ul>
                                        </div>
                                        <div class="product-card__body"><a class="product-card__title" href="javascript: void(0);">Blome Мыльница 892</a>
                                            <div class="product-card__price"><span class="cost">175</span><span class="currency">лей / шт</span></div>
                                        </div>
                                        <div class="product-card__footer">
                                            <div class="product-card__info">
                                                <div class="product-card__availability">Нет в наличии</div>
                                                <div class="product-card__code">Артикул: 90858</div>
                                            </div>
                                            <div class="product-card__controls">
                                                <button class="btn product-card__btn product-card__btn_favorite active js-to-favorite" type="button" aria-label="Добавлено в избранное. Отменить добавление"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart-fill"></use></svg>
                                                </button>
                                                <button class="btn product-card__btn product-card__btn_cart js-to-cart" type="button" aria-label="В корзину"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop-added"></use></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="product-card" tabindex="0">
                                    <div class="product-card__content">
                                        <div class="product-card__header"><a class="product-card__img" href="javascript: void(0);"><img src="images/content/products/product-img-1.jpg" alt="Изображение продукта"/></a><a class="product-card__brand" href="javascript: void(0);" aria-label="Перейти к бренду Roca"><img src="images/content/brands/brand-img-1.png" alt="Roca"/></a>
                                            <ul class="list list_unstyled product-card__marks marks-list">
                                                <li class="list__item list__item_num bg_red">25%</li>
                                            </ul>
                                        </div>
                                        <div class="product-card__body"><a class="product-card__title" href="javascript: void(0);">Blome Стакан для зубных щеток</a>
                                            <div class="product-card__price"><span class="cost">277</span><span class="currency">лей / шт</span></div>
                                        </div>
                                        <div class="product-card__footer">
                                            <div class="product-card__info">
                                                <div class="product-card__availability product-card__availability_true">В наличии</div>
                                                <div class="product-card__code">Артикул: 90858</div>
                                            </div>
                                            <div class="product-card__controls">
                                                <button class="btn product-card__btn product-card__btn_favorite js-to-favorite" type="button" aria-label="В избранное"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart-fill"></use></svg>
                                                </button>
                                                <button class="btn product-card__btn product-card__btn_cart js-to-cart" type="button" aria-label="В корзину"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop-added"></use></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="product-card" tabindex="0">
                                    <div class="product-card__content">
                                        <div class="product-card__header"><a class="product-card__img" href="javascript: void(0);"><img src="images/content/products/product-img-2.jpg" alt="Изображение продукта"/></a><a class="product-card__brand" href="javascript: void(0);" aria-label="Перейти к бренду Roca"><img src="images/content/brands/brand-img-1.png" alt="Roca"/></a>
                                            <ul class="list list_unstyled product-card__marks marks-list">
                                                <li class="list__item list__item_num bg_red">25%</li>
                                            </ul>
                                        </div>
                                        <div class="product-card__body"><a class="product-card__title" href="javascript: void(0);">Blome Дозатор для жидкого мыла 889</a>
                                            <div class="product-card__price"><span class="old">8 345</span><span class="cost cost_new">3 567</span><span class="currency">лей / шт</span></div>
                                        </div>
                                        <div class="product-card__footer">
                                            <div class="product-card__info">
                                                <div class="product-card__availability product-card__availability_true">В наличии</div>
                                                <div class="product-card__code">Артикул: 90858</div>
                                            </div>
                                            <div class="product-card__controls">
                                                <button class="btn product-card__btn product-card__btn_favorite js-to-favorite" type="button" aria-label="В избранное"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart-fill"></use></svg>
                                                </button>
                                                <button class="btn product-card__btn product-card__btn_cart js-to-cart" type="button" aria-label="В корзину"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop-added"></use></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="product-card" tabindex="0">
                                    <div class="product-card__content">
                                        <div class="product-card__header"><a class="product-card__img" href="javascript: void(0);"><img src="images/content/products/product-img-default.jpg" alt="Изображение продукта"/></a><a class="product-card__brand" href="javascript: void(0);" aria-label="Перейти к бренду Roca"><img src="images/content/brands/brand-img-1.png" alt="Roca"/></a>
                                            <ul class="list list_unstyled product-card__marks marks-list">
                                                <li class="list__item list__item_num bg_red">25%</li>
                                            </ul>
                                        </div>
                                        <div class="product-card__body"><a class="product-card__title" href="javascript: void(0);">Blome Щетка для унитаза 893</a>
                                            <div class="product-card__price"><span class="cost">1232</span><span class="currency">лей / шт</span></div>
                                        </div>
                                        <div class="product-card__footer">
                                            <div class="product-card__info">
                                                <div class="product-card__availability product-card__availability_true">В наличии</div>
                                                <div class="product-card__code">Артикул: 90858</div>
                                            </div>
                                            <div class="product-card__controls">
                                                <button class="btn product-card__btn product-card__btn_favorite js-to-favorite" type="button" aria-label="В избранное"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart-fill"></use></svg>
                                                </button>
                                                <button class="btn product-card__btn product-card__btn_cart js-to-cart" type="button" aria-label="В корзину"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop-added"></use></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="product-card" tabindex="0">
                                    <div class="product-card__content">
                                        <div class="product-card__header"><a class="product-card__img" href="javascript: void(0);"><img src="images/content/products/product-img-4.jpg" alt="Изображение продукта"/></a><a class="product-card__brand" href="javascript: void(0);" aria-label="Перейти к бренду Roca"><img src="images/content/brands/brand-img-1.png" alt="Roca"/></a>
                                            <ul class="list list_unstyled product-card__marks marks-list">
                                                <li class="list__item bg_blue">Новинка</li>
                                            </ul>
                                        </div>
                                        <div class="product-card__body"><a class="product-card__title" href="javascript: void(0);">Blome Стакан 891</a>
                                            <div class="product-card__price"><span class="cost">819</span><span class="currency">лей / шт</span></div>
                                        </div>
                                        <div class="product-card__footer">
                                            <div class="product-card__info">
                                                <div class="product-card__availability product-card__availability_true">В наличии</div>
                                                <div class="product-card__code">Артикул: 90858</div>
                                            </div>
                                            <div class="product-card__controls">
                                                <button class="btn product-card__btn product-card__btn_favorite js-to-favorite" type="button" aria-label="В избранное"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart-fill"></use></svg>
                                                </button>
                                                <button class="btn product-card__btn product-card__btn_cart js-to-cart" type="button" aria-label="В корзину"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop-added"></use></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="product-card" tabindex="0">
                                    <div class="product-card__content">
                                        <div class="product-card__header"><a class="product-card__img" href="javascript: void(0);"><img src="images/content/products/product-img-2.jpg" alt="Изображение продукта"/></a><a class="product-card__brand" href="javascript: void(0);" aria-label="Перейти к бренду Roca"><img src="images/content/brands/brand-img-1.png" alt="Roca"/></a>
                                            <ul class="list list_unstyled product-card__marks marks-list">
                                                <li class="list__item list__item_num bg_red">25%</li>
                                            </ul>
                                        </div>
                                        <div class="product-card__body"><a class="product-card__title" href="javascript: void(0);">Blome Дозатор для жидкого мыла 889</a>
                                            <div class="product-card__price"><span class="old">8 345</span><span class="cost cost_new">3 567</span><span class="currency">лей / шт</span></div>
                                        </div>
                                        <div class="product-card__footer">
                                            <div class="product-card__info">
                                                <div class="product-card__availability product-card__availability_true">В наличии</div>
                                                <div class="product-card__code">Артикул: 90858</div>
                                            </div>
                                            <div class="product-card__controls">
                                                <button class="btn product-card__btn product-card__btn_favorite js-to-favorite" type="button" aria-label="В избранное"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart-fill"></use></svg>
                                                </button>
                                                <button class="btn product-card__btn product-card__btn_cart js-to-cart" type="button" aria-label="В корзину"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop-added"></use></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="product-card" tabindex="0">
                                    <div class="product-card__content">
                                        <div class="product-card__header"><a class="product-card__img" href="javascript: void(0);"><img src="images/content/products/product-img-default.jpg" alt="Изображение продукта"/></a><a class="product-card__brand" href="javascript: void(0);" aria-label="Перейти к бренду Roca"><img src="images/content/brands/brand-img-1.png" alt="Roca"/></a>
                                            <ul class="list list_unstyled product-card__marks marks-list">
                                                <li class="list__item list__item_num bg_red">25%</li>
                                            </ul>
                                        </div>
                                        <div class="product-card__body"><a class="product-card__title" href="javascript: void(0);">Blome Щетка для унитаза 893</a>
                                            <div class="product-card__price"><span class="cost">1232</span><span class="currency">лей / шт</span></div>
                                        </div>
                                        <div class="product-card__footer">
                                            <div class="product-card__info">
                                                <div class="product-card__availability product-card__availability_true">В наличии</div>
                                                <div class="product-card__code">Артикул: 90858</div>
                                            </div>
                                            <div class="product-card__controls">
                                                <button class="btn product-card__btn product-card__btn_favorite js-to-favorite" type="button" aria-label="В избранное"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart-fill"></use></svg>
                                                </button>
                                                <button class="btn product-card__btn product-card__btn_cart js-to-cart" type="button" aria-label="В корзину"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop-added"></use></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="product-card" tabindex="0">
                                    <div class="product-card__content">
                                        <div class="product-card__header"><a class="product-card__img" href="javascript: void(0);"><img src="images/content/products/product-img-2.jpg" alt="Изображение продукта"/></a><a class="product-card__brand" href="javascript: void(0);" aria-label="Перейти к бренду Roca"><img src="images/content/brands/brand-img-1.png" alt="Roca"/></a>
                                            <ul class="list list_unstyled product-card__marks marks-list">
                                                <li class="list__item list__item_num bg_red">25%</li>
                                            </ul>
                                        </div>
                                        <div class="product-card__body"><a class="product-card__title" href="javascript: void(0);">Blome Дозатор для жидкого мыла 889</a>
                                            <div class="product-card__price"><span class="old">8 345</span><span class="cost cost_new">3 567</span><span class="currency">лей / шт</span></div>
                                        </div>
                                        <div class="product-card__footer">
                                            <div class="product-card__info">
                                                <div class="product-card__availability product-card__availability_true">В наличии</div>
                                                <div class="product-card__code">Артикул: 90858</div>
                                            </div>
                                            <div class="product-card__controls">
                                                <button class="btn product-card__btn product-card__btn_favorite js-to-favorite" type="button" aria-label="В избранное"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart-fill"></use></svg>
                                                </button>
                                                <button class="btn product-card__btn product-card__btn_cart js-to-cart" type="button" aria-label="В корзину"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop-added"></use></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="product-card" tabindex="0">
                                    <div class="product-card__content">
                                        <div class="product-card__header"><a class="product-card__img" href="javascript: void(0);"><img src="images/content/products/product-img-3.jpg" alt="Изображение продукта"/></a><a class="product-card__brand" href="javascript: void(0);" aria-label="Перейти к бренду Geberit"><img src="images/content/brands/brand-img-2.png" alt="Geberit"/></a>
                                            <ul class="list list_unstyled product-card__marks marks-list">
                                                <li class="list__item bg_blue">Новинка</li>
                                            </ul>
                                        </div>
                                        <div class="product-card__body"><a class="product-card__title" href="javascript: void(0);">Blome Мыльница 892</a>
                                            <div class="product-card__price"><span class="cost">175</span><span class="currency">лей / шт</span></div>
                                        </div>
                                        <div class="product-card__footer">
                                            <div class="product-card__info">
                                                <div class="product-card__availability">Нет в наличии</div>
                                                <div class="product-card__code">Артикул: 90858</div>
                                            </div>
                                            <div class="product-card__controls">
                                                <button class="btn product-card__btn product-card__btn_favorite js-to-favorite" type="button" aria-label="В избранное"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart-fill"></use></svg>
                                                </button>
                                                <button class="btn product-card__btn product-card__btn_cart js-to-cart" type="button" aria-label="В корзину"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop-added"></use></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="product-card" tabindex="0">
                                    <div class="product-card__content">
                                        <div class="product-card__header"><a class="product-card__img" href="javascript: void(0);"><img src="images/content/products/product-img-1.jpg" alt="Изображение продукта"/></a><a class="product-card__brand" href="javascript: void(0);" aria-label="Перейти к бренду Roca"><img src="images/content/brands/brand-img-1.png" alt="Roca"/></a>
                                            <ul class="list list_unstyled product-card__marks marks-list">
                                                <li class="list__item list__item_num bg_red">25%</li>
                                            </ul>
                                        </div>
                                        <div class="product-card__body"><a class="product-card__title" href="javascript: void(0);">Blome Стакан для зубных щеток</a>
                                            <div class="product-card__price"><span class="cost">277</span><span class="currency">лей / шт</span></div>
                                        </div>
                                        <div class="product-card__footer">
                                            <div class="product-card__info">
                                                <div class="product-card__availability product-card__availability_true">В наличии</div>
                                                <div class="product-card__code">Артикул: 90858</div>
                                            </div>
                                            <div class="product-card__controls">
                                                <button class="btn product-card__btn product-card__btn_favorite js-to-favorite" type="button" aria-label="В избранное"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart-fill"></use></svg>
                                                </button>
                                                <button class="btn product-card__btn product-card__btn_cart js-to-cart" type="button" aria-label="В корзину"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop-added"></use></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="product-card" tabindex="0">
                                    <div class="product-card__content">
                                        <div class="product-card__header"><a class="product-card__img" href="javascript: void(0);"><img src="images/content/products/product-img-4.jpg" alt="Изображение продукта"/></a><a class="product-card__brand" href="javascript: void(0);" aria-label="Перейти к бренду Roca"><img src="images/content/brands/brand-img-1.png" alt="Roca"/></a>
                                            <ul class="list list_unstyled product-card__marks marks-list">
                                                <li class="list__item bg_blue">Новинка</li>
                                            </ul>
                                        </div>
                                        <div class="product-card__body"><a class="product-card__title" href="javascript: void(0);">Blome Стакан 891</a>
                                            <div class="product-card__price"><span class="cost">819</span><span class="currency">лей / шт</span></div>
                                        </div>
                                        <div class="product-card__footer">
                                            <div class="product-card__info">
                                                <div class="product-card__availability product-card__availability_true">В наличии</div>
                                                <div class="product-card__code">Артикул: 90858</div>
                                            </div>
                                            <div class="product-card__controls">
                                                <button class="btn product-card__btn product-card__btn_favorite js-to-favorite" type="button" aria-label="В избранное"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-heart-fill"></use></svg>
                                                </button>
                                                <button class="btn product-card__btn product-card__btn_cart js-to-cart" type="button" aria-label="В корзину"><svg class="btn__icon btn__icon_default" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop"></use></svg>
                                                    <svg class="btn__icon btn__icon_active" role="img" aria-hidden="true" width="24" height="24"><use xlink:href="#svg-icon-shop-added"></use></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="section__controls">
                        <div class="section__controls-nav swiper-nav">
                            <button class="swiper-button-prev" type="button"><svg role="img" aria-hidden="true" width="30" height="30"><use xlink:href="#svg-icon-down-arrow"></use></svg></button>
                            <button class="swiper-button-next" type="button"><svg role="img" aria-hidden="true" width="30" height="30"><use xlink:href="#svg-icon-down-arrow"></use></svg></button>
                        </div>
                    </div>
                </div>
            </div>
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
    }
</script>
