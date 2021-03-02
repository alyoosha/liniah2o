<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = 'regions';
    protected $guarded = [];
    public $timestamps = false;

    public function cities()
    {
        return $this->hasMany(City::class, 'region_id', 'id');
    }
}
