<?php

namespace App\Nova;

use Eminiarts\Tabs\Tabs;
use Eminiarts\Tabs\TabsOnEdit;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Place;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use NumaxLab\NovaCKEditor5Classic\CKEditor5Classic;

class Contact extends Resource
{
    use TabsOnEdit;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Contact::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    public static $trafficCop = false;

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    public static function label()
    {
        return 'Контакты';
    }

    public static $group = 'Страницы';

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            (new Tabs('Contact', [
                'SEO' => $this->SEOFields(),
                'Основной адрес' => $this->addressFields(),
                'Сервис центр' => $this->serviceFields(),
                'Онлайн магазин' => $this->onlineShopFields(),
                'Реквизиты' => $this->requisitesFields(),
//                'Доставка' => $this->deliveryFields(),
                'Часы работы' => $this->workingHoursFields(),
                'Карта' => $this->mapFields(),
            ])),
        ];
    }

    protected function SEOFields()
    {
        return [
            Text::make('Заголовок страницы', 'seo_title')
                ->updateRules('max:255'),
            Text::make('Описание страницы', 'seo_description'),
            Text::make('Ключевые слова', 'seo_keywords')
                ->updateRules('max:1000'),
        ];
    }

    protected function mapFields()
    {
        return [
            Text::make('Основной телефон (над картой)', 'map_phone')
                ->updateRules('required', 'max:255'),
            Text::make('Координаты на карте (широта (lat)) центр', 'map_pin_lat')
                ->updateRules('required'),
            Text::make('Координаты на карте (Долгота (lng)) центр', 'map_pin_lng')
                ->updateRules('required'),

            Text::make('Координаты на карте магазина 1 (широта (lat))', 'address_coords_first_map_pin_lat')
                ->updateRules('required'),
            Text::make('Координаты на карте магазина 1 (Долгота (lng))', 'address_coords_first_map_pin_lng')
                ->updateRules('required'),

            Text::make('Координаты на карте магазина 2 (широта (lat))', 'address_coords_second_map_pin_lat')
                ->updateRules('required'),
            Text::make('Координаты на карте магазина 2 (Долгота (lng))', 'address_coords_second_map_pin_lng')
                ->updateRules('required'),

            Text::make('Координаты на карте магазина 3 (широта (lat))', 'address_coords_third_map_pin_lat')
                ->updateRules('required'),
            Text::make('Координаты на карте магазина 3 (Долгота (lng))', 'address_coords_third_map_pin_lng')
                ->updateRules('required'),

            Text::make('Координаты на карте магазина 4 (широта (lat))', 'address_coords_forth_map_pin_lat')
                ->updateRules('required'),
            Text::make('Координаты на карте магазина 4 (Долгота (lng))', 'address_coords_forth_map_pin_lng')
                ->updateRules('required'),
        ];
    }

    protected function workingHoursFields()
    {
        return [
            Text::make('время работы 1 (ru)', 'working_hours_first_ru')
                ->updateRules('required', 'max:255'),
            Text::make('время работы 1 (ro)', 'working_hours_first_ro')
                ->updateRules('required', 'max:255'),
            Text::make('время работы 2 (ru)', 'working_hours_second_ru')
                ->updateRules('required', 'max:255'),
            Text::make('время работы 2 (ro)', 'working_hours_second_ro')
                ->updateRules('required', 'max:255'),
        ];
    }

    protected function addressFields()
    {
        return [
            Text::make('местоположение 1 (ru)', 'address_coords_first_ru')
                ->updateRules('required', 'max:255'),
            Text::make('местоположение 1 (ro)', 'address_coords_first_ro')
                ->updateRules('required', 'max:255'),
            Text::make('местоположение 2 (ru)', 'address_coords_second_ru')
                ->updateRules('required', 'max:255'),
            Text::make('местоположение 2 (ro)', 'address_coords_second_ro')
                ->updateRules('required', 'max:255'),
            Text::make('местоположение 3 (ru)', 'address_coords_third_ru')
                ->updateRules('required', 'max:255'),
            Text::make('местоположение 3 (ro)', 'address_coords_third_ro')
                ->updateRules('required', 'max:255'),
            Text::make('местоположение 4 (ru)', 'address_coords_forth_ru')
                ->updateRules('required', 'max:255'),
            Text::make('местоположение 4 (ro)', 'address_coords_forth_ro')
                ->updateRules('required', 'max:255'),

        ];
    }

    protected function serviceFields()
    {
        return [
            Text::make('местоположение (ru)', 'service_coords_ru')
                ->updateRules('required', 'max:255'),
            Text::make('местоположение (ro)', 'service_coords_ro')
                ->updateRules('required', 'max:255'),
            Text::make('Телефон', 'service_phone')
                ->updateRules('required', 'max:255'),
            Text::make('Координаты на карте (широта (lat))', 'service_address_coords_map_pin_lat')
                ->updateRules('required', 'max:255'),
            Text::make('Координаты на карте (широта (lng))', 'service_address_coords_map_pin_lng')
                ->updateRules('required', 'max:255'),
        ];
    }

    protected function onlineShopFields()
    {
        return [
            Text::make('местоположение (ru)', 'online_shop_address_ru')
                ->updateRules('required', 'max:255'),
            Text::make('местоположение (ro)', 'online_shop_address_ro')
                ->updateRules('required', 'max:255'),
            Text::make('Телефон', 'online_shop_phone')
                ->updateRules('required', 'max:255'),
            Text::make('Координаты на карте (широта (lat))', 'online_shop_address_coords_map_pin_lat')
                ->updateRules('required', 'max:255'),
            Text::make('Координаты на карте (широта (lng))', 'online_shop_address_coords_map_pin_lng')
                ->updateRules('required', 'max:255'),
        ];
    }

    protected function requisitesFields()
    {
        return [
            Text::make('Юр. данные (ru)', 'requisites_coords_ru')
                ->updateRules('required', 'max:255'),
            Text::make('Юр. данные (ro)', 'requisites_coords_ro')
                ->updateRules('required', 'max:255'),
            CKEditor5Classic::make('Фискальный код', 'requisites_number')
                ->options([
                    'heading' => [
                        'options'=> [
                            [ 'model'=> 'paragraph', 'title'=> 'Параграф', 'class'=> 'ck-heading_paragraph'] ,
                            [ 'model'=> 'heading1', 'view'=> 'h1', 'title'=> 'Заголовок 1', 'class'=> 'ck-heading_heading1' ],
                            [ 'model'=> 'heading2', 'view'=> 'h2', 'title'=> 'Заголовок 2', 'class'=> 'ck-heading_heading2' ],
                            [ 'model'=> 'heading3', 'view'=> 'h3', 'title'=> 'Заголовок 3', 'class'=> 'ck-heading_heading3' ],
                            [ 'model'=> 'heading4', 'view'=> 'h4', 'title'=> 'Заголовок 4', 'class'=> 'ck-heading_heading4' ],
                            [ 'model'=> 'heading5', 'view'=> 'h5', 'title'=> 'Заголовок 5', 'class'=> 'ck-heading_heading5' ],
                            [ 'model'=> 'heading6', 'view'=> 'h6', 'title'=> 'Заголовок 6', 'class'=> 'ck-heading_heading6' ],
                        ]
                    ]
                ])
                ->updateRules('required', 'max:255'),
        ];
    }

    protected function deliveryFields()
    {
        return [
            Text::make('Телефон', 'delivery_phone')
                ->updateRules('required', 'max:255'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
