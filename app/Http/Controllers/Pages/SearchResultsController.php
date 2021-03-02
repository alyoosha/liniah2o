<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Api\AjaxController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchResultsController extends Controller
{
    protected const PER_PAGE = 8;

    public function __invoke(Request $request)
    {
        $inputStr = $request->input('header-search');
        $perPage = self::PER_PAGE;
        $products = $categories = $categoriesForProduct = $tags = [];

        if(!empty($inputStr) && mb_strlen($inputStr) > 2) {
            $result = AjaxController::getSearchResults($request, true);

            $categories = $result['categoriesFound'];
            $products = $result['productsFound'];

            if(empty($categories) && empty($products)) {
                $categories = $products = null;
                $inputStr = __('no_results_were_found_for_this_request');
            }
        }
        elseif (empty($inputStr)) {
            return redirect()->route('pages.main.index');
        }
        else {
            $inputStr = __('no_results_were_found_for_this_request');
        }

        return view('pages.search-results', compact(['products', 'categories', 'perPage', 'inputStr']));
    }
}
