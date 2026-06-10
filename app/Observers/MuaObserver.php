<?php

namespace App\Observers;

use App\Models\Mua;
use App\Services\VectorBuilderService;

class MuaObserver
{
    public function saved(Mua $mua): void
    {
        app(VectorBuilderService::class)->saveForMua($mua);
    }
}
