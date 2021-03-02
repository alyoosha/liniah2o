<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Locale;
use App\Models\Page;
use App\Models\Product;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
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

    public static function getSearchResultForCategory(Request $request) {
        $lang = Locale::getLocale();
        $str = $request->input('header-search');

        $categories = Category::categoriesForSearch($lang, $str)->with('childs')->get();
        if(!$categories->isEmpty()) {
            $categories = parent::getBreadcrumbsForSearchPage($categories);
        }

        return $categories;
    }

    public static function getSearchResultForProduct(Request $request) {
        $lang = Locale::getLocale();
        $str = $request->input('header-search');
        $take = $request->input('take') ?? 8;
        $skip = $request->input('skip') ? $request->input('skip') * $take : 0;
        $countProducts = Product::productsForSearch($lang, $str)->count();
        $products = collect([]);
        $products = $products->put('products', Product::productsForSearch($lang, $str)->skip($skip)->take($take)->get());
        $products->put('countProducts', $countProducts);
        $collections = \App\Models\Collection::all()->toArray(); //TODO переделать/удалить в будущем

        foreach ($products['products'] as $product) {
            $product['brand'] = $product->brand;

            //TODO переделать/удалить в будущем
            $arrLink = explode('/', $product->link);
            if ($arrLink[2] == 'plitka-10382') {
                foreach ($collections as $collection) {
                    $ps = json_decode(json_decode($collection['product_array'], JSON_UNESCAPED_UNICODE)['ids'], JSON_UNESCAPED_UNICODE);
                    foreach ($ps as $p) {
                        if($p == $product->articul) {
                            $lastEl = array_pop($arrLink);
                            array_push($arrLink, $collection['slug'], $lastEl);
                            $product['newLink'] = implode('/', $arrLink);
                        }
                    }
                }
            }
            else {
                $product['newLink'] = $product->link;
            }
            //TODO конец

            $product['image'] = $product->getPreviewPicture();
            $product['pathBrand'] = Storage::disk('public')->url('brands');
            $tagsIds = explode(',', $product->tags);
            $tgs = collect([]);

            foreach ($tagsIds as $tagId) {
                $tag = Tag::find($tagId);

                if($tag) {
                    $tgs[] = $tag;
                }
            }

            $product['arTags'] = $tgs;
        }

        return $products;
    }
}
