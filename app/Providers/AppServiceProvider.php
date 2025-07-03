<?php

namespace App\Providers;

use App\Auth\ContactEmailUserProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\View\Components\ThemeToggle;

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
        Auth::provider('contact_email', function ($app, array $config) {
            return new ContactEmailUserProvider();
        });
        Blade::component('theme-toggle', ThemeToggle::class);
    }
}
