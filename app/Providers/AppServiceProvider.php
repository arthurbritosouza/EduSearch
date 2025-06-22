<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\Relation_notification;
use Illuminate\Support\Facades\View;

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
        View::composer('include.sidebar', function ($view) {
            if (Auth::check()) {
                $notificationCount = Relation_notification::where('partner_id', Auth::id())->count();
                $view->with('notificationCount', $notificationCount);
            }
        });
    }
}
