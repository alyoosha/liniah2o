<?php

namespace App\Nova;

use App\Models\Tag;
use App\Rules\Url;
use Eminiarts\Tabs\Tabs;
use Eminiarts\Tabs\TabsOnEdit;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\BooleanGroup;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use NumaxLab\NovaCKEditor5Classic\CKEditor5Classic;

/**
 * Class Settings
 * @package App\Nova
 */
class PromoBlocks extends Resource
{
    use TabsOnEdit;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\PromoBlock::class;

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


    public static $trafficCop = false;

    /**
     * @return array|string|null
     */
    public static function label()
    {
        return 'Промо-блоки';
    }

    public static function singularLabel()
    {
        return 'Промо-блоки';
    }

    /**
     * Temporary unavailable to see in sidebar
     *
     * @param Request $request
     * @return bool
     */
    public static function availableForNavigation(Request $request)
    {
        return false;
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [

            (new Tabs('Ru',
                [
                    'Ru' => [
                        Heading::make('Первый промо-блок'),

                        CKEditor5Classic::make('Заголовок блока','block1_title_ru')
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
                            ->rules(['required', 'max:255'])
                            ->help('Желательное количество символов 25 для корректного отображения.'),

                        Text::make('Описание', 'block1_description_ru')
                            ->stacked()
                            ->rules(['max:255'])
                            ->help('Желательное количество символов 170 для корректного отображения.'),

                        Text::make('Скидка', 'block1_discount_ru')
                            ->rules(['max:255'])
                            ->stacked(),

                        Heading::make('Второй промо-блок'),

                        CKEditor5Classic::make('Заголовок блока','block2_title_ru')
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
                            ->rules(['required', 'max:255'])
                            ->help('Желательнок количество символов 25 для корректного отображения.'),

                        Text::make('Описание', 'block2_description_ru')
                            ->stacked()
                            ->rules(['max:255'])
                            ->help('Желательное количество символов 170 для корректного отображения.'),

                        Text::make('Скидка', 'block2_discount_ru')
                            ->rules(['max:255'])
                            ->stacked(),

                        Heading::make('Акционная лента'),

                        CKEditor5Classic::make('', 'promo_banner_ru')
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
                            ->stacked()
                    ]
                ]
            )),

            (new Tabs('Ro',
                [
                    'Ro' => [
                        Heading::make('Первый промо-блок'),

                        CKEditor5Classic::make('Заголовок блока','block1_title_ro')
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
                            ->rules(['required', 'max:255'])
                            ->help('Желательное количество символов 25 для корректного отображения.'),

                        Text::make('Описание', 'block1_description_ro')
                            ->stacked()
                            ->rules(['max:255'])
                            ->help('Желательное количество символов 170 для корректного отображения.'),

                        Text::make('Скидка', 'block1_discount_ro')
                            ->rules(['max:255'])
                            ->stacked(),

                        Heading::make('Второй промо-блок'),

                        CKEditor5Classic::make('Заголовок блока','block2_title_ro')
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
                            ->rules(['required', 'max:255'])
                            ->help('Желательное количество символов 25 для корректного отображения.'),

                        Text::make('Описание', 'block2_description_ro')
                            ->stacked()
                            ->rules(['max:255'])
                            ->help('Желательное количество символов 170 для корректного отображения.'),

                        Text::make('Скидка', 'block2_discount_ro')
                            ->rules(['max:255'])
                            ->stacked(),

                        Heading::make('Акционная лента'),

                        CKEditor5Classic::make('', 'promo_banner_ro')
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
                            ->stacked()
                    ]
                ]
            )),

            (new Tabs('Ссылки',
                [
                    'Ссылка' => [
                        Heading::make('Ссылки для русской версии'),

                        Text::make('Ссылка первого промо-блока', 'block1_link_ru')
                            ->stacked()
                            ->rules(['required', 'string', 'max:255']),

                        Text::make('Ссылка второго промо-блока', 'block2_link_ru')
                            ->stacked()
                            ->rules(['required', 'string', 'max:255']),

                        Heading::make('Ссылки для румынской версии'),

                        Text::make('Ссылка первого промо-блока', 'block1_link_ro')
                            ->stacked()
                            ->rules(['required', 'string', 'max:255']),

                        Text::make('Ссылка второго промо-блока', 'block2_link_ro')
                            ->stacked()
                            ->rules(['required', 'string', 'max:255']),
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
