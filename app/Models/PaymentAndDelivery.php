<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentAndDelivery extends Model
{
    protected $table = 'payment_and_delivery';

    protected $fillable = [
        'payment_title_ru',
        'payment_title_ro',
        'delivery_title_ru',
        'delivery_title_ro',
        'delivery_description_ru',
        'delivery_description_ro',
        'link_location',
        'seo_title',
        'seo_description',
        'seo_keywords'
    ];

    public function paymentOptions() {
        return $this->hasMany(PaymentOption::class,'payment_and_delivery_id');
    }

    public $timestamps = true;
}
