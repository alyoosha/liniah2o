<?php

namespace App\Nova;

use App\Models\Feature;
use App\Models\FeatureType;
use App\Models\Tag;
use Egorovagency\FieldAdditionalImages\FieldAdditionalImages;
use Egorovagency\FieldMultiselect\FieldMultiselect;
use Eminiarts\Tabs\TabsOnEdit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use App\Models\Category;


class Item extends Resource
{
//    use TabsOnEdit;
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Models\Product';

    public function title()
    {

        $subtitle = '';

        $newTagId = Tag::isNew()->get('id')->map(function ($p) {
            return $p->id;
        })->toArray()[0];

        $tags = explode(',', $this->tags);

        if(in_array($newTagId, $tags)) {
            $subtitle .= "Новинка";
        }

        $promotionsIds = Tag::isPromotion()->get('id')->map(function ($p) {
            return $p->id;
        })->toArray();

        foreach ($promotionsIds as $id) {
            if(in_array($id, $tags)) {
                $subtitle .= " Акция";
                break;
            }
        }

        $salesId = Tag::isSale()->get('id')->map(function ($p) {
            return $p->id;
        })->toArray()[0];

        $tags = explode(',', $this->tags);

        if(in_array($salesId, $tags)) {
            $subtitle .= "Распродажа";
        }

        $category = Category::find($this->category_id);

        return $this->name_ru. ' |' . $subtitle . ' | Категория - ' . $category->parent->parent->name_ru . ' -> ' . $category->parent->name_ru . ' -> ' . $category->name_ru;
    }

    public function subtitle()
    {
        $subtitle = '';

        $newTagId = Tag::isNew()->get('id')->map(function ($p) {
            return $p->id;
        })->toArray()[0];

        $tags = explode(',', $this->tags);

        if(in_array($newTagId, $tags)) {
            $subtitle .= "Новинка";
        }

        $promotionsIds = Tag::isPromotion()->get('id')->map(function ($p) {
            return $p->id;
        })->toArray();

        foreach ($promotionsIds as $id) {
            if(in_array($id, $tags)) {
                $subtitle .= " Акция (скидка: ".(int)Tag::find($id)->first()['discount']."%) | ". Str::limit(Tag::find($id)->first()['name_ru'], 40, '...');
                break;
            }
        }

        $salesId = Tag::isSale()->get('id')->map(function ($p) {
            return $p->id;
        })->toArray()[0];

        $tags = explode(',', $this->tags);

        if(in_array($salesId, $tags)) {
            $subtitle .= " Распродажа";
        }

        return $subtitle;
    }

    public static $group = 'Админ';

    public static $trafficCop = false;

    public static function label()
    {
        return 'Товары';
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'articul',
        'name_ru',
        'id'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make('ID')
                ->sortable(),

            Text::make('Наименование','name_ru')
                ->hideWhenUpdating()
                ->sortable(),

            FieldMultiselect::make("Теги", 'tags', function (){
                $ts = explode(',', $this->tags);
                $tagsAll= Tag::all();
                $tags = [];

                foreach ($ts as $tag) {
                    $t = Tag::find($tag, ['id', 'name_ru']);

                    if(!empty($t)) {
                        $tags[] = $t;
                    }
                }
                $tags = collect($tags);
                $items = $tags->map(function ($tag){
                    return [
                        'id' => $tag->id,
                        'value' => $tag->name_ru
                    ];

                });

                $itemsAll = $tagsAll->map(function ($tag){
                    return [
                        'id' => $tag->id,
                        'value' => $tag->name_ru
                    ];

                });

                $group = false;
                return compact(['items', 'itemsAll', 'group']);
            })
                ->hideFromIndex(),

            FieldMultiselect::make("Опции", 'features', function (){
                $items = json_decode($this->features, JSON_UNESCAPED_UNICODE)
                ? json_decode($this->features, JSON_UNESCAPED_UNICODE)
                : [];

                $featureTypesAll= FeatureType::all();

                $itemsAll = $featureTypesAll->map(function ($featureType) {
                    $features = null;
                    $options = null;

                    if(!$featureType->features->isEmpty()) {
                        $features = $featureType->features;
                        $a = null;
                        foreach ($features as $k => $f) {
                            $options[$k]['id'] = $f->id;
                            $options[$k]['value'] = $f->value_ru;
                        }
                    }
                    return [
                        'id' => $featureType->id,
                        'value' => $featureType->name_ru,
                        'options' => $options,
                    ];
                });

                $group = true;
                return compact(['items', 'itemsAll', 'group']);
            })
                ->hideFromIndex(),

            BelongsTo::make('Бренд', 'brand', 'App\Nova\Brand')
                ->hideWhenUpdating()
                ->sortable(),

            Text::make('Категория', function () {
                $category = Category::find($this->category_id);
                if(!empty($category)) return $category->parent->name_ru;
            })
                ->hideWhenUpdating()
                ->hideFromIndex(),

            BelongsTo::make('Подкатегория', 'category', 'App\Nova\Category')
                ->sortable()
                ->hideWhenUpdating()
                ->hideFromIndex(),

            Text::make('Цена', 'price')
                ->hideWhenUpdating()
                ->hideFromIndex(),

            Text::make('Количество', 'stock')
                ->sortable()
                ->hideWhenUpdating()
                ->hideFromIndex(),

            Image::make('Основное изображение', 'images')
                ->disk('public')
                ->preview(function () {
                    $image = json_decode($this->images)[0];
                    return Storage::disk('public')->exists('/products/'.$image)
                        ? Storage::disk('public')->url('/products/'.$image)
                        : Storage::disk('public')->url('/products/product-img-default.jpg');
                })
                ->path('products')
                ->disableDownload()
                ->hideWhenUpdating()
                ->hideFromIndex(),

            FieldAdditionalImages::make('Дополнительные изображения', function () {
                $images = $this->images;
                $path = Storage::url('/products/');
                return compact(['images', 'path']);
            })
                ->hideFromIndex()
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
