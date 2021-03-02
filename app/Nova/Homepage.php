<?php

namespace App\Nova;

use Egorovagency\LiniaOdds\LiniaOdds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Panel;
use NumaxLab\NovaCKEditor5Classic\CKEditor5Classic;

class Homepage extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Homepage::class;

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

    public static $group = 'Страницы';

    public static function label()
    {
        return 'Главная';
    }

    public static function singularLabel()
    {
        return 'Главная страница';
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
            new Panel('SEO поля', $this->SEOFields()),
            new Panel('Блок "кратко о нас"', $this->aboutUsFields()),
            new Panel('Преимущества LINIAH2O', [
                LiniaOdds::make('', 'odds')
                    ->hideFromDetail()
                    ->hideFromIndex()
                    ->hideWhenCreating()
            ])
        ];
    }

    public function SEOFields()
    {
        return [
            Text::make('Заголовок страницы (ru)', 'seo_title_ru')
                ->updateRules('max:255')
                ->required(),
            Text::make('Заголовок страницы (ro)', 'seo_title_ro')
                ->updateRules('max:255')
                ->required(),
            Text::make('Описание страницы', 'seo_description'),
            Text::make('Ключевые слова', 'seo_keywords')
                ->updateRules('max:500')
        ];
    }

    public function aboutUsFields()
    {
        return [
            Text::make('Заголовок (ru)', 'srortly_about_us_title_ru')
                ->updateRules('max:255'),
            Text::make('Заголовок (ro)', 'srortly_about_us_title_ro')
                ->updateRules('max:255'),
            Image::make('Изображение', 'background_image')
                ->disk('public')
                ->preview(function ($value) {
                    return Storage::disk('public')->exists($value)
                        ? Storage::disk('public')->url($value)
                        : Storage::disk('public')->url('attachments/no-image.png');
                })
                ->rules('mimes:png,jpg,jpeg', 'max:10240')
                ->thumbnail(function () {
                    return Storage::disk('public')->exists($this->background_image)
                        ? Storage::disk('public')->url($this->background_image)
                        : Storage::disk('public')->url('attachments/no-image.png');
                })->storeAs(function (Request $request) {
                    return '/homepage/'.$request->background_image->getClientOriginalName();
                })
                ->disableDownload(),
            CKEditor5Classic::make('Контент (ru)', 'srortly_about_us_content_ru')
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
                ]),
            CKEditor5Classic::make('Контент (ro)', 'srortly_about_us_content_ro')
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
