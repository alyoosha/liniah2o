<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class OrdersPolicy
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
