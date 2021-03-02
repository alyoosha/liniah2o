<?php

namespace App\Http\Controllers\Pages\Secondary;

use App\Http\Controllers\Controller;
use App\Models\ExploitationRules;
use App\Models\Guarantee;
use App\Models\Page;
use App\Models\PaymentAndDelivery;
use App\Models\CategoriesGuarantee;
use App\Models\PaymentOption;
use App\Models\Regulation;
use App\Models\WarrantyPeriods;

class SecondaryPageController extends Controller
{
    protected const HTTP_NOTFOUND_CODE = 404;

    public function show($slug)
    {
        $page = Page::where('slug', $slug)->first();

        abort_unless($page, self::HTTP_NOTFOUND_CODE);

        $oneColumn = true;
        $menuSecPage = $page->has_menu ? 'parts.secondary.menu-right' : null;

        return view('pages.secondary.template-main', compact('page', 'menuSecPage', 'oneColumn'));
    }

    public function showPaymentAndDelivery()
    {
        $page = PaymentAndDelivery::find(1);

        abort_unless($page, self::HTTP_NOTFOUND_CODE);

        $paymentOptions = PaymentOption::all();
        $modalDeliveryClause = $page['delivery_clause_' . self::$lang];

        return view('pages.secondary.payment-and-delivery', compact('page', 'modalDeliveryClause', 'paymentOptions'));
    }

    public function showWarrantyPeriods()
    {
        $page = WarrantyPeriods::find(1);

        abort_unless($page, self::HTTP_NOTFOUND_CODE);

        $categories = CategoriesGuarantee::all();
        $guarantees = [];

        for ($c = 0; $c < count($categories); ++$c) {
            $guarantees[$c] = $categories[$c]->guarantees()->sortBy('validity')->reverse();
        }

        return view('pages.secondary.warranty-periods', compact('page', 'categories', 'guarantees'));
    }

    public function showExploitationRules()
    {
        $page = ExploitationRules::find(1);

        abort_unless($page, self::HTTP_NOTFOUND_CODE);

        $regulation = Regulation::all();
        $ctgries = Regulation::uniqueIdCategories();
        $categories = null;
        $regulations = null;
        $perPage = 5;

        foreach ($ctgries as $category) {
            foreach ($regulation as $reg) {
                if ($category->category_id == $reg['category_id']) {
                    $categories[$category->category_id] = $reg->category;
                    $regulations[$category->category_id][] = $reg;
                }
            }
        }

        abort_if(is_null($regulation) || is_null($categories), self::HTTP_NOTFOUND_CODE);

        return view('pages.secondary.exploitation-rules', compact('page', 'categories', 'regulations', 'perPage'));
    }

    public function showExploitationRule($id)
    {
        $page = Regulation::find($id);

        abort_unless($page, self::HTTP_NOTFOUND_CODE);

        $guarantee = Guarantee::find($page->guarantee_id);
        $menuSecPage = false;
        $oneColumn = true;

        return view('pages.secondary.template-main', compact('page', 'menuSecPage', 'guarantee', 'oneColumn'));
    }
}
