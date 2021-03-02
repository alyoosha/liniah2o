<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarrantyPeriods extends Model
{
    protected $table = 'warranty_periods';

    protected $fillable = [
        'brand_id',
        'categories_guarantee_id',
        'validity',
        'instruction',
        'ticket',
    ];

    public $timestamps = true;

    public function guarantees() {
        return $this->hasMany(Guarantee::class, 'warranty_period_id');
    }

    public function brand() {
        return $this->belongsTo(Brand::class);
    }

    public function categoriesGuarantee() {
        return $this->belongsTo(CategoriesGuarantee::class);
    }
}
