<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Resources\Json\JsonResource;
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
        if (request()->is('admin/*')) {
            config(['session.cookie' => config('session.cookie_admin')]);
        }

        Validator::extend('zipcode_format', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^\d{3}-?\d{4}$/', $value);
        });

        JsonResource::withoutWrapping();
    }
}
