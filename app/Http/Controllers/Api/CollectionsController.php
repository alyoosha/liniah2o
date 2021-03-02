<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Collection;
use App\Models\FeatureType;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CollectionsController extends Controller
{
    public function sortCollectionsByFilter(Request $request)
    {
        $sorting_value = $request->get('sorting_value');
        $collection = collect($request->get('collection'));

        switch ($sorting_value) {
            // TODO popular sorting
            case 'popular':
                return response()->json($collection, 200);
            case 'price_up':
                $sorted = $collection->sort(function ($a, $b) {
                    if($a['discount_price'] > 0 && $b['discount_price'] > 0) {
                        if ($a['discount_price'] == $b['discount_price']) {
                            return 0;
                        }
                        return ($a['discount_price'] > $b['discount_price']) ? 1 : -1;
                    } elseif ($a['discount_price'] > 0 && $b['discount_price'] == 0) {
                        if ($a['discount_price'] == $b['price']) {
                            return 0;
                        }
                        return ($a['discount_price'] > $b['price']) ? 1 : -1;
                    } elseif ($a['discount_price'] == 0 && $b['discount_price'] > 0) {
                        if ($a['price'] == $b['discount_price']) {
                            return 0;
                        }
                        return ($a['price'] > $b['discount_price']) ? 1 : -1;
                    } else {
                        if ($a['price'] == $b['price']) {
                            return 0;
                        }
                        return ($a['price'] > $b['price']) ? 1 : -1;
                    }
                });

                return response()->json($sorted->values(), 200);
            case 'price_down':
                $sorted = $collection->sort(function ($a, $b) {
                    if($a['discount_price'] > 0 && $b['discount_price'] > 0) {
                        if ($a['discount_price'] == $b['discount_price']) {
                            return 0;
                        }
                        return ($a['discount_price'] > $b['discount_price']) ? -1 : 1;
                    } elseif ($a['discount_price'] > 0 && $b['discount_price'] == 0) {
                        if ($a['discount_price'] == $b['price']) {
                            return 0;
                        }
                        return ($a['discount_price'] > $b['price']) ? -1 : 1;
                    } elseif ($a['discount_price'] == 0 && $b['discount_price'] > 0) {
                        if ($a['price'] == $b['discount_price']) {
                            return 0;
                        }
                        return ($a['price'] > $b['discount_price']) ? -1 : 1;
                    } else {
                        if ($a['price'] == $b['price']) {
                            return 0;
                        }
                        return ($a['price'] > $b['price']) ? -1 : 1;
                    }
                });

                return response()->json($sorted->values(), 200);
            default :
                return response()->json($collection, 200);
        }
    }

    public function sortCollectionsByCategory(Request $request)
    {
        $lang = $request->get('lang', App::getLocale());
        $change_slug = $request->get('category_slug');

        $change_category_id = Category::ofSlug($change_slug)->first()->id;

        $query_result_rows = DB::select("
            select
                collections.id as 'collection_id',
                collections.category_id as 'collection_category_id',
                collections.name_ru as 'collection_name_ru',
                collections.name_ro as 'collection_name_ro',
                collections.price as 'collection_price',
                collections.discount_price as 'collection_discount_price',
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
                countries.name_ro as 'product_brand_country_name_ro'
                    from `collections` as collections
                        left join `brands` as brands on brands.id=collections.brand_id
                        left join `countries` as countries on countries.id=brands.country_id
            
                        left join `categories` as parent_category on parent_category.id=collections.category_id
                        left join `categories` as parent_parent_category on parent_parent_category.id=parent_category.parent_id
                            where collections.category_id=? and collections.is_visible=1
        ", [$change_category_id]);

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
                'images' => $row->collection_images,
                'features' => $row->collection_features
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

                        $product_image_list = json_decode($product_for_choose->images);

                        if(!empty($product_image_list) && Storage::disk('public')->exists('products/'.$product_image_list[0])) {
                            $product['preview_picture'] = Storage::disk('public')->url('products/'.$product_image_list[0]);
                        } else {
                            $product['preview_picture'] = Storage::disk('public')->url('products/product-img-default.jpg');
                        }

                        $product_slug_attribute =  Str::slug($product_for_choose->name_ru) . '-' . $product_for_choose->articul;
                        $product_slug_attribute = preg_replace('/(?<=\d)(x)(?=\d)/i', '-', $product_slug_attribute);

//                        $product['link'] = route('pages.product.index', [$product_slug_attribute]);
                        $product['link'] = route('homepage').'/'.$lang.'/products/'.$product_slug_attribute;

                        $products[] = $product;
                    }
                }

                $c['products'] = $products;
            }

            $imageList = json_decode($row->collection_images);

            if(!empty($imageList) && Storage::disk('public')->exists('collections/'.$imageList[0])) {
                $c['preview_picture'] = Storage::disk('public')->url('collections/'.$imageList[0]);
            } else {
                $c['preview_picture'] = Storage::disk('public')->url('products/product-img-default.jpg');
            }

            $collection_slug = Str::slug($row->collection_name_ru) . '-' . $row->collection_id;

//            $c['collection_link'] = route('pages.collections.index', [$row->parent_parent_category_slug, $row->parent_category_slug, $collection_slug]);
            $c['collection_link'] = route('homepage').'/'.$lang.'/catalog/'.$row->parent_parent_category_slug.'/'.$row->parent_category_slug.'/collections/'.$collection_slug;

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

        $countries = $this->getCountries($brands);

        $featureList = $this->getFeatures($collection_list);
        $feature_types = FeatureType::whereRaw("JSON_CONTAINS(feature_types.categories->'$.ids', '[$change_category_id]')")
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
                return count($f['filtered_features']) === 0;
            })->values();

        return response()->json(['collection' => $collection_list, 'brands' => $brands, 'countries' => $countries, 'feature_types' => $feature_types], 200);
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

        foreach ($collections as $collection) {
            if($collection['features']) {
                $features = json_decode($collection['features'])->ids;
                $imploded_features = implode(',', $features);

                if(count($features) > 0) {
                    $query = "select * from `features` as features where features.id in ($imploded_features)";
                    $features_rows = DB::select($query);

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

    public function filterCollections(Request $request)
    {
        $lang = $request->get('lang', App::getLocale());
        $filters = $request->get('filters');
        $category = Category::ofSlug($request->get('category_slug'))->isActive()->first();

        $collection_list = Collection::ofCategory($category->id)->isVisible();

        $collection_list = $collection_list
            ->ofCountries($filters['country'])
            ->ofBrands($filters['brand'])
            ->ofFeatures($filters['features'])
            ->get()
            ->map(function ($c) use ($lang) {
                $c['brand_name'] = $c->brand ? $c->brand->name : null;
                $c['brand_image'] = $c->brand ? Storage::disk('public')->url('brands/'.$c->brand->image) : null;
                $c['preview_picture'] = $c->getPreviewPicture();

//                $collection_link = route('pages.collections.index', [$c->category->parent->slug, $c->category->slug, $c->getSlugAttribute()]);
                $collection_link = route('homepage').'/'.$lang.'/catalog/'.$c->category->parent->slug.'/'.$c->category->slug.'/collections/'.$c->getSlugAttribute();
                $c['collection_link'] = $collection_link;

                $product_articles = collect(json_decode(json_decode($c->product_array)->ids));

                if($product_articles->count() > 0) {
                    $products = collect([]);

                    foreach ($product_articles as $product_article) {
                        $product = Product::ofArticul($product_article)->first();

                        if($product) {
                            $product['preview_picture'] = $product->getPreviewPicture();
                            $product['link'] = route('homepage').'/'.$lang.'/products/'.$product->getSlugAttribute();
                        }

                        if($product) {
                            $products[] = $product;
                        }
                    }

                    $c['products'] = $products;
                }

                return $c;
            });

        // filter by price
        $collection_list = $collection_list
            ->when($filters['price']['from'], function ($q) use($filters) {
                return $q->where('filtered_price', '>', $filters['price']['from']);
            })
            ->when($filters['price']['to'], function ($q) use($filters) {
                return $q->where('filtered_price', '<', $filters['price']['to']);
            })
            ->values()
            ->all();

        return response()->json($collection_list, 200);
    }
}
