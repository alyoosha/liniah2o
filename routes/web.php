<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/' . \Illuminate\Support\Facades\App::getLocale());
})->name('homepage')->middleware('user');

Route::get('/test-constructor', function () {
    return view('test_color', ['menu' => [], 'lang' => 'ru']);
});

Route::get('/test-kitchen-ar', function () {
    return view('kitchen-ar', ['menu' => [], 'lang' => 'ru']);
});

Route::get('setlocale/{locale}', 'LanguageController@index')->name('locale');
Route::get('/lang-{lang}.js', 'LanguageController@show');

Route::group(['namespace' => 'Pages', 'prefix' => App\Http\Middleware\Locale::getLocale(), 'middleware' => ['user']], function () {
    Route::get('/', 'MainController@index')->name("pages.main.index");
    Route::get('/contacts', 'ContactsController')->name("pages.contacts.index");
    Route::get('/about-us', 'AboutController')->name("pages.about.index");

    Route::group(['prefix' => 'brands'], function () {
        Route::get('', 'BrandsController@index')->name('pages.brands.index');
        Route::get('/{brand}', 'BrandsController@show')->name('pages.brands.show');
    });

    Route::group(['prefix' => 'promotions'], function () {
        Route::get('', 'PromotionController@index')->name('pages.promotions.index');
        Route::get('/{promotion}', 'PromotionController@show')->name('pages.promotions.show');
    });

    Route::group(['prefix' => 'catalog'], function () {
        // Link to first level catalog page
        Route::get('', 'CatalogController@index')->name('pages.catalog.index');
        // Link to second level catalog page
        Route::get('{secondary}', 'CatalogController@secondary_index')->name('pages.catalog.secondary_index');
        // Link to collections catalog page
        Route::get('{first_level_category}/collections/{second_level_category}', 'CollectionsController@catalog_index')->name('pages.collections.catalog_index');
        // Link to third level catalog page
        Route::get('{secondary}/{ternary}/{third_level_category?}', 'CatalogController@ternary_index')->name('pages.catalog.ternary_index');
        // Link to single collection page
        Route::get('{first_level_category}/{second_level_category}/collections/{collection_slug}', 'CollectionsController@index')->name('pages.collections.index');
    });

    Route::get('/search-results', 'SearchResultsController')->name("pages.search_results.index");

    Route::group(['prefix' => 'cart'], function () {
        Route::get('', 'CartController@index')->name('pages.cart.index');
        Route::get('/order', 'CartController@order')->name('pages.cart.order');
        Route::get('/order/{identification}', 'CartController@status')->name('pages.cart.status');
        Route::post('/checkout', 'CartController@checkout');
    });

    Route::group(['prefix' => 'products'], function () {
        // Link to single product
        Route::get('{product_slug}', 'ProductController@index')->name('pages.product.index');
    });
});

Route::group(['name' => 'secondary.', 'namespace' => 'Pages\Secondary' ,'prefix' => App\Http\Middleware\Locale::getLocale(), 'middleware' => ['user']], function () {
    Route::get('/payment-and-delivery', 'SecondaryPageController@showPaymentAndDelivery')->name('show-payment-and-delivery.get');
    Route::get('/warranty-periods', 'SecondaryPageController@showWarrantyPeriods')->name('show-warranty-periods.get');
    Route::group(['prefix' => 'exploitation-rules'], function () {
        Route::get('', 'SecondaryPageController@showExploitationRules')->name('show-exploitation-rules.get');
        Route::get('/{id}', 'SecondaryPageController@showExploitationRule')->name('show-exploitation-rule.get')->where('id', '[0-9]+');
    });
    Route::get('/{slug}', 'SecondaryPageController@show')->name('show-secondary-page.get')->where('slug', '[a-z-]{3,255}');
});

Route::group(['prefix' => 'sitemap.xml'], function () {
    Route::get('', 'SitemapController@index')->name('sitemap.xml');
    Route::get('main', 'SitemapController@main')->name('sitemap.xml.main');
    Route::get('secondary-pages', 'SitemapController@secondaryPages')->name('sitemap.xml.secondary-pages');
    Route::get('cart', 'SitemapController@cart')->name('sitemap.xml.cart');
    Route::get('catalog', 'SitemapController@catalog')->name('sitemap.xml.catalog');
});
