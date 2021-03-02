<?php

namespace App\Parser;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Country;
use App\Models\Feature;
use App\Models\FeatureType;
use App\Models\Product;
use App\Models\Tag;
use App\Models\TmpCollection;
use App\Models\TmpProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yadakhov\InsertOnDuplicateKey;
use ErrorException;

class Parser
{
    use InsertOnDuplicateKey;

    protected $brands_xml;

    protected $products_and_categories_xml;
    protected $features_xml;
    protected $tags_xml;
    protected $prices_xml;

    protected $brands;
    protected $countries;


    protected $categories;
    protected $products;
    protected $tags;
    protected $features;
    protected $feature_types;
    protected $collections;

    protected $url;

    public function __construct()
    {
        if (App::environment() === 'local') {
            $this->url = storage_path('app/public/xml/');
        } elseif(App::environment() === 'production') {
            $this->url = Storage::disk('public')->url('xml');
        } else {
            $this->url = asset('/storage/xml/');
        }

        $file_products_and_categories_xml = file_get_contents($this->url.'/upload_products.xml');
        $this->products_and_categories_xml = new \SimpleXMLElement($file_products_and_categories_xml);

        $file_features_xml = file_get_contents($this->url.'/upload_features.xml');
        $this->features_xml = new \SimpleXMLElement($file_features_xml);

        $file_brands_xml = file_get_contents($this->url.'/upload_brands.xml');
        $this->brands_xml = new \SimpleXMLElement($file_brands_xml);

        $file_tags_xml = file_get_contents($this->url.'/upload_tags.xml');
        $this->tags_xml = new \SimpleXMLElement($file_tags_xml);
    }

    public function parseBrands() : int
    {
        $this->brands = [];

        foreach ($this->brands_xml->brands->brand as $brand) {
            $this->brands[] = [
                'id' => (int)$brand->id,
                'name' => (string)htmlspecialchars_decode($brand->name),
                'slug' => Str::slug((string)htmlspecialchars_decode($brand->name)),
                'country_id' => (int)($brand->country),
                'image' => (string)htmlspecialchars_decode($brand->image),
                'category_id' => isset($brand->categories) && !empty($brand->categories) ? $this->getBrandCategory($brand->categories) : null,
                'description_ru' => (string)htmlspecialchars_decode($brand->description_ru),
                'description_ro' => (string)htmlspecialchars_decode($brand->description_ro),
            ];
        }

        return count($this->brands);
    }

    public function getBrandCategory($categories)
    {
        $c = null;

        foreach ($categories->category_id as $category) {
            $c = (int)str_replace('00-', '', $category);
            break;
        }

        return $c;
    }

    public function parseBrandCountries()
    {
        $this->countries = [];

        foreach ($this->brands_xml->countries->country as $country) {
            $this->countries[] = [
                'id' => (int)$country->id,
                'name_ru' => mb_ucfirst(mb_strtolower((string)htmlspecialchars_decode($country->name_ru))),
                'name_ro' => mb_ucfirst(mb_strtolower((string)htmlspecialchars_decode($country->name_ro))),
            ];
        }
    }

    public function insertBrandCountries()
    {
        Country::insertOnDuplicateKey($this->countries, ['id', 'name_ru', 'name_ro']);
    }

    public function insertBrands()
    {
        Brand::insertOnDuplicateKey($this->brands, ['id', 'name', 'slug', 'country_id', 'image', 'category_id', 'description_ru', 'description_ro']);
    }

    public function parseTags() : int
    {
        $this->tags = [];

        foreach ($this->tags_xml->tags->tag as $tag) {
            $this->tags[] = [
                'id' => (int)$tag->id,
                'name_ru' => (string)htmlspecialchars_decode($tag->name_ru),
                'name_ro' => (string)htmlspecialchars_decode($tag->name_ro),
                'slug' => Str::slug((string)htmlspecialchars_decode($tag->name_ru)),
                'description_ru' => (string)htmlspecialchars_decode($tag->description_ru),
                'description_ro' => (string)htmlspecialchars_decode($tag->description_ro),
                'discount' => (int)$tag->discount,
                'image' => (string)htmlspecialchars_decode($tag->image),
                'from_date' => Carbon::parse((string)htmlspecialchars_decode($tag->from_date))->format('Y-m-d'),
                'to_date' => Carbon::parse((string)htmlspecialchars_decode($tag->to_date))->format('Y-m-d')
            ];
        }

        return count($this->tags);
    }

    public function insertTags()
    {
        $output = Tag::insertOnDuplicateKey($this->tags, ['id', 'name_ru', 'name_ro', 'slug', 'description_ru', 'description_ro', 'discount', 'image']);
    }

    public function parseFeatureTypes()
    {
        $this->feature_types = [];

        foreach ($this->features_xml->feature_types->feature_type as $feature_type) {
            $this->feature_types[] = [
                'id' => (int)$feature_type->id,
                'name_ru' => (string)htmlspecialchars_decode($feature_type->name_ru),
                'name_ro' => (string)htmlspecialchars_decode($feature_type->name_ro),
                'add_to_filter' => (string)$feature_type->addtofilter,
                'filter_type' => (string)htmlspecialchars_decode($feature_type->filter_type),
                'categories' => isset($feature_type->categories) ? json_encode(['ids' => $this->getFeatureTypeCategories($feature_type->categories)]) : null
            ];
        }
    }

    public function getFeatureTypeCategories($categories)
    {
        $f = [];

        foreach ($categories->category as $category) {
            $f[] = (int)str_replace('00-', '', $category);
        }

        return $f;
    }

    public function insertFeatureTypes()
    {
        FeatureType::insertOnDuplicateKey($this->feature_types, ['id', 'name_ru', 'name_ro', 'add_to_filter', 'filter_type', 'categories']);
    }

    public function parseFeatures() : int
    {
        $this->features = [];

        foreach ($this->features_xml->features->feature as $feature) {
            $this->features[] = [
                'id' => (int)$feature->id,
                'feature_type_id' => (int)$feature->id_feature_type,
                'value_ru' => (string)htmlspecialchars_decode($feature->value_ru),
                'value_ro' => (string)htmlspecialchars_decode($feature->value_ro),
            ];
        }

        return count($this->features);
    }

    public function insertFeatures()
    {
        Feature::insertOnDuplicateKey($this->features, ['id', 'feature_type_id', 'value_ru', 'value_ro']);
    }

    public function parseCategories() : int
    {
        $this->categories = []; // Массив для загрузки в базу

        foreach ($this->products_and_categories_xml->categories->category as $category) {
            $this->categories[] = [
                'id' => (int)str_replace('00-', '', $category->id),
                'parent_id' => !empty($category->parent_id) ? (int)str_replace('00-', '', $category->parent_id) : 1,
                'name_ru' => (string)htmlspecialchars_decode($category->name_ru),
                'name_ro' => (string)htmlspecialchars_decode($category->name_ro),
                'is_active' => (int)$category->is_active,
                'slug' => Str::slug((string)htmlspecialchars_decode($category->name_ru)).'-'.(int)str_replace('00-', '', $category->id),
            ];
        }

        return count($this->categories);
    }

    public function updateOrInsertCategories()
    {
        Category::insertOnDuplicateKey($this->categories, ['id', 'parent_id', 'name_ru', 'name_ro', 'slug', 'is_active']);
    }

    public function parseProducts() : int
    {
        $this->products = [];

        foreach ($this->products_and_categories_xml->products->product as $product) {
            $this->products[] = [
                'articul' => (int)$product->id,
                'category_id' => (int)str_replace('00-', '', $product->category_id),
                'name_ru' => (string)htmlspecialchars_decode($product->name_ru),
                'name_ro' => (string)htmlspecialchars_decode($product->name_ro),
                'price' => (float)$product->price,
                'discount_price' => !empty($product->discount_price) ? (float)$product->discount_price : null,
                'stock' => (int)$product->stock,
                'is_visible' => (int)$product->is_visible,
                'warranty' => json_encode(['type' => (string)$product->warranty->attributes()['type'], 'value' => (int)$product->warranty]),
                'brand_id' => (int)$product->brand,
                'collection_id' => (int)$product->collection_id ? (int)$product->collection_id : null,
                'unit_ru' => (string)htmlspecialchars_decode($product->unit_ru),
                'unit_ro' => (string)htmlspecialchars_decode($product->unit_ro),
                'color' => (string)htmlspecialchars_decode($product->color),
                'color_array' => isset($product->color_array) && !empty($product->color_array) ? json_encode(explode(',', $product->color_array)) : null,
                'sizes' => isset($product->size) && !empty($product->size) ? $this->getProductSizes($product->size) : null,
                'size_array' => isset($product->size_array) && !empty($product->size_array) ? json_encode(explode(',', $product->size_array)) : null,
                'description_ru' => isset($product->description_ru) && !empty($product->description_ru) ? (string)htmlspecialchars_decode($product->description_ru) : null,
                'description_ro' => isset($product->description_ro) && !empty($product->description_ro) ? (string)htmlspecialchars_decode($product->description_ro) : null,
                'relaited_array' => isset($product->related_array) && !empty($product->related_array) ? json_encode(['ids' => $this->getProductRelatedProducts($product->related_array)]) : null,
                'similar_array' => isset($product->similar_array) && !empty($product->similar_array) ? json_encode(['ids' => $this->getProductSimilarProducts($product->similar_array)]) : null,
                'images' => $this->getProductImages($product->images),
                'tags' => $product->tags ? (string)$product->tags : null,
                'features' => isset($product->features) && !empty($product->features) ? json_encode(['ids' => $this->getProductFeatures($product->features)]) : null,
//                'recommended' => isset($product->recommended) ?: (int) $product->recommended,
                'recommended' => (int) $product->recommended,
                'complements' => isset($product->set) && !empty($product->set) ? json_encode(['singly' => $this->getProductComplementsSingly($product->set), 'kit' => $this->getProductComplementsKit($product->set)]) : null
            ];
        }

        return count($this->products);
    }

    protected function getProductRelatedProducts($related)
    {
        return explode(',', $related);
    }

    protected function getProductSimilarProducts($relaited)
    {
        return explode(',', $relaited);
    }

    protected function getProductSizes($size)
    {
        $s = [
            'unit' => (string)htmlspecialchars_decode($size->unit),
            'width' => (float)$size->width,
            'height' => (float)$size->height,
//            'depth' => (float)$size->depth,
        ];

        return json_encode($s);
    }

    protected function getProductImages($images)
    {
        $im = [];

        foreach ($images->image as $image) {
            $im[] = (string)$image;
        }

        return json_encode($im);
    }

    protected function getProductTags($tags)
    {
        if(empty($tags)) {
            return null;
        }

        $t = [];

        foreach ($tags as $tag) {
            $t[] = (int)$tag;
        }

        return implode(',', $t);
    }

    protected function getProductFeatures($features)
    {
        $f = [];
        foreach ($features->feature_id as $feature) {
            $f[] = (int)$feature;
        }

        return $f;
    }

    protected function getProductComplementsSingly($complements)
    {
        $c = [];

        foreach ($complements->id_product as $product) {
            if($product->attributes()['in_kit_only'] == 0) {
                $c[] = (int)$product;
            }
        }

        foreach ($complements->similar_products as $block) {
            $similar_block = [];

            foreach ($block->id_product as $product_articul) {
                if((int)$product_articul->attributes()['in_kit_only'] === 0) {
                    $similar_block[] = (int)$product_articul;
                }
            }

            if(!empty($similar_block)) {
                $c[] = $similar_block;
            }
        }

        return $c;
    }

    protected function getProductComplementsKit($complements)
    {
        $c = [];
        foreach ($complements->id_product as $product) {
            if($product->attributes()['in_kit_only'] == 1) {
                $c[] = (int)$product;
            }
        }

        foreach ($complements->similar_products as $block) {
            $similar_block = [];

            foreach ($block->id_product as $product_articul) {
                if((int)$product_articul->attributes()['in_kit_only'] === 1) {
                    $similar_block[] = (int)$product_articul;
                }
            }

            if(!empty($similar_block)) {
                $c[] = $similar_block;
            }
        }

        return $c;
    }

    /**
     * Создание временной таблицы продуктов, занесения туда данных, удаление текущей страницы продуктов и переименование верменной таблицы в таблицу продуктов
     * Такая реализация метода предназначена для того, чтобы при обновлении таблицы товаров полностью удалять индексные таблицы
     */
    public function insertOrUpdateProducts()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('products');

        Schema::create('tmp_products', function($table)
        {
            $table->increments('id');
            $table->string('articul', 100);
            $table->integer('category_id');
            $table->text('name_ru');
            $table->text('name_ro');
            $table->float('price');
            $table->float('discount_price')->nullable()->default(null);
            $table->integer('stock');
            $table->boolean('is_visible');
            $table->json('warranty');
            $table->text('unit_ru');
            $table->text('unit_ro');
            $table->string('color', 500);
            $table->json('color_array')->nullable()->default(null);
            $table->json('sizes')->nullable()->default(null);
            $table->json('size_array')->nullable()->default(null);
            $table->integer('brand_id')->nullable();
            $table->integer('collection_id')->nullable();
            $table->json('complements')->nullable()->default(null);
            $table->json('images');
            $table->string('tags', 255)->nullable();
            $table->json('features')->nullable()->default(null);
            $table->integer('recommended');
            $table->text('description_ru')->nullable()->default(null);
            $table->text('description_ro')->nullable()->default(null);
            $table->json('relaited_array')->nullable()->default(null);
            $table->json('similar_array')->nullable()->default(null);
            $table->timestamp('created_at')->default(Carbon::now()->format('Y-m-d'));
            $table->timestamp('updated_at')->nullable()->default(null);
            $table->unique('articul');
            $table->foreign('category_id')->references('id')->on('categories')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('brand_id')->references('id')->on('brands')->onUpdate('cascade')->onDelete('set null');
//            $table->foreign('collection_id')->references('id')->on('collections')->onUpdate('cascade')->onDelete('set null');
        });

        foreach (array_chunk($this->products,1000) as $chunk)
        {
            TmpProduct::insertOnDuplicateKey($chunk, [
                'articul',
                'category_id',
                'name_ru',
                'name_ro',
                'price',
                'discount_price',
                'stock',
                'is_visible',
                'warranty',
                'unit_ru',
                'unit_ro',
                'color',
                'color_array',
                'sizes',
                'size_array',
                'brand_id',
                'collection_id',
                'complements',
                'images',
                'tags',
                'features',
                'recommended',
                'description_ru',
                'description_ro',
                'relaited_array',
                'similar_array'
            ]);
        }

        Schema::rename('tmp_products', 'products');
        Schema::enableForeignKeyConstraints();
    }

    public function dropTmpProducts()
    {
        Schema::dropIfExists('tmp_products');
    }

    public function parseCollections() {
        $this->collections = []; // Массив для загрузки в базу

        foreach ($this->products_and_categories_xml->tiles_collections->tiles_collection as $collection) {

            $this->collections[] = [
                'id' => (int)str_replace('00-', '', $collection->id),
                'category_id' => !empty($collection->category_id) ? (int)str_replace('00-', '', $collection->category_id) : 1,
                'name_ru' => (string)htmlspecialchars_decode($collection->name_ru),
                'name_ro' => (string)htmlspecialchars_decode($collection->name_ro),
                'price' => (integer) $collection->price ?? null,
                'discount_price' => (integer) $collection->discount_price ?? null,
                'unit_ru' => (string)htmlspecialchars_decode($collection->unit_ru),
                'unit_ro' => (string)htmlspecialchars_decode($collection->unit_ro),
                'description_ru' => isset($collection->description_ru) && !empty($collection->description_ru) ? (string)htmlspecialchars_decode($collection->description_ru) : null,
                'description_ro' => isset($collection->description_ro) && !empty($collection->description_ro) ? (string)htmlspecialchars_decode($collection->description_ro) : null,
                'brand_id' => (int)$collection->brand,
                'is_visible' => (integer) $collection->is_visible ?? 0,
                'product_array' => isset($collection->set) ? json_encode(['ids' => $this->getCollectionProducts($collection->set)]) : null,
                'images' => $this->getProductImages($collection->images),
                'features' => isset($collection->features) && !empty($collection->features) ? json_encode(['ids' => $this->getCollectionFeatures($collection->features)]) : null,
            ];
        }

        return count($this->collections);
    }

    protected function getCollectionFeatures($features)
    {
        $f = [];
        foreach ($features->feature_id as $feature) {
            $f[] = (int)$feature;
        }

        return $f;
    }

    protected function getCollectionProducts($products) {
        $p = [];

        foreach ($products as $product) {
            foreach ($product->id_product as $id) {
                $p[] = (int)$id;
            }
        }

        return json_encode($p);
    }

    public function insertOrUpdateCollections()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('collections');

        Schema::create('tmp_collections', function($table)
        {
            $table->increments('id');
            $table->integer('category_id');
            $table->text('name_ru');
            $table->text('name_ro');
            $table->float('price');
            $table->float('discount_price')->nullable()->default(null);
            $table->string('unit_ru', 255)->nullable();
            $table->string('unit_ro', 255)->nullable();
            $table->text('description_ru')->nullable()->default(null);
            $table->text('description_ro')->nullable()->default(null);
            $table->integer('brand_id')->nullable();
            $table->boolean('is_visible');
            $table->json('product_array')->nullable()->default(null);
            $table->json('images');
            $table->json('features')->nullable()->default(null);
            $table->timestamp('created_at')->default(Carbon::now()->format('Y-m-d'));
            $table->timestamp('updated_at')->nullable()->default(null);
            $table->foreign('category_id')->references('id')->on('categories')->onUpdate('cascade')->onDelete('restrict');
        });

        TmpCollection::insertOnDuplicateKey($this->collections, [
            'id',
            'category_id',
            'name_ru',
            'name_ro',
            'price',
            'discount_price',
            'unit_ru',
            'unit_ro',
            'description_ru',
            'description_ro',
            'brand_id',
            'is_visible',
            'product_array',
            'images',
            'features'
        ]);

        Schema::rename('tmp_collections', 'collections');
        Schema::enableForeignKeyConstraints();
    }

    public function dropTmpCollections()
    {
        Schema::dropIfExists('tmp_collections');
    }

//    public function updatePrice()
//    {
//        $file_prices_xml = file_get_contents($this->url.'/upload_price.xml');
//        $this->prices_xml = new \SimpleXMLElement($file_prices_xml);
//
//        $productPrices = $this->parseProductsPricesToArray();
//
//        $totalProducts = $limit = count($productPrices);
//        $notfound = [];
//        $updated = [];
//
//        for($i = 0; $i < $limit; $i++) {
//            $p = Product::where('articul', $productPrices[$i]['articul'])->first();
//
//            if($p) {
//                $p->price = $productPrices[$i]['price'];
//                $p->stock = $productPrices[$i]['stock'];
//                if(isset($productPrices[$i]['discount_price'])) {
//                    $p->discount_price = $productPrices[$i]['discount_price'];
//                }
//
//                $p->save();
//
//                $updated[] = $productPrices[$i]['articul'];
//            } else {
//                $notfound[] = $productPrices[$i]['articul'];
//            }
//        }
//
//        return response()->json(['updated' => $updated, 'not_found' => $notfound, 'total' => $totalProducts])->setStatusCode(200);
//    }

    public function getTotalProductsForUpdatePrices()
    {
        $xmlLoaded = $this->loadPricesXml();

        $productPrices = $this->parseProductsPricesToArray();

        $totalProducts = count($productPrices);

        return response()->json(['totalCount' => $totalProducts, 'xmlLoaded' => $xmlLoaded]);
    }

    public function updatePrices(Request $request)
    {
        $xmlLoaded = $this->loadPricesXml();

        if($xmlLoaded) {
            $step = $request->productsPerStep;

            $total = $request->total;
            $current = $request->current;
            $productPrices = count((array)$request->products) > 0
                ? $request->products
                : $this->parseProductsPricesToArray();
            $notfound = count($request->notFound) === 0 ? [] : $request->notFound;
            $updated = count($request->updated) === 0 ? [] : $request->updated;

            $limit = ($current + $step) > $total ? $total : ($current + $step);

            for($i = $current; $i < $limit; $i++) {
                $p = Product::where('articul', $productPrices[$i]['articul'])->first();

                if($p) {
                    $p->price = $productPrices[$i]['price'];
                    $p->stock = $productPrices[$i]['stock'];
                    if(isset($productPrices[$i]['discount_price'])) {
                        $p->discount_price = $productPrices[$i]['discount_price'];
                    }

                    $p->save();

                    $updated[] = $productPrices[$i]['articul'];
                } else {
                    $notfound[] = $productPrices[$i]['articul'];
                }
            }

            $current = $limit;

            return response()->json([
                'step' => $request->step,
                'steps' => $request->steps,
                'productsPerStep' => $request->productsPerStep,
                'total' => $total,
                'current' => $current,
                'updated' => $updated,
                'notFound' => $notfound,
                'products' => $productPrices,
            ]);
        } else {
            return response()->json([
                'total' => $request->total,
                'current' => 0,
                'updated' => 0,
                'notFound' => 0,
                'products' => [],
                'step' => 1,
                'steps' => $request->steps,
                'productsPerStep' => 1000,
            ]);
        }
    }

    public function loadPricesXml()
    {
        try {
            $file_prices_xml = file_get_contents($this->url.'/upload_price.xml');
            $this->prices_xml = new \SimpleXMLElement($file_prices_xml);

            return true;
        } catch (ErrorException $exception) {
            return false;
        }
    }

    public function parseProductsPricesToArray() :  array
    {
        $productPrices = [];

        $i = 0;

        foreach ($this->prices_xml->products->product as $product) {
            $productPrices[$i] = [
                'articul' => (int)$product->product_id,
                'price' => (float)$product->price,
                'stock' => (int)$product->stock
            ];

            if(isset($product->discount_price)) {
                $productPrices[$i]['discount_price'] = (float)$product->discount_price;
            }

            $i++;
        }

        return $productPrices;
    }

}
