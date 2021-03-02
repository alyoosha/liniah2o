<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yadakhov\InsertOnDuplicateKey;

class Brand extends Model
{
    use InsertOnDuplicateKey;

    protected $table = 'brands';
    protected $guarded = [];

    public $timestamps = true;


    /**
     * При парсинге категорий формируем slug из названия брэнда
     *
     * @param $name_ru
     */
    public function setNameRuAttribute($name_ru)
    {
        $this->attributes['name_ru'] = $name_ru;
        $this->attributes['slug'] = Str::slug($name_ru);
    }

    public function getImageAttribute()
    {
        if(Storage::disk('public')->exists('brands/'.$this->attributes['image'])) {
            return $this->attributes['image'];
        } else {
            return 'default-brand-placeholder.png';
        }
    }

    /**
     * Используем этот метод чтобы сделать ЧПУ
     * и переходить на страницу отдельной категории по slug, а не по id
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id', 'id');
    }

    public function scopeOfSlug($query, $slug) {
        return $query->where('slug', $slug);
    }

    public function scopeOfCountry($query, $country_id)
    {
        return $query->where('country_id', $country_id);
    }

    public function collections()
    {
        return $this->hasMany(Collection::class, 'brand_id', 'id');
    }
}
