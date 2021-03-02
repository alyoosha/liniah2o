<?php


namespace App\Http\Controllers\Pages;


use App\Http\Controllers\Controller;
use App\Models\CatalogSlider;
use App\Models\Category;
use App\Models\Feature;
use App\Models\FeatureType;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CatalogController extends Controller
{
    public function index()
    {
        $categories = Category::getFirstLevelCategories()->isActive()->get();
        $newTag = Tag::isNew()->first();
        $promotionTag = Tag::isPromotion()->first();
        $saleTag = Tag::isSale()->first();

        return view('pages.catalog.index', compact('categories', 'newTag', 'saleTag', 'promotionTag'));
    }

    public function secondary_index(string $secondary_slug)
    {
        $first_level_category = Category::ofSlug($secondary_slug)->first();

        abort_if(!$first_level_category || (int)$first_level_category->parent_id !== 1, 404);

        $query_result_rows = DB::select("
            select
                first_level_categories.id as 'first_level_category_id',
                first_level_categories.name_ru as 'first_level_category_name_ru',
                first_level_categories.name_ro as 'first_level_category_name_ro',
                first_level_categories.slug as 'first_level_category_slug',
                first_level_categories.logo as 'first_level_category_logo',
                first_level_categories.svg_logo as 'first_level_category_svg_logo',
                first_level_categories.color_class_prefix as 'first_level_category_color_class_prefix',
                
                second_level_categories.id as 'second_level_category_id',
                second_level_categories.name_ru as 'second_level_category_name_ru',
                second_level_categories.name_ro as 'second_level_category_name_ro',
                second_level_categories.slug as 'second_level_category_slug',
                second_level_categories.logo as 'second_level_category_logo',
                second_level_categories.svg_logo as 'second_level_category_svg_logo',
                second_level_categories.color_class_prefix as 'second_level_category_color_class_prefix',
                
                third_level_categories.id as 'third_level_category_id',
                third_level_categories.name_ru as 'third_level_category_name_ru',
                third_level_categories.name_ro as 'third_level_category_name_ro',
                third_level_categories.slug as 'third_level_category_slug'
                    from `categories` as first_level_categories
                        join `categories` as second_level_categories on second_level_categories.parent_id=first_level_categories.id and second_level_categories.is_active=1
                        left join `categories` as third_level_categories on third_level_categories.parent_id=second_level_categories.id and third_level_categories.is_active=1
                            where first_level_categories.parent_id=1
                                and first_level_categories.is_active=1
                                and first_level_categories.slug=?
            ", [$secondary_slug]);

        $categories = [];

        foreach ($query_result_rows as $row) {
            if(!array_key_exists($row->second_level_category_id, $categories)) {
                $categories[$row->second_level_category_id] = [];

                $second_level_category_info = [
                    'id' => $row->second_level_category_id,
                    'name_ru' => $row->second_level_category_name_ru,
                    'name_ro' => $row->second_level_category_name_ro,
                    'slug' => $row->second_level_category_slug,
                    'logo' => $row->second_level_category_logo,
                    'svg_logo' => $row->second_level_category_svg_logo,
                    'color_class_prefix' => $row->second_level_category_color_class_prefix,
                ];

                $categories[$row->second_level_category_id]['category_info'] = $second_level_category_info;
            }

            if($row->third_level_category_id) {
                $categories[$row->second_level_category_id]['children'][$row->third_level_category_id] = [
                    'id' => $row->third_level_category_id,
                    'name_ru' => $row->third_level_category_name_ru,
                    'name_ro' => $row->third_level_category_name_ro,
                    'slug' => $row->third_level_category_slug,
                ];
            }
        }

        // 10382 -> id Плитки
        $isTile = (int)$first_level_category->id === 10382 ? true : false;

        $categories = $this->putRelatedProductsSubcategoryToEnd($categories);
        $categories = $this->sortCategoryChildrenByEmptyChildList($categories);

        $newTag = Tag::isNew()->first();
        $promotionTag = Tag::isPromotion()->first();
        $saleTag = Tag::isSale()->first();

        return view('pages.catalog.secondary_index', compact('categories', 'first_level_category', 'newTag', 'saleTag', 'promotionTag', 'isTile'));
    }

    public function putRelatedProductsSubcategoryToEnd($categories)
    {
        $related_products_subcategory = '';

        foreach ($categories as $key => $child) {
            if(preg_match("/(soputstvuyushhie-tovary)-[0-9]+$/", $child['category_info']['slug'])) {
                $related_products_subcategory = $categories[$key];
                unset($categories[$key]);
            }
        }

        if(!empty($related_products_subcategory)) {
            $categories[] = $related_products_subcategory;
        }

        return $categories;
    }

    public function sortCategoryChildrenByEmptyChildList($categories)
    {
        $empty_categories = [];

        foreach ($categories as $key => $category) {
            if(!array_key_exists('children', $category)) {
                $empty_categories[$key] = $categories[$key];
                unset($categories[$key]);
            }
        }

        $categories = $empty_categories + $categories;

        return $categories;
    }

    public function ternary_index(Request $request, string $secondary_slug, string $ternary_slug, string $third_level_category_slug = 'all_categories')
    {
        $first_level_category = Category::ofSlug($secondary_slug)->isActive()->first();
        $second_level_category = Category::ofSlug($ternary_slug)->isActive()->first();

        abort_if(!$first_level_category || !$second_level_category || (int)$first_level_category->parent_id === 0, 404);
        abort_if((int)$second_level_category->parent_id !== (int)$first_level_category->id, 404);

        $second_level_category_query_rows = DB::select("
            select 
               categories.id,
               categories.slug,
               categories.name_ru,
               categories.name_ro 
                    from `categories` as categories 
                        where categories.parent_id=? and categories.is_active=1
        ", [$second_level_category->id]);

        $second_level_category['children_categories'] = collect([]);

        foreach ($second_level_category_query_rows as $row) {
            $child = [
                'id' => $row->id,
                'slug' => $row->slug,
                'name_ru' => $row->name_ru,
                'name_ro' => $row->name_ro,
            ];

            $second_level_category['children_categories'][$row->id] = $child;
        }

        $second_level_category['children_categories'] = json_encode($second_level_category['children_categories'], JSON_UNESCAPED_UNICODE);

        $third_level_category = $this->getThirdLevelCategory($third_level_category_slug);

        abort_if(!$third_level_category, 404);

        if(isset($third_level_category->parent_id)) {
            abort_if((int)$third_level_category->parent_id !== (int)$second_level_category->id, 404);
        }

        if($third_level_category_slug !== 'all_categories') {
            $products = $this->getProductsOfThirdLevelCategory($third_level_category->id);
        } else {
            $products = $this->getProductsOfSecondLevelCategory($second_level_category);
        }
        // when we set brand filter before we go to this page
        $active_brand = $request->query('brand');
        $active_tags = [
            'new' => $request->query('new'),
            'sale' => $request->query('sale')
        ];

        $brands = $this->getBrands($products)->map(function ($b) use($active_brand) {
            if($b['id'] === (int)$active_brand) {
                $b['checked'] = true;
            } else {
                $b['checked'] = false;
            }

            return $b;
        });

        $countries = $this->getCountries($brands);
        $colors = $this->getColors($products);
        $tags = $this->getTags($products)->map(function ($t) use($active_tags) {
            if($t['id'] === (int)$active_tags['new']) {
                $t['is_new'] = true;
            } else {
                $t['is_new'] = false;
            }

            if($t['id'] === (int)$active_tags['sale']) {
                $t['is_sale'] = true;
            } else {
                $t['is_sale'] = false;
            }

            return $t;
        });

        $in_stock_count = $products->where('in_stock', true)->count();

//        $featureList = $this->getFeatures($products);
//        if($featureList->count() > 0) {
//            $feature_types = FeatureType::whereRaw("JSON_CONTAINS(feature_types.categories->'$.ids', '[$second_level_category->id]')")
//                ->isShouldBeAddedToFilter()
//                ->get()
//                ->map(function ($f) use($featureList) {
//                    if($f->features->count() > 0) {
//                        $features = $f->features;
//
//                        if($features->count() > 0) {
//                            foreach ($features as $feature) {
//                                if($featureList->has($feature->id)) {
//                                    $feature['count'] = $featureList[$feature->id]['count'];
//                                } else $feature['count'] = 0;
//                            }
//
//                            $features = $features
//                                ->reject(function ($f) {
//                                    return $f->count == 0;
//                                })
//                                ->values();
//                        }
//
//                        $f['filtered_features'] = $features;
//                    }
//
//                    return $f;
//                })
//                ->reject(function ($f) {
//                    return !$f['filtered_features'];
//                })
//                ->values();
//        } else {
//            $feature_types = collect([]);
//        }

        $featureList = $this->getFeaturesNew($products);
        if(count($featureList) > 0) {
            $feature_types = FeatureType::whereRaw("JSON_CONTAINS(feature_types.categories->'$.ids', '[$second_level_category->id]')")
                ->isShouldBeAddedToFilter()
                ->get()
                ->map(function ($f) use($featureList) {
                    if($f->features->count() > 0) {
                        $features = $f->features;

                        if($features->count() > 0) {
                            foreach ($features as $feature) {
                                if(array_key_exists($feature->id, $featureList)) {
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
                })
                ->values();
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

        $link_to_secondary_catalog_page = route('pages.catalog.secondary_index', $first_level_category->slug);

        return view('pages.catalog.ternary_index', compact(
            'products',
            'brands',
            'tags',
            'countries',
            'colors',
            'feature_types',
            'slides',
            'secondary_slug',
            'ternary_slug',
            'first_level_category',
            'second_level_category',
            'third_level_category',
            'third_level_category_slug',
            'link_to_secondary_catalog_page',
            'in_stock_count'
        ));
    }

    public function getThirdLevelCategory(string $slug)
    {
        if($slug !== 'all_categories') {
            return Category::ofSlug($slug)->isActive()->first();
        } else {
            return collect([]);
        }
    }

    public function getProductsOfThirdLevelCategory(int $category_id)
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
                        left join `images` images ON images.product_articul=products.articul
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
            $p['link_to_brands_page'] = route('pages.brands.index');

            $p['brand_country_id'] = $row->product_brand_country_id;
            $p['brand_country_name_ru'] = $row->product_brand_country_name_ru;
            $p['brand_country_name_ro'] = $row->product_brand_country_name_ro;

            $product_slug_attribute =  Str::slug($row->product_name_ru) . '-' . $row->product_articul;
            $product_slug_attribute = preg_replace('/(?<=\d)(x)(?=\d)/i', '-', $product_slug_attribute);

            $p['link'] = route('pages.product.index', [$product_slug_attribute]);

            if(Storage::disk('public')->exists('brands/'.$row->product_brand_image_name)) {
                $p['brand_image'] = Storage::disk('public')->url('brands/'.$row->product_brand_image_name);
            } else {
                $p['brand_image'] = Storage::disk('public')->url('brands/default-brand-placeholder.png');
            }

            $products[] = $p;
        }

        return $products;
    }

    public function getProductsOfSecondLevelCategory($second_level_category)
    {
        $query_result_rows = DB::select("
            select 
                third_level_category.id as 'third_level_category_id',
                third_level_category.name_ru as 'third_level_category_name_ru',
                third_level_category.name_ro as 'third_level_category_name_ro',
                   
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
                    from `categories` as third_level_category
                        join `products` as products on products.category_id=third_level_category.id and products.is_visible=1
                        left join `brands` as brands on brands.id=products.brand_id
                        left join `countries` as countries on countries.id=brands.country_id
                        left join `images` images ON images.product_articul=products.articul and images.is_visible
                        where third_level_category.parent_id=? and third_level_category.is_active=1
                        GROUP BY products.id",
            [$second_level_category->id]);

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
            $p['link_to_brands_page'] = route('pages.brands.index');

            $p['brand_country_id'] = $row->product_brand_country_id;
            $p['brand_country_name_ru'] = $row->product_brand_country_name_ru;
            $p['brand_country_name_ro'] = $row->product_brand_country_name_ro;

            $product_slug_attribute =  Str::slug($row->product_name_ru) . '-' . $row->product_articul;
            $product_slug_attribute = preg_replace('/(?<=\d)(x)(?=\d)/i', '-', $product_slug_attribute);

            $p['link'] = route('pages.product.index', [$product_slug_attribute]);

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

        $features_for_choose = Feature::all();

        foreach ($products as $product) {
            if($product['features']) {
                $features = json_decode($product['features'])->ids;

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

    public function getFeaturesNew($products)
    {
        $features_for_choose = Feature::all()->toArray();
        $features_for_choose_ids = Feature::all()->pluck('id')->toArray();
        $features_for_choose = array_combine($features_for_choose_ids, $features_for_choose);

        $products_features = [];

        foreach ($products as $key => $product) {
            if($product['features']) {
                $features = json_decode($product['features'])->ids;

                if(count($features) > 0) {
                    foreach ($features as $feature_id) {
                        if(!array_key_exists($feature_id, $products_features)) {
                            $f = isset($features_for_choose[(int)$feature_id]) ? $features_for_choose[(int)$feature_id] : [];
                            $f['count'] = 1;
                            $products_features[$feature_id] = $f;
                        } else {
                            $products_features[$feature_id]['count'] += 1;
                        }
                    }
                }
            }
        }

        $products_features = array_intersect_key($products_features, $features_for_choose);

        return $products_features;
    }
}
