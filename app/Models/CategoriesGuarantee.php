<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriesGuarantee extends Model
{
    public $table = 'categories_guarantees';

    protected $fillable = [
        'name_ru',
        'name_ro',
    ];

    public function guarantees() {
        return $this->hasMany(Guarantee::class, 'categories_guarantee_id')->get();
    }

    public $timestamps = false;
}
