<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class HeaderController extends Controller
{
    protected const SUCCESS_STATUS_CODE = 200;

    public function getFirstLevelCategories()
    {
        $categories = Category::getFirstLevelCategories()->isActive()->with('parent')->get();

        return response()->json($categories, self::SUCCESS_STATUS_CODE);
    }

    public function getSecondLevelCategories(Request $request)
    {
        $categories = Category::ofParentCategory($request->id)->isActive()->with('childs')->get();

        return response()->json($categories, self::SUCCESS_STATUS_CODE);
    }

    public function getThirdLevelCategories(Request $request)
    {
        App::setLocale($request->get('lang', 'ro'));

        $slugs = [
            'first_level_category_slug' => $request->get('first_level_category_slug'),
            'second_level_category_slug' => $request->get('second_level_category_slug'),
        ];

        $categories = Category::ofParentCategory($request->id)
            ->isActive()
            ->get()
            ->map(function ($c) use ($slugs) {
                $third_level_category_slug = $c->slug;

                $c['path_to_ternary_index_catalog_page'] = route('homepage').'/'.App::getLocale().'/catalog/'.$slugs['first_level_category_slug'].'/'.$slugs['second_level_category_slug'].'/'.$third_level_category_slug;

                return $c;
            });

        return response()->json($categories, self::SUCCESS_STATUS_CODE);
    }
}
