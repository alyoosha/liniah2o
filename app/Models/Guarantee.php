<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guarantee extends Model
{
    public $table = 'guarantees';

    protected $fillable = [
        'brand_id',
        'categories_guarantee_id',
        'validity',
        'instruction',
        'ticket',
    ];

    public function warrantyPeriod() {
        return $this->belongsTo(WarrantyPeriods::class);
    }

    public function brand() {
        return $this->belongsTo(Brand::class);
    }

    public function categoriesGuarantee() {
        return $this->belongsTo(CategoriesGuarantee::class,'categories_guarantee_id');
    }

    public $timestamps = false;
}
