<?php


namespace App\Http\Controllers\Pages;


use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Tag;
use App\Traits\RecommendedProductsTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandsController extends Controller
{
    use RecommendedProductsTrait;

    protected $brands;

    public function index()
    {
        $non_tile_recommended_products = $this->getNonTileRecommendedProducts();
        $tile_recommended_products = $this->getTileRecommendedProducts();
        $json_encoded_recommended_products = $this->getJsonEncodedRecommendedProducts($non_tile_recommended_products, $tile_recommended_products);

        $parent_categories = Category::getFirstLevelCategories()->isActive()->get();
        $brands = $this->getBrandsFromAllCategories();

        $catalog_path = route('pages.catalog.index');
        $storage_path = asset('storage/');
        $russian_alphabet = json_encode(get_russian_alphabet(), JSON_UNESCAPED_UNICODE);
        $english_alphabet = json_encode(get_english_alphabet(), JSON_UNESCAPED_UNICODE);

        return view('pages.brands.index', compact(
            'parent_categories',
            'brands',
            'catalog_path',
            'storage_path',
            'russian_alphabet',
            'english_alphabet',
            'json_encoded_recommended_products'
        ));
    }

    public function getBrandsFromAllCategories()
    {
        $this->brands = Brand::all();
        $this->brands = $this->setPathToSingleBrandPage();
        $this->brands = $this->setBrandPreviewPicture();

        return $this->brands;
    }

    public function setPathToSingleBrandPage()
    {
        $brands = [];

        foreach($this->brands as $brand) {
            $brand['singlePagePath'] = route('pages.brands.show', $brand['slug']);
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

    public function show(string $slug)
    {
        $brand = Brand::ofSlug($slug)->first();
        $newTag = Tag::isNew()->first();
        $saleTag = Tag::isSale()->first();

        abort_unless($brand, 404);

        $category = Category::find($brand->category_id);

        if(!$category || (int)$category->parent_id !== 1) {
            $category = Category::getFirstLevelCategories()->isActive()->first();
        }

        $non_tile_recommended_products = $this->getNonTileRecommendedProducts();
        $tile_recommended_products = $this->getTileRecommendedProducts();
        $json_encoded_recommended_products = $this->getJsonEncodedRecommendedProducts($non_tile_recommended_products, $tile_recommended_products);

        return view('pages.brands.show', compact('brand', 'category', 'json_encoded_recommended_products', 'newTag', 'saleTag'));
    }
}
