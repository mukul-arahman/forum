<?php

namespace App\Providers;

use App\Channel;
use Illuminate\Support\ServiceProvider;

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
        \View::composer('*', function ($view) {
            $channel = \Cache::rememberForever('channels', function () {
                return Channel::all();
            });
            $view->with('channels', $channel);
        });
    }
}
