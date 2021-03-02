<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Yadakhov\InsertOnDuplicateKey;

class Images extends Model
{
    use InsertOnDuplicateKey;
    public $timestamps = false;

    public function getImageResizedSmall() {
        if(!is_null($this->paths_resized)) {
            return explode(',', $this->paths_resized)[0];
        }
        else {
            return $this->path;
        }
    }

    public function getImageResizedMiddle() {
        if(!is_null($this->paths_resized)) {
            return explode(',', $this->paths_resized)[1];
        }
        else {
            return $this->path;
        }
    }

    public function getImagePreview() {
        return $this->path;
    }
}
