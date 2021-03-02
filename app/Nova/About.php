<?php

namespace App\Nova;

use ClassicO\NovaMediaLibrary\MediaLibrary;
use Eminiarts\Tabs\Tabs;
use Eminiarts\Tabs\TabsOnEdit;
use EricLagarda\SettingsCard\SettingsCard;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use NumaxLab\NovaCKEditor5Classic\CKEditor5Classic;

class About extends Resource
{
    use TabsOnEdit;
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Models\About';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    public static $trafficCop = false;

    public static $group = 'Страницы';

    public static function label()
    {
        return 'О нас';
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
            (new Tabs('About', [
                'Ru' => [
                    Heading::make('Блок "Лучшие решения"'),
                    Textarea::make('Заголовок', 'best_practices_content_title_ru')
                        ->rows(2)
                        ->stacked()
                        ->updateRules('required'),
                    CKEditor5Classic::make('Параграф', 'best_practices_content_ru')
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
                        // для отображения label над полем
                        ->stacked()
                        ->updateRules('required'),
                    //////////////////////////////////////////////
                    Heading::make('Блок "Качество и совершенство"'),
                    Textarea::make('Заголовок', 'quality_and_perfection_title_ru')
                        ->rows(2)
                        ->stacked()
                        ->updateRules('required'),
                    CKEditor5Classic::make('Параграф', 'quality_and_perfection_content_ru')
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
                        ->updateRules('required'),
                    //////////////////////////////////////////////
                    Heading::make('Блок "Наша миссия"'),
                    Textarea::make('Заголовок', 'our_mission_content_title_ru')
                        ->rows(2)
                        ->stacked()
                        ->updateRules('required'),
                    CKEditor5Classic::make('Параграф (оформлять списком)', 'our_mission_content_ru')
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
                        // для отображения label над полем
                        ->stacked()
                        ->updateRules('required'),
                ],
                'Ro' => [
                    Heading::make('Блок "Лучшие решения"'),
                    Textarea::make('Заголовок', 'best_practices_content_title_ro')
                        ->stacked()
                        ->rows(2)
                        ->updateRules('required'),
                    CKEditor5Classic::make('Параграф', 'best_practices_content_ro')
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
                        ->updateRules('required'),
                    //////////////////////////////////////////////
                    Heading::make('Блок "Качество и совершенство"'),
                    Textarea::make('Заголовок', 'quality_and_perfection_title_ro')
                        ->rows(2)
                        ->stacked()
                        ->updateRules('required'),
                    CKEditor5Classic::make('Параграф', 'quality_and_perfection_content_ro')
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
                        ->updateRules('required'),
                    //////////////////////////////////////////////
                    Heading::make('Блок "Наша миссия"'),
                    Textarea::make('Заголовок', 'our_mission_content_title_ro')
                        ->rows(2)
                        ->stacked()
                        ->updateRules('required'),
                    CKEditor5Classic::make('Параграф (оформлять списком)', 'our_mission_content_ro')
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
                        // для отображения label над полем
                        ->stacked()
                        ->updateRules('required'),
                ],
                'SEO' => [
                    Text::make('Заголовок страницы', 'seo_title')
                        ->updateRules('max:255'),
                    Text::make('Описание страницы', 'seo_description'),
                    Text::make('Ключевые слова', 'seo_keywords')
                        ->updateRules('max:1000'),
                ]
            ])),

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
