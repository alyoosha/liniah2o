<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BrandPolicy
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
        return true;
    }

    public function delete()
    {
        return true;
    }
}
