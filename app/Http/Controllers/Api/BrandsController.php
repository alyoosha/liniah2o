<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class BrandsController extends Controller
{
    protected $brands;

    public function getBrandsByCategoryName(Request $request)
    {
        $lang = $request->get('lang', App::getLocale());
        $brands = [];

        if($request->category === 'all_categories') {
            $brands = $this->getBrandsFromAllCategories($lang);

            return $brands;
        }

        $parent_category = Category::where('name_ru', 'LIKE',  '%'. ucfirst($request->category) .'%')->isActive()->first();
        $parent_category_id = $parent_category->id;

        $second_level_categories = Category::where('parent_id', $parent_category_id)->isActive()->with('childs')->get();

        // 10382 -> id Плитки
        if((int)$parent_category->id === 10382) {
            foreach ($second_level_categories as $second_level_category) {
                $collections = $second_level_category->collections;

                if($collections->count() > 0) {
                    foreach ($collections as $collection) {
                        $brand_params = $collection->brand->toArray();
                        $brand_params['singlePagePath'] = route('homepage').'/'.$lang.'/brands/'.$collection->brand->slug;
                        $brand_params['preview_image'] = Storage::disk('public')->url('brands/'.$collection->brand->image);

                        if(!in_array($brand_params, $brands)) {
                            $brands[] = $brand_params;
                        }
                    }
                }
            }

            return $brands;
        } else {
            foreach ($second_level_categories as $second_level_category) {
                $third_level_categories = $second_level_category->childs()->isActive()->with('products')->get();

                foreach ($third_level_categories as $third_level_category) {
                    $prods = $third_level_category->products;

                    if($prods->count() > 0) {
                        foreach ($prods as $prod) {
                            $brand = $prod->brand;

                            if($brand) {
                                $brand_params = $brand->toArray();
                                $brand_params['singlePagePath'] = route('homepage').'/'.$lang.'/brands/'.$prod->brand->slug;
                                $brand_params['preview_image'] = Storage::disk('public')->url('brands/'.$prod->brand->image);

                                if(!in_array($brand_params, $brands)) {
                                    $brands[] = $brand_params;
                                }
                            }
                        }
                    }
                }
            }

            return $brands;
        }
    }

    public function getBrandsFromAllCategories(string $lang)
    {
        $this->brands = Brand::all();
        $this->brands = $this->setPathToSingleBrandPage($lang);
        $this->brands = $this->setBrandPreviewPicture();

        return $this->brands;
    }

    public function setPathToSingleBrandPage(string $lang)
    {
        $brands = [];

        foreach($this->brands as $brand) {
            $brand['singlePagePath'] = route('homepage').'/'.$lang.'/brands/'.$brand['slug'];
            $brands[] = $brand;
        }

        return $brands;
    }

    public function setBrandPreviewPicture()
    {
        $brands = [];

        foreach($this->brands as $brand) {
            $brand['preview_image'] = Storage::disk('public')->url('brands/'.$brand['image']);

            $brands[] = $brand;
        }

        return $brands;
    }
}
