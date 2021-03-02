<?php


namespace App\Http\Controllers\Pages;


use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PromotionController extends Controller
{
    protected $promotions;
    protected const HTTP_NOTFOUND_CODE = 404;
    protected const HTTP_SUCCESS_CODE = 200;

    public function index()
    {
        $this->promotions = Tag::isPromotion()->get();
        $promotions = $this->setPathToSinglePromotionPage();
        $storage_path = asset('storage/');

        return view('pages.promotions.index', compact('promotions', 'storage_path'));
    }

    public function setPathToSinglePromotionPage()
    {
        $promotions = $this->promotions->map(function ($p) {
            $p['singlePagePath'] = route('pages.promotions.show', $p->slug);

            return $p;
        });

        return $promotions;
    }

    public function show(string $slug)
    {
        $promotion = Tag::isPromotion()->where('slug', $slug)->first();

        abort_unless($promotion, self::HTTP_NOTFOUND_CODE);

        $query = "
            select
                parent_category.id as 'product_parent_category_id',
                parent_category.name_ru as 'product_parent_category_name_ru',
                parent_category.name_ro as 'product_parent_category_name_ro',
                parent_category.slug as 'product_parent_category_slug',
                   
                parent_parent_category.id as 'product_parent_parent_category_id',
                parent_parent_category.name_ru as 'product_parent_parent_category_name_ru',
                parent_parent_category.name_ro as 'product_parent_parent_category_name_ro',
                parent_parent_category.slug as 'product_parent_parent_category_slug',
                   
                parent_parent_parent_category.id as 'product_parent_parent_parent_category_id',
                parent_parent_parent_category.name_ru as 'product_parent_parent_parent_category_name_ru',
                parent_parent_parent_category.name_ro as 'product_parent_parent_parent_category_name_ro',
                parent_parent_parent_category.slug as 'product_parent_parent_parent_category_slug',
                
                products.id as 'product_id',
                products.articul as 'product_articul',
                products.category_id as 'product_category_id',
                products.name_ru as 'product_name_ru',
                products.name_ro as 'product_name_ro',
                products.unit_ru as 'product_unit_ru',
                products.unit_ro as 'product_unit_ro',
                products.price as 'product_price',
                products.discount_price as 'product_discount_price',
                products.stock as 'product_stock',
                products.images as 'product_images',
                products.tags as 'product_tags',
                products.complements as 'product_complements',
                products.collection_id as 'collection_id',
                
                brands.id as 'product_brand_id',
                brands.name as 'product_brand_name',
                brands.slug as 'product_brand_slug',
                brands.image as 'product_brand_image_name'
                    from `products` as products
                        left join `brands` as brands on brands.id=products.brand_id
                        left join `categories` as parent_category on parent_category.id=products.category_id and parent_category.is_active=1
                        left join `categories` as parent_parent_category on parent_parent_category.id=parent_category.parent_id and parent_parent_category.is_active=1
                        left join `categories` as parent_parent_parent_category on parent_parent_parent_category.id=parent_parent_category.parent_id and parent_parent_parent_category.is_active=1
                            where products.is_visible=1 and FIND_IN_SET($promotion->id,tags)
        ";
        $query_result_rows = DB::select($query);
        $products = collect([]);
        $tagsForChoose = Tag::all();

        foreach ($query_result_rows as $row) {
            $p = collect([]);

            $tagsIds = explode(',', $row->product_tags);

            $p['articul'] = $row->product_articul;
            $p['name_ru'] = $row->product_name_ru;
            $p['name_ro'] = $row->product_name_ro;
            $p['price'] = $row->product_price;
            $p['discount_price'] = $row->product_discount_price;
            $p['unit_ru'] = $row->product_unit_ru;
            $p['unit_ro'] = $row->product_unit_ro;
            $p['stock'] = $row->product_stock;
            $p['collection_id'] = $row->collection_id;

            $p['tags'] = collect([]);
            $p['tags'] = $tagsForChoose->filter(function ($tag) use($tagsIds) {
                if(in_array($tag->id, $tagsIds)) {
                    return $tag;
                }
            })->values();

            $p['brand_id'] = $row->product_brand_id;
            $p['brand_slug'] = $row->product_brand_slug;
            $p['brand_name'] = $row->product_brand_name;

            if(Storage::disk('public')->exists('brands/'.$row->product_brand_image_name)) {
                $p['brand_image'] = Storage::disk('public')->url('brands/'.$row->product_brand_image_name);
            } else {
                $p['brand_image'] = Storage::disk('public')->url('brands/default-brand-placeholder.png');
            }

            $p['go_to_brand_path'] = route('pages.brands.index');

            $product_image_list = json_decode($row->product_images);

            if(!empty($product_image_list) && Storage::disk('public')->exists('products/'.$product_image_list[0])) {
                $p['preview_picture'] = Storage::disk('public')->url('products/'.$product_image_list[0]);
            } else {
                $p['preview_picture'] = Storage::disk('public')->url('products/product-img-default.jpg');
            }

            $product_slug_attribute =  Str::slug($row->product_name_ru) . '-' . $row->product_articul;
            $product_slug_attribute = preg_replace('/(?<=\d)(x)(?=\d)/i', '-', $product_slug_attribute);

            $p['product_link'] = route('pages.product.index', [$product_slug_attribute]);

            $products[] = $p;
        }

        $brands = $this->getBrands($products);
        $first_level_categories = $this->getFirstLevelCategories($query_result_rows);
        $second_level_categories_for_match = $this->getSecondLevelCategories($query_result_rows);
        $third_level_categories_for_match = $this->getThirdLevelCategories($query_result_rows);

        $catalog_path = route('pages.catalog.index');
        $storage_path = asset('storage/');

        return view('pages.promotions.show', compact(
            'promotion',
            'products',
            'brands',
            'first_level_categories',
            'second_level_categories_for_match',
            'third_level_categories_for_match',
            'catalog_path',
            'storage_path'
        ));
    }

    public function getBrands($products)
    {
        $brands = collect([]);

        foreach ($products as $p) {
            $brand = collect([]);
            $brand['id'] = $p['brand_id'];
            $brand['name'] = $p['brand_name'];
            $brand['slug'] = $p['brand_slug'];

            if(!$brands->has($p['brand_id'])) {
                $brands[$p['brand_id']] = $brand;
            }
        }

        return $brands;
    }

    public function getFirstLevelCategories($products)
    {
        $categories = collect([]);

        foreach ($products as $p) {
            $category = collect([]);

            if($p->product_parent_parent_parent_category_id && (int)$p->product_parent_parent_parent_category_id !== 1) {
                $category['id'] = $p->product_parent_parent_parent_category_id;
                $category['name_ru'] = $p->product_parent_parent_parent_category_name_ru;
                $category['name_ro'] = $p->product_parent_parent_parent_category_name_ro;

                if(!$categories->has($p->product_parent_parent_parent_category_id)) {
                    $categories[$p->product_parent_parent_parent_category_id] = $category;
                }
            } else {
                $category['id'] = $p->product_parent_parent_category_id;
                $category['name_ru'] = $p->product_parent_parent_category_name_ru;
                $category['name_ro'] = $p->product_parent_parent_category_name_ro;

                if(!$categories->has($p->product_parent_parent_category_id)) {
                    $categories[$p->product_parent_parent_category_id] = $category;
                }
            }
        }

        return $categories;
    }

    public function getSecondLevelCategories($products)
    {
        $categories = collect([]);

        foreach ($products as $p) {
            $category = collect([]);

            if($p->product_parent_parent_category_id && (int)$p->product_parent_parent_parent_category_id !== 1) {
                $category['id'] = $p->product_parent_parent_category_id;
                $category['name_ru'] = $p->product_parent_parent_category_name_ru;
                $category['name_ro'] = $p->product_parent_parent_category_name_ro;

                if(!$categories->has($p->product_parent_parent_category_id)) {
                    $categories[$p->product_parent_parent_category_id] = $category;
                }
            } else {
                $category['id'] = $p->product_parent_category_id;
                $category['name_ru'] = $p->product_parent_category_name_ru;
                $category['name_ro'] = $p->product_parent_category_name_ro;

                if(!$categories->has($p->product_parent_category_id)) {
                    $categories[$p->product_parent_category_id] = $category;
                }
            }
        }

        return $categories;
    }

    public function getThirdLevelCategories($products)
    {
        $categories = collect([]);

        foreach ($products as $p) {
            $category = collect([]);

            if($p->product_parent_category_id) {
                $category['id'] = $p->product_parent_category_id;
                $category['name_ru'] = $p->product_parent_category_name_ru;
                $category['name_ro'] = $p->product_parent_category_name_ro;

                if(!$categories->has($p->product_parent_category_id)) {
                    $categories[$p->product_parent_category_id] = $category;
                }
            }
        }

        return $categories;
    }
}
