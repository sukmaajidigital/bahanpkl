<?php

namespace App\Providers;

use App\Models\Kriteria;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;

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
        View::composer('layouts.sidebar', function($view){
            $katekori = Kriteria::all();
            $view->with([
                'kategori' => $katekori
            ]);
        });
    }
}
