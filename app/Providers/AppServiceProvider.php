<?php namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Change User provider
        $this->app['auth']->extend('eloquent', function ($app) {
            $model = $app['config']['auth.model'];
            return new CachedEloquentUserProvider($app['hash'], $model);
        });

        // Add user to the view
        view()->composer('*', function ($view) {
            $view->with('authUser', \Auth::user());
        });

        /**
         * Validates a user's password
         * This is used when an user changes their password.
         */
        \Validator::extend('auth', function ($attribute, $value) {
            return Hash::check($value, Auth::user()->password);
        }, "Password is incorrect.");

        /**
         * Validates that only a client can have money.
         */
        \Validator::extend('money', function ($attribute, $value) {
            return ($value and \Request::get('group') == "Client");
        }, "Only a client can record their money.");

        /**
         * Validates that an admin or employee must exist
         */
        \Validator::extend('noClientExists', function ($attribute, $value) {
            return User::where('group', '!=', 'Client')
                ->where('id', $value)
                ->count();
        }, "Invalid user selected.");
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
