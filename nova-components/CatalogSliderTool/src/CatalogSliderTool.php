<?php

namespace Egorovagency\CatalogSliderTool;

use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class CatalogSliderTool extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::script('catalog-slider-tool', __DIR__.'/../dist/js/tool.js');
        Nova::style('catalog-slider-tool', __DIR__.'/../dist/css/tool.css');
    }

    /**
     * Build the view that renders the navigation links for the tool.
     *
     * @return \Illuminate\View\View
     */
    public function renderNavigation()
    {
//        return view('catalog-slider-tool::navigation');
    }
}
