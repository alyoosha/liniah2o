<?php

namespace App\Nova;

use App\Models\Tag;
use App\Rules\Url;
use Eminiarts\Tabs\Tabs;
use Eminiarts\Tabs\TabsOnEdit;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
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

/**
 * Class Settings
 * @package App\Nova
 */
class PromoSlider extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\PromoSlider::class;

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
        return 'Промо-слайдер';
    }

    public static function singularLabel()
    {
        return 'Промо-слайдер';
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
            ID::make()
                ->sortable(),

            Boolean::make("Опубликован", 'published')
                ->sortable(),

            (new Tabs('Версии',
                [
                    'Ru' => [
                        Heading::make('Русская версия'),

                        Text::make("Ссылка", 'link_ru')
                            ->hideFromIndex()
                            ->required(),

                        Text::make("CEO тескт", 'ceo_text_ru')
                            ->required(),

                        Image::make('Изображение', 'image_ru')
                            ->disk('public')
                            ->path('promo-slider')
                            ->disableDownload()
                            ->required(),

                        Image::make('Изображение мобильное', 'image_mobile_ru')
                            ->disk('public')
                            ->path('promo-slider/mobile')
                            ->required()
                            ->disableDownload()
                    ],
                    'Ro' => [
                        Heading::make('Румынская версия')
                            ->required(),

                        Text::make("Ссылка", 'link_ro')
                            ->required()
                            ->hideFromIndex(),

                        Text::make("CEO тескт", 'ceo_text_ro')
                            ->required(),

                        Image::make('Изображение', 'image_ro')
                            ->disk('public')
                            ->path('promo-slider')
                            ->required()
                            ->disableDownload(),

                        Image::make('Изображение мобильное', 'image_mobile_ro')
                            ->disk('public')
                            ->path('promo-slider/mobile')
                            ->required()
                            ->disableDownload()
                    ]
                ]
            )),
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
