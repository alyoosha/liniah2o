<?php

namespace App\Nova;

use App\Models\Brand;
use App\Models\Category;
use Eminiarts\Tabs\Tabs;
use Eminiarts\Tabs\TabsOnEdit;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class WarrantyPeriods extends Resource
{
    use TabsOnEdit;
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\WarrantyPeriods::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    public static $with = ['guarantee'];

    public static $group = 'Второстепенные страницы';

    public static function label() {
        return 'Гарантийные сроки';
    }

    public static function singularLabel()
    {
        return 'Гарантийные сроки';
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
            (new Tabs(
                'Гарантийные сроки', [
                    'Ru' => [
                        Text::make('Заголовок вкладки браузера', 'seo_title_ru')
                            ->stacked()
                            ->rules(['required','max:255']),

                        Text::make('Заголовок', 'title_ru')
                            ->stacked()
                            ->updateRules(['required','max:255']),
                    ],

                    'Ro' => [
                        Text::make('Заголовок вкладки браузера', 'seo_title_ro')
                            ->stacked()
                            ->rules(['required','max:255'])
                            ->hideFromIndex(),

                        Text::make('Заголовок', 'title_ro')
                            ->stacked()
                            ->updateRules(['required','max:255'])
                            ->hideFromIndex(),
                    ],

                    'Seo' => [
                        Textarea::make('Описание страницы', 'seo_description')
                            ->updateRules('required'),
                        Textarea::make('Ключевые слова', 'seo_keywords')
                            ->updateRules(['required']),
                    ]
                ]
            ))->withToolbar(),

            HasMany::make('Гарантии', 'guarantees', 'App\Nova\Guarantee')
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
