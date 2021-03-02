<?php

namespace App\Traits;

use App\Models\Product;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait RelatedProductsTrait {
    public function getRelatedProducts($product_relaited_array) {
        $related_product_articules = $product_relaited_array ? json_decode($product_relaited_array)->ids : [];

        if(count($related_product_articules) >= 12) {
            $related_product_articules = array_slice($related_product_articules, 0, 12);
        }

        $imploded_related_product_articules = implode(',', $related_product_articules);

        $query = "select
                        products.id as 'product_id',
                        products.articul as 'product_articul',
                        products.name_ru as 'product_name_ru',
                        products.name_ro as 'product_name_ro',
                        products.unit_ru as 'product_unit_ru',
                        products.unit_ro as 'product_unit_ro',
                        products.price as 'product_price',
                        products.discount_price as 'product_discount_price',
                        products.stock as 'product_stock',
                        products.size_array as 'product_size_array',
                        products.color_array as 'product_color_array',
                        products.warranty as 'product_warranty',
                        products.tags as 'product_tags',
                        products.images as 'product_images',
                        products.features as 'product_features',
                        products.relaited_array as 'product_relaited_array',
                        products.complements as 'product_complements',
                        products.collection_id as 'collection_id',
       
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
                        GROUP_CONCAT(DISTINCT (images.paths_resized) SEPARATOR ',') AS images_name,
                        GROUP_CONCAT(DISTINCT (images.paths_resized) ORDER BY images.name SEPARATOR ',') AS images_resized

                            from `products` as products
                                left join `collections` as collections on collections.id=products.collection_id AND collections.is_visible=1
            
                                left join `brands` as brands on brands.id=products.brand_id
                                left join `countries` as countries on countries.id=brands.country_id
                                left join `images` images ON images.product_articul=products.articul and images.is_visible
                                    where products.articul in ($imploded_related_product_articules) and products.is_visible
                                    GROUP BY products.id";

        $result_rows = DB::select($query);

        $related_products = collect([]);

        $tagsForChoose = Tag::all();

        foreach ($result_rows as $row) {
            $product = collect([
                'id' => $row->product_id,
                'articul' => $row->product_articul,
                'name_ru' => $row->product_name_ru,
                'name_ro' => $row->product_name_ro,
                'price' => $row->product_price,
                'discount_price' => $row->product_discount_price,
                'unit_ru' => $row->product_unit_ru,
                'unit_ro' => $row->product_unit_ro,
                'stock' => $row->product_stock,
                'warranty' => $row->product_warranty,
                'brand_name' => $row->product_brand_name,
                'complements' => $row->product_complements,
                'collection_id' => $row->collection_id
            ]);

            $product['preview_picture'] = get_preview_picture($row->product_images, 'products');
            $product['imagesResized'] = get_images_resized($row->images_resized);

            $product_tag_list = explode(',', $row->product_tags);

            $product['tags'] = collect([]);
            $product['tags'] = $tagsForChoose->filter(function ($tag) use($product_tag_list) {
                if(in_array($tag->id, $product_tag_list)) {
                    return $tag;
                }
            })->values();

            $product['brand_id'] = $row->product_brand_id;
            $product['brand_name'] = $row->product_brand_name;
            $product['brand_slug'] = $row->product_brand_slug;
            $product['link_to_brands_page'] = route('pages.brands.index');

            if(Storage::disk('public')->exists('brands/'.$row->product_brand_image_name)) {
                $product['brand_image'] = Storage::disk('public')->url('brands/'.$row->product_brand_image_name);
            } else {
                $product['brand_image'] = Storage::disk('public')->url('brands/default-brand-placeholder.png');
            }

            $product_slug_attribute =  Str::slug($row->product_name_ru) . '-' . $row->product_articul;
            $product_slug_attribute = preg_replace('/(?<=\d)(x)(?=\d)/i', '-', $product_slug_attribute);

            $product['link'] = route('pages.product.index', [$product_slug_attribute]);

            $related_products[] = $product;
        }

        return $related_products;
    }
}
