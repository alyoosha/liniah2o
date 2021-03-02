<!-- Модальное окно с положением о доставке-->
<div class="modal modal-delivery-clause fade" id="modal-delivery-clause" tabindex="-1" role="dialog" aria-labeledby="modal-delivery-clause-title" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="section__title modal-title" id="modal-delivery-clause-title">{{ __('delivery_clause') }}</div>
                <button class="modal-close" type="button" data-dismiss="modal" aria-label="{{ __('close') }}">
                    <svg role="img" aria-hidden="true" width="26" height="26">
                        <use xlink:href="#svg-icon-cancel"></use>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="scrollbar-inner">
                    <div class="delivery-clause-content">
                        @isset($modalDeliveryClause)
                            @if(is_string($modalDeliveryClause))
                                @php
                                    echo html_entity_decode($modalDeliveryClause)
                                @endphp
                            @endif
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Модальное окно с сообщением, что товар добавлен в корзину-->
<add-to-cart language="{{ $lang }}"></add-to-cart>
<cart-products-in-order language="{{ $lang }}"></cart-products-in-order>
<!-- Модальное окно "Успех". Запускается через js стандартными методами Bootstrap 4 (https://bootstrap-4.ru/docs/4.3.1/components/modal/#modalshow)-->
<div class="modal modal-success fade" id="modal-success" tabindex="-1" role="dialog" aria-labeledby="modal-success-title" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body modal-message">
                <div class="modal-message__icon color_green">
                    <svg role="img" aria-hidden="true" width="150" height="150">
                        <use xlink:href="#svg-icon-verified"></use>
                    </svg>
                </div>
                <div class="section__title section__title_style5 modal-message__title" id="modal-success-title"><span class="line">Заявка на рекламацию успешно отправлена</span></div>
                <button class="btn btn_default btn_with-icon btn_dark modal-message__btn" type="button" data-dismiss="modal" aria-label="Закрыть">
                    <span class="btn__icon" aria-hidden="true">
                        <svg role="img" aria-hidden="true" width="30" height="30">
                            <use xlink:href="#svg-icon-verified"></use>
                        </svg>
                    </span>
                    <span class="btn__text">{{ __('ok') }}</span>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Модальное окно "Ошибка". Запускается через js стандартными методами Bootstrap 4 (https://bootstrap-4.ru/docs/4.3.1/components/modal/#modalshow)-->
<div class="modal modal-error fade" id="modal-error" tabindex="-1" role="dialog" aria-labeledby="modal-error-title" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body modal-message">
                <div class="modal-message__icon color_red">
                    <svg role="img" aria-hidden="true" width="150" height="150">
                        <use xlink:href="#svg-icon-error"></use>
                    </svg>
                </div>
                <div class="section__title section__title_style5 modal-message__title" id="modal-error-title">
                    <span class="line">{{ __('error_occurred') }}</span>
                    <span class="line">{{ __('try_again') }}</span>
                </div>
                <button class="btn btn_default btn_with-icon btn_dark modal-message__btn" type="button" data-dismiss="modal" aria-label="Закрыть">
                    <span class="btn__icon" aria-hidden="true">
                        <svg role="img" aria-hidden="true" width="30" height="30">
                            <use xlink:href="#svg-icon-verified"></use>
                        </svg>
                    </span>
                    <span class="btn__text">{{ __('ok') }}</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Модальное окно "Успех". Запускается через js стандартными методами Bootstrap 4 (https://bootstrap-4.ru/docs/4.3.1/components/modal/#modalshow)-->
<div class="modal modal-success fade" id="modal-success-set" tabindex="-1" role="dialog" aria-labeledby="modal-success-title" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body modal-message">
                <div class="modal-message__icon color_green"><svg role="img" aria-hidden="true" width="150" height="150"><use xlink:href="#svg-icon-verified"></use></svg></div>
                <div class="section__title section__title_style5 modal-message__title" id="modal-success-title"><span class="line">{{__("set_added_to_cart")}}</span></div>
                <button class="btn btn_default btn_with-icon btn_dark modal-message__btn" type="button" data-dismiss="modal" aria-label="Закрыть"><span class="btn__icon" aria-hidden="true"><svg role="img" aria-hidden="true" width="30" height="30"><use xlink:href="#svg-icon-verified"></use></svg></span><span class="btn__text">Ок</span></button>
            </div>
        </div>
    </div>
</div>
<!-- Модальное окно "Ошибка". Запускается через js стандартными методами Bootstrap 4 (https://bootstrap-4.ru/docs/4.3.1/components/modal/#modalshow)-->
<div class="modal modal-error fade" id="modal-error" tabindex="-1" role="dialog" aria-labeledby="modal-error-title" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body modal-message">
                <div class="modal-message__icon color_red"><svg role="img" aria-hidden="true" width="150" height="150"><use xlink:href="#svg-icon-error"></use></svg></div>
                <div class="section__title section__title_style5 modal-message__title" id="modal-error-title"><span class="line">произошла ошибка</span><span class="line">попробуйте еще раз</span></div>
                <button class="btn btn_default btn_with-icon btn_dark modal-message__btn" type="button" data-dismiss="modal" aria-label="Закрыть"><span class="btn__icon" aria-hidden="true"><svg role="img" aria-hidden="true" width="30" height="30"><use xlink:href="#svg-icon-verified"></use></svg></span><span class="btn__text">Ок</span></button>
            </div>
        </div>
    </div>
</div>
