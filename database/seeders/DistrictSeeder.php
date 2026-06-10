<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DistrictSeeder extends Seeder
{
    public function run(): void
    {
        $districts = [
            'Temanggung', 'Tembarak', 'Selopampang', 'Kranggan',
            'Pringsurat', 'Kaloran', 'Kandangan', 'Kedu',
            'Ngadirejo', 'Jumo', 'Gemawang', 'Candiroto',
            'Bejen', 'Tretep', 'Wonoboyo', 'Bulu',
            'Tlogomulyo', 'Kledung', 'Bansari', 'Parakan',
        ];

        foreach ($districts as $name) {
            District::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
        }
    }
}
