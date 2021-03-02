<?php

namespace App\Nova;

use Eminiarts\Tabs\Tabs;
use Eminiarts\Tabs\TabsOnEdit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;

/**
 * Class Settings
 * @package App\Nova
 */
class Settings extends Resource
{
    use TabsOnEdit;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Settings::class;

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
    public static function label() {
        return __('settings_singular');
    }

    /**
     * @return array|string|null
     */
    public static function singularLabel() {
        return __('settings_singular');
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
            (new Tabs(__('settings'), [
                __('site') => [
                    Text::make('Название компании', 'company_name')
                        ->updateRules('required'),
                    Text::make('Основной телефон (в шапке)', 'company_phone')
                        ->updateRules('required'),
                    Image::make('Логотип', 'site_logo')
                        ->disk('public')
                        ->updateRules('mimes:svg', 'max:10240', function ($attribute, $value, $fail) use ($request) {
                            $model = $this->resource->find($request->route('resourceId'));
                            if (empty($value) && empty($model->$attribute)) {
                                $fail(__(':Attribute is required.', ['attribute' => __($attribute)]));
                            }
                        })
                        ->thumbnail(function () {
                            return \Storage::disk('public')->url($this->site_logo);
                        })
                        ->storeAs(function (Request $request) {
                            return '/site/svg/'.$request->site_logo->getClientOriginalName();
                        }),
                    Text::make('Разработан', 'developed_by')
                        ->readonly(function () {
                            return !in_array(Auth::user()->email, config('nova.superadmin'));
                        })
                        ->updateRules('required'),
                    Text::make('Сайт разработчика', 'developed_by_site')
                        ->readonly(function () {
                            return !in_array(Auth::user()->email, config('nova.superadmin'));
                        })
                        ->updateRules('required'),
                ],
                __('admin') => [
                    //
                ],
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
