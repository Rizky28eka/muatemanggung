<?php

namespace Database\Seeders;

use App\Models\PriceRange;
use Illuminate\Database\Seeder;

class PriceRangeSeeder extends Seeder
{
    public function run(): void
    {
        $ranges = [
            ['label' => '< Rp 500.000',              'min_price' => null,      'max_price' => 499999,   'sort_order' => 1],
            ['label' => 'Rp 500.000 – Rp 1.000.000', 'min_price' => 500000,   'max_price' => 1000000,  'sort_order' => 2],
            ['label' => 'Rp 1.000.000 – Rp 2.000.000','min_price' => 1000001, 'max_price' => 2000000,  'sort_order' => 3],
            ['label' => 'Rp 2.000.000 – Rp 5.000.000','min_price' => 2000001, 'max_price' => 5000000,  'sort_order' => 4],
            ['label' => '> Rp 5.000.000',             'min_price' => 5000001,  'max_price' => null,     'sort_order' => 5],
        ];
        foreach ($ranges as $range) {
            PriceRange::firstOrCreate(['label' => $range['label']], $range);
        }
    }
}
