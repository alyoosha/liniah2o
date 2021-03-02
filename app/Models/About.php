<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $table = 'about';

    protected $fillable = [
        'seo_title',
        'seo_description',
        'seo_keywords',
        'best_practices_content_title_ru',
        'best_practices_content_title_ro',
        'best_practices_content_ru',
        'best_practices_content_ro',
        'quality_and_perfection_title_ru',
        'quality_and_perfection_title_ro',
        'quality_and_perfection_content_ru',
        'quality_and_perfection_content_ro',
        'our_mission_content_title_ru',
        'our_mission_content_ru',
        'our_mission_content_title_ro',
        'our_mission_content_ro',
    ];

    public $timestamps = true;
}
