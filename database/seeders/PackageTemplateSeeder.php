<?php

namespace Database\Seeders;

use App\Models\EventType;
use App\Models\PackageTemplate;
use App\Models\PackageTemplateInclude;
use Illuminate\Database\Seeder;

class PackageTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'akad' => [
                ['name' => 'Makeup Only',                  'includes' => ['Makeup Pengantin', 'Hijabdo/Hairdo']],
                ['name' => 'Makeup + Wardrobe',            'includes' => ['Makeup Pengantin', 'Hijabdo/Hairdo', 'Sepasang Busana Akad', 'Free Softlens']],
                ['name' => 'Makeup + Dokumentasi + Dekor', 'includes' => ['Makeup Pengantin', 'Hijabdo/Hairdo', 'Busana Akad', 'Fotografer', 'Dekorasi']],
            ],
            'resepsi' => [
                ['name' => 'Pengantin (Makeup Only)',                        'includes' => ['Makeup Sepasang Pengantin', 'Hijabdo/Hairdo', 'Retouch']],
                ['name' => 'Pengantin + Orang Tua',                          'includes' => ['Makeup Pengantin', 'Hijabdo', '2 Makeup Ibu', '2 Busana Ortu', 'Busana Bapak']],
                ['name' => 'Pengantin + Ortu + Domas + Penerima Tamu',       'includes' => ['Makeup Pengantin', 'Makeup Ortu', 'Makeup 4 Domas', 'Makeup Penerima Tamu', 'Hijabdo Semua']],
            ],
            'lamaran' => [
                ['name' => 'Makeup Only',                            'includes' => ['Makeup Pengantin', 'Hijabdo']],
                ['name' => 'Makeup + Wardrobe + Dekor + Dokumentasi', 'includes' => ['Makeup Pengantin', 'Hijabdo', 'Busana', 'Dekorasi', 'Fotografer']],
            ],
            'siraman' => [
                ['name' => 'Paket Lengkap', 'includes' => ['Makeup Siraman', 'Busana Siraman', 'Hias Bunga', 'Perlengkapan Siraman']],
                ['name' => 'Paket Biasa',   'includes' => ['Makeup Siraman', 'Busana Siraman']],
            ],
            'prewed' => [
                ['name' => 'Makeup Only',                   'includes' => ['Makeup', 'Hijabdo/Hairdo']],
                ['name' => 'Makeup + Wardrobe (Indoor)',    'includes' => ['Makeup', 'Hijabdo/Hairdo', 'Kostum Studio']],
                ['name' => 'Makeup + Wardrobe (Outdoor)',   'includes' => ['Makeup', 'Hijabdo/Hairdo', 'Kostum Outdoor']],
            ],
            'wisuda' => [
                ['name' => 'Makeup Only',        'includes' => ['Makeup', 'Hijabdo & Pemasangan Toga']],
                ['name' => 'Makeup + Wardrobe',  'includes' => ['Makeup', 'Hijabdo', 'Busana Wisuda']],
            ],
            'yearbook' => [
                ['name' => 'Makeup Only',        'includes' => ['Makeup', 'Hijabdo/Hairdo']],
                ['name' => 'Makeup + Wardrobe',  'includes' => ['Makeup', 'Hijabdo/Hairdo', 'Kostum (sesuai tema foto)']],
            ],
            'character-penokohan' => [
                ['name' => 'Makeup + Wardrobe', 'includes' => ['Makeup Karakter', 'Kostum (sesuai penokohan)']],
            ],
            'makeup-tari' => [
                ['name' => 'Makeup Only',        'includes' => ['Makeup Tari']],
                ['name' => 'Makeup + Wardrobe',  'includes' => ['Makeup Tari', 'Kostum (sesuai jenis tari)']],
            ],
        ];

        foreach ($data as $eventSlug => $templates) {
            $eventType = EventType::where('slug', $eventSlug)->first();
            if (!$eventType) continue;

            foreach ($templates as $order => $tpl) {
                $template = PackageTemplate::firstOrCreate(
                    ['event_type_id' => $eventType->id, 'name' => $tpl['name']],
                    ['sort_order' => $order + 1]
                );
                foreach ($tpl['includes'] as $idx => $item) {
                    PackageTemplateInclude::firstOrCreate(
                        ['package_template_id' => $template->id, 'include_item' => $item],
                        ['sort_order' => $idx + 1]
                    );
                }
            }
        }
    }
}
