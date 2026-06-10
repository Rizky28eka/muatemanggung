<?php

namespace Database\Seeders;

use App\Models\MakeupLook;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MakeupLookSeeder extends Seeder
{
    public function run(): void
    {
        $looks = ['Soft', 'Bold', 'Barbie Look', 'Natural', 'Korean', 'Spesialisasi'];
        foreach ($looks as $name) {
            MakeupLook::firstOrCreate(['slug' => Str::slug($name)], ['name' => $name]);
        }
    }
}
