<?php

namespace App\Models;

use App\Http\Middleware\Locale;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yadakhov\InsertOnDuplicateKey;

class Category extends Model
{
    use InsertOnDuplicateKey;

    protected $table = 'categories';
    protected $guarded = [];

    /**
     * При парсинге брэндов формируем slug из названия брэнда
     *
     * @param $name
     */
    public function setNameAttribute($name)
    {
        $this->attributes['name_ru'] = $name;
        $this->attributes['slug'] = Str::slug($name);
    }

    /**
     * Используем этот метод чтобы сделать ЧПУ
     * и переходить на страницу отдельного брэнда по slug, а не по id
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function parent()
    {
        return $this->belongsTo(self::class,'parent_id');
    }

    public function childs()
    {
        return $this->hasMany(self::class,'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    public function collections()
    {
        return $this->hasMany(Collection::class, 'category_id', 'id');
    }

    public function firstLevelCategoryPromoBlock()
    {
        return $this->hasOne(CategoriesFirstLevelPromoProducts::class, 'category_id', 'id');
    }

    public function getFirstChild()
    {
        return $this->childs->first();
    }

    public function getBrands()
    {
        $brands = [];

        // 10382 = id плитки
        if((int)$this->id === 10382) {
            $query_result_rows = DB::select("
                select
                    brands.id as 'brand_id',
                    brands.name as 'brand_name',
                    brands.slug as 'brand_slug',
                    brands.image as 'brand_image'
                        from `categories` as second_level_categories
                            join `products` as products on products.category_id=second_level_categories.id and products.is_visible=1
                            left join `brands` as brands on brands.id=products.brand_id
                                where second_level_categories.parent_id=? and second_level_categories.is_active=1
            ", [$this->id]);
        } else {
            $query_result_rows = DB::select("
                select
                    brands.id as 'brand_id',
                    brands.name as 'brand_name',
                    brands.slug as 'brand_slug',
                    brands.image as 'brand_image'
                        from `categories` as second_level_categories
                            join `categories` as third_level_categories on third_level_categories.parent_id=second_level_categories.id and third_level_categories.is_active=1
                            join `products` as products on products.category_id=third_level_categories.id and products.is_visible=1
                            left join `brands` as brands on brands.id=products.brand_id
                                where second_level_categories.parent_id=? and second_level_categories.is_active=1
            ", [$this->id]);
        }

        foreach ($query_result_rows as $row) {
//            if(count($brands) >= 20) {
//                continue;
//            } else {
                if(!array_key_exists($row->brand_id, $brands)) {
                    if($row->brand_id) {
                        $brand = [
                            'id' => $row->brand_id,
                            'name' => $row->brand_name,
                            'slug' => $row->brand_slug,
                            'link_to_single_brand_page' => route('pages.brands.show', [$row->brand_slug])
                        ];

                        if(Storage::disk('public')->exists('brands/'.$row->brand_image)) {
                            $brand['image'] = Storage::disk('public')->url('brands/'.$row->brand_image);
                        } else {
                            $brand['image'] = Storage::disk('public')->url('brands/default-brand-placeholder.png');
                        }

                        $brands[$row->brand_id] = $brand;
                    }
                }
//            }
        }

        if(empty($brands)) {
            return Brand::all()/*->take(20)*/->map(function ($b) {
                if(Storage::disk('public')->exists('brands/'.$b->image)) {
                    $b['image'] = Storage::disk('public')->url('brands/'.$b->image);
                } else {
                    $b['image'] = Storage::disk('public')->url('brands/default-brand-placeholder.png');
                }

                $b['link_to_single_brand_page'] = route('pages.brands.show', [$b->slug]);

                return $b;
            });
        } else {
            return $brands;
        }
    }

    public static function getCategoriesWithUniqueKeys() {
        $pdo = DB::connection()->getPdo();
        $query = $pdo->prepare("SELECT *, id FROM categories");
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_UNIQUE|\PDO::FETCH_ASSOC);
    }

    /**
     * Получаем все категории, у которых parent_id равен 1,
     * так как в базе существует поддельная главная категория "каталог"
     * от которой наследуются все реальные категории 1 уровня
     *
     * @param $query
     * @return mixed
     */
    public function scopeGetFirstLevelCategories($query)
    {
        return $query->where('parent_id', 1);
    }

    public function scopeOfSlug($query, $slug) {
        return $query->where('slug', $slug);
    }

    public function scopeIsActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeIsRecommended($query)
    {
        return $query->where('is_recommended', 1);
    }

    public function scopeOfParentCategory($query, $parent_id)
    {
        return $query->where('parent_id', $parent_id);
    }

    public function scopeCategoriesForSearch($query, $lang, $str) {
        return $query->where('name_' . $lang, 'regexp', '^' . $str);
    }
}
