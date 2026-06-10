<?php

namespace Database\Seeders;

use App\Models\Theme;
use App\Models\ThemeType;
use App\Models\ThemeSubtype;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ThemeSeeder extends Seeder
{
    public function run(): void
    {
        // Tema Adat
        $adat = Theme::firstOrCreate(['slug' => 'adat'], ['name' => 'Adat']);
        $typeData = [
            'jawa'      => ['name' => 'Jawa',      'subtypes' => []],
            'sunda'     => ['name' => 'Sunda',     'subtypes' => []],
            'nusantara' => ['name' => 'Nusantara', 'subtypes' => ['Klasik', 'Modern Klasik', 'Modifikasi']],
            'nasional'  => ['name' => 'Nasional',  'subtypes' => []],
        ];
        foreach ($typeData as $slug => $data) {
            $type = ThemeType::firstOrCreate(
                ['slug' => $slug],
                ['theme_id' => $adat->id, 'name' => $data['name']]
            );
            foreach ($data['subtypes'] as $sub) {
                ThemeSubtype::firstOrCreate(
                    ['slug' => Str::slug($sub)],
                    ['theme_type_id' => $type->id, 'name' => $sub]
                );
            }
        }

        // Tema Modern
        $modern = Theme::firstOrCreate(['slug' => 'modern'], ['name' => 'Modern']);
        ThemeType::firstOrCreate(
            ['slug' => 'modern-kontemporer'],
            ['theme_id' => $modern->id, 'name' => 'Modern Kontemporer']
        );
    }
}
