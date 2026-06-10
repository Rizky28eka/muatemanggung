<?php

namespace App\Providers;

use App\Models\Mua;
use App\Observers\MuaObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Mua::observe(MuaObserver::class);
    }
}
