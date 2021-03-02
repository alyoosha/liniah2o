<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Locale;
use App\Models\Page;
use App\Models\Product;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class AjaxController extends Controller
{
    public $data = [];

    protected static function error($err)
    {
        echo json_encode(['message' => $err, 'error' => true], JSON_UNESCAPED_UNICODE);
        die;
    }

    protected static function success($message)
    {
        echo json_encode(['message' => $message, 'error' => false], JSON_UNESCAPED_UNICODE);
        die;
    }

    public function checkValue(Request $request)
    {
        $name = $request->input('name');
        $value = $request->input('value');
        $col = $request->input('col');

        if ((!isset($name) && empty($name)) || (!isset($col) && empty($col))) {
            self::error('Ошибка! Не могу связать с API');
            die;
        }

        if(!isset($value) && empty($value)) {
            self::error('Поле ' . $name . ' является обязательным');
            die;
        }

        $page = Page::where($col, trim($value))->first();

        if (!empty($page)) {
            self::error($name . ' страницы уже существует');
        } else {
            self::success('Подтверждено');
        }
    }

    public static function getSearchResults(Request $request, $page = false) {
        $str = $request->input('header-search');

        $categoriesFound = $productsFound = [];

        if(is_null($str)) return json_encode(null);

        $lang = $request->input('lang') ? $request->input('lang') : self::$lang;
        $pathBrand = Storage::disk('public')->url('brands');

//        foreach ($categories as $key => $c) {
//            preg_match('/' . $str .  '/uim', $c['name_ru'].'|'.$c['name_ro'], $matches);
//            if(isset($matches[0])) {
//                $c['breadcrumbs'] =  get_breadcrumbs($categories, $c, $lang);
//                $categoriesFound[] = $c;
//            }
//        }

        $products = DB::select("
            SELECT 
            products.id as 'id', 
            products.articul as 'articul', 
            products.name_ru as 'name_ru', 
            products.name_ro as 'name_ro', 
            products.tags as 'tags', 
            products.price as 'price', 
            products.discount_price as 'discount_price', 
            products.unit_ru as 'unit_ru',
            products.stock as 'stock',
            products.unit_ro as 'unit_ro', 
            products.images as 'images', 
            brands.name as 'brand_name', 
            brands.slug as 'brand_slug', 
            brands.image as 'brand_image',
            categories.id as 'product_category_id',
            GROUP_CONCAT(DISTINCT (images.paths_resized) SEPARATOR ',') AS images_name,
            GROUP_CONCAT(DISTINCT (images.paths_resized) ORDER BY images.name SEPARATOR ',') AS images_resized
            FROM `products` products
            LEFT JOIN `categories` as categories on products.category_id=categories.id
            LEFT JOIN `brands` brands ON brands.id=products.brand_id
            LEFT JOIN `images` images ON images.product_articul=products.articul and images.is_visible = 1
            where products.is_visible=1 and (products.name_ru REGEXP ? or products.name_ro REGEXP ? or products.articul REGEXP ?)
            GROUP BY products.id", [$str, $str, $str]);

        if($page) $tags = Tag::all();

        foreach ($products as $key => $p) {
            $p = (array) $p;

            $p['link'] = route('homepage').'/'.$lang.'/products/'.get_slug_product($p);
            $p['imagePreview'] = get_preview_picture($p['images'], 'products');
            $p['imagesResized'] = get_images_resized($p['images_resized']);
            $p['pathBrand'] = $pathBrand;

            if($page) {
                $p['tags'] = get_tags($p['tags'], $tags);
            }

            $productsFound[] = $p;
        }

        $categories = Category::getCategoriesWithUniqueKeys();

        foreach ($productsFound as $key => $p) {
            if(array_key_exists($p['product_category_id'], $categories)) {
                $product_category = $categories[$p['product_category_id']];
                $product_category['breadcrumbs'] = get_breadcrumbs($categories, $categories[$p['product_category_id']], $lang);

                if(!array_key_exists($p['product_category_id'], $categoriesFound)) {
                    $categoriesFound[$p['product_category_id']] = $product_category;
                }
            }
        }

        return compact('categoriesFound', 'productsFound');
    }
}
