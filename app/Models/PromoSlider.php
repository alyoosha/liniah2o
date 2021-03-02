<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use ShortPixel\ShortPixel;
use ShortPixel\Source;

class PromoSlider extends Model
{
    protected $table = 'promo_slider';

    protected $casts = [
        'tags' => 'array'
    ];

    public $timestamps = true;

    public function scopePublished($query)
    {
        return $query->where('published', '=', 1);
    }

    public function setImageRuAttribute($image) {
        try {
            ShortPixel::setKey("i2sbE2U5TbMemQoNX9Yb");
            ShortPixel::setOptions(['base_path' => Storage::path('public')]);
            $shortPixel = new Source();
            $shortPixel
                ->fromFiles(Storage::disk('public')->path($image))
                ->optimize(1)
                ->generateWebP()
                ->toFiles('/promo-slider/');

            $this->attributes['image_ru'] = $image;
        } catch (\Exception $e) {
            //
        }
    }

    public function setImageRoAttribute($image) {
        try {
            ShortPixel::setKey("i2sbE2U5TbMemQoNX9Yb");
            ShortPixel::setOptions(['base_path' => Storage::path('public')]);
            $shortPixel = new Source();
            $shortPixel
                ->fromFiles(Storage::disk('public')->path($image))
                ->optimize(1)
                ->generateWebP()
                ->toFiles('/promo-slider/');

            $this->attributes['image_ro'] = $image;
        } catch (\Exception $e) {
            //
        }
    }

    public function setImageMobileRuAttribute($image) {
        try {
            ShortPixel::setKey("i2sbE2U5TbMemQoNX9Yb");
            ShortPixel::setOptions(['base_path' => Storage::path('public')]);
            $shortPixel = new Source();
            $shortPixel
                ->fromFiles(Storage::disk('public')->path($image))
                ->optimize(1)
                ->generateWebP()
                ->toFiles('/promo-slider/mobile/');

            $this->attributes['image_mobile_ru'] = $image;
        } catch (\Exception $e) {
            //
        }
    }

    public function setImageMobileRoAttribute($image) {
        try {
            ShortPixel::setKey("i2sbE2U5TbMemQoNX9Yb");
            ShortPixel::setOptions(['base_path' => Storage::path('public')]);
            $shortPixel = new Source();
            $shortPixel
                ->fromFiles(Storage::disk('public')->path($image))
                ->optimize(1)
                ->generateWebP()
                ->toFiles('/promo-slider/mobile/');

            $this->attributes['image_mobile_ro'] = $image;
        } catch (\Exception $e) {
            //
        }
    }

    public function product() {
        return $this->belongsTo(Product::class, 'product_id', "articul");
    }
}
