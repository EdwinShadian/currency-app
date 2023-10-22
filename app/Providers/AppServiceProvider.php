<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Response;
use Route;
use Throwable;

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
        Response::macro('api', function (array $data) {
            return Response::make([
                'data' => $data,
            ]);
        });

        Response::macro('error', function (Throwable $e) {
            return Response::make([
                'status' => $e->getCode() ?: 500,
                'message' => $e->getMessage(),
            ]);
        });

        Livewire::setScriptRoute(function ($handle) {
            return Route::get('/vendor/livewire/livewire.js', $handle);
        });
    }
}
