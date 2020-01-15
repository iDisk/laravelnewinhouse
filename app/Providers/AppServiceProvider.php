<?php

namespace App\Providers;

use View;
use Illuminate\Support\ServiceProvider;

//use App\Models\User;
//use App\Observers\UserObserver;
//
//use App\Models\Push;
//use App\Observers\PushObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        //User::observe(UserObserver::class);
        //Push::observe(PushObserver::class);
        View::composer('*', function ($view) {
            $user = auth()->user();
            if($user)
            {
                $assigned_brokers = $user->assigned_brokers;
                $view->with('global_assigned_brokers', $assigned_brokers);
            }
        });
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
