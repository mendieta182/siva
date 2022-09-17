<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //Max key length error fix
        Schema::defaultStringLength(191);

        //Shared Variables
        Inertia::share([
            // 'errors' => function () {
            //     return Session::get('errors')
            //         ? Session::get('errors')->getBag('default')->getMessages()
            //         : (object)[];
            // },
            // 'lang' => function () {
            //     return Session::get('locale');
            // },
            'lang' => function () {
                return app()->getLocale();
            },
            // 'project_info' => function () {
            //     return Env::get('APP_NAME');
            // },
            // 'roles' => function () {
            //     if (Auth::check()) {
            //         return Auth::user()->getRoleNames();
            //     } else {
            //         return [];
            //     }
            // },
            // 'permissions' => function () {
            //     if (Auth::check()) {
            //         return Auth::user()->getAllPermissions();
            //     } else {
            //         return [];
            //     }
            // }
        ]);

        Inertia::share('flash', function () {
            return [
                'message' => Session::get('message'),
            ];
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
