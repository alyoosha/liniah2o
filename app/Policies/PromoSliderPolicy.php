<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PromoSliderPolicy
{
    use HandlesAuthorization;

    public function create()
    {

    }

    public function view()
    {
        return true;
    }

    public function update()
    {
        return false;
    }

    public function delete()
    {
        return false;
    }
}
