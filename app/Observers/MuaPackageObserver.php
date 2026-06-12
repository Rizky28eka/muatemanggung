<?php

namespace App\Observers;

use App\Models\MuaPackage;
use App\Services\VectorBuilderService;

class MuaPackageObserver
{
    public function saved(MuaPackage $package): void
    {
        if ($package->mua) {
            app(VectorBuilderService::class)->saveForMua($package->mua);
        }
    }

    public function deleted(MuaPackage $package): void
    {
        if ($package->mua) {
            app(VectorBuilderService::class)->saveForMua($package->mua);
        }
    }
}
