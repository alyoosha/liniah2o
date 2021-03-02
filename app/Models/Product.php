<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yadakhov\InsertOnDuplicateKey;

class Product extends Model
{
    use InsertOnDuplicateKey;

    protected $table = 'products';
    protected $guarded = [];

    public $timestamps = true;

    protected $appends = [
        'filtered_price',
        'slug',
    ];

    public function getSlugAttribute() {
        $slug =  Str::slug($this->name_ru) . '-' . $this->articul;
        return preg_replace('/(?<=\d)(x)(?=\d)/i', '-', $slug);
    }

    public static function getTags($tags) {
        $tagsIds = explode(',', $tags);
        $tags = collect([]);

        foreach ($tagsIds as $tagId) {
            $tag = Tag::find($tagId);

            if($tag) {
                $tags[] = $tag;
            }
        }

        return $tags;
    }

    public static function getProductsByArticulsOfProduct($articuls) {
        $articulsIds = json_decode($articuls) ? json_decode($articuls) : [];
        $products = collect([]);

        foreach ($articulsIds as $articulId) {
            $pt = Product::ofArticul($articulId)->first();
            if(!$pt) continue;
            $products->push($pt);
        }

        return $products;
    }

    public static function getArticulBySlug($value) {
        return array_reverse(explode('-', $value))[0];
    }

    public function getFilteredPriceAttribute()
    {
        $filtered_price = $this->price;

        if($this->discount_price != 0) {
            $filtered_price = $this->discount_price;
        }

        return $filtered_price;
    }

    public function getPreviewPicture()
    {
        $imageList =  (array) json_decode($this->images);

        if(!empty($imageList) && Storage::disk('public')->exists('products/' . $imageList[0]) && Storage::disk('public')->exists('compressed_images/products/images_optimized/'.$imageList[0])) {
            return Storage::disk('public')->url('compressed_images/products/images_optimized/'.$imageList[0]);
        } else {
            return Storage::disk('public')->url('products/product-img-default.jpg');
        }
    }

    public function getLink()
    {
        $product_slug_attribute =  Str::slug($this->name_ru) . '-' . $this->articul;
        $product_slug_attribute = preg_replace('/(?<=\d)(x)(?=\d)/i', '-', $product_slug_attribute);

        return route('pages.product.index', [$product_slug_attribute]);
    }

    public function categoriesFirstLevelNew()
    {
        return $this->hasMany(CategoriesFirstLevelPromoProducts::class, 'new_product_id', 'id');
    }

    public function categoriesFirstLevelPromotion()
    {
        return $this->hasMany(CategoriesFirstLevelPromoProducts::class, 'promotion_product_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function collection()
    {
        return $this->belongsTo(Collection::class, 'collection_id', 'id');
    }

    public function images_table()
    {
        return $this->hasMany(Images::class, 'product_articul', 'articul');
    }

    public function scopeIsRecommended($query)
    {
        return $query->where('recommended', 1);
    }

    public function scopeIsVisible($query)
    {
        return $query->where('is_visible', 1);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Фильтр продукта по бренду
     *
     * @param $query
     * @param $brand_id
     * @return mixed
     */
    public function scopeOfBrand($query, $brand_id)
    {
        return $query->when($brand_id, function ($query) use ($brand_id) {
            return $query->where('brand_id', $brand_id);
        });
    }

    public function scopeOfBrands($query, $brands)
    {
        if(!empty($brands)) {
            return $query->whereIn('brand_id', $brands);
        } else {
            return $query;
        }
    }

    public function scopeOfPromotion($query, $promotionId) {
        return $query->whereRaw("FIND_IN_SET($promotionId,tags)");
    }

    public function scopeOfTag($query, $tagId)
    {
        return $query->whereRaw("FIND_IN_SET($tagId,tags)");
    }

    public function scopeOfTags($query, $tagIds)
    {
        if(!empty($tagIds)) {
            if($tagIds[0] !== 1) {
                $query->whereRaw("FIND_IN_SET($tagIds[0],tags)");
            } else {
                $query->where('stock', '>', 0);
            }

            $countOfTags = count($tagIds);

            for($i = 1; $i < $countOfTags; $i++) {
                if($tagIds[$i] !== 1) {
                    $query->orWhereRaw("FIND_IN_SET('$tagIds[$i]',tags)");
                } else {
                    $query->orWhere('stock', '>', 0);
                }
            }

            return $query;
        } else {
            return $query;
        }
    }

    public function scopeOfCountries($query, $countries)
    {
        if(!empty($countries)) {
            $brands = Brand::whereIn('country_id', $countries)->get()->map(function ($b) {
                return $b->id;
            })->toArray();

            return $query->whereIn('brand_id', $brands);
        } else {
            return $query;
        }
    }

    public function scopeOfColors($query, $colors)
    {
        if(!empty($colors)) {
            $query->where('color', $colors[0]);

            $countOfColors = count($colors);

            for($i = 1; $i < $countOfColors; $i++) {
                $query->orWhere('color', $colors[$i]);
            }

            return $query;
        } else {
            return $query;
        }
    }

    public function scopeOfFeatures($query, $features)
    {
        if(!empty($features)) {
            $query->whereRaw("JSON_CONTAINS(products.features->'$.ids', '[$features[0]]')");

            $countOfFeatures = count($features);

            for($i = 1; $i < $countOfFeatures; $i++) {
                $query->orWhereRaw("JSON_CONTAINS(products.features->'$.ids', '[$features[$i]]')");
            }

            return $query;
        } else {
            return $query;
        }
    }

    /**
     * Фильтр продукта по одной или нескольким категориям разных уровней
     *
     * @param $query
     * @param $category_first_id
     * @param $category_second_id
     * @param $category_third_id
     * @return mixed
     */
    public function scopeOfCategories($query, $category_first_id, $category_second_id, $category_third_id) {
        if($category_first_id && !$category_second_id && !$category_third_id) {
            $first_level_category = Category::find($category_first_id);

            $category_ids = [];

            if($first_level_category) {
                foreach ($first_level_category->childs as $second_level_category) {
                    $category_ids[] = $second_level_category->id;

                    foreach ($second_level_category->childs as $third_level_category) {
                        $category_ids[] = $third_level_category->id;
                    }
                }
            }

            return $query->whereIn('category_id', $category_ids);
        } elseif($category_first_id && $category_second_id && !$category_third_id) {
            $second_level_category = Category::find($category_second_id);

            $category_ids = [];
            $category_ids[] = $second_level_category->id;

            foreach ($second_level_category->childs as $third_level_category) {
                $category_ids[] = $third_level_category->id;
            }

            return $query->whereIn('category_id', $category_ids);
        } elseif($category_first_id && $category_second_id && $category_third_id) {
            return $query->where('category_id', $category_third_id);
        } else {
            return $query;
        }
    }

    public function scopeOfCategory($query, $id)
    {
        return $query->where('category_id', $id);
    }

    public function scopeOfIsTileProduct($query, $first_id, $second_id) {
        if($first_id && !$second_id) {
            $first_level_category = Category::find($first_id);

            if($first_level_category) {
                $countOfChildren = count($first_level_category->childs);

                $query->where('category_id', $first_level_category->childs[0]->id);

                for($i = 1; $i < $countOfChildren; $i++) {
                    $query->orWhere('category_id', $first_level_category->childs[$i]->id);
                }

                return $query;
            } else return $query;
        } else return $query->where('category_id', $second_id);
    }

    public function scopeOfSecondLevelCategory($query, $id) {
        $second_level_category = Category::find($id);

        $matchConditionList = [];

        if($second_level_category) {
            foreach ($second_level_category->childs as $third_level_category) {
                $matchConditionList[] = $third_level_category->id;
            }
        }

        return $query->whereIn('category_id', $matchConditionList);
    }

    public function scopeProductsByName($query, $lang, $str) {
        $query->where('name_' . $lang, 'regexp', '^' . $str);
    }

    public function scopeOfArticul($query, $articul)
    {
        $query->where('articul', $articul);
    }
}
