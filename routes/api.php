<?php

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Locale;

Route::get('getSessionUser', function () {
    $user = Cookie::get('user');

    if($user) {
        return response()->json($user, 200);
    } else {
        return response()->json('', 200);
    }
});

Route::get('getStoragePath', function () {
    return asset('storage/');
});
Route::get('getCatalogPath', function () {
    return route('pages.catalog.index');
});

Route::group(['namespace'=>'Api',], function () {
    Route::group(['prefix' => 'parser'], function ($route) {
        $route->post('parseCatalog', 'Parser@parseCatalog');
        $route->get('updateCatalogImportTimestamps', 'Parser@updateCatalogImportTimestamps');
        $route->get('getCatalogLastUpdatedAtTimestamps', 'Parser@getCatalogLastUpdatedAtTimestamps');
        $route->get('compareValidationAndUpdatingCatalogDates', 'Parser@compareValidationAndUpdatingCatalogDates');

        $route->get('getPriceLastUpdatedAtTimestamps', 'Parser@getPriceLastUpdatedAtTimestamps');
        $route->get('updatePriceTimestamps', 'Parser@updatePriceTimestamps');
        $route->get('compareValidationAndUpdatingPricesDates', 'Parser@compareValidationAndUpdatingPricesDates');
        $route->get('getTotalNumberOfProducts', 'Parser@getTotalProductsForUpdatePrices');
        $route->post('updatePrices/{step}', 'Parser@updatePrices');
        $route->get('set', 'ImagesParser@setInvisibleImages');
    });

    Route::group(['prefix' => 'validate'], function ($route) {
        $route->get('getXMLLastValidatedAtTimestamps', 'XMLValidator@getXMLLastValidatedAtTimestamps');
        $route->get('updateXMLValidationTimestamps', 'XMLValidator@updateXMLValidationTimestamps');
        $route->post('validateXML', 'XMLValidator@validateXML');
    });

    Route::group(['prefix' => 'brands'], function ($route) {
        $route->get('getBrandsByCategory', 'BrandsController@getBrandsByCategoryName');
    });

    Route::group(['prefix' => 'cart'], function ($route) {
        $route->get('getCartLink', 'CartController@getCartLink');
        $route->get('getAvailableDeliveryCitiesByRegion', 'CartController@getAvailableDeliveryCitiesByRegion');
        $route->get('getLastAddedProduct', 'CartController@getLastAddedProduct');
        $route->get('getProductsByArticles', 'CartController@getProductsByArticles');
        $route->get('getProductsByArticlesWithComplement', 'CartController@getProductsByArticlesWithComplement');
        $route->get('getCategoriesWithRecommendedProducts', 'CartController@getCategoriesWithRecommendedProducts');
    });

    Route::group(['prefix' => 'promotions'], function ($route) {
        $route->post('getSecondLevelCategories', 'PromotionController@getSecondLevelCategories');
        $route->post('getThirdLevelCategories', 'PromotionController@getThirdLevelCategories');
        $route->post('getFilteredProducts', 'PromotionController@getFilteredProducts');
    });

    Route::group(['prefix' => 'header'], function ($route) {
        $route->get('getFirstLevelCategories', 'HeaderController@getFirstLevelCategories');
        $route->post('getSecondLevelCategories', 'HeaderController@getSecondLevelCategories');
        $route->post('getThirdLevelCategories', 'HeaderController@getThirdLevelCategories');
    });

    Route::group(['prefix' => 'homepage'], function ($route) {
        $route->get('getOdds', 'MainController@getOdds');
        $route->post('uploadImage', 'MainController@uploadImage');
    });

    Route::group(['prefix' => 'catalog'], function ($route) {
        $route->get('getLinkToTernaryCatalogPage', 'CatalogController@getLinkToTernaryCatalogPage');
        $route->post('sortProductsByFilter', 'CatalogController@sortProductsByFilter');
        $route->post('sortProductsByCategory', 'CatalogController@sortProductsByCategory');
        $route->post('filterProducts', 'CatalogController@filterProducts');

        $route->post('sortCollectionsByFilter', 'CollectionsController@sortCollectionsByFilter');
        $route->post('sortCollectionsByCategory', 'CollectionsController@sortCollectionsByCategory');
        $route->post('filterCollections', 'CollectionsController@filterCollections');
    });

    Route::group(['name' => 'ajax.', 'prefix' => 'ajax'], function ($route) {
        $route->get('/check-value', 'AjaxController@checkValue')->name('check-value.get');
    });

    Route::group(['name' => 'search.', 'prefix' => 'search'], function ($route) {
        $route->get('/get-search-results', 'AjaxController@getSearchResults')->name('get-search-results.get');
    });
});
