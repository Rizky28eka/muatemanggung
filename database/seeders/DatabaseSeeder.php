<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            DistrictSeeder::class,
            EventTypeSeeder::class,
            ThemeSeeder::class,
            MakeupLookSeeder::class,
            PriceRangeSeeder::class,
            PackageTemplateSeeder::class,
            AdminUserSeeder::class,
            MuaSeeder::class,
        ]);
    }
}
