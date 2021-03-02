<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Region;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    public function getCartLink()
    {
        return route('homepage');
    }

    public function getAvailableDeliveryCitiesByRegion(Request $request)
    {
        $region_id = $request->get('region');
        $region = Region::find($region_id);

        if($region) {
            return response()->json($region->cities()->orderBy('name_ru', 'ASC')->get(), 200);
        } else {
            return response()->json([], 200);
        }
    }

    public function getLastAddedProduct(Request $request)
    {
        $lang = $request->get('lang', App::getLocale());
        $productArticul = $request->get('articul');
        $product = $this->getProductAndAddInfoToProduct($productArticul, $lang);

        return response()->json($product, 200);
    }

    public function getProductsByArticlesWithComplement(Request $request)
    {
        $lang = $request->get('lang', App::getLocale());
        $articles = $request->get('articles');

        $products = collect([]);

        $articles = json_decode($articles);

        $cookieCartProducts = json_decode(Cookie::get('user'))->cart;

        foreach ($cookieCartProducts as $cookieCartProduct) {
            $product = $this->getProductAndAddInfoToProduct(is_array($cookieCartProduct->articul) ? json_encode($cookieCartProduct->articul) : $cookieCartProduct->articul, $lang);
            $arr = [];

            if(isset($cookieCartProduct->articul) && is_array($cookieCartProduct->articul) && isset($cookieCartProduct->product_id_for_kit)) {
                $arr['products'] = $product;
                $arr['count'] = $cookieCartProduct->count;
                $arr['parent_url'] = isset($cookieCartProduct->parent_url) ? $cookieCartProduct->parent_url : '';
                $arr['product_id_for_kit'] = isset($cookieCartProduct->product_id_for_kit) ? $cookieCartProduct->product_id_for_kit : null;
                $products[] = $arr;
            } else {
                $product['count'] = $cookieCartProduct->count;
                // singly_product_id_for_kit equals product_id_for_kit
                // but we need to change key name for if condition in Cart Index loop
                $product['singly_product_id_for_kit'] = isset($cookieCartProduct->product_id_for_kit) ? $cookieCartProduct->product_id_for_kit : null;
                $products[] = $product;
            }
        }

        return response()->json($products, 200);
    }

    public function getProductAndAddInfoToProduct(string $articul, string $lang)
    {
        if(is_array(json_decode($articul))) {
            $articles = json_decode($articul);

            $products = collect([]);

            foreach ($articles as $article) {
                $p = Product::ofArticul($article)->first();
                $p['preview_picture'] = $p->getPreviewPicture();
                $p['tags'] = $this->getProductTags($p);
                $p['product_link'] = route('homepage').'/'.$lang.'/products/'.$p->getSlugAttribute();

                $products[] = $p;
            }

            return $products;
        } else {
            $product = Product::ofArticul($articul)->first();
            $product['preview_picture'] = $product->getPreviewPicture();
            $product['tags'] = $this->getProductTags($product);
            $product['product_link'] = route('homepage').'/'.$lang.'/products/'.$product->getSlugAttribute();

            return $product;
        }

    }

    public function getProductsByArticles(Request $request)
    {
        $lang = $request->get('lang', App::getLocale());
        $articles = $request->get('articles');

        $products = collect([]);

        $cookieCartProducts = json_decode(Cookie::get('user'))->cart;

        if($articles) {
            foreach ($articles as $articul) {
                $product = $this->getProductAndAddInfoToProduct($articul, $lang);

                foreach ($cookieCartProducts as $cookieCartProduct) {
                    if(is_array(json_decode($articul))) {
                        if(json_decode($articul) === $cookieCartProduct->articul) {
                            $product['count'] = $cookieCartProduct->count;
                        }
                    } else {
                        if($articul === $cookieCartProduct->articul) {
                            $product['count'] = $cookieCartProduct->count;
                        }
                    }
                }

                $products[] = $product;
            }
        }

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
}
