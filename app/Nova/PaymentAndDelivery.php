<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Eminiarts\Tabs\Tabs;
use Eminiarts\Tabs\TabsOnEdit;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Heading;
use NumaxLab\NovaCKEditor5Classic\CKEditor5Classic;

class PaymentAndDelivery extends Resource
{
    use TabsOnEdit;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\PaymentAndDelivery::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    public static $trafficCop = false;

    public static $group = 'Второстепенные страницы';

    public static function label() {
        return 'Оплата и доставка';
    }

    public static function singularLabel()
    {
        return 'Оплата и доставка';
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    public static $with = ['paymentOptions'];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function fields(Request $request)
    {
        return [
            Select::make('Отображение ссылки', 'link_location')
                ->options([
                    'header' => 'Верхняя шапка',
                    'footer' => 'Футер'
                ])
                ->rules(['required'])
                ->stacked()
                ->hideFromIndex()
                ->hideFromDetail(),

            (new Tabs('Оплата и доставка', [
                'Ru' => [
                    Heading::make('Блок "Оплата"'),

                    Text::make('Заголовок вкладки браузера', 'seo_title_ru')
                        ->stacked()
                        ->rules(['required','max:255'])
                        ->hideFromIndex(),

                    Text::make('Заголовок', 'payment_title_ru')
                        ->stacked()
                        ->updateRules(['required','max:255']),

                    Heading::make('Блок "Доставка"'),

                    Text::make('Заголовок', 'delivery_title_ru')
                        ->stacked()
                        ->updateRules(['required','max:255']),

                    CKEditor5Classic::make('Контент', 'delivery_description_ru')
                        ->options([
                            'heading' => [
                                'options'=> [
                                    [ 'model'=> 'paragraph', 'view'=> 'p', 'title'=> 'Параграф', 'class'=> 'ck-heading_paragraph'] ,
                                    [ 'model'=> 'heading1', 'view'=> 'h1', 'title'=> 'Заголовок 1', 'class'=> 'ck-heading_heading1' ],
                                    [ 'model'=> 'heading2', 'view'=> 'h2', 'title'=> 'Заголовок 2', 'class'=> 'ck-heading_heading2' ],
                                    [ 'model'=> 'heading3', 'view'=> 'h3', 'title'=> 'Заголовок 3', 'class'=> 'ck-heading_heading3' ],
                                    [ 'model'=> 'heading4', 'view'=> 'h4', 'title'=> 'Заголовок 4', 'class'=> 'ck-heading_heading4' ],
                                    [ 'model'=> 'heading5', 'view'=> 'h5', 'title'=> 'Заголовок 5', 'class'=> 'ck-heading_heading5' ],
                                    [ 'model'=> 'heading6', 'view'=> 'h6', 'title'=> 'Заголовок 6', 'class'=> 'ck-heading_heading6' ],
                                ]
                            ]
                        ])
                        ->stacked(),

                    CKEditor5Classic::make('Положение о доставке', 'delivery_clause_ru')
                        ->options([
                            'heading' => [
                                'options'=> [
                                    [ 'model'=> 'paragraph', 'view'=> 'p', 'title'=> 'Параграф', 'class'=> 'ck-heading_paragraph'] ,
                                    [ 'model'=> 'heading1', 'view'=> 'h1', 'title'=> 'Заголовок 1', 'class'=> 'ck-heading_heading1' ],
                                    [ 'model'=> 'heading2', 'view'=> 'h2', 'title'=> 'Заголовок 2', 'class'=> 'ck-heading_heading2' ],
                                    [ 'model'=> 'heading3', 'view'=> 'h3', 'title'=> 'Заголовок 3', 'class'=> 'ck-heading_heading3' ],
                                    [ 'model'=> 'heading4', 'view'=> 'h4', 'title'=> 'Заголовок 4', 'class'=> 'ck-heading_heading4' ],
                                    [ 'model'=> 'heading5', 'view'=> 'h5', 'title'=> 'Заголовок 5', 'class'=> 'ck-heading_heading5' ],
                                    [ 'model'=> 'heading6', 'view'=> 'h6', 'title'=> 'Заголовок 6', 'class'=> 'ck-heading_heading6' ],
                                ]
                            ]
                        ])
                        ->rules(['required'])
                        ->stacked()
                ],
                'Ro' => [
                    Heading::make('Блок "Оплата"'),

                    Text::make('Заголовок вкладки браузера', 'seo_title_ro')
                        ->stacked()
                        ->rules(['required','max:255'])
                        ->hideFromIndex(),

                    Text::make('Заголовок', 'payment_title_ro')
                        ->stacked()
                        ->updateRules(['required','max:255']),

                    Heading::make('Блок "Доставка"'),

                    Text::make('Заголовок', 'delivery_title_ro')
                        ->stacked()
                        ->updateRules(['required','max:255']),

                    CKEditor5Classic::make('Контент', 'delivery_description_ro')
                        ->options([
                            'heading' => [
                                'options'=> [
                                    [ 'model'=> 'paragraph', 'view'=> 'p', 'title'=> 'Параграф', 'class'=> 'ck-heading_paragraph'] ,
                                    [ 'model'=> 'heading1', 'view'=> 'h1', 'title'=> 'Заголовок 1', 'class'=> 'ck-heading_heading1' ],
                                    [ 'model'=> 'heading2', 'view'=> 'h2', 'title'=> 'Заголовок 2', 'class'=> 'ck-heading_heading2' ],
                                    [ 'model'=> 'heading3', 'view'=> 'h3', 'title'=> 'Заголовок 3', 'class'=> 'ck-heading_heading3' ],
                                    [ 'model'=> 'heading4', 'view'=> 'h4', 'title'=> 'Заголовок 4', 'class'=> 'ck-heading_heading4' ],
                                    [ 'model'=> 'heading5', 'view'=> 'h5', 'title'=> 'Заголовок 5', 'class'=> 'ck-heading_heading5' ],
                                    [ 'model'=> 'heading6', 'view'=> 'h6', 'title'=> 'Заголовок 6', 'class'=> 'ck-heading_heading6' ],
                                ]
                            ]
                        ])
                        ->stacked(),

                    CKEditor5Classic::make('Положение о доставке', 'delivery_clause_ro')
                        ->options([
                            'heading' => [
                                'options'=> [
                                    [ 'model'=> 'paragraph', 'view'=> 'p', 'title'=> 'Параграф', 'class'=> 'ck-heading_paragraph'] ,
                                    [ 'model'=> 'heading1', 'view'=> 'h1', 'title'=> 'Заголовок 1', 'class'=> 'ck-heading_heading1' ],
                                    [ 'model'=> 'heading2', 'view'=> 'h2', 'title'=> 'Заголовок 2', 'class'=> 'ck-heading_heading2' ],
                                    [ 'model'=> 'heading3', 'view'=> 'h3', 'title'=> 'Заголовок 3', 'class'=> 'ck-heading_heading3' ],
                                    [ 'model'=> 'heading4', 'view'=> 'h4', 'title'=> 'Заголовок 4', 'class'=> 'ck-heading_heading4' ],
                                    [ 'model'=> 'heading5', 'view'=> 'h5', 'title'=> 'Заголовок 5', 'class'=> 'ck-heading_heading5' ],
                                    [ 'model'=> 'heading6', 'view'=> 'h6', 'title'=> 'Заголовок 6', 'class'=> 'ck-heading_heading6' ],
                                ]
                            ]
                        ])
                        ->rules(['required'])
                        ->stacked()
                ],
                'SEO' => [
                    Text::make('Описание страницы', 'seo_description')
                        ->updateRules('required'),
                    Text::make('Ключевые слова', 'seo_keywords')
                        ->updateRules(['required','max:1000']),
                ]
            ])),

            HasMany::make('Варианты оплаты', 'paymentOptions', 'App\Nova\PaymentOption'),
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
