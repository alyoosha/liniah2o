<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Yadakhov\InsertOnDuplicateKey;

class Feature extends Model
{
    use InsertOnDuplicateKey;

    protected $table = 'features';
    protected $guarded = [];

    public $timestamps = false;

    public function feature_type()
    {
        return $this->belongsTo(FeatureType::class, 'feature_type_id', 'id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'feature_product', 'feature_id', 'tag_id');
    }
}
