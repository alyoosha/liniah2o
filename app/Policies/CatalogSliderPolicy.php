<?php

namespace App\Policies;

use App\Models\About;
use App\Models\CatalogSlider;
use Illuminate\Auth\Access\HandlesAuthorization;

class CatalogSliderPolicy
{
    use HandlesAuthorization;

    public function create()
    {
        $totalCatalogSlidersCount = CatalogSlider::all()->count();

        return $totalCatalogSlidersCount < 4
            ? true
            : false;
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
