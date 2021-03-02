<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Orders;
use App\Models\Page;
use App\Models\Product;
use App\Observers\CategoryObserver;
use App\Observers\ProductObserver;
use App\Observers\SendOrderStatusLinkObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Http\Middleware\Locale;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Category::observe(new CategoryObserver());
        Product::observe(ProductObserver::class);
        Orders::observe(SendOrderStatusLinkObserver::class);

        View::share('lang', Locale::getLocale()); // Подключаем переменную языка ко всем шаблонам

        View::composer('*', function($view) {
           $pages = Page::all();

            $view->with([
                'addItemList' => $pages
            ]);
        });
    }
}
