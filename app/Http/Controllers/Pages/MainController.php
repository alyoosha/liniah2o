<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Homepage;
use App\Models\Product;
use App\Models\PromoBlock;
use App\Models\PromoSlider;
use App\Models\Tag;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MainController extends Controller
{
    protected const RECOMMENDED_PRODUCTS_LIMIT = 12;
    protected const TILE_CATEGORY_ID = 10382;
    protected const SUCCESS_STATUS_CODE = 200;
    protected const SUCCESS_MESSAGE = 'OK';
    protected $tagsForChoose;

    public function __construct()
    {
        parent::__construct();
        $this->tagsForChoose = Tag::all();
    }

    public function index() {
        $slides = PromoSlider::published()->get();

        $non_tile_recommended_products = $this->getNonTileRecommendedProducts();
        $tile_recommended_products = $this->getTileRecommendedProducts();
        $json_encoded_recommended_products = $this->getJsonEncodedRecommendedProducts($non_tile_recommended_products, $tile_recommended_products);

        $blocks = PromoBlock::find(1);
        $aboutUsBlock = Homepage::findOrFail(1);
        $oddsBlock = json_decode($aboutUsBlock->odds, JSON_UNESCAPED_UNICODE);

        $brands = Brand::all()->take(12)->map(function ($b) {
            $b['preview_image'] = Storage::disk('public')->url('brands/'.$b->image);
            $b['link_to_brand_page'] = route('pages.brands.show', [$b->slug]);

            return $b;
        });

        $route_cart = route('pages.cart.index');
        $catalog_path = route('pages.catalog.index');

        return view('pages.home', compact(
            'slides',
            'blocks',
            'brands',
            'catalog_path',
            'aboutUsBlock',
            'oddsBlock',
            'route_cart',
            'json_encoded_recommended_products'
        ));
    }

    public function getTileRecommendedProducts()
    {
        $query_result_rows = DB::select(
            "select 
                    first_level_category.id as 'first_level_category_id',
                    first_level_category.name_ru as 'first_level_category_name_ru',
                    first_level_category.name_ro as 'first_level_category_name_ro',
                    first_level_category.slug as 'first_level_category_slug',
                    first_level_category.svg_logo as 'first_level_category_svg_logo',
                    
                    second_level_category.id as 'second_level_category_id',
                    second_level_category.parent_id as 'second_level_category_parent_id',
                    second_level_category.slug as 'second_level_category_slug',
                    
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
                    products.created_at,
                    products.updated_at,
                    
                    brands.id as 'product_brand_id',
                    brands.name as 'product_brand_name',
                    brands.slug as 'product_brand_slug',
                    brands.image as 'product_brand_image_name'
                        from `categories` as first_level_category 
                            join `categories` as second_level_category on second_level_category.parent_id=first_level_category.id
                            
                            left join `products` as products on products.category_id=second_level_category.id AND products.recommended=1 AND products.is_visible=1
                            
                            left join `brands` as brands on brands.id=products.brand_id
                            
                                where first_level_category.parent_id=1
                                    AND first_level_category.is_active=1 
                                    AND first_level_category.is_recommended=1
                                    
                                    AND first_level_category.id = ?
                                order by products.updated_at DESC, products.created_at DESC
               ",
            [self::TILE_CATEGORY_ID]
        );

        $recommendedProducts = [];

        foreach ($query_result_rows as $row) {
            if(!array_key_exists($row->first_level_category_id, $recommendedProducts)) {
                $recommendedProducts[$row->first_level_category_id] = [];

                $category = [];

                $category['id'] = $row->first_level_category_id;
                $category['name_ru'] = $row->first_level_category_name_ru;
                $category['name_ro'] = $row->first_level_category_name_ro;
                $category['slug'] = $row->first_level_category_slug;
                $category['svg_logo'] = $row->first_level_category_svg_logo;

                $recommendedProducts[$row->first_level_category_id]['category_info'] = $category;
            }

            if(count($recommendedProducts[$row->first_level_category_id]) >= self::RECOMMENDED_PRODUCTS_LIMIT) {
                continue;
            } else {
                if($row->product_id) {
                    $product = [];

                    $product['id'] = $row->product_id;
                    $product['articul'] = $row->product_articul;
                    $product['name_ru'] = $row->product_name_ru;
                    $product['name_ro'] = $row->product_name_ro;
                    $product['price'] = $row->product_price;
                    $product['discount_price'] = $row->product_discount_price;
                    $product['unit_ru'] = $row->product_unit_ru;
                    $product['unit_ro'] = $row->product_unit_ro;
                    $product['in_stock'] = $row->product_stock > 0 ? true : false;
                    $product['complements'] = $row->product_complements;
                    $product['collection_id'] = $row->collection_id;
                    $product['created_at'] = $row->created_at;
                    $product['updated_at'] = $row->updated_at;

                    $tagsIds = explode(',', $row->product_tags);

                    $product['tags'] = collect([]);
                    $product['tags'] = $this->tagsForChoose->filter(function ($tag) use($tagsIds) {
                        if(in_array($tag->id, $tagsIds)) {
                            return $tag;
                        }
                    })->values();

                    $product['preview_picture'] = get_preview_picture($row->product_images, 'products');

                    $product['brand_id'] = $row->product_brand_id;
                    $product['brand_name'] = $row->product_brand_name;
                    $product['brand_slug'] = $row->product_brand_slug;
                    $product['link_to_brands_page'] = route('pages.brands.index');

                    $product_slug_attribute =  Str::slug($row->product_name_ru) . '-' . $row->product_articul;
                    $product_slug_attribute = preg_replace('/(?<=\d)(x)(?=\d)/i', '-', $product_slug_attribute);

                    $product['link'] = route('pages.product.index', [$product_slug_attribute]);

                    if(Storage::disk('public')->exists('brands/'.$row->product_brand_image_name)) {
                        $product['brand_image'] = Storage::disk('public')->url('brands/'.$row->product_brand_image_name);
                    } else {
                        $product['brand_image'] = Storage::disk('public')->url('brands/default-brand-placeholder.png');
                    }

                    $recommendedProducts[$row->first_level_category_id][] = [$product];
                }
            }
        }

        return $recommendedProducts;
    }

    public function getNonTileRecommendedProducts()
    {
        $query_result_rows = DB::select(
            "select 
                    first_level_category.id as 'first_level_category_id',
                    first_level_category.name_ru as 'first_level_category_name_ru',
                    first_level_category.name_ro as 'first_level_category_name_ro',
                    first_level_category.slug as 'first_level_category_slug',
                    first_level_category.svg_logo as 'first_level_category_svg_logo',
                    
                    second_level_category.id as 'second_level_category_id',
                    second_level_category.parent_id as 'second_level_category_parent_id',
                    second_level_category.slug as 'second_level_category_slug',
                    
                    third_level_category.id as 'third_level_category_id',
                    third_level_category.parent_id as 'third_level_category_parent_id',
                    third_level_category.slug as 'third_level_category_slug',
                    
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
                    products.created_at,
                    products.updated_at,
                    
                    brands.id as 'product_brand_id',
                    brands.name as 'product_brand_name',
                    brands.slug as 'product_brand_slug',
                    brands.image as 'product_brand_image_name'
                        from `categories` as first_level_category 
                            join `categories` as second_level_category on second_level_category.parent_id=first_level_category.id
                            join `categories` as third_level_category on third_level_category.parent_id=second_level_category.id
                            
                            left join `products` as products on products.category_id=third_level_category.id AND products.recommended=1 AND products.is_visible=1
                            
                            left join `brands` as brands on brands.id=products.brand_id
                                where first_level_category.parent_id=1
                                    AND first_level_category.is_active=1 
                                    AND first_level_category.is_recommended=1
                                    
                                    AND first_level_category.id <> ?
                                order by products.updated_at DESC, products.created_at DESC
               ",
            [self::TILE_CATEGORY_ID]
        );

        $recommendedProducts = [];

        foreach ($query_result_rows as $row) {
            if(!array_key_exists($row->first_level_category_id, $recommendedProducts)) {
                $recommendedProducts[$row->first_level_category_id] = [];

                $category = [];

                $category['id'] = $row->first_level_category_id;
                $category['name_ru'] = $row->first_level_category_name_ru;
                $category['name_ro'] = $row->first_level_category_name_ro;
                $category['slug'] = $row->first_level_category_slug;
                $category['svg_logo'] = $row->first_level_category_svg_logo;

                $recommendedProducts[$row->first_level_category_id]['category_info'] = $category;
            }

            if(count($recommendedProducts[$row->first_level_category_id]) >= self::RECOMMENDED_PRODUCTS_LIMIT) {
                continue;
            } else {
                if($row->product_id) {
                    $product = [];

                    $product['id'] = $row->product_id;
                    $product['articul'] = $row->product_articul;
                    $product['name_ru'] = $row->product_name_ru;
                    $product['name_ro'] = $row->product_name_ro;
                    $product['price'] = $row->product_price;
                    $product['discount_price'] = $row->product_discount_price;
                    $product['unit_ru'] = $row->product_unit_ru;
                    $product['unit_ro'] = $row->product_unit_ro;
                    $product['in_stock'] = $row->product_stock > 0 ? true : false;
                    $product['complements'] = $row->product_complements;
                    $product['collection_id'] = $row->collection_id;
                    $product['created_at'] = $row->created_at;
                    $product['updated_at'] = $row->updated_at;

                    $tagsIds = explode(',', $row->product_tags);

                    $product['tags'] = collect([]);
                    $product['tags'] = $this->tagsForChoose->filter(function ($tag) use($tagsIds) {
                        if(in_array($tag->id, $tagsIds)) {
                            return $tag;
                        }
                    })->values();

                    $product['preview_picture'] = get_preview_picture($row->product_images, 'products');

                    $product['brand_id'] = $row->product_brand_id;
                    $product['brand_name'] = $row->product_brand_name;
                    $product['brand_slug'] = $row->product_brand_slug;
                    $product['link_to_brands_page'] = route('pages.brands.index');

                    $product_slug_attribute =  Str::slug($row->product_name_ru) . '-' . $row->product_articul;
                    $product_slug_attribute = preg_replace('/(?<=\d)(x)(?=\d)/i', '-', $product_slug_attribute);

                    $product['link'] = route('pages.product.index', [$product_slug_attribute]);

                    if(Storage::disk('public')->exists('brands/'.$row->product_brand_image_name)) {
                        $product['brand_image'] = Storage::disk('public')->url('brands/'.$row->product_brand_image_name);
                    } else {
                        $product['brand_image'] = Storage::disk('public')->url('brands/default-brand-placeholder.png');
                    }

                    $recommendedProducts[$row->first_level_category_id][] = [$product];
                }
            }
        }

        return $recommendedProducts;
    }

    public function getJsonEncodedRecommendedProducts($non_tile_recommended_products, $tile_recommended_products)
    {
        return json_encode(array_merge($non_tile_recommended_products, $tile_recommended_products), JSON_UNESCAPED_UNICODE);;
    }
}
