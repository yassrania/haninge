<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use App\Models\FooterSetting;
use App\Models\FooterLinkGroup;

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
    View::composer(['layouts.*', 'partials.*', '*'], function ($view) {
        // اختر الموديل الصحيح لديك: Setting أو FooterSetting
        $view->with('site', \App\Models\Setting::first()); 
        // لو تستخدم FooterSetting:
        // $view->with('site', \App\Models\FooterSetting::first());
    });
}

}

