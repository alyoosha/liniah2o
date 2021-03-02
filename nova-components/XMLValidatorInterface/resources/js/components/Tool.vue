<template>
    <div>
        <div class="row">
            <h1>Проверка xml файлов на корректность</h1>
            <p>Последнее обновление было в: <span>{{ XMLLastValidatedAt }}</span> (UTC +0)</p>
        </div>
        <p class="validator-desc">
            Здесь осуществляется проверка xml файлов на валидность и все основные логические правила составления xml<br>
            Предварительно загрузите xml файлы на сервер, после чего выполните проверку. Возможность обновления каталога будет отключена, пока не будет проведена проверка.
        </p>
        <button :disabled="disabled" type="button" class="btn btn-validate" @click="validateXML">Проверить xml</button>
        <p class="validator-done" style="display: none"></p>
        <p class="validator-done-errors" style="display: none">Ошибки:</p>
        <p class="validator-done-no-errors" style="display: none">Ошибок выявлено не было!</p>
        <ul class="done-list"></ul>
    </div>
</template>

<script>
    import * as $ from 'jquery'

    export default {
        data() {
            return {
                success: false,
                fail: false,
                XMLLastValidatedAt: '',
                disabled: false
            }
        },
        beforeMount() {
            $('.px-view').find('.text-xs').remove();

            axios.get('/api/validate/getXMLLastValidatedAtTimestamps')
                .then(response => {
                    this.XMLLastValidatedAt = response.data;
                })
                .catch(error => console.log(error));
        },
        methods: {
            validateXML() {
                this.success = false;
                $('ul.done-list').empty();
                $('.validator-done-errors').hide();
                $('.validator-done-no-errors').hide();
                $('.validator-done').text('').hide();
                this.disabled = true;

                axios.post('/api/validate/validateXML')
                    .then(response => {
                        if(response.data) {
                            $('.validator-done').text('xml файлы были проверены!').show();
                            this.disabled = false;

                            if(response.data && response.data.length != 0) {
                                $('.validator-done-errors').show();

                                // TAGS
                                if(response.data.tags) {
                                    $('ul.done-list').append(
                                        `<li class="title">Теги</li>`
                                    );
                                    for (let index = 0; index < response.data.tags.length; index++) {
                                        $('ul.done-list').append(
                                            `<li>
                                                ${response.data.tags[index]}
                                            </li>`
                                        );
                                    }
                                }

                                // BRANDS
                                if(response.data.brands) {
                                    $('ul.done-list').append(
                                        `<li class="title">Бренды</li>`
                                    );
                                    for (let index = 0; index < response.data.brands.length; index++) {
                                        $('ul.done-list').append(
                                            `<li>
                                                ${response.data.brands[index]}
                                            </li>`
                                        );
                                    }
                                }

                                // COUNTRIES
                                if(response.data.countries) {
                                    $('ul.done-list').append(
                                        `<li class="title">Страны</li>`
                                    );
                                    for (let index = 0; index < response.data.countries.length; index++) {
                                        $('ul.done-list').append(
                                            `<li>
                                                ${response.data.countries[index]}
                                            </li>`
                                        );
                                    }
                                }

                                // PRICES
                                if(response.data.prices) {
                                    $('ul.done-list').append(
                                        `<li class="title">Цены</li>`
                                    );
                                    for (let index = 0; index < response.data.prices.length; index++) {
                                        $('ul.done-list').append(
                                            `<li>
                                                ${response.data.prices[index]}
                                            </li>`
                                        );
                                    }
                                }

                                // FEATURE TYPES
                                if(response.data.feature_types) {
                                    $('ul.done-list').append(
                                        `<li class="title">Типы характеристик</li>`
                                    );
                                    for (let index = 0; index < response.data.feature_types.length; index++) {
                                        $('ul.done-list').append(
                                            `<li>
                                                ${response.data.feature_types[index]}
                                            </li>`
                                        );
                                    }
                                }

                                // FEATURES
                                if(response.data.features) {
                                    $('ul.done-list').append(
                                        `<li class="title">Характеристики</li>`
                                    );
                                    for (let index = 0; index < response.data.features.length; index++) {
                                        $('ul.done-list').append(
                                            `<li>
                                                ${response.data.features[index]}
                                            </li>`
                                        );
                                    }
                                }

                                // PRODUCTS
                                if(response.data.products) {
                                    $('ul.done-list').append(
                                        `<li class="title">Товары</li>`
                                    );
                                    for (let index = 0; index < response.data.products.length; index++) {
                                        $('ul.done-list').append(
                                            `<li>
                                                ${response.data.products[index]}
                                            </li>`
                                        );
                                    }
                                }

                                // COLLECTIONS
                                if(response.data.collections) {
                                    $('ul.done-list').append(
                                        `<li class="title">Коллекции</li>`
                                    );
                                    for (let index = 0; index < response.data.collections.length; index++) {
                                        $('ul.done-list').append(
                                            `<li>
                                                ${response.data.collections[index]}
                                            </li>`
                                        );
                                    }
                                }

                                // CATEGORIES
                                if(response.data.categories) {
                                    $('ul.done-list').append(
                                        `<li class="title">Категории</li>`
                                    );
                                    for (let index = 0; index < response.data.categories.length; index++) {
                                        $('ul.done-list').append(
                                            `<li>
                                                ${response.data.categories[index]}
                                            </li>`
                                        );
                                    }
                                }

                                // bad_additional_filenames
                                if(response.data.bad_additional_filenames) {
                                    $('ul.done-list').append(
                                        `<li class="title">${response.data.bad_additional_filenames}</li>`
                                    );
                                }

                                // additional_filenames_exception
                                if(response.data.additional_filenames_exception) {
                                    $('ul.done-list').append(
                                        `<li class="title">${response.data.additional_filenames_exception}</li>`
                                    );
                                }

                                // Additional xml exception
                                if(response.data.load_additional_xmls_exception) {
                                    $('ul.done-list').append(
                                        `<li class="title">${response.data.load_additional_xmls_exception}</li>`
                                    );
                                }

                                // bad_filename
                                if(response.data.bad_filename) {
                                    $('ul.done-list').append(
                                        `<li class="title">${response.data.bad_filename}</li>`
                                    );
                                }

                                // filename_exception
                                if(response.data.filename_exception) {
                                    $('ul.done-list').append(
                                        `<li class="title">${response.data.filename_exception}</li>`
                                    );
                                }

                                // load_xml_exception
                                if(response.data.load_xml_exception) {
                                    $('ul.done-list').append(
                                        `<li class="title">${response.data.load_xml_exception}</li>`
                                    );
                                }
                            } else {
                                $('.validator-done-no-errors').show();
                            }
                        }
                    })
                    .catch(error => {
                        this.fail = true;
                        $('.validator-done').text('Произошла ошибка при валидации xml файлов').css('color', '#901424').show();
                        console.log(error)
                    });

                axios.get('/api/validate/updateXMLValidationTimestamps')
                    .then(response => {
                        this.XMLLastValidatedAt = response.data;
                    })
                    .catch(error => console.log(error));
            }
        }
    }
</script>

<style>
    .row {
        display: flex;
        font-size: 16px;
        font-weight: bolder;
    }
    .row p {
        padding-top: 13px;
        padding-left: 15px;
    }
    .row p span {
        font-weight: lighter;
        color: #00880c;
    }
    h1 {
        padding-bottom: 30px;
    }
    p.validator-desc {
        padding-bottom: 15px;
        font-size: 16px;
    }
    p.validator-done {
        font-weight: bold;
        font-size: 20px;
        padding: 20px 0 0 0;
        color: #20a338;
    }
    p.validator-done-errors {
        font-weight: bold;
        font-size: 20px;
        padding: 20px 0 0 0;
        color: #ac1726;
    }
    p.validator-done-no-errors {
        font-weight: bold;
        font-size: 20px;
        padding: 20px 0 0 0;
        color: #20a338;
    }
    button.btn-validate {
        padding: 10px 20px;
        outline: none;
        border: none;
        border-radius: 5px;
        background-color: #535F6F;
        color: white;
    }
    button.btn-validate:hover {
        background-color: #88a8b8;
    }
    button.btn-validate:disabled,
    button.btn-validate[disabled]{
        background-color: #262626;
        color: white;
    }
    .done-list {
        padding-left: 0;
        list-style: none;
        padding-top: 5px;
    }
    .done-list li {
        margin-top: 10px;
        font-weight: bolder;
        font-size: 18px;
    }

    .done-list .title {
        margin-top: 15px;
        font-weight: bolder;
        font-size: 20px;
        color: #525e6e;
    }
    svg.thumb-up {
        padding-left: 5px;
        position: relative;
        top: 3px;
    }
</style>
