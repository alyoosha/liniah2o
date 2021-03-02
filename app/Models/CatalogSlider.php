<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatalogSlider extends Model
{
    protected $table = 'catalog_slider';

    protected $guarded = [];

    public $timestamps = false;

    public function scopeIsPublished($query)
    {
        return $query->where('is_published', 1);
    }
}
