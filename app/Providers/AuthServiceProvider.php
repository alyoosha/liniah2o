<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\CatalogSlider;
use App\Models\Orders;
use App\Models\Product;
use App\Policies\BrandPolicy;
use App\Policies\CatalogSliderPolicy;
use App\Policies\OrdersPolicy;
use App\Policies\ProductPolicy;
use App\Policies\UserPolicy;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\About' => 'App\Policies\PagePolicy',
        'Infinety\MenuBuilder\Http\Models\Menu' => 'App\Policies\MenuPolicy',
        User::class => UserPolicy::class,
        CatalogSlider::class => CatalogSliderPolicy::class,
        Product::class => ProductPolicy::class,
        Orders::class => OrdersPolicy::class,
        Brand::class => BrandPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
