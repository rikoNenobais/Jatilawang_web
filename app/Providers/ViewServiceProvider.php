<?php

namespace App\Providers;

use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Share cart total items to all views
        View::composer('*', function ($view) {
            $totalItems = Auth::check() 
                ? CartItem::where('user_id', Auth::id())->sum('quantity')
                : 0;
            
            $view->with('totalItems', $totalItems);
        });
    }
}