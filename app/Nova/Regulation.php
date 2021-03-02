<?php

namespace App\Nova;

use Eminiarts\Tabs\Tabs;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use NumaxLab\NovaCKEditor5Classic\CKEditor5Classic;

class Regulation extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Regulation::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title_ru';

    public static function label() {
        return 'Правило эксплуатации';
    }

    public static function singularLabel() {
        return 'Правило эксплуатации';
    }

    public static $displayInNavigation = false;

    /**
     * The columns that should be searched.
     *
     * @var array
     */

//    public static $displayInNavigation = false;

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
            Select::make('Категория', 'category_id')->options(function () {
                $categories = \App\Models\Category::getFirstLevelCategories()->get();
                $arr = [];

                foreach ($categories as $item) {
                    $arr[$item->id] = $item->name_ru;
                }

                return $arr;
            })
                ->stacked()
                ->rules(['required']),

            (new Tabs(
                'Ru', [
                    'Ru' => [
                        Text::make('Заголовок вкладки браузера', 'seo_title_ru')
                            ->stacked()
                            ->rules(['required','max:255']),

                        Text::make('Заголовок', 'title_ru')
                            ->stacked()
                            ->rules(['required','max:255']),

                        CKEditor5Classic::make('Контент', 'body_ru')
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
                            ->withFiles('public')
                            ->stacked()
                            ->rules(['required']),
                    ]
                ]
            )),
            (new Tabs(
                'Ro', [
                    'Ro' => [
                        Text::make('Заголовок вкладки браузера', 'seo_title_ro')
                            ->stacked()
                            ->rules(['required','max:255'])
                            ->hideFromIndex(),

                        Text::make('Заголовок', 'title_ro')
                            ->stacked()
                            ->rules(['required','max:255'])
                            ->hideFromIndex(),

                        CKEditor5Classic::make('Контент', 'body_ro')
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
                            ->withFiles('public')
                            ->stacked()
                            ->rules(['required']),
                    ]
                ]
            )),
            (new Tabs('Seo', [
                'Seo' => [
                    Textarea::make('Описание страницы', 'seo_description')
                        ->rows(1)
                        ->stacked()
                        ->rules(['required']),
                    Textarea::make('Ключевые слова', 'seo_keywords')
                        ->rows(1)
                        ->stacked()
                        ->rules(['required']),
                ]
            ]))
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
