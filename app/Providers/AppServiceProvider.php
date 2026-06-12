<?php

namespace App\Providers;

use App\Models\Mua;
use App\Models\MuaPackage;
use App\Observers\MuaObserver;
use App\Observers\MuaPackageObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Mua::observe(MuaObserver::class);
        MuaPackage::observe(MuaPackageObserver::class);
    }
}
