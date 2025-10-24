<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\Menu;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Share menu tree with header (and other layout views if needed)
        View::composer(['layouts.header', 'layouts.*', 'partials.*', 'header'], function ($view) {
            // Prefer `order` if present
            $orderCol = Schema::hasColumn('menus', 'order') ? 'order' : 'id';

            $menuTree = Menu::query()
                ->whereNull('parent_id')
                ->active()
                ->with(['children' => function ($q) use ($orderCol) {
                    $q->active()->orderBy($orderCol);
                }])
                ->orderBy($orderCol)
                ->get();

            $view->with('menuTree', $menuTree);
        });
    }
}
