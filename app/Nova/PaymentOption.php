<?php

namespace App\Nova;

use Eminiarts\Tabs\Tabs;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use NumaxLab\NovaCKEditor5Classic\CKEditor5Classic;

class PaymentOption extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\PaymentOption::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name_ru';

    public static $displayInNavigation = false;

    public static function label() {
        return 'Варианты оплаты';
    }

    public static function singularLabel()
    {
        return 'Вариант оплаты';
    }
    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Хеш svg', 'hash_svg')
                ->stacked()
                ->help('Хеш тега имеет вид: "svg-icon-svg_name"')
                ->hideFromIndex(),

            (new Tabs('Ru',[
                    'Ru' => [
                        Text::make('Вариант оплаты', 'name_ru')
                            ->stacked()
                            ->rules(['required', 'max:255']),

                        CKEditor5Classic::make('Описание варианта оплаты', 'description_ru')
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
                            ->stacked()
                            ->rules(['required'])
                            ->hideFromIndex(),
                    ]
                ]
            )),

            (new Tabs('Ro', [
                    'Ro' => [
                        Text::make('Вариант оплаты', 'name_ro')
                            ->stacked()
                            ->rules(['required', 'max:255'])
                            ->hideFromIndex(),

                        CKEditor5Classic::make('Описание варианта оплаты', 'description_ro')
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
                            ->stacked()
                            ->rules(['required'])
                            ->hideFromIndex(),
                    ]
                ]
            ))
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
