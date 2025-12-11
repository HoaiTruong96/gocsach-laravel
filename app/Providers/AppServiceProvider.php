<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // [1] Thêm dòng này
use App\Models\Category; // [2] Thêm dòng này
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $view->with('menuCategories', Category::orderBy('name')->get(['id', 'name']));
        });
    }
}
