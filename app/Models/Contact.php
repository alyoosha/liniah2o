<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contact';

    protected $fillable = [
        'map_pin_lat',
        'map_pin_lng',
        'working_hours_first_ru',
        'working_hours_first_ro',
        'working_hours_second_ru',
        'working_hours_second_ro',
        'map_phone',
        'address_coords_ru',
        'address_coords_ro',
        'address_coords_second_ru',
        'address_coords_second_ro',
        'address_coords_third_ru',
        'address_coords_third_ro',
        'address_coords_forth_ru',
        'address_coords_forth_ro',

        'address_coords_first_map_pin_lat',
        'address_coords_first_map_pin_lng',
        'address_coords_second_map_pin_lat',
        'address_coords_second_map_pin_lng',
        'address_coords_third_map_pin_lat',
        'address_coords_third_map_pin_lng',
        'address_coords_forth_map_pin_lat',
        'address_coords_forth_map_pin_lng',

        'online_shop_address_ru',
        'online_shop_address_ro',
        'online_shop_phone',
        'online_shop_address_coords_map_pin_lat',
        'online_shop_address_coords_map_pin_lng',

        'service_coords_ru',
        'service_coords_ro',
        'service_phone',
        'service_address_coords_map_pin_lat',
        'service_address_coords_map_pin_lng',

        'requisites_coords_ru',
        'requisites_coords_ro',
        'requisites_number',
        'delivery_phone',
        'seo_title',
        'seo_description',
        'seo_keywords'
    ];

    public $timestamps = true;
}
