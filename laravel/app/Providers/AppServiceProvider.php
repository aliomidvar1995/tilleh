<?php

namespace App\Providers;

use App\Http\Resources\CommentResource;
use App\Http\Resources\NewsResource;
use Illuminate\Support\ServiceProvider;

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
        NewsResource::withoutWrapping();
        CommentResource::withoutWrapping();
    }
}
