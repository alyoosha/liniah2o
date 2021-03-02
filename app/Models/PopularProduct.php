<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PopularProduct extends Model
{
    protected $table = 'popular_products';
    protected $guarded = [];
    public $timestamps = false;
    protected $primaryKey = 'articul';
}
