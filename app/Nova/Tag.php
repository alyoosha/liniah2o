<?php

namespace App\Nova;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Panel;
use Yna\NovaSwatches\Swatches;

class Tag extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Tag::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name_ru';

    public static $trafficCop = false;

    public static $displayInNavigation = false;

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name_ru',
    ];

    public static function label()
    {
        return 'Теги и акции';
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
            ID::make('ID', 'id')->hideWhenUpdating()->hideWhenCreating()->hideFromIndex(),
            Text::make('Название (ru)', 'name_ru')
                ->rules('required', 'max:255'),
            Text::make('Название (ro)', 'name_ro')
                ->rules('required', 'max:255'),
            Text::make('slug')
                ->hideFromIndex()
                ->hideWhenCreating()
                ->hideWhenUpdating(),
            Swatches::make('Цвет лейбла', 'color')->colors('material-dark')/*->colors(['#ffffff', '#000'])*/,
//                ->hideWhenUpdating(),
            Image::make('Изображение', 'image')
                ->disk('public')
                ->rules('mimes:jpeg,jpg,png', 'max:10240', function ($attribute, $value, $fail) use ($request) {
                    $model = $this->resource->find($request->route('resourceId'));
                    if (empty($value) && empty($model->$attribute)) {
                        $fail(__(':Attribute is required.', ['attribute' => __($attribute)]));
                    }
                })
                ->preview(function ($value) {
                    return Storage::disk('public')->exists($value)
                        ? Storage::disk('public')->url($value)
                        : Storage::disk('public')->url('attachments/no-image.png');
                })
                ->thumbnail(function () {
                    return Storage::disk('public')->exists($this->image)
                        ? Storage::disk('public')->url($this->image)
                        : Storage::disk('public')->url('attachments/no-image.png');
                })->storeAs(function (Request $request) {
                    return '/promotions/promotions-image-'.$request->image->getClientOriginalName();
                })
                ->disableDownload(),
            Textarea::make('Описание (ru)', 'description_ru')
                ->rows(6),
            Textarea::make('Описание (ro)', 'description_ro')
                ->rows(6),
            new Panel('Акционные поля', $this->promotionFields())
        ];
    }

    protected function promotionFields()
    {
        return [
            Number::make('Скидка в %', 'discount')
//                ->rules('sometimes|min:1|max:100')
                ->min(0)
                ->max(100)
                ->hideFromIndex()
                ->showOnUpdating(function () {
//                    return $this->discount <> 0;
                    return true;
                })
                ->showOnDetail(function () {
                    return $this->discount <> 0;
                }),
            Date::make('Акция действует от', 'from_date')
                ->withMeta([
                    'value' => Carbon::parse($this->from_date)->format('Y-m-d')
                ])
                ->hideFromIndex()
                ->showOnUpdating(function () {
//                    return $this->discount <> 0;
                    return true;
                })
                ->showOnDetail(function () {
                    return $this->discount <> 0;
                }),
            Date::make('Акция действует по', 'to_date')
                ->withMeta([
                    'value' => Carbon::parse($this->to_date)->format('Y-m-d')
                ])
                ->hideFromIndex()
                ->showOnUpdating(function () {
//                    return $this->discount <> 0;
                    return true;
                })
                ->showOnDetail(function () {
                    return $this->discount <> 0;
                }),
        ];
    }

    public function tagHexColors($color_class)
    {
        switch ($color_class) {
            case 'green': return '#18B93B';
            case 'red': return '#F53434';
            case 'black': return '#252A2E';
            case 'gray': return '#9FA5B9';
            case 'blue': return '#0085E5';
            case 'yellow': return '#FFC700';
            case 'orange': return '#FF6B00';
            case 'violet': return '#A034F5';
            default: return '#9FA5B9';
        }
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
