<?php

namespace App\Nova;

use App\Models\City;
use App\Models\Orders;
use App\Models\Region;
use Carbon\Carbon;
use Egorovagency\OrderProductsField\OrderProductsField;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;

class Order extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Orders::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    public static $group = 'Админ';

    public static function label()
    {
        return 'Заказы';
    }

    public static function singularLabel()
    {
        return 'Заказ';
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            Heading::make('Текущее состояние заказа'),
            ID::make('ID заказа', 'id')->sortable()->hideWhenUpdating(),
            Text::make('Ссылка на статус заказа', 'url')
                ->hideFromIndex()
                ->hideWhenUpdating(),
            Text::make('Статус заказа', 'status_display_value')
                ->hideWhenUpdating(),
            Select::make('Статус', 'status')->options([
                'new' => 'Новый',
                'deny' => 'Отмена',
                'question' => 'Вопрос клиенту',
                'applied' => 'Согласован',
                'is_completing' => 'Комплектуется',
                'completed' => 'Скомплектован',
                'delivery' => 'Передан на доставку',
                'return' => 'Возврат',
                'ready' => 'Выполнен',
            ])
                ->displayUsingLabels()
                ->hideFromIndex()
                ->hideFromDetail(),
            Heading::make('Товары')->hideWhenUpdating(),
            OrderProductsField::make('Товары', 'products')
                ->hideFromIndex()
                ->hideWhenUpdating(),
            Heading::make('Личные данные'),
            Text::make('Имя покупателя', 'customer_name')
                ->hideFromIndex(),
            Text::make('Телефон покупателя', 'customer_phone')
                ->hideFromIndex(),
            Text::make('email покупателя', 'customer_email'),
            Text::make('Регион', 'delivery_info', function ($value) {
                if (isset(json_decode($value)->region)) {
                    $region_id = (int)json_decode($value)->region;
                    $region = Region::find($region_id);

                    return $region['name_ru'];
                } else return null;
            })
                ->hideFromIndex()
                ->hideWhenUpdating()
                ->showOnDetail(function () {
                    return isset(json_decode($this->delivery_info)->region);
                }),
            Text::make('Город', 'delivery_info', function ($value) {
                if (isset(json_decode($value)->city)) {
                    $city_id = (int)json_decode($value)->city;
                    $city = City::find($city_id);

                    return $city['name_ru'];
                } else return null;
            })
                ->hideFromIndex()
                ->hideWhenUpdating()
                ->showOnDetail(function () {
                    return isset(json_decode($this->delivery_info)->city);
                }),
            Text::make('Улица', 'delivery_info', function ($value) {
                return isset(json_decode($value)->street) ? json_decode($value)->street : null;
            })
                ->hideFromIndex()
                ->hideWhenUpdating()
                ->showOnDetail(function () {
                    return isset(json_decode($this->delivery_info)->street);
                }),
            Text::make('Дом', 'delivery_info', function ($value) {
                return isset(json_decode($value)->house) ? json_decode($value)->house : null;
            })
                ->hideFromIndex()
                ->hideWhenUpdating()
                ->showOnDetail(function () {
                    return isset(json_decode($this->delivery_info)->house);
                }),
            Text::make('Квартира', 'delivery_info', function ($value) {
                return isset(json_decode($value)->flat) ? json_decode($value)->flat : null;
            })
                ->hideFromIndex()
                ->hideWhenUpdating()
                ->showOnDetail(function () {
                    return isset(json_decode($this->delivery_info)->flat);
                }),
            Heading::make('Детальная информация о заказе'),
            Number::make('Общая стоимость', 'total', function ($value) {
                return $value. ' '. __('currency_name');
            })->hideWhenUpdating(),
            Text::make('Оплата', 'payment', function ($value) {
                if($value === 'in_shop') {
                    return 'В магазине';
                } else {
                    return 'Курьеру';
                }
            })
                ->hideFromIndex()
                ->hideWhenUpdating(),
            Text::make('Способ оплаты', 'payment_method', function ($value) {
                if($value === 'card') {
                    return 'Картой';
                } else {
                    return 'Наличными';
                }
            })
                ->hideFromIndex()
                ->hideWhenUpdating(),
            Text::make('Доставка', 'delivery_method', function ($value) {
                if($value === 'pickup') {
                    return 'Самовывоз';
                } else {
                    return 'Курьером';
                }
            })
                ->hideFromIndex()
                ->hideWhenUpdating(),
            Text::make('Адрес магазина', 'delivery_info', function () {
                    return isset(json_decode($this->delivery_info)->address) ? json_decode($this->delivery_info)->address : null;
                })
                ->hideFromIndex()
                ->showOnUpdating(function () {
                    return false;
                })
                ->showOnDetail(function () {
                    return isset(json_decode($this->delivery_info)->address);
                }),
            Textarea::make('Комментарии к заказу', 'comment')
                ->rows(6)
                ->hideWhenUpdating(),
            Date::make('Дата оформления заказа', 'created_at')
                ->withMeta([
                    'value' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s')
                ]),
            Date::make('Дата последнего изменения заказа', 'updated_at')
                ->withMeta([
                    'value' => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s')
                ]),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param Request $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param Request $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param Request $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param Request $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
