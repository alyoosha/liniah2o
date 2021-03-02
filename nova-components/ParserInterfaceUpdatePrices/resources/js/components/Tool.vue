<template>
    <div>
        <div class="row">
            <h1>Обновление цен</h1>
            <p>Последнее обновление было в: <span>{{ priceLastUpdatedAt }}</span></p>
        </div>
        <p class="parser-desc">
            Здесь осуществляется обновление каталога цен из файла xml, который расположен на сервере.<br>
            Также обновление выставлено как задача по расписанию и происходит раз в день в 00:00
        </p>
        <div class="btn-loader">
            <button :disabled="disabled" type="button" class="btn btn-update" @click="updatePrices">Начать обновление цен</button>
            <div v-show="disabled" class="loader"></div>
        </div>
        <p class="parser-done" style="display: none"></p>
        <p class="validation-check" style="display: none">Сначала проведите валидацию всех xml файлов</p>
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
                priceLastUpdatedAt: '',
                disabled: false,
                canUpdate: false,

                xmlLoaded: false,
                totalCount: 0,
                currentCount: 0,
                updated: [],
                notFound: [],
                productPrices: [],
                steps: 0
            }
        },
        beforeMount() {
            $('.px-view').find('.text-xs').remove();

            axios.get('/api/parser/getPriceLastUpdatedAtTimestamps')
                .then(response => {
                    this.priceLastUpdatedAt = response.data;
                })
                .catch(error => console.log(error));

            axios.get('/api/parser/compareValidationAndUpdatingPricesDates')
                .then(response => {
                    this.canUpdate = response.data;
                })
                .catch(error => console.log(error));

            axios.get('/api/parser/getTotalNumberOfProducts')
                .then(response => {
                    this.xmlLoaded = response.data.xmlLoaded;
                    this.totalCount = Number.parseInt(response.data.totalCount);
                    this.steps = Math.ceil(this.totalCount / 1000);
                })
                .catch(error => console.log(error));
        },
        methods: {
            updatePrices() {
                function* updatePricesGenerator(url, steps, totalCount, currentCount, updated, notFound, productPrices) {
                    for(let i = 1; i <= steps; i++) {
                        yield axios.post(url, {
                            step: i,
                            steps,
                            total: totalCount,
                            current: currentCount,
                            updated,
                            notFound,
                            products: productPrices,
                            productsPerStep: 1000,
                        })
                            .then(response => {
                                let data = response.data;

                                if (data) {
                                    url = '/api/parser/updatePrices/'+i;
                                    currentCount += 1000;
                                    updated = response.data.updated;
                                    notFound = response.data.notFound;

                                    return data;
                                } else {
                                    return null;
                                }
                            });
                    }
                }

                const updatePricePerStep = (options) => {
                    // Make the initial call to get the generator, specifying the url to get the first page of data
                    if(!options.hasOwnProperty('generator')) {
                        options.generator = {};
                    }

                    if (options.step === 0) {
                        options.generator = updatePricesGenerator('/api/parser/updatePrices/'+options.step, options.steps, options.total, options.current, options.updated, options.notFound, options.products, options.productsPerStep);
                    }

                    options.step++;

                    let next = options.generator.next();

                    if(!next.done) {
                        next.value.then(data => {
                            if (data) {
                                // Then call ourselves again to get the results of the next ajax call
                                options.step = data.step;
                                options.steps = data.steps;
                                options.total = data.total;
                                options.current = data.current;
                                options.updated = data.updated;
                                options.notFound = data.notFound;
                                options.products = data.products;
                                options.productsPerStep = data.productsPerStep;

                                console.log(options);
                                updatePricePerStep(options);
                            }
                        });
                    } else {
                        axios.get('/api/parser/updatePriceTimestamps')
                            .then(response => {
                                this.priceLastUpdatedAt = response.data;
                            })
                            .catch(error => console.log(error));

                        this.fail = false;

                        if(!this.fail) {
                            $('.parser-done').text('Цены обновлены!').show();
                            this.disabled = false;

                            $('ul.done-list').append(
                                `<li data-prop="total">
                                    Общее кол-во товаров в xml: ${options.total}
                                </li>`
                            );
                            $('ul.done-list').append(
                                `<li data-prop="updated">
                                    Обновлено товаров: ${options.updated.length}
                                </li>`
                            );
                            $('ul.done-list').append(
                                `<li data-prop="not_found">
                                    Не найдено товаров: ${options.notFound.length}
                                </li>`
                            );
                        }
                        // If we don't have any more data, call our callback with the complete list of messages
                        console.log("NO MORE STEPS");
                    }
                };

                if(this.canUpdate && this.xmlLoaded) {
                    this.success = false;
                    $('ul.done-list').empty();
                    $('.parser-done').text('').hide();
                    this.disabled = true;
                    this.fail = true;

                    updatePricePerStep({
                        step: 0,
                        steps: this.steps,
                        total: this.totalCount,
                        current: this.currentCount,
                        updated: this.updated,
                        notFound: this.notFound,
                        products: this.productPrices,
                        productsPerStep: 1000,
                    });
                } else {
                    $('.validation-check').show();
                }
            },
        }
    }
</script>

<style>
    .btn-loader {
        display: flex;
    }

    .loader {
        margin-left: 30px;
        border: 8px solid #ffffff;
        border-top: 8px solid #525e6e;
        border-bottom: 8px solid #525e6e;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

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
    p.parser-desc {
        padding-bottom: 15px;
        font-size: 16px;
    }
    p.parser-done {
        font-weight: bold;
        font-size: 20px;
        padding: 20px 0 0 0;
        color: #20a338;
    }
    p.validation-check {
        font-weight: bold;
        font-size: 20px;
        padding: 20px 0 0 0;
        color: #ac1726;
    }
    button.btn-update {
        padding: 10px 20px;
        outline: none;
        border: none;
        border-radius: 5px;
        background-color: #535F6F;
        color: white;
    }
    button.btn-update:hover {
        background-color: #88a8b8;
    }
    button.btn-update:disabled,
    button.btn-update[disabled]{
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
    svg.thumb-up {
        padding-left: 5px;
        position: relative;
        top: 3px;
    }
</style>
