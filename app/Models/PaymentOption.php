<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentOption extends Model
{
    protected $table = "payment_options";

    protected $fillable = [
        'name_ru',
        'name_ro',
        'description_ru',
        'description_ro',
        'hash_svg'
    ];

    public $timestamps = false;
}
