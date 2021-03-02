<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Feature;
use App\Models\FeatureType;
use App\Models\PopularProduct;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CatalogController extends Controller
{
    public function getLinkToTernaryCatalogPage()
    {
        // Грузим для брендов категорию сантехника, так как первая в списке пустая сейчас
        // 8538 - id Сантехники
        $category_first = Category::where('slug', 'santexnika-8538')->first();
        $category_second_slug = Category::ofParentCategory($category_first->id)->first()->slug;

        return route('pages.catalog.ternary_index', [$category_first->slug, $category_second_slug]);
    }

    public function sortProductsByFilter(Request $request)
    {
        $lang = $request->get('lang', App::getLocale());
        $sorting_value = $request->get('sorting_value');
        $products = collect($request->get('products'));

        switch ($sorting_value) {
            case 'popular':
                $popularProducts = PopularProduct::orderBy('count_of_orders', 'desc')->get();

                $currentPopularProducts = $products->filter(function ($p) use ($popularProducts) {
                    return $popularProducts->contains('articul', '=', $p['articul']);
                });

                $products = $products->reject(function ($p) use ($popularProducts) {
                    return $popularProducts->contains('articul', '=', $p['articul']);
                });

                $products = $currentPopularProducts->merge($products);

                return response()->json($products, 200);
            case 'price_up':
                $sorted = $products->sort(function ($a, $b) {
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
                $sorted = $products->sort(function ($a, $b) {
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
            case 'new':
                $newTag = Tag::isNew()->first();

                $sorted = $this->getProductsBySpecialTag($newTag, $products);

                return response()->json($sorted, 200);
            case 'sale':
                $saleTag = Tag::isSale()->first();

                $sorted = $this->getProductsBySpecialTag($saleTag, $products);

                return response()->json($sorted, 200);
            default :
                return response()->json($products, 200);
        }
    }

    public function getProductsBySpecialTag($newTag, $products)
    {
        $sorted = collect([]);

        foreach ($products as $key => $product) {
            $tags = $product['tags'];

            if(count($tags) > 0) {
                foreach ($tags as $tag) {
                    if($tag['id'] == $newTag['id']) {
                        $sorted[] = $product;
                        unset($products[$key]);
                    }
                }
            }
        }

        return $sorted->merge($products);
    }

    public function sortProductsByCategory(Request $request)
    {
        $lang = $request->get('lang', App::getLocale());

        $second_level_category_slug = $request->get('second_level_category_slug');
        $third_level_category_slug = $request->get('category_slug');

        $third_level_category = Category::ofSlug($third_level_category_slug)->isActive()->first();

        $third_level_category_name = $request->get('lang', 'ro') === 'ru' ? $third_level_category->name_ru : $third_level_category->name_ro;

        $second_level_category_id = Category::ofSlug($second_level_category_slug)->first()->id;

        $products = $this->getProductsOfThirdLevelCategory($third_level_category->id, $lang);

        $brands = $this->getBrands($products);
        $tags = $this->getTags($products);
        $countries = $this->getCountries($brands);
        $colors = $this->getColors($products);
        $featureList = $this->getFeatures($products);
        $feature_types = FeatureType::whereRaw("JSON_CONTAINS(feature_types.categories->'$.ids', '[$second_level_category_id]')")
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
        $in_stock_count = $products->where('in_stock', true)->count();

        return response()->json(['products' => $products, 'brands' => $brands, 'tags' => $tags, 'countries' => $countries, 'colors' => $colors, 'feature_types' => $feature_types, 'category_name' => $third_level_category_name, 'in_stock_count' => $in_stock_count], 200);
    }

    public function getProductsOfThirdLevelCategory(int $category_id, string $lang)
    {
        $query_result_rows = DB::select("
            select 
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
                products.color as 'product_color',
                products.features as 'product_features',
                products.complements as 'product_complements',
                
                brands.id as 'product_brand_id',
                brands.name as 'product_brand_name',
                brands.slug as 'product_brand_slug',
                brands.image as 'product_brand_image_name',
                   
                countries.id as 'product_brand_country_id',
                countries.name_ru as 'product_brand_country_name_ru',
                countries.name_ro as 'product_brand_country_name_ro',
                GROUP_CONCAT(DISTINCT (images.paths_resized) SEPARATOR ',') AS images_name,
                GROUP_CONCAT(DISTINCT (images.paths_resized) ORDER BY images.name SEPARATOR ',') AS images_resized
                    from `products` as products
                        left join `brands` as brands on brands.id=products.brand_id
                        left join `countries` as countries on countries.id=brands.country_id
                        left join `images` images ON images.product_articul=products.articul and images.is_visible
                            where products.category_id=? and products.is_visible=1 
                            GROUP BY products.id",
            [$category_id]);

        $products = collect([]);

        $tags_for_choose = Tag::all();

        foreach ($query_result_rows as $row) {
            $p = collect([
                'id' => $row->product_id,
                'articul' => $row->product_articul,
                'category_id' => $row->product_category_id,
                'name_ru' => $row->product_name_ru,
                'name_ro' => $row->product_name_ro,
                'price' => $row->product_price,
                'discount_price' => $row->product_discount_price,
                'unit_ru' => $row->product_unit_ru,
                'unit_ro' => $row->product_unit_ro,
                'in_stock' => $row->product_stock > 0 ? true : false,
                'complements' => $row->product_complements
            ]);

            $p['color'] = $row->product_color !== "\n" ? $row->product_color : "";
            $p['features'] = $row->product_features;

            $tagsIds = explode(',', $row->product_tags);

            $p['tags'] = collect([]);
            $p['tags'] = $tags_for_choose->filter(function ($tag) use($tagsIds) {
                if(in_array($tag->id, $tagsIds)) {
                    return $tag;
                }
            })->values();

            $p['preview_picture'] = get_preview_picture($row->product_images, 'products');
            $p['imagesResized'] = get_images_resized($row->images_resized);

            $p['brand_id'] = $row->product_brand_id;
            $p['brand_name'] = $row->product_brand_name;
            $p['brand_slug'] = $row->product_brand_slug;
//            $p['link_to_brands_page'] = route('pages.brands.index');
            $p['link_to_brands_page'] = route('homepage').'/'.$lang.'/brands/';

            $p['brand_country_id'] = $row->product_brand_country_id;
            $p['brand_country_name_ru'] = $row->product_brand_country_name_ru;
            $p['brand_country_name_ro'] = $row->product_brand_country_name_ro;

            $product_slug_attribute =  Str::slug($row->product_name_ru) . '-' . $row->product_articul;
            $product_slug_attribute = preg_replace('/(?<=\d)(x)(?=\d)/i', '-', $product_slug_attribute);

//            $p['link'] = route('pages.product.index', [$product_slug_attribute]);
            $p['link'] = route('homepage').'/'.$lang.'/products/'.$product_slug_attribute;

            if(Storage::disk('public')->exists('brands/'.$row->product_brand_image_name)) {
                $p['brand_image'] = Storage::disk('public')->url('brands/'.$row->product_brand_image_name);
            } else {
                $p['brand_image'] = Storage::disk('public')->url('brands/default-brand-placeholder.png');
            }

            $products[] = $p;
        }

        return $products;
    }

    public function getBrands($products)
    {
        $brands = collect([]);

        foreach ($products as $p) {
            $brand = collect([]);
            $brand['id'] = $p['brand_id'];
            $brand['country_id'] = $p['brand_country_id'];
            $brand['country_name_ru'] = $p['brand_country_name_ru'];
            $brand['country_name_ro'] = $p['brand_country_name_ro'];
            $brand['name'] = $p['brand_name'];
            $brand['slug'] = $p['brand_slug'];
            $brand['image'] = $p['brand_image'];
            $brand['link_to_brands_page'] = $p['link_to_brands_page'];

            if(!$brands->has($p['brand_id'])) {
                $brand['count'] = 1;
                $brands[$p['brand_id']] = $brand;
            } else {
                $brands[$p['brand_id']]['count'] += 1;
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

    public function getColors($products)
    {
        $colors = collect([]);

        foreach ($products as $product) {
            if($product['color']) {
                $productColors = explode(',', $product['color']);

                if(count($productColors) == 2) {
                    if(!$colors->has($product['color'])) {
                        $colors[$product['color']] = collect(['color' => $product['color'], 'count' => 1]);
                    } else {
                        $colors[$product['color']]['count'] += 1;
                    }
                } else {
                    foreach ($productColors as $color) {
                        if(!$colors->has($color)) {
                            $colors[$color] = collect(['color' => $color, 'count' => 1]);
                        } else {
                            $colors[$color]['count'] += 1;
                        }
                    }
                }
            }
        }

        return $colors;
    }

    public function getTags($products)
    {
        $promotionTags = Tag::isPromotion()->get();

        $tagsList = collect([]);

        foreach ($products as $product) {
            $tags = $product['tags'];

            if($tags->count() > 0) {
                foreach ($tags as $tag) {
                    // except promotions
                    if(!$promotionTags->contains($tag->id)) {
                        if(!$tagsList->has($tag->id)) {
                            $tag['count'] = 1;
                            $tagsList[$tag->id] = $tag;
                        } else {
                            $tagsList[$tag->id]['count'] += 1;
                        }
                    }
                }
            }
        }

        return $tagsList;
    }

    public function getFeatures($products)
    {
        $featureList = collect([]);

        foreach ($products as $product) {
            if($product['features']) {
                $features = json_decode($product['features'])->ids;
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

    public function filterProducts(Request $request)
    {
        $lang = $request->get('lang', App::getLocale());
        $filters = $request->get('filters');
        $category = Category::ofSlug($request->get('category_slug'))->isActive()->first();

        if($category->childs->count() > 0) {
            $products = Product::ofSecondLevelCategory($category->id);
        } else {
            $products = Product::ofCategory($category->id);
        }

        $products = $products
            ->isVisible()
            ->ofTags($filters['tag'])
            ->ofCountries($filters['country'])
            ->ofBrands($filters['brand'])
            ->ofColors($filters['color'])
            ->ofFeatures($filters['features'])
            ->with('images_table')
            ->get()
            ->map(function ($p) use ($lang) {
                $p['in_stock'] = $p->stock > 0 ? true : false;
                $p['tags'] = $this->getProductTags($p);

                $brand = $this->getProductBrand($p);

                if($brand) {
                    $p['brand_name'] = $brand->name;
                    $p['brand_image'] = Storage::disk('public')->url('brands/'.$brand->image);
                }

                if(!$p['images_table']->isEmpty()) {
                    $p['imagesResized'] = explode(',', $p['images_table'][0]['paths_resized']);
                }

                $p['preview_picture'] = $p->getPreviewPicture();
                $p['link'] = route('homepage').'/'.$lang.'/products/'.$p->getSlugAttribute();

                return $p;
            });

        // filter by price
        $products = $products
            ->when($filters['price']['from'], function ($q) use($filters) {
                return $q->where('filtered_price', '>', $filters['price']['from']);
            })
            ->when($filters['price']['to'], function ($q) use($filters) {
                return $q->where('filtered_price', '<', $filters['price']['to']);
            })
            ->values()
            ->all();

        return response()->json($products, 200);
    }

    public function getProductTags($product)
    {
        $tagsIds = explode(',', $product->tags);
        $tags = collect([]);

        foreach ($tagsIds as $tagId) {
            $tag = Tag::find($tagId);

            if($tag) {
                $tags[] = $tag;
            }
        }

        return $tags;
    }

    public function getProductBrand($product)
    {
        return $product->brand;
    }
}
