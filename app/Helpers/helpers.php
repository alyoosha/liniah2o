<?php

use App\Models\Settings;
use App\Models\Tag;
use App\Models\Images;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

if (!function_exists('get_setting_by_key')) {
    function get_setting_by_key(string $key){
        return Settings::first($key)->{$key};
    }
}

if (!function_exists('get_russian_alphabet')) {
    function get_russian_alphabet() {
        return [
            'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о',
            'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ь', 'ы', 'ъ', 'э', 'ю', 'я'
        ];
    }
}

if (!function_exists('get_english_alphabet')) {
    function get_english_alphabet() {
        return [
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p',
            'q', 'r', 's', 't', 'v', 'u', 'w', 'x', 'y', 'z'
        ];
    }
}

if(!function_exists('mb_ucfirst'))
{
    function mb_ucfirst($string, $enc = 'UTF-8')
    {
        return mb_strtoupper(mb_substr($string, 0, 1, $enc), $enc) .
            mb_substr($string, 1, mb_strlen($string, $enc), $enc);
    }
}

if(!function_exists('get_price_for_html'))
{
    function get_price_for_html($num)
    {
        $num = ceil($num);
        if(strlen($num) > 3) {
            return substr($num, 0,1) . ' ' . substr($num, 1);
        }
        else {
            return $num;
        }
    }
}

if(!function_exists('show_tag_name'))
{
    function show_tag_name($tag)
    {
        if((int)$tag->discount !== 0 && (int)$tag->show_name === 1) {
            preg_match('/[0-9]{1,2}%/i', $tag['name_ru'], $discount_array);

            return $discount_array[0];
        }

        if($tag->show_name === 1) {
            return $tag['name_'.App::getLocale()];
        }
    }
}

if(!function_exists('get_product_keywords_from_breadcrumbs'))
{
    function get_product_keywords_from_breadcrumbs($breadcrumbs)
    {
        $breadcrumbs = $breadcrumbs ?? [];
        $str = '';

        foreach ($breadcrumbs as $bc) {
            if(isset($bc['name_ru'])) {
                $str .= $bc['name_'.App::getLocale()] . ' ';
            } else {
                $str .= $bc['name'] . ' ';
            }
        }

        return $str;
    }
}

if(!function_exists('filter_images'))
{
    function filter_images($images, $folder, $articul = null)
    {
        $images = json_decode($images);

        $column = $folder == 'products' ? 'product_articul' : 'collection_articul';

        if($articul) {
            $arr = [];
            $imgs = Images::where($column, $articul)->where('is_visible', 1)->get();

            $imgs->map(function ($img) use (&$arr) {
                $arr[] = $img['name'] . '.' . $img['ext'];
            });

            $images = array_values(array_intersect($images, $arr));
        }

        if(!empty($images)) {
            foreach ($images as $key => $image) {

                if(!Storage::disk('public')->exists($folder . '/' . $image) && !Storage::disk('public')->exists('compressed_images/' . $folder . '/images_optimized/' . $image)) {
                    unset($images[$key]);
                }
            }
        }

        $images = array_values($images);

        return json_encode($images);
    }
}

if(!function_exists('is_tile'))
{
    function is_tile($product)
    {
        if($product->collection_id) return true;

        return false;
    }
}

if(!function_exists('get_bread'))
{
    function get_breadcrumbs($categories, $category, $lang)
    {
        $i = 0;
        $bc = [];
        $link = '';

        while($category['id'] != 0) {
            $bc[$i]['name']= $category['name_' . $lang];
            $bc[$i]['slug']= $category['slug'];
            $bc[$i]['id']= $category['id'];

            if($category['parent_id'] == 0) break;

            $category = $categories[$category['parent_id']];
            ++$i;
        }

        $bc = array_reverse($bc);

        if($bc[1]['id'] == 10382 && count($bc) == 3) {
            $lastItem = array_splice($bc, -1,1);
            array_push($bc, ['name' => __('collections'), 'slug' => 'collections']);
            array_push($bc, $lastItem[0]);

            foreach ($bc as $key => $b) {
                if($key == 2) {
                    $bc[$key]['link'] = $link;
                    $link .= '/' . $b['slug'];
                    continue;
                }

                $link .= '/' . $b['slug'];
                $bc[$key]['link'] = $link;
            }
        }
        else {
            foreach ($bc as $key => $b) {
                $link .= '/' . $b['slug'];
                $bc[$key]['link'] = $link;
            }
        }

        return $bc;
    }
}

if(!function_exists('get_preview_picture'))
{
    function get_preview_picture($images, $folder)
    {
        $images = json_decode($images, true);

        if(!empty($images) && Storage::disk('public')->exists($folder . '/' . $images[0]) && Storage::disk('public')->exists('compressed_images/' . $folder . '/images_optimized/' . $images[0])) {
            return Storage::disk('public')->url('compressed_images/' . $folder . '/images_optimized/' . $images[0]);
        }
        else {
            return Storage::disk('public')->url('products/product-img-default.jpg');
        }
    }
}

if(!function_exists('get_slug_product'))
{
    function get_slug_product($product)
    {
        $slug =  \Illuminate\Support\Str::slug($product['name_ru']) . '-' . $product['articul'];
        return preg_replace('/(?<=\d)(x)(?=\d)/i', '-', $slug);
    }
}

if(!function_exists('get_tags'))
{
    function get_tags($tags, $allTags)
    {
        $tagsIds = explode(',', $tags);

        $tags = $allTags->filter(function ($tag) use ($tagsIds) {
            if(in_array($tag->id, $tagsIds)) {
                return $tag;
            }
        })->values()->toArray();

        return $tags;
    }
}

if(!function_exists('get_products'))
{
    function get_products($products, $allTags)
    {
        if(is_null($products) || empty($products)) {
            return null;
        }

        $productsAll = [];

        foreach ($products as $product_articles) {
            if(is_array($product_articles)) {
                $similar_product_articles = [];
                $imploded_product_articles = implode(',', $product_articles);

                $query = "
                    select products.*,
                    brands.id as 'brand_id',
                    brands.name as 'brand_name',
                    brands.slug as 'brand_slug',
                    brands.image as 'brand_image',
                    GROUP_CONCAT(DISTINCT images.paths_resized SEPARATOR ',') AS images_resized
                    from `products`
                    left join brands on brands.id=products.brand_id
                    left join `images` images ON images.product_articul=products.articul and images.is_visible
                    where products.articul IN ($imploded_product_articles)
                    GROUP BY products.id";

                $query_result_products_products = DB::select($query);

                if($query_result_products_products) {
                    foreach ($query_result_products_products as $p) {
                        $p = (array) $p;
                        $p['tags'] = !empty($p['tags']) ? get_tags($p['tags'], $allTags) : [];
                        $p['imgPreview'] = get_preview_picture($p['images'], 'products');
                        $p['imagesResized'] = get_images_resized($p['images_resized']);
                        $p['link'] = route('pages.product.index', get_slug_product($p));

                        $similar_product_articles[] = $p;
                    }

                    $productsAll[] = $similar_product_articles;
                }
            } else {
                $query = "
                    select products.*, 
                    brands.id as 'brand_id', 
                    brands.name as 'brand_name', 
                    brands.slug as 'brand_slug', 
                    brands.image as 'brand_image',
                    GROUP_CONCAT(DISTINCT images.paths_resized SEPARATOR ',') AS images_resized
                    from `products` 
                    left join brands on brands.id=products.brand_id   
                    left join `images` images ON images.product_articul=products.articul and images.is_visible = 1
                    where products.articul=$product_articles
                    GROUP BY products.id";

                $query_result_product = DB::select($query);

                if($query_result_product) {
                    $product_result_row = $query_result_product[0];

                    $p = (array) $product_result_row;

                    $p['tags'] = !empty($p['tags']) ? get_tags($p['tags'], $allTags) : [];
                    $p['imgPreview'] = get_preview_picture($p['images'], 'products');
                    $p['imagesResized'] = get_images_resized($p['images_resized']);
                    $p['link'] = route('pages.product.index', get_slug_product($p));

                    $productsAll[] = $p;
                }
            }
        }

        return $productsAll;
    }
}

if(!function_exists('get_promotion_discount_attribute_for_product'))
{
    function get_promotion_discount_attribute_for_product($tags)
    {
        $promotions = Tag::isPromotion()->get();

        foreach ($promotions as $p) {
            $tagsIds = explode(',', $tags);

            if(in_array($p->id, $tagsIds)) {
                return $p->discount;
            }
        }

        return 0;
    }
}

if(!function_exists('get_tag_css_class_by_color')) {
    function get_tag_css_class_by_color(string $hex) {
        $color_classes = [
            '#D32F2F' => 'bg_normal_red',
            '#C2185B' => 'bg_magenta',
            '#7B1FA2' => 'bg_purple',
            '#512DA8' => 'bg_violent',
            '#303F9F' => 'bg_darkblue',
            '#1976D2' => 'bg_seablue',
            '#0097A7' => 'bg_biruzze',
            '#00796B' => 'bg_darkgreen',
            '#388E3C' => 'bg_forestgreen',
            '#689F38' => 'bg_grassgreen',
            '#AFB42B' => 'bg_saladgreen',
            '#FBC02D' => 'bg_sunyellow',
            '#FFA000' => 'bg_brightorange',
            '#F57C00' => 'bg_orange2',
            '#E64A19' => 'bg_carrot',
            '#5D4037' => 'bg_bearbrown',
            '#616161' => 'bg_raingray',
            '#455A64' => 'bg_wetgray',
        ];

        if($color_classes[$hex]) {
            return $color_classes[$hex];
        } else {
            return '';
        }
    }
}

if(!function_exists('get_images_resized')) {
    function get_images_resized($images) {
        $images = explode(',', $images);

        return $images;
    }
}
