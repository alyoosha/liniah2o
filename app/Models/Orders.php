<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'orders';

    protected $guarded = [];

    /**
     * Кастомизация типа полей с указанием формата
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'date:j F',
        'updated_at' => 'date:j F',
        'delivery_info' => 'array',
        'products' => 'array'
    ];

    /**
     * Форматируем вывод поля created_at в зависимости от того, находимся ли мы в админ панели или на сайте
     * Если мы находимся на сайте, то форматируем вывод в формат ";день месяца; ;название месяца;"
     *
     * @param $from
     * @return Carbon|mixed
     */
    public function getCreatedAtAttribute($from)
    {
        if(!preg_match('#'. url('/').'\/nova-api\/.*$#', url()->current())) {
            return str_replace(' '.Carbon::parse()->format('Y').' г.', '', Carbon::parse($from)->isoFormat('LLL'));
        } else {
            return Carbon::parse($from);
        }
    }

    /**
     * @param $to
     * @return Carbon|mixed
     */
    public function getUpdatedAtAttribute($to)
    {
        if(!preg_match('#'. url('/').'\/nova-api\/.*$#', url()->current())) {
            return str_replace(' '.Carbon::parse()->format('Y').' г.', '', Carbon::parse($to)->isoFormat('LLL'));
        } else {
            return Carbon::parse($to);
        }
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = $value;
        $this->attributes['status_display_value'] = __($value.'_order');
    }

    public function getDeliveryInfoAttribute($value)
    {
        return json_decode($value, JSON_UNESCAPED_UNICODE);
    }
}
