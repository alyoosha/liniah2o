<?php

namespace App\Providers;

use Egorovagency\Alexsettings\Alexsettings;
use Egorovagency\ParserInterface\ParserInterface;
use Egorovagency\ParserInterfaceUpdatePrices\ParserInterfaceUpdatePrices;
use Egorovagency\PromoBlocksTool\PromoBlocksTool;
use Egorovagency\PromoSliderTool\PromoSliderTool;
use Egorovagency\XMLValidatorInterface\XMLValidatorInterface;
use Illuminate\Support\Facades\Gate;
use Infinety\MenuBuilder\MenuBuilder;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Day4\TreeView\TreeView;
use Laravel\Nova\Panel;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        \OptimistDigital\NovaSettings\NovaSettings::addSettingsFields([

            new Panel('Общие настройки', [
                Text::make('Имя', 'namew'),
                Image::make('Logo', 'logo'),
            ]),
        ]);
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, config('nova.admin'));
        });
    }


    /**
     * Get the cards that should be displayed on the default Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [
//            new Help,
        ];
    }

    /**
     * Get the extra dashboards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            new MenuBuilder(),

            new TreeView([
                ['Категории', 'categories'],
            ]),

            new ParserInterface(),
            new ParserInterfaceUpdatePrices(),
            new XMLValidatorInterface(),

            new Alexsettings(),

            new PromoSliderTool(),

            new PromoBlocksTool(),
//            new NovaMediaLibrary()
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
         //
    }
}
