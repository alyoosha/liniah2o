<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Category;

class AboutController extends Controller
{
    public function __invoke()
    {
        $aboutUsInfo = About::all()[0];
        $categories = Category::getFirstLevelCategories()->isActive()->get();

        return view('pages.about', compact('aboutUsInfo', 'categories'));
    }
}
