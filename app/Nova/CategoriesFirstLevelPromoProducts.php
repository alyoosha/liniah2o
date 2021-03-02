<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use App\Models\Tag;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Nova\Item as NewItem;
use App\Nova\Item as PromotionItem;

class CategoriesFirstLevelPromoProducts extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\CategoriesFirstLevelPromoProducts::class;

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

    public static $group = 'Страницы';

    public static function label()
    {
        return 'Каталог 1 уровня';
    }

    public static $displayInNavigation = false;

    public static function singularLabel()
    {
        return 'акционный товар и новинку для промо блока категории';
    }

    /**
     * Build a "relatable" query for the given resource.
     *
     * This query determines which instances of the model may be attached to other resources.
     */
    public static function relatableCategories(NovaRequest $request, $query)
    {
        return $query->getFirstLevelCategories()->isActive();
    }

//    public static function relatableProducts(NovaRequest $request, $query)
//    {
//        $newTagId = Tag::isNew()->get('id')->map(function ($p) {
//            return $p->id;
//        })->toArray();
//
//        $queryString = "FIND_IN_SET($newTagId[0],tags)";
//
//        $promotionsIds = Tag::isPromotion()->get('id')->map(function ($p) {
//            return $p->id;
//        })->toArray();
//
//        foreach ($promotionsIds as $id) {
//            $queryString .= "OR FIND_IN_SET($id,tags)";
//        }
//
//        $salesIds = Tag::isSale()->get('id')->map(function ($p) {
//            return $p->id;
//        })->toArray();
//
//        foreach ($salesIds as $id) {
//            $queryString .= "OR FIND_IN_SET($id,tags)";
//        }
//
//        return $query->whereRaw($queryString);
//    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            BelongsTo::make('Категория 1 уровня', 'firstLevelCategory', 'App\Nova\Category')
                ->creationRules('unique:categories_first_level_new_and_promotion_products,category_id')
                ->updateRules('unique:categories_first_level_new_and_promotion_products,category_id,{{resourceId}}'),
            BelongsTo::make('Новинка', 'newProduct', NewItem::class)
                ->searchable()
                ->help(
                    '
                        Выбираются только товары, которые являются либо акционными, либо новинками (присвоен тег "Новинка")<br>
                        <b>Поиск может осуществляться по</b>
                        <ul style="list-style: none; padding-left: 10px;">
                            <li>
                                ID товара
                            </li>
                            <li>
                                Артикулу товара
                            </li>
                            <li>
                                Названию товара
                            </li>
                        </ul>
                    '
                ),
            BelongsTo::make('Акционный товар', 'promotionProduct', PromotionItem::class)
                ->searchable()
                ->help(
                    '
                        Выбираются только товары, которые являются либо акционными, либо новинками (присвоен тег "Новинка")<br>
                        <b>Поиск может осуществляться по</b>
                        <ul style="list-style: none; padding-left: 10px;">
                            <li>
                                ID товара
                            </li>
                            <li>
                                Артикулу товара
                            </li>
                            <li>
                                Названию товара
                            </li>
                        </ul>
                    '
                ),
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
