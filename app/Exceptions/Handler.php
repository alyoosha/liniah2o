<?php

namespace App\Exceptions;

use App\Http\Middleware\Locale;
use App\Models\Category;
use App\Models\Product;
use App\Traits\RecommendedProductsTrait;
use Exception;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    use RecommendedProductsTrait;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param Throwable $exception
     * @return void
     *
     * @throws Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  Request  $request
     * @param Throwable $exception
     * @return Response
     *
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($this->isHttpException($exception)) {
            if ($exception->getStatusCode() == 404) {
                $lang = Locale::getLocale(); // Подключаем переменную языка 404

                App::setLocale($lang);

                $menu = collect(@getMenuBySlug('menu-' . Locale::getLocale())->parentItems); // Получаем меню
                $menu = $menu->where('enabled', 1)->sortBy('order'); // Подключаем к 404

                $non_tile_recommended_products = $this->getNonTileRecommendedProducts();
                $tile_recommended_products = $this->getTileRecommendedProducts();
                $json_encoded_recommended_products = $this->getJsonEncodedRecommendedProducts($non_tile_recommended_products, $tile_recommended_products);

                return response()->view('errors.404', ['lang' => $lang, 'menu' => $menu, 'json_encoded_recommended_products' => $json_encoded_recommended_products], 404);
            }

            if ($exception->getStatusCode() == 500) {
                $lang = Locale::getLocale(); // Подключаем переменную языка 500

                App::setLocale($lang);

                $menu = collect(@getMenuBySlug('menu-' . Locale::getLocale())->parentItems); // Получаем меню
                $menu = $menu->where('enabled', 1)->sortBy('order'); // Подключаем к 500

                return response()->view('errors.500', ['lang' => $lang, 'menu' => $menu], 500);
            }
        }

        return parent::render($request, $exception);
    }
}
