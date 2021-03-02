<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class CatalogSlider extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\CatalogSlider::class;

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

    public static $displayInNavigation = false;
    public static $trafficCop = false;

    public static function label()
    {
        return 'Каталог-слайдер';
    }

    public static function singularLabel()
    {
        return 'Каталог-слайдер';
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
            Text::make("Ссылка на ресурс", "url"),
            Boolean::make("Опубликован", 'is_published')
                ->sortable()
                ->rules('required'),
            Image::make('Изображение десктопное', 'image_desktop')
                ->rules('mimes:jpeg,png,jpg', 'max:10240', function ($attribute, $value, $fail) use ($request) {
                    $model = $this->resource->find($request->route('resourceId'));
                    if (empty($value) && empty($model->$attribute)) {
                        $fail(__(':Attribute is required.', ['attribute' => __($attribute)]));
                    }
                })
                ->disk('public')
                ->preview(function ($value) {
                    return Storage::disk('public')->exists($value)
                        ? Storage::disk('public')->url($value)
                        : Storage::disk('public')->url('attachments/no-image.png');
                })
                ->thumbnail(function () {
                    return Storage::disk('public')->exists($this->image_desktop)
                        ? Storage::disk('public')->url($this->image_desktop)
                        : Storage::disk('public')->url('attachments/no-image.png');
                })->storeAs(function (Request $request) {
                    return '/catalog-slider/'.$request->image_desktop->getClientOriginalName();
                })
                ->disableDownload()
                ->hideFromIndex(),
            Image::make('Изображение мобильное', 'image_mobile')
                ->rules('mimes:jpeg,png,jpg', 'max:10240', function ($attribute, $value, $fail) use ($request) {
                    $model = $this->resource->find($request->route('resourceId'));
                    if (empty($value) && empty($model->$attribute)) {
                        $fail(__(':Attribute is required.', ['attribute' => __($attribute)]));
                    }
                })
                ->disk('public')
                ->preview(function ($value) {
                    return Storage::disk('public')->exists($value)
                        ? Storage::disk('public')->url($value)
                        : Storage::disk('public')->url('attachments/no-image.png');
                })
                ->thumbnail(function () {
                    return Storage::disk('public')->exists($this->image_mobile)
                        ? Storage::disk('public')->url($this->image_mobile)
                        : Storage::disk('public')->url('attachments/no-image.png');
                })->storeAs(function (Request $request) {
                    return '/catalog-slider/'.$request->image_mobile->getClientOriginalName();
                })
                ->disableDownload()
                ->hideFromIndex(),
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
