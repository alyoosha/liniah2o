<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PromotionController extends Controller
{
    protected const HTTP_NOTFOUND_CODE = 404;
    protected const HTTP_SUCCESS_CODE = 200;

    public function getSecondLevelCategories(Request $request)
    {
        $parent_category = $request->parent_category;
        $second_level_categories_for_match = $request->categories;

        if($parent_category) {
            $categories = Category::ofParentCategory($parent_category)->isActive()->get()->reject(function ($c) use($second_level_categories_for_match) {
                return !array_key_exists($c->id, $second_level_categories_for_match);
            });

            if($categories) {
                return response()->json($categories, self::HTTP_SUCCESS_CODE);
            } else {
                return response()->json([], self::HTTP_SUCCESS_CODE);
            }
        }

        return response()->json(['fail' => 'Данной категории нет!'], self::HTTP_SUCCESS_CODE);
    }

    public function getThirdLevelCategories(Request $request)
    {
        $parent_category = $request->parent_category;
        $third_level_categories_for_match = $request->categories;

        if($parent_category) {
            $categories = Category::ofParentCategory($parent_category)->isActive()->get()->reject(function ($c) use($third_level_categories_for_match) {
                return !array_key_exists($c->id, $third_level_categories_for_match);
            });;

            if($categories) {
                return response()->json($categories, self::HTTP_SUCCESS_CODE);
            } else {
                return response()->json([], self::HTTP_SUCCESS_CODE);
            }
        }

        return response()->json(['fail' => 'Данной категории нет!'], self::HTTP_SUCCESS_CODE);
    }

    public function getFilteredProducts(Request $request)
    {
        $lang = $request->get('lang', App::getLocale());

        $promotion_id = $request->filters['promotion_id'];

        $first_level_category = Category::find($request->filters['category_first']);

        // 10382 -> id Плитки
        if($first_level_category && (int)$first_level_category->id === 10382) {
            $products = Product::ofIsTileProduct($request->filters['category_first'], $request->filters['category_second'])
                ->ofPromotion($promotion_id)
                ->ofBrand($request->filters['brand'])
                ->get();
        } else {
            $products = Product::ofPromotion($promotion_id)
                ->ofBrand($request->filters['brand'])
                ->ofCategories($request->filters['category_first'], $request->filters['category_second'], $request->filters['category_third'])
                ->get();
        }

        $products = $this->getAdditionalProductInfo($products, $lang);

        return response()->json($products, self::HTTP_SUCCESS_CODE);
    }

    public function getAdditionalProductInfo($products, string $lang)
    {
        $products->map(function ($p) use ($lang) {
            $tagsIds = explode(',', $p->tags);
            $tags = collect([]);

            foreach ($tagsIds as $tagId) {
                $tag = Tag::find($tagId);

                if($tag) {
                    $tags[] = $tag;
                }
            }

            $p['tags'] = $tags;
            $p['brand_name'] = $p->brand->name;
            $p['brand_image'] = Storage::disk('public')->url('brands/'.$p->brand->image);
            $p['go_to_brand_path'] = route('homepage').'/'.$lang.'/brands/';
            $p['preview_picture'] = $p->getPreviewPicture();

            $product_slug_attribute =  Str::slug($p->name_ru) . '-' . $p->articul;
            $product_slug_attribute = preg_replace('/(?<=\d)(x)(?=\d)/i', '-', $product_slug_attribute);

            $p['product_link'] = route('homepage').'/'.$lang.'/products/'.$product_slug_attribute;

            return $p;
        });

        return $products;
    }
}
