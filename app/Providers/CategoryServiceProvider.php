<?php

namespace App\Providers;

use App\Models\Advertisement;
use App\Models\Category;
use App\Models\Sidebar;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
class CategoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        
        View::composer('*', function ($view) {
            $categories = Category::withCount('articles')->get();
            
            $sidebars = Sidebar::where('is_active', true)->orderBy('order')->get(); // Fetch sidebars data
            $randomAdvertisement = Advertisement::inRandomOrder()->first();
            // Share categories and sidebars with all views
            $view->with('categories', $categories);
            $view->with('sidebars', $sidebars);
            $view->with('randomAdvertisement', $randomAdvertisement);
        });
    }
}
