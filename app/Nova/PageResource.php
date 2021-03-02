<?php

namespace App\Nova;

use App\Rules\Url;
use Eminiarts\Tabs\Tabs;
use Eminiarts\Tabs\TabsOnEdit;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use NumaxLab\NovaCKEditor5Classic\CKEditor5Classic;
use Egorovagency\UrlSecondaryPage\UrlSecondaryPage;
use Egorovagency\FieldForSecondaryPage\FieldForSecondaryPage;

class PageResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Page::class;

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

    public static $group = 'Второстепенные страницы';

    public static $trafficCop = false;


    public static function label()
    {
        return 'Шаблонные страницы';
    }

    public static function singularLabel()
    {
        return 'Шаблонную страницу';
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
            ID::make()
                ->sortable(),

            FieldForSecondaryPage::make("Название", "name")
                ->rules(['required', 'string', 'min:3', 'max:255'])
                ->stacked()
                ->sortable()
                ->withMeta(['required' => true, 'regexp' => ['value' => '^[ а-яА-Яa-zA-Z0-9-]+$', 'flag' => 'i', 'msg' => 'Значение поля "Название" может содержать кириллицу, латиницу, цифры и знак "-"'], 'minLength' => 3, 'maxLength' => 255]),

            UrlSecondaryPage::make("Url", "slug")
                ->rules('required', new Url)
                ->stacked()
                ->sortable()
                ->withMeta(['required' => true, 'regexp' => ['value' => '^[a-z0-9-]+$', 'flag' => '', 'msg' => 'Значение поля "Url" может содержать латиницу в нижнем регистре, цифры и знак "-"'], 'minLength' => 3, 'maxLength' => 255]),

            DateTime::make('Создано', 'created_at')
                ->format('d.m.Y H:m:s')
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->sortable(),


            DateTime::make('Изменено', 'updated_at')
                ->format('d.m.Y H:m:s')
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->sortable(),


            Select::make('Отображение ссылки', 'link_location')
                ->options([
                    'header' => 'Меню - первый уровень',
                    'footer' => 'Футер'
                ])
                ->stacked()
                ->hideFromIndex(),

            Boolean::make('Наличие меню', 'has_menu')
                ->hideFromIndex(),

            Boolean::make('Опубликовано', 'status'),

            (new Tabs('Ru', [
                'Ru' => [
                    FieldForSecondaryPage::make('Заголовок вкладки браузера', 'seo_title_ru')
                        ->creationRules(['required', 'string', 'min:3', 'max:255', 'unique:App\Models\Page,seo_title_ru'])
                        ->updateRules(['required', 'string', 'min:3', 'max:255'])
                        ->stacked()
                        ->sortable()
                        ->hideFromIndex()
                        ->withMeta(['required' => true, 'regexp' => ['value' => '^[ а-яА-Яa-zA-Z0-9-]+$', 'flag' => 'i', 'msg' => 'Значение поля "Заголовок вкладки браузера" может содержать кириллицу, латиницу, цифры и дефис'], 'minLength' => 3, 'maxLength' => 255]),

                    Text::make('Заголовок страницы', 'title_ru')
                        ->stacked()
                        ->rules(['required', 'string', 'max:255'])
                        ->hideFromIndex(),


                    CKEditor5Classic::make('Контент','body_ru')
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
                        ->withFiles('public')
                        ->hideFromIndex(),

                    Text::make('Описание страницы SEO', 'seo_description_ru')
                        ->rules('required')
                        ->hideFromIndex(),

                    Text::make('Ключевые слова страницы SEO', 'seo_keywords_ru')
                        ->rules(['required','max:1000'])
                        ->hideFromIndex(),
                ],
            ])),

            (new Tabs('Ro', [
                'Ro' => [
                    FieldForSecondaryPage::make('Заголовок вкладки браузера', 'seo_title_ro')
                        ->creationRules(['required', 'string', 'min:3', 'max:255', 'unique:App\Models\Page,seo_title_ru'])
                        ->updateRules(['required', 'string', 'min:3', 'max:255'])
                        ->stacked()
                        ->sortable()
                        ->hideFromIndex()
                        ->withMeta(['required' => true, 'regexp' => ['value' => '^[ а-яА-Яa-zA-Z0-9-]+$', 'flag' => 'i', 'msg' => 'Значение поля "Заголовок вкладки браузера" может содержать кириллицу, латиницу, цифры и дефис'], 'minLength' => 3, 'maxLength' => 255]),

                    Text::make('Заголовок страницы', 'title_ro')
                        ->stacked()
                        ->rules(['required', 'string', 'max:255'])
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
                        ->stacked()
                        ->withFiles('public')
                        ->hideFromIndex(),

                    Text::make('Описание страницы SEO', 'seo_description_ro')
                        ->rules('required')
                        ->hideFromIndex(),

                    Text::make('Ключевые слова страницы SEO', 'seo_keywords_ro')
                        ->rules(['required','max:1000'])
                        ->hideFromIndex()
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
