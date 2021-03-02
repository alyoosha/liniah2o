<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Yadakhov\InsertOnDuplicateKey;

class Tag extends Model
{
    use InsertOnDuplicateKey;

    protected $table = 'tags';

    protected $fillable = [
        'name_ru',
        'name_ro',
        'description_ru',
        'description_ro',
        'discount',
        'from_date',
        'to_date',
    ];

    protected $guarded = [];

    /**
     * Кастомизация типа полей с указанием формата
     *
     * @var array
     */
    protected $casts = [
        'from_date' => 'date:j F',
        'to_date' => 'date:j F'
    ];

    public $timestamps = true;

    public function setNameRuAttribute($name_ru)
    {
        $this->attributes['name_ru'] = $name_ru;
        $this->attributes['slug'] = Str::slug($name_ru);
    }

    /**
     * Форматируем вывод поля from_date в зависимости от того, находимся ли мы в админ панели или на сайте
     * Если мы находимся на сайте, то форматируем вывод в формат ";день месяца; ;название месяца;"
     *
     * @param $from
     * @return Carbon|mixed
     */
    public function getFromDateAttribute($from)
    {
        if(!preg_match('#'. url('/').'\/nova-api\/.*$#', url()->current())) {
            return str_replace([' '.Carbon::parse($from)->format('Y').' г.', ' '.Carbon::parse($from)->format('Y')], ['', ''], Carbon::parse($from)->isoFormat('LL'));
        } else {
            return Carbon::parse($from);
        }
    }

    /**
     * @param $to
     * @return Carbon|mixed
     */
    public function getToDateAttribute($to)
    {
        if(!preg_match('#'. url('/').'\/nova-api\/.*$#', url()->current())) {
            return str_replace([' '.Carbon::parse($to)->format('Y').' г.', ' '.Carbon::parse($to)->format('Y')], ['', ''], Carbon::parse($to)->isoFormat('LL'));
        } else {
            return Carbon::parse($to);
        }
    }

    public function setColorAttribute($hex) {
        $this->attributes['color'] = $hex;
        $this->attributes['class'] = $hex ? get_tag_css_class_by_color($hex) : null;
    }

    public function getDurationTimeInMilliseconds()
    {
        return (int)round(strtotime($this->attributes['to_date'])*1000);
    }

    public function getYearOfEndingPromotion()
    {
        return Carbon::parse($this->attributes['to_date'])->format('Y');
    }

    /**
     * Используем этот метод чтобы сделать ЧПУ
     * и переходить на страницу отдельной акции по slug, а не по id
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'tags', 'id');
    }

    public function scopeIsPromotion($query)
    {
        return $query->where('slug', 'skidka')->orWhere('discount', '<>', '0');
    }

    public function scopeIsNew($query)
    {
        return $query->where('slug', 'novinka');
    }

    public function scopeIsPreorder($query)
    {
        return $query->where('slug', 'predzakaz');
    }

    public function scopeIsSale($query)
    {
        return $query->where('slug', 'rasprodaza');
    }
}
