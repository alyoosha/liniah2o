<?php

namespace App\Http\Controllers\Pages;

use App\Models\Brand;
use App\Models\CatalogSlider;
use App\Models\Feature;
use App\Models\FeatureType;
use App\Models\Product;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Traits\RelatedProductsTrait;
use App\Traits\WatchedProductsTrait;
use App\Traits\SimilarProductsTrait;


class CollectionsController extends Controller
{
    use RelatedProductsTrait;
    use WatchedProductsTrait;
    use SimilarProductsTrait;

    protected const WATCHED_PRODUCTS_COUNT = 1;

    public function catalog_index(Request $request, string $first_slug, string $secondary_slug)
    {
        $tile_category = Category::ofSlug($first_slug)->isActive()->first();

        $tile_collections = $tile_category->childs;

        $category_collection = Category::ofSlug($secondary_slug)->isActive()->first();
        if($category_collection) {
            $category_collection_id = $category_collection->id;
        } else $category_collection_id = '';

        // when we set brand filter before we go to this page
        $active_brand = $request->query('brand');

        $query_result_rows = DB::select("
            select
                collections.id as 'collection_id',
                collections.category_id as 'collection_category_id',
                collections.name_ru as 'collection_name_ru',
                collections.name_ro as 'collection_name_ro',
                collections.price as 'collection_price',
                collections.discount_price as 'collection_discount_price',
                collections.unit_ru as 'collection_unit_ru',
                collections.unit_ro as 'collection_unit_ro',
                collections.description_ru as 'collection_description_ru',
                collections.description_ro as 'collection_description_ro',
                collections.images as 'collection_images',
                collections.features as 'collection_features',
                collections.product_array as 'collection_product_array',
                
                parent_category.slug as 'parent_category_slug',
                parent_parent_category.slug as 'parent_parent_category_slug',
                   
                brands.id as 'collection_brand_id',
                brands.name as 'collection_brand_name',
                brands.slug as 'collection_brand_slug',
                brands.image as 'collection_brand_image_name',
                   
                countries.id as 'product_brand_country_id',
                countries.name_ru as 'product_brand_country_name_ru',
                countries.name_ro as 'product_brand_country_name_ro',
                GROUP_CONCAT(DISTINCT (images.paths_resized) SEPARATOR ',') AS images_name,
                GROUP_CONCAT(DISTINCT (images.paths_resized) ORDER BY images.name SEPARATOR ',') AS images_resized
                    from `collections` as collections
                        left join `brands` as brands on brands.id=collections.brand_id
                        left join `countries` as countries on countries.id=brands.country_id
            
                        left join `categories` as parent_category on parent_category.id=collections.category_id
                        left join `categories` as parent_parent_category on parent_parent_category.id=parent_category.parent_id
                        left join `images` images ON images.collection_articul=collections.id and images.is_visible = 1
                            where collections.category_id=? and collections.is_visible=1
                            GROUP BY collections.id", [$category_collection_id]);

        $collection_list = collect([]);

        $products_for_choose = DB::select("select products.id, products.articul, products.name_ru, products.name_ro, products.images from `products` as products");

        foreach ($query_result_rows as $row) {
            $c = [
                'id' => $row->collection_id,
                'category_id' => $row->collection_category_id,
                'name_ru' => $row->collection_name_ru,
                'name_ro' => $row->collection_name_ro,
                'price' => $row->collection_price,
                'discount_price' => $row->collection_discount_price,
                'unit_ru' => $row->collection_unit_ru,
                'unit_ro' => $row->collection_unit_ro,
                'description_ru' => $row->collection_description_ru,
                'description_ro' => $row->collection_description_ro,
                'images' => $row->collection_images,
                'features' => $row->collection_features,
            ];

            $product_articles = json_decode(json_decode($row->collection_product_array)->ids);

            if(count($product_articles) > 0) {
                $products = collect([]);

                foreach ($products_for_choose as $product_for_choose) {
                    if(in_array($product_for_choose->articul, $product_articles)) {
                        $product = collect([
                            'id' => $product_for_choose->id,
                            'articul' => $product_for_choose->articul,
                            'name_ru' => $product_for_choose->name_ru,
                            'name_ro' => $product_for_choose->name_ro,
                        ]);

                        $product['preview_picture'] = get_preview_picture($product_for_choose->images, 'products');

                        $product_slug_attribute =  Str::slug($product_for_choose->name_ru) . '-' . $product_for_choose->articul;
                        $product_slug_attribute = preg_replace('/(?<=\d)(x)(?=\d)/i', '-', $product_slug_attribute);

                        $product['link'] = route('pages.product.index', [$product_slug_attribute]);

                        $products[] = $product;
                    }
                }

                $c['products'] = $products;
            }

            $c['preview_picture'] = get_preview_picture($row->collection_images, 'collections');
            $c['imagesResized'] = get_images_resized($row->images_resized);

            $collection_slug = Str::slug($row->collection_name_ru) . '-' . $row->collection_id;

            $c['collection_link'] = route('pages.collections.index', [$row->parent_parent_category_slug, $row->parent_category_slug, $collection_slug]);

            $c['brand_id'] = $row->collection_brand_id;
            $c['brand_name'] = $row->collection_brand_name;

            $c['brand_country_id'] = $row->product_brand_country_id;
            $c['brand_country_name_ru'] = $row->product_brand_country_name_ru;
            $c['brand_country_name_ro'] = $row->product_brand_country_name_ro;

            if(Storage::disk('public')->exists('brands/'.$row->collection_brand_image_name)) {
                $c['brand_image'] = Storage::disk('public')->url('brands/'.$row->collection_brand_image_name);
            } else {
                $c['brand_image'] = Storage::disk('public')->url('brands/default-brand-placeholder.png');
            }

            $collection_list[] = $c;
        }

        $brands = $this->getBrands($collection_list);
        $brands = $brands->map(function ($b) use($active_brand) {
            if($b['id'] === (int)$active_brand) {
                $b['checked'] = true;
            } else {
                $b['checked'] = false;
            }

            return $b;
        });

        $countries = $this->getCountries($brands);

        $featureList = $this->getFeatures($collection_list);
        if($featureList->count() > 0) {
            $feature_types = FeatureType::whereRaw("JSON_CONTAINS(feature_types.categories->'$.ids', '[$category_collection_id]')")
                ->isShouldBeAddedToFilter()
                ->get()
                ->map(function ($f) use($featureList) {
                    if($f->features->count() > 0) {
                        $features = $f->features;

                        if($features->count() > 0) {
                            foreach ($features as $feature) {
                                if($featureList->has($feature->id)) {
                                    $feature['count'] = $featureList[$feature->id]['count'];
                                } else $feature['count'] = 0;
                            }

                            $features = $features
                                ->reject(function ($f) {
                                    return $f->count == 0;
                                })
                                ->values();
                        }

                        $f['filtered_features'] = $features;
                    }

                    return $f;
                })
                ->reject(function ($f) {
                    return !$f['filtered_features'];
                })->values();
        } else {
            $feature_types = collect([]);
        }

        $slides = CatalogSlider::isPublished()
            ->get()
            ->take(4)
            ->map(function ($s) {
                $s['link_desktop'] = Storage::disk('public')->url($s->image_desktop);
                $s['link_mobile'] = Storage::disk('public')->url($s->image_mobile);

                return $s;
            });

        $additional_products_url = route('pages.catalog.ternary_index', ['secondary' => 'plitka-10382', 'ternary' => 'soputstvuyushhie-tovary-10390']);

        return view('pages.collections.catalog_index', compact(
            'category_collection',
            'first_slug',
            'secondary_slug',
            'tile_collections',
            'collection_list',
            'slides',
            'brands',
            'feature_types',
            'countries',
            'additional_products_url'
        ));
    }

    public function getBrands($collectionList)
    {
        $brands = collect([]);

        foreach ($collectionList as $c) {
            $brand = collect([]);
            $brand['id'] = $c['brand_id'];
            $brand['country_id'] = $c['brand_country_id'];
            $brand['country_name_ru'] = $c['brand_country_name_ru'];
            $brand['country_name_ro'] = $c['brand_country_name_ro'];
            $brand['name'] = $c['brand_name'];
            $brand['image'] = $c['brand_image'];

            if(!$brands->has($c['brand_id'])) {
                $brand['count'] = 1;
                $brands[$c['brand_id']] = $brand;
            } else {
                $brands[$c['brand_id']]['count'] += 1;
            }
        }

        return $brands;
    }

    public function getCountries($brands)
    {
        $countries = collect([]);

        foreach ($brands as $brand) {
            $country = collect([]);
            $country['id'] = $brand['country_id'];
            $country['name_ru'] = $brand['country_name_ru'];
            $country['name_ro'] = $brand['country_name_ro'];

            if(!$countries->has($country['id'])) {
                $country['count'] = $brand['count'];
                $countries[$country['id']] = $country;
            } else {
                $countries[$country['id']]['count'] += $brand['count'];
            }
        }

        return $countries;
    }

    public function getFeatures($collections)
    {
        $featureList = collect([]);

        $features_for_choose = Feature::all();

        foreach ($collections as $collection) {
            if($collection['features']) {
                $features = json_decode($collection['features'])->ids;

                if(count($features) > 0) {
                    $features_rows = $features_for_choose->whereIn('id', $features)->values();

                    foreach ($features_rows as $row) {
                        $f = collect([
                            'id' => $row->id,
                            'feature_type_id' => $row->feature_type_id,
                            'value_ru' => $row->value_ru,
                            'value_ro' => $row->value_ro,
                        ]);

                        if(!$featureList->has($row->id)) {
                            $f['count'] = 1;
                            $featureList[$row->id] = $f;
                        } else {
                            $featureList[$row->id]['count'] += 1;
                        }
                    }
                }
            }
        }

        return $featureList;
    }

    public function index(string $first_level_category, string $second_level_category, string $collection_slug) {
        $id = Collection::getIdBySlug($collection_slug);
        $collection = DB::table('collections')
            ->join('brands', 'brands.id', '=', 'collections.brand_id')
            ->join('countries', 'countries.id', '=', 'brands.country_id')
            ->select('collections.*', 'brands.name as brand_name', 'brands.slug as brand_slug', 'brands.image as brand_image', 'countries.name_ru as country_name_ru', 'countries.name_ro as country_name_ro')
            ->where('collections.id', '=', $id)
            ->get()->toArray();


        $categories = Category::getCategoriesWithUniqueKeys();

        abort_unless($collection, 404);

        $collection = $collection[0];

        $collection->breadcrumbs = get_breadcrumbs($categories, $categories[$collection->category_id], self::$lang);

        abort_if(
            $first_level_category != $collection->breadcrumbs[1]['slug'] &&
            $second_level_category != $collection->breadcrumbs[2]['slug'],
            404
        );

        $tags = Tag::all();

        $collection->products = get_products(json_decode(json_decode($collection->product_array)->ids), $tags);
        $collection->images = filter_images($collection->images, 'collections', $collection->id);
        $collection->category = $categories[$collection->category_id];
        $collection->imgPreview = get_preview_picture($collection->images,'collections');
        $collection->link = route('pages.collections.index', ['first_level_category' => $first_level_category, 'second_level_category' => $second_level_category, 'collection_slug' => $collection_slug]);

        if(count($collection->products)) {

            $similar_products = collect([]);

            if($collection->products[0]['similar_array']) {
                $similar_products = $this->getSimilarProducts($collection['products'][0]['similar_array']);
            }

            $related_products = collect([]);

            if($collection->products[0]['relaited_array']) {
                $related_products = $this->getRelatedProducts($collection['products'][0]['relaited_array']);
            }
        }
        $watched_products = $this->getWatchedProducts();

        $collection->images = json_decode($collection->images, true);

        $collection = (array) $collection;

        return view('pages.collections.index', compact('collection', 'watched_products', 'similar_products', 'related_products'));
    }

}
