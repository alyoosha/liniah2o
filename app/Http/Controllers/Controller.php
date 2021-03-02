<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Locale;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected static $lang;

    public function __construct()
    {
        self::$lang =  Locale::getLocale();

        $menu = collect(@getMenuBySlug('menu-' . Locale::getLocale())->parentItems); // Получаем меню
        View::share('menu', $menu->where('enabled', 1)->sortBy('order')); // Подключаем ко всем шаблонам
    }
}
