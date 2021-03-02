<?php


namespace App\Http\Controllers;


use App\Models\About;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Contact;
use App\Models\ExploitationRules;
use App\Models\Page;
use App\Models\PaymentAndDelivery;
use App\Models\Tag;
use App\Models\WarrantyPeriods;

class SitemapController extends Controller
{
    public function index()
    {
        return response()->view('sitemap.index')->header('Content-Type', 'text/xml');
    }

    public function main()
    {
        $about = About::find(1);
        $contacts = Contact::find(1);
        $brand = Brand::latest('updated_at')->first();
        $promotionLatest = Tag::isPromotion()->latest('updated_at')->first();
        $promotions = Tag::isPromotion()->get();

        return response()
            ->view('sitemap.main', compact(
            'about',
            'contacts',
                'brand',
                'promotionLatest',
                'promotions'
        ))
            ->header('Content-Type', 'text/xml');
    }

    public function secondaryPages()
    {
        $paymentAndDelivery = PaymentAndDelivery::find(1);
        $warrantyPeriods = WarrantyPeriods::find(1);
        $explotationRuleLatest = ExploitationRules::latest('updated_at')->first();
        $explotationRulesList = ExploitationRules::all();
        $pagesList = Page::all();

        return response()
            ->view('sitemap.secondary-pages', compact(
                'paymentAndDelivery',
                'warrantyPeriods',
                'explotationRuleLatest',
                'explotationRulesList',
                'pagesList'
            ))
            ->header('Content-Type', 'text/xml');
    }

    public function cart()
    {
        return response()
            ->view('sitemap.cart')
            ->header('Content-Type', 'text/xml');
    }

    public function catalog()
    {
        $categoryLatestUpdated = Category::latest('updated_at')->first();
        $firstLevelcategoriesList = Category::getFirstLevelCategories()->get();

        return response()
            ->view('sitemap.catalog', compact(
                'categoryLatestUpdated',
                'firstLevelcategoriesList'
            ))
            ->header('Content-Type', 'text/xml');
    }
}
