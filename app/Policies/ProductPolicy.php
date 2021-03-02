<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    public function create()
    {
        return false;
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
