<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class CategoriesFirstLevelPromoProducts extends Model
{
    protected $table = 'categories_first_level_new_and_promotion_products';
    protected $guarded = [];

    public $timestamps = false;

    public function newProduct()
    {
        return $this->belongsTo(Product::class, 'new_product_id', 'articul')->with('images_table');
    }

    public function promotionProduct()
    {
        return $this->belongsTo(Product::class, 'promotion_product_id', 'articul')->with('images_table');
    }

    public function firstLevelCategory()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
