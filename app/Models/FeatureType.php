<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Yadakhov\InsertOnDuplicateKey;

class FeatureType extends Model
{
    use InsertOnDuplicateKey;

    protected $table = 'feature_types';
    protected $guarded = [];

    public $timestamps = false;

    public function features()
    {
        return $this->hasMany(Feature::class, 'feature_type_id', 'id');
    }

    public function scopeIsShouldBeAddedToFilter($query)
    {
        return $query->where('add_to_filter', 1);
    }
}
