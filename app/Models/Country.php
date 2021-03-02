<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Yadakhov\InsertOnDuplicateKey;

class Country extends Model
{
    use InsertOnDuplicateKey;

    protected $table = 'countries';
    protected $guarded = [];

    public function brands()
    {
        return $this->hasMany(Brand::class, 'country_id', 'id');
    }
}
