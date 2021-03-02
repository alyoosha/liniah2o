<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Yadakhov\InsertOnDuplicateKey;

class TmpProduct extends Model
{
    use InsertOnDuplicateKey;

    protected $table = 'tmp_products';
    protected $guarded = [];

    public $timestamps = true;
}
