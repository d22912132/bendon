<?php

namespace App\Providers;
use App\Model\Cart;
use Illuminate\Support\ServiceProvider;
use App\Observers\CartObserver;


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
         Cart::observe(CartObserver::class);
    }
}
