<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;

class Brand extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Brand::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    public static $trafficCop = false;

    public static $group = 'Admin';

    public static $displayInNavigation = false;

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    public static function label()
    {
        return 'Бренды';
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
            Text::make('Название', 'name')
                ->rules('required', 'max:255'),
            BelongsTo::make('Страна', 'country', Country::class)
                ->hideFromIndex()
                ->viewable(false),
            Image::make('Логотип', 'image')
                ->disk('public')
                ->preview(function ($value) {
                    return $value
                        ? Storage::disk('public')->url('brands/'.$value)
                        : Storage::disk('public')->url('attachments/no-image.png');
                })
                ->rules('mimes:png', 'max:10240', function ($attribute, $value, $fail) use ($request) {
                    $model = $this->resource->find($request->route('resourceId'));
                    if (empty($value) && empty($model->$attribute)) {
                        $fail(__(':Attribute is required.', ['attribute' => __($attribute)]));
                    }
                })
                ->thumbnail(function () {
                    return $this->image
                        ? Storage::disk('public')->url('brands/'.$this->image)
                        : Storage::disk('public')->url('attachments/no-image.png');
                })->storeAs(function (Request $request) {
                    return '/brands/brand-image-'.$request->name.$request->image->getClientOriginalExtension();
                })
                ->disableDownload(),
            Text::make('slug')
                ->hideFromIndex()
                ->hideWhenCreating()
                ->hideWhenUpdating(),
            Textarea::make('Описание (ru)', 'description_ru')
                ->rows(6)
                ->hideWhenUpdating(),
            Textarea::make('Описание (ro)', 'description_ro')
                ->rows(6)
                ->hideWhenUpdating()
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
