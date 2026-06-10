<?php

namespace Database\Seeders;

use App\Models\EventType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EventTypeSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            ['name' => 'Akad',                 'is_siraman' => false, 'sort_order' => 1],
            ['name' => 'Resepsi',               'is_siraman' => false, 'sort_order' => 2],
            ['name' => 'Lamaran',               'is_siraman' => false, 'sort_order' => 3],
            ['name' => 'Siraman',               'is_siraman' => true,  'sort_order' => 4],
            ['name' => 'Prewed',                'is_siraman' => false, 'sort_order' => 5],
            ['name' => 'Wisuda',                'is_siraman' => false, 'sort_order' => 6],
            ['name' => 'Yearbook',              'is_siraman' => false, 'sort_order' => 7],
            ['name' => 'Character & Penokohan', 'is_siraman' => false, 'sort_order' => 8],
            ['name' => 'Makeup Tari',           'is_siraman' => false, 'sort_order' => 9],
        ];

        foreach ($events as $event) {
            EventType::firstOrCreate(
                ['slug' => Str::slug($event['name'])],
                ['name' => $event['name'], 'is_siraman' => $event['is_siraman'], 'sort_order' => $event['sort_order']]
            );
        }
    }
}
