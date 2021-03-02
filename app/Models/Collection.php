<?php

namespace App\Models;

use App\Http\Middleware\Locale;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Collection extends Model
{
    protected $table = 'collections';

    public $timestamps = false;

    protected $appends = [
        'slug',
        'filtered_price',
    ];

    public function brand() {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'collection_id', 'id');
    }

    public function getFilteredPriceAttribute()
    {
        $filtered_price = $this->price;

        if($this->discount_price != 0) {
            $filtered_price = $this->discount_price;
        }

        return $filtered_price;
    }

    public function getSlugAttribute() {
        return Str::slug($this->name_ru) . '-' . $this->id;
    }

    public static function getIdBySlug($value) {
        return array_reverse(explode('-', $value))[0];
    }

    public function getPreviewPicture()
    {
        $imageList = json_decode($this->images);

        if(!empty($imageList) && Storage::disk('public')->exists('collections/' . $imageList[0]) && Storage::disk('public')->exists('compressed_images/collections/images_optimized/'.$imageList[0])) {
            return Storage::disk('public')->url('compressed_images/collections/images_optimized/'.$imageList[0]);
        } else {
            return Storage::disk('public')->url('products/product-img-default.jpg');
        }
    }

    public static function getProducts($products) {
        $products = collect(json_decode(json_decode($products)->ids)) ?? [];

        $products = $products->map(function ($item) {
            $product = Product::ofArticul($item)->first();
            $product['arTags'] = !empty($product->tags) ? Product::getTags($product->tags) : [];
            $product['imgPreview'] = $product->getPreviewPicture();

            return $product;
        });

        return $products;
    }

    public function scopeIsVisible($query) {
        return $query->where('is_visible', 1);
    }

    public function scopeOfCategory($query, $id)
    {
        return $query->where('category_id', $id);
    }

    public function scopeOfBrands($query, $brands)
    {
        if(!empty($brands)) {
            return $query->whereIn('brand_id', $brands);
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

    public function scopeOfFeatures($query, $features)
    {
        if(!empty($features)) {
            $query->whereRaw("JSON_CONTAINS(collections.features->'$.ids', '[$features[0]]')");

            $countOfFeatures = count($features);

            for($i = 1; $i < $countOfFeatures; $i++) {
                $query->orWhereRaw("JSON_CONTAINS(collections.features->'$.ids', '[$features[$i]]')");
            }

            return $query;
        } else {
            return $query;
        }
    }
}
