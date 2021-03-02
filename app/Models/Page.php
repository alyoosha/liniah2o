<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'pages';

    protected $fillable = [
        'name',
        'title_ru',
        'title_ro',
        'body_ru',
        'body_ro',
        'slug',
        'has_menu',
        'link_location',
        'seo_title_ru',
        'seo_title_ro',
        'seo_description',
        'seo_keywords',
    ];

    public $timestamps = true;
}
