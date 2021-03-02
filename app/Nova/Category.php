<?php

namespace App\Nova;

use Benjaminhirsch\NovaSlugField\Slug;
use Benjaminhirsch\NovaSlugField\TextWithSlug;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Panel;

class Category extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Models\Category';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name_ru';

    /**
     * Indicates if the resource should be displayed in the sidebar.
     *
     * @var bool
     */
    public static $displayInNavigation = false;

    /**
     * Just need it to display categories in tree view format
     * on a single page
     */
    public static $perPageOptions = [10000, 11000, 12000];

    /**
     * @var bool
     */
    public static $trafficCop = false;

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
        return 'Категории';
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
            ID::make()->sortable(),
            BelongsTo::make('Родитель', 'parent', 'App\Nova\Category')
                ->searchable()
                ->nullable()
                ->default(1),
            TextWithSlug::make('Наименование (ru)','name_ru')
                ->slug('slug')
                ->rules('required', 'min:2'),
            TextWithSlug::make('Наименование (ro)','name_ro')
                ->slug('slug')
                ->rules('required', 'min:2'),
            Slug::make('Slug','slug')
                ->rules('required', 'min:2'),
            Number::make('order')
                ->hideFromDetail()
                ->hideFromIndex()
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->default(0),
            Boolean::make('Рекоммендуемая категория', 'is_recommended')
                ->trueValue(1)
                ->falseValue(0)
                ->showOnUpdating($this->isFirstLevelCategory())
                ->hideFromDetail($this->isNotFirstLevelCategory())
                ->hideFromIndex($this->isNotFirstLevelCategory())
                ->help('<strong>Категория не появится в блоке рекоммендуемых, если у нее не будет рекоммендуемых товаров, 
                                    вне зависимости от того, выставлена здесь галочка или нет
                                </strong>'),
            Boolean::make('Статус','is_active')->default(true),
            new Panel('Картинки', $this->imageFields()),
        ];
    }

    public function imageFields()
    {
        return [
            Select::make('Цвет ссылки', 'color_class_prefix')->options([
                'brown' => 'Коричневый',
                'dark' => 'Серый',
                'blue' => 'Темно-голубой',
            ])
                ->showOnUpdating($this->isFirstLevelCategory())
                ->hideFromIndex(),
            Image::make('Изображение категории svg', 'svg_logo')
                ->showOnUpdating($this->isImagable())
                ->hideFromIndex()
                ->disk('public')
                ->updateRules('mimes:svg', 'max:10240')
                ->maxWidth(60)
                ->storeAs(function (Request $request) {
                    return '/categories/images/svg/'.$request->svg_logo->getClientOriginalName();
                })
                ->disableDownload(),
            Image::make('Изображение категории (фоновое) маленькое', 'logo_small')
                ->showOnUpdating($this->isImagable())
                ->disk('public')
                ->hideFromIndex()
                ->updateRules('mimes:png,jpeg,jpg', 'max:10240')
                ->storeAs(function (Request $request) {
                    return 'categories/images/small/'.$request->logo_small->getClientOriginalName();
                })
                ->disableDownload(),
            Image::make('Изображение категории (фоновое)', 'logo')
                ->showOnUpdating($this->isImagable())
                ->hideFromIndex()
                ->disk('public')
                ->updateRules('mimes:png,jpeg,jpg', 'max:10240')
                ->storeAs(function (Request $request) {
                    return '/categories/images/'.$request->logo->getClientOriginalName();
                })
                ->disableDownload()
        ];
    }


    /**
     * Проверяет текущую категорию на вложенность, если ее уровень 1 или 2, то выводит поля заполнения картинок
     *
     * @return bool
     */
    public function isImagable()
    {
        $first = Category::getFirstLevelCategories()->get();

        $isFirstLevel = $first->contains('id', $this->id);

        $isSecondLevel = false;

        foreach ($first as $f) {
            if($f->childs->contains('id', $this->id)) {
                $isSecondLevel = true;
            }
        }

        return $isFirstLevel || $isSecondLevel;
    }

    public function isFirstLevelCategory()
    {
        $first = Category::getFirstLevelCategories()->get();

        $isFirstLevel = $first->contains('id', $this->id);

        return $isFirstLevel;
    }

    public function isNotFirstLevelCategory()
    {
        $first = Category::getFirstLevelCategories()->get();

        $isFirstLevel = $first->contains('id', $this->id);

        return !$isFirstLevel;
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
