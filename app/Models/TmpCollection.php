<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Yadakhov\InsertOnDuplicateKey;

class TmpCollection extends Model
{
    use InsertOnDuplicateKey;

    protected $table = 'tmp_collections';
    protected $guarded = [];

    public $timestamps = true;
}
