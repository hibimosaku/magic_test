<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\SecondaryCategory;
use App\Models\PrimaryCategory;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('components.nav', function ($view) {
            $secondaryCategories = SecondaryCategory::all();
            $primaryCategories = PrimaryCategory::all();

            $view->with('secondaryCategories', $secondaryCategories);
            $view->with('primaryCategories', $primaryCategories);
        });
    }
}
