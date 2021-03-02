<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Locale;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Feature;
use App\Models\FeatureType;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Psy\Util\Json;
use App\Traits\RelatedProductsTrait;
use App\Traits\WatchedProductsTrait;
use App\Traits\SimilarProductsTrait;
use App\Traits\RecommendedProductsTrait;

class ProductController extends Controller
{
    use RelatedProductsTrait;
    use WatchedProductsTrait;
    use SimilarProductsTrait;
    use RecommendedProductsTrait;

    protected const HTTP_NOTFOUND_CODE = 404;
    protected const WATCHED_PRODUCTS_COUNT = 1;

    public function index(string $product_slug) {
        $isTile = false;

        $articul = Product::getArticulBySlug($product_slug);

        abort_if(!$articul, self::HTTP_NOTFOUND_CODE);

        $query_result_row = DB::select("
            select
                products.id as 'product_id',
                products.articul as 'product_articul',
                products.name_ru as 'product_name_ru',
                products.name_ro as 'product_name_ro',
                products.unit_ru as 'product_unit_ru',
                products.unit_ro as 'product_unit_ro',
                products.price as 'product_price',
                products.discount_price as 'product_discount_price',
                products.description_ru as 'product_description_ru',
                products.description_ro as 'product_description_ro',
                products.stock as 'product_stock',
                products.sizes as 'product_size',
                products.size_array as 'product_size_array',
                products.color as 'product_color',
                products.color_array as 'product_color_array',
                products.complements as 'product_complement',
                products.warranty as 'product_warranty',
                products.tags as 'product_tags',
                products.images as 'product_images',
                products.features as 'product_features',
                products.relaited_array as 'product_relaited_array',
                products.similar_array as 'product_similar_array',
                   
                brands.id as 'product_brand_id',
                brands.name as 'product_brand_name',
                brands.slug as 'product_brand_slug',
                brands.image as 'product_brand_image_name',
                   
                countries.name_ru as 'product_brand_country_name_ru',
                countries.name_ro as 'product_brand_country_name_ro',
                   
                collections.id as 'product_collection_id',
                collections.name_ru as 'product_collection_name_ru',
                collections.name_ro as 'product_collection_name_ro',
                collections.price as 'product_collection_price',
                collections.discount_price as 'product_collection_discount_price',
                collections.images as 'product_collection_images',
                collections.product_array as 'product_collection_product_array',
                   
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
                parent_parent_parent_category.slug as 'product_parent_parent_parent_category_slug'
                    from `products` as products
                        left join `collections` as collections on collections.id=products.collection_id AND collections.is_visible=1
            
                        left join `brands` as brands on brands.id=products.brand_id
                        left join `countries` as countries on countries.id=brands.country_id
                        
                        left join `categories` as parent_category on parent_category.id=products.category_id
                        left join `categories` as parent_parent_category on parent_parent_category.id=parent_category.parent_id
                        left join `categories` as parent_parent_parent_category on parent_parent_parent_category.id=parent_parent_category.parent_id
                            where products.articul=? and products.is_visible=1
                                limit 1
        " , [$articul]);

        abort_if(empty($query_result_row), self::HTTP_NOTFOUND_CODE);

        $product_info = $query_result_row[0];

        abort_if(!$product_info->product_id, self::HTTP_NOTFOUND_CODE);

        $watched_products = $this->getWatchedProducts();

        $related_products = collect([]);

        if($product_info->product_relaited_array) {
            $related_products = $this->getRelatedProducts($product_info->product_relaited_array);
        }

        $similar_products = collect([]);

        if($product_info->product_similar_array) {
            $similar_products = $this->getSimilarProducts($product_info->product_similar_array);
        }

        $slug =  Str::slug($product_info->product_name_ru) . '-' . $product_info->product_articul;
        $slug = preg_replace('/(?<=\d)(x)(?=\d)/i', '-', $slug);

        abort_if($slug != $product_slug, self::HTTP_NOTFOUND_CODE);

        // collection
        $collection = [];

        $tagsForChoose = Tag::all();

        if($product_info->product_collection_id) {
            $isTile = true;

            $collection_slug = Str::slug($product_info->product_collection_name_ru) . '-' . $product_info->product_collection_id;

            $collection = [
                'id' => $product_info->product_collection_id,
                'slug' => $collection_slug,
                'name_ru' => $product_info->product_collection_name_ru,
                'name_ro' => $product_info->product_collection_name_ro,
                'price' => $product_info->product_collection_price,
                'discount_price' => $product_info->product_collection_discount_price,
                'images' => $product_info->product_collection_images,
                'link' => route('pages.collections.index', ['first_level_category' => $product_info->product_parent_parent_category_slug, 'second_level_category' => $product_info->product_parent_category_slug, 'collection_slug' => $collection_slug])
            ];

            $collection['products'] = get_products(json_decode(json_decode($product_info->product_collection_product_array)->ids), $tagsForChoose);
        }

        // paths
        $pathProduct = Storage::disk('public')->url('compressed_images/products/images_optimized/');
        $pathBrand = Storage::disk('public')->url('brands/');

        // brand and country
        $country = [
            'name_ru' => $product_info->product_brand_country_name_ru,
            'name_ro' => $product_info->product_brand_country_name_ro
        ];
        $brand = [
            'id' => $product_info->product_brand_id,
            'name' => $product_info->product_brand_name,
            'slug' => $product_info->product_brand_slug,
            'image' => $product_info->product_brand_image_name,
            'country' => $country,
        ];

        // image

        $product_preview_picture = get_preview_picture($product_info->product_images, 'products');

        // features
        $arFeatures = null;

        if($product_info->product_features) {
            $product_features_list = json_decode($product_info->product_features)->ids ? json_decode($product_info->product_features)->ids : [];
            $features_for_choose = Feature::all();
            $feature_types_for_choose = FeatureType::all();
            $product_features = $features_for_choose->whereIn('id', $product_features_list)->values();

            foreach ($product_features as $f) {
                $feature_type = $feature_types_for_choose->first(function ($value) use ($f) {
                    return $value->id == $f->feature_type_id;
                });

                $arFeatures[$feature_type['name_' . self::$lang]] = $f['value_' . self::$lang];
            }
        }

        $product_features = $arFeatures;

        // breadcrumbs
        $product_breadcrumbs = collect([]);

        $categories = Category::getCategoriesWithUniqueKeys();

        if((int)$product_info->product_parent_parent_parent_category_id === 1) {
            $product_breadcrumbs[] = [
                'name_ru' => $categories[1]['name_ru'],
                'name_ro' => $categories[1]['name_ro'],
                'slug' => $categories[1]['slug'],
                'url' => route('pages.catalog.index'),
            ];
            $product_breadcrumbs[] = [
                'name_ru' => $product_info->product_parent_category_name_ru,
                'name_ro' => $product_info->product_parent_category_name_ro,
                'slug' => $product_info->product_parent_category_slug,
                'url' => route('pages.catalog.secondary_index', [$product_info->product_parent_parent_category_slug]),
            ];
        } else {
            $product_breadcrumbs[] = [
                'name_ru' => $categories[1]['name_ru'],
                'name_ro' => $categories[1]['name_ro'],
                'slug' => $categories[1]['slug'],
                'url' => route('pages.catalog.index'),
            ];
            $product_breadcrumbs[] = [
                'name_ru' => $product_info->product_parent_parent_parent_category_name_ru,
                'name_ro' => $product_info->product_parent_parent_parent_category_name_ro,
                'slug' => $product_info->product_parent_parent_parent_category_slug,
                'url' => route('pages.catalog.secondary_index', [$product_info->product_parent_parent_parent_category_slug]),
            ];
            $product_breadcrumbs[] = [
                'name_ru' => $product_info->product_parent_parent_category_name_ru,
                'name_ro' => $product_info->product_parent_parent_category_name_ro,
                'slug' => $product_info->product_parent_parent_category_slug,
                'url' => route('pages.catalog.ternary_index', [$product_info->product_parent_parent_parent_category_slug, $product_info->product_parent_parent_category_slug]),
            ];
            $product_breadcrumbs[] = [
                'name_ru' => $product_info->product_parent_category_name_ru,
                'name_ro' => $product_info->product_parent_category_name_ro,
                'slug' => $product_info->product_parent_category_slug,
                'url' => route('pages.catalog.ternary_index', [$product_info->product_parent_parent_parent_category_slug, $product_info->product_parent_parent_category_slug, $product_info->product_parent_category_slug])
            ];
        }

        $product_slug =  Str::slug($product_info->product_name_ru) . '-' . $product_info->product_articul;
        $product_slug = preg_replace('/(?<=\d)(x)(?=\d)/i', '-', $product_slug);

        $mainProduct = collect([
            'id' => $product_info->product_id,
            'articul' => $product_info->product_articul,
            'name_ru' => $product_info->product_name_ru,
            'name_ro' => $product_info->product_name_ro,
            'unit_ru' => $product_info->product_unit_ru,
            'unit_ro' => $product_info->product_unit_ro,
            'price' => $product_info->product_price,
            'discount_price' => $product_info->product_discount_price,
            'description_ru' => $product_info->product_description_ru,
            'description_ro' => $product_info->product_description_ro,
            'stock' => $product_info->product_stock,
            'warranty' => $product_info->product_warranty,
            'pathProduct' => $pathProduct,
            'pathBrand' => $pathBrand,
            'brand' => $brand,
            'arFeatures' => $product_features,
            'preview_picture' => $product_preview_picture,
            'breadcrumbs' => $product_breadcrumbs,
            'complement' => $product_info->product_complement,
            'color' => $product_info->product_color,
            'size' => $product_info->product_size,
            'images' => filter_images($product_info->product_images, 'products', $product_info->product_articul),
            'link' => route('pages.product.index', [$product_slug])
        ]);

        // tags
        $product_tag_list = explode(',', $product_info->product_tags);

        $mainProduct['arTags'] = collect([]);
        $mainProduct['arTags'] = $tagsForChoose->filter(function ($tag) use($product_tag_list) {
            if(in_array($tag->id, $product_tag_list)) {
                return $tag;
            }
        })->values();

        // productsBySizes
        $mainProduct['productsBySizes'] = collect([]);
        $mainProduct->put('products', collect([]));
        $mainProduct['products']->put('ptBySizes', collect([]));
        $mainProduct['products']->put('fromSizes', collect([]));

        if(!empty($product_info->product_size_array) || !empty(json_decode($product_info->product_size_array)[0])) {
            $mainProduct['products']['ptBySizes'] = $this->getProductsByArticlesOfProduct($product_info->product_size_array);

            $mainProduct['products']['ptBySizes']->map(function ($item) use ($mainProduct) {
                $mainProduct['products']['fromSizes'][] = $this->getProductsByArticlesOfProduct($item["color_array"]);
            });
        }

        // productsByColors
        $mainProduct['products']->put('ptByColors', collect([]));
        if(!empty($product_info->product_color_array) || !empty(json_decode($product_info->product_color_array)[0])) {
            $mainProduct['products']['ptByColors'] = $this->getProductsByArticlesOfProduct($product_info->product_color_array);
        }

        if(!is_null($mainProduct['complement'])) {
            $mainProduct->put('kit', get_products(json_decode($mainProduct['complement'])->kit, $tagsForChoose));
            $mainProduct->put('singly', get_products(json_decode($mainProduct['complement'])->singly, $tagsForChoose));
        }

        return view('pages.product', compact('mainProduct', 'related_products', 'similar_products', 'watched_products', 'isTile', 'collection'));
    }

    public function getProductsByArticlesOfProduct($product_articles_array)
    {
        $articles = json_decode($product_articles_array) ? implode(',', json_decode($product_articles_array)) : implode(',', []);

        if(empty($articles)) return [];

        $query = "select
                        products.id as 'product_id',
                        products.articul as 'product_articul',
                        products.name_ru as 'product_name_ru',
                        products.name_ro as 'product_name_ro',
                        products.unit_ru as 'product_unit_ru',
                        products.unit_ro as 'product_unit_ro',
                        products.price as 'product_price',
                        products.discount_price as 'product_discount_price',
                        products.description_ru as 'product_description_ru',
                        products.description_ro as 'product_description_ro',
                        products.stock as 'product_stock',
                        products.sizes as 'product_size',
                        products.size_array as 'product_size_array',
                        products.color as 'product_color',
                        products.color_array as 'product_color_array',
                        products.warranty as 'product_warranty',
                        products.tags as 'product_tags',
                        products.images as 'product_images',
                        products.features as 'product_features',
                        products.relaited_array as 'product_relaited_array',
                        products.similar_array as 'product_similar_array',
                        products.complements as 'product_complement',
       
                        brands.id as 'product_brand_id',
                        brands.name as 'product_brand_name',
                        brands.slug as 'product_brand_slug',
                        brands.image as 'product_brand_image_name',
                           
                        countries.name_ru as 'product_brand_country_name_ru',
                        countries.name_ro as 'product_brand_country_name_ro',
                           
                        collections.id as 'product_collection_id',
                        collections.name_ru as 'product_collection_name_ru',
                        collections.name_ro as 'product_collection_name_ro',
                        collections.price as 'product_collection_price',
                        collections.discount_price as 'product_collection_discount_price',
                        collections.images as 'product_collection_images',
                        collections.product_array as 'product_collection_product_array',
       
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
                        parent_parent_parent_category.slug as 'product_parent_parent_parent_category_slug'
                            from `products` as products
                                left join `collections` as collections on collections.id=products.collection_id AND collections.is_visible=1
            
                                left join `brands` as brands on brands.id=products.brand_id
                                left join `countries` as countries on countries.id=brands.country_id

                                left join `categories` as parent_category on parent_category.id=products.category_id
                                left join `categories` as parent_parent_category on parent_parent_category.id=parent_category.parent_id
                                left join `categories` as parent_parent_parent_category on parent_parent_parent_category.id=parent_parent_category.parent_id
                                    where products.articul in ($articles) and products.is_visible=1";

        $result_rows = DB::select($query);

        $products_by_articles = collect([]);

        $tagsForChoose = Tag::all();

        // paths
        $pathProduct = Storage::disk('public')->url('products/');
        $pathBrand = Storage::disk('public')->url('brands/');

        foreach ($result_rows as $row) {
            // brand and country
            $country = [
                'name_ru' => $row->product_brand_country_name_ru,
                'name_ro' => $row->product_brand_country_name_ro
            ];
            $brand = [
                'id' => $row->product_brand_id,
                'name' => $row->product_brand_name,
                'slug' => $row->product_brand_slug,
                'image' => $row->product_brand_image_name,
                'country' => $country,
            ];

            // features
            $arFeatures = null;

            if($row->product_features) {
                $product_features_list = json_decode($row->product_features)->ids ? json_decode($row->product_features)->ids : [];
                $features_for_choose = Feature::all();
                $feature_types_for_choose = FeatureType::all();
                $product_features = $features_for_choose->whereIn('id', $product_features_list)->values();

                foreach ($product_features as $f) {
                    $feature_type = $feature_types_for_choose->first(function ($value) use ($f) {
                        return $value->id == $f->feature_type_id;
                    });

                    $arFeatures[$feature_type['name_' . self::$lang]] = $f['value_' . self::$lang];
                }
            }

            $product_features = $arFeatures;

            // image
            $product_preview_picture = get_preview_picture($row->product_images, 'products');

            // breadcrumbs
            $product_breadcrumbs = collect([]);

            $categories = Category::getCategoriesWithUniqueKeys();

            if((int)$row->product_parent_parent_parent_category_id === 1) {
                $product_breadcrumbs[] = [
                    'name_ru' => $categories[1]['name_ru'],
                    'name_ro' => $categories[1]['name_ro'],
                    'slug' => $categories[1]['slug'],
                    'url' => route('pages.catalog.index'),
                ];
                $product_breadcrumbs[] = [
                    'name_ru' => $row->product_parent_category_name_ru,
                    'name_ro' => $row->product_parent_category_name_ro,
                    'slug' => $row->product_parent_category_slug,
                    'url' => route('pages.catalog.secondary_index', [$row->product_parent_parent_category_slug]),
                ];
            } else {
                $product_breadcrumbs[] = [
                    'name_ru' => $categories[1]['name_ru'],
                    'name_ro' => $categories[1]['name_ro'],
                    'slug' => $categories[1]['slug'],
                    'url' => route('pages.catalog.index'),
                ];
                $product_breadcrumbs[] = [
                    'name_ru' => $row->product_parent_parent_category_name_ru,
                    'name_ro' => $row->product_parent_parent_category_name_ro,
                    'slug' => $row->product_parent_parent_category_slug,
                    'url' => route('pages.catalog.secondary_index', [$row->product_parent_parent_parent_category_slug]),
                ];
                $product_breadcrumbs[] = [
                    'name_ru' => $row->product_parent_parent_category_name_ru,
                    'name_ro' => $row->product_parent_parent_category_name_ro,
                    'slug' => $row->product_parent_parent_category_slug,
                    'url' => route('pages.catalog.ternary_index', [$row->product_parent_parent_parent_category_slug, $row->product_parent_parent_category_slug]),
                ];
                $product_breadcrumbs[] = [
                    'name_ru' => $row->product_parent_category_name_ru,
                    'name_ro' => $row->product_parent_category_name_ro,
                    'slug' => $row->product_parent_category_slug,
                    'url' => route('pages.catalog.ternary_index', [$row->product_parent_parent_parent_category_slug, $row->product_parent_parent_category_slug, $row->product_parent_category_slug])
                ];
            }

            $product = collect([
                'id' => $row->product_id,
                'articul' => $row->product_articul,
                'name_ru' => $row->product_name_ru,
                'name_ro' => $row->product_name_ro,
                'unit_ru' => $row->product_unit_ru,
                'unit_ro' => $row->product_unit_ro,
                'price' => $row->product_price,
                'discount_price' => $row->product_discount_price,
                'description_ru' => $row->product_description_ru,
                'description_ro' => $row->product_description_ro,
                'stock' => $row->product_stock,
                'warranty' => $row->product_warranty,
                'pathProduct' => $pathProduct,
                'pathBrand' => $pathBrand,
                'brand' => $brand,
                'arFeatures' => $product_features,
                'preview_picture' => $product_preview_picture,
                'breadcrumbs' => $product_breadcrumbs,
                'color' => $row->product_color,
                'color_array' => $row->product_color_array,
                'size' => $row->product_size,
                'images' => filter_images($row->product_images, 'products', $row->product_articul),
                'complement' => $row->product_complement
            ]);

            if(!is_null($product['complement'])) {
                $product->put('kit', get_products(json_decode($product['complement'])->kit, $tagsForChoose));
                $product->put('singly', get_products(json_decode($product['complement'])->singly, $tagsForChoose));
            }

            // tags
            $product_tag_list = explode(',', $row->product_tags);

            $product['arTags'] = collect([]);
            $product['arTags'] = $tagsForChoose->filter(function ($tag) use($product_tag_list) {
                if(in_array($tag->id, $product_tag_list)) {
                    return $tag;
                }
            })->values();

            // preview picture
            $product['preview_picture'] = get_preview_picture($row->product_images, 'products');

            // brand
            $product['brand_id'] = $row->product_brand_id;
            $product['brand_name'] = $row->product_brand_name;
            $product['brand_slug'] = $row->product_brand_slug;
            $product['link_to_brands_page'] = route('pages.brands.index');

            if(Storage::disk('public')->exists('brands/'.$row->product_brand_image_name)) {
                $product['brand_image'] = Storage::disk('public')->url('brands/'.$row->product_brand_image_name);
            } else {
                $product['brand_image'] = Storage::disk('public')->url('brands/default-brand-placeholder.png');
            }

            // product link
            $product_slug_attribute =  Str::slug($row->product_name_ru) . '-' . $row->product_articul;
            $product_slug_attribute = preg_replace('/(?<=\d)(x)(?=\d)/i', '-', $product_slug_attribute);

            $product['link'] = route('pages.product.index', [$product_slug_attribute]);

            $products_by_articles[] = $product;
        }

        return $products_by_articles;
    }
}
