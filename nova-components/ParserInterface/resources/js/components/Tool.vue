<template>
    <div>
        <div class="row">
            <h1>Импорт каталога</h1>
            <p>Последнее обновление было в: <span>{{ catalogLastUpdatedAt }}</span> (UTC +0)</p>
        </div>
        <p class="parser-desc">
            Здесь осуществляется импорт каталога из файла xml, который расположен на сервере.<br> В импорт каталога входит:
            импорт категорий, товаров, коллекций товаров(плитка), характеристик товаров, брендов товаров и тегов и акций товаров.<br>
            Также импорт выставлен как задача по расписанию и происходит раз в неделю в 00:00
        </p>
        <button :disabled="disabled" type="button" class="btn btn-parse" @click="parse">Начать загрузку каталога</button>
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
            catalogLastUpdatedAt: '',
            disabled: false,
            canUpdate: false,
        }
    },
    beforeMount() {
        $('.px-view').find('.text-xs').remove();

        axios.get('/api/parser/getCatalogLastUpdatedAtTimestamps')
            .then(response => {
                this.catalogLastUpdatedAt = response.data;
            })
            .catch(error => console.log(error));

        axios.get('/api/parser/compareValidationAndUpdatingCatalogDates')
            .then(response => {
                this.canUpdate = response.data;
            })
            .catch(error => console.log(error));
    },
    methods: {
        parse() {
            if(this.canUpdate) {
                this.success = false;
                $('ul.done-list').empty();
                $('.parser-done').text('').hide();
                this.disabled = true;

                this.ajax();

                this.success = true;

                // Вызовется после всех ajax запросов
                $( document ).ajaxStop(() => {
                    if(this.success && !this.fail) {
                        $('.parser-done').text('Весь каталог был успешно загружен!').show();
                        this.disabled = false;
                    }
                });

                axios.get('/api/parser/updateCatalogImportTimestamps')
                    .then(response => {
                        this.catalogLastUpdatedAt = response.data;
                    })
                    .catch(error => console.log(error));
            } else {
                $('.validation-check').show();
            }
        },
        ajax() {
            $.ajax({
                url : '/api/parser/parseCatalog',
                type : 'POST',
                data: {
                    // порядок элементов важен
                    categories: {
                        status: false,
                        count: 0
                    },
                    brands: {
                        status: false,
                        count: 0
                    },
                    features: {
                        status: false,
                        count: 0
                    },
                    tags: {
                        status: false,
                        count: 0
                    },
                    products: {
                        status: false,
                        count: 0
                    },
                    collections: {
                        status: false,
                        count: 0
                    }
                },
                success : function(state) {
                    this.data = state;

                    for (let prop in this.data) {
                        if (this.data[prop]['status'] === 'true') {
                            if($('ul.done-list').find(`li[data-prop='${prop}']`).length === 0) {
                                let value = '';

                                switch (prop) {
                                    case 'tags': value = 'Теги'; break;
                                    case 'features': value = 'Характеристики'; break;
                                    case 'brands': value = 'Бренды'; break;
                                    case 'categories': value = 'Категории'; break;
                                    case 'products': value = 'Товары'; break;
                                    case 'collections': value = 'Коллекции'; break;
                                }

                                $('ul.done-list').append(
                                    `<li data-prop="${prop}">
                                        ${value} выгружены в кол-ве ${this.data[prop]['count']} элементов
                                        <svg class="thumb-up" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path class="heroicon-ui" d="M17.62 10H20a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H8.5c-1.2 0-2.3-.72-2.74-1.79l-3.5-7-.03-.06A3 3 0 0 1 5 9h5V4c0-1.1.9-2 2-2h1.62l4 8zM16 11.24L12.38 4H12v7H5a1 1 0 0 0-.93 1.36l3.5 7.02a1 1 0 0 0 .93.62H16v-8.76zm2 .76v8h2v-8h-2z"/></svg>
                                    </li>`
                                );
                            }
                        } else {
                            $.ajax(this)
                            break;
                        }
                    }
                },
                error : function(xhr, textStatus) {
                    this.fail = true;
                    $('.parser-done').text('Произошла ошибка при загрузке каталога').css('color', '#901424').show();

                    console.log(xhr, textStatus)
                }.bind(this)
            })
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
        color: #000088;
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
    button.btn-parse {
        padding: 10px 20px;
        outline: none;
        border: none;
        border-radius: 5px;
        background-color: #535F6F;
        color: white;
    }
    button.btn-parse:hover {
        background-color: #88a8b8;
    }
    button.btn-parse:disabled,
    button.btn-parse[disabled]{
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
