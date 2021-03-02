<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Regulation extends Model
{
    protected $table = 'regulations';

    public $fillable = [
        'title_ru',
        'title_ro',
        'body_ru',
        'body_ro',
        'guarantee_id',
        'category_id',
        'exploitation_rule_id',
        'seo_title_ru',
        'seo_title_ro',
        'seo_description',
        'seo_keywords',
    ];

    public $timestamps = false;

    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public static function uniqueIdCategories() {
        return DB::table('regulations')->select('category_id')->distinct()->get();
    }

    public function guarantee() {
        return $this->belongsTo(Guarantee::class, 'guarantee_id');
    }
}
