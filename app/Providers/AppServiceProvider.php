<?php

namespace App\Providers;

use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind('user', UserService::class);
    }

    public function boot(): void
    {
        UserResource::withoutWrapping();
    }
}
