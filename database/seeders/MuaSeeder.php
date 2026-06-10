<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\EventType;
use App\Models\MakeupLook;
use App\Models\Mua;
use App\Models\Theme;
use App\Models\ThemeType;
use App\Models\User;
use App\Models\PackageTemplate;
use App\Models\MuaPackage;
use App\Models\MuaPortfolio;
use App\Services\VectorBuilderService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MuaSeeder extends Seeder
{
    public function run(): void
    {
        $muas = [
            [
                'name'               => 'Zahra MUA',
                'email'              => 'zahra@muatemanggung.com',
                'whatsapp_number'    => '6281234560001',
                'instagram_username' => 'zahra_mua',
                'is_home_service'    => true,
                'district'           => 'temanggung',
                'event_types'        => ['akad', 'resepsi'],
                'themes'             => ['adat', 'modern'],
                'theme_types'        => ['jawa', 'sunda', 'modern-kontemporer'],
                'looks'              => ['soft', 'natural', 'bold'],
                'districts'          => ['temanggung', 'parakan', 'ngadirejo'],
                'description'        => 'MUA profesional spesialisasi wedding dengan pengalaman lebih dari 5 tahun di Temanggung.',
            ],
            [
                'name'               => 'Elly Neisya',
                'email'              => 'elly@muatemanggung.com',
                'whatsapp_number'    => '6281234560002',
                'instagram_username' => 'elly_neisya',
                'is_home_service'    => true,
                'district'           => 'parakan',
                'event_types'        => ['wisuda'],
                'themes'             => ['modern'],
                'theme_types'        => ['modern-kontemporer'],
                'looks'              => ['soft', 'natural'],
                'districts'          => ['parakan', 'temanggung', 'bansari'],
                'description'        => 'Spesialisasi makeup wisuda untuk semua jenjang pendidikan.',
            ],
            [
                'name'               => 'Cissy Rhy',
                'email'              => 'cissy@muatemanggung.com',
                'whatsapp_number'    => '6281234560003',
                'instagram_username' => 'cissy_rhy',
                'is_home_service'    => true,
                'district'           => 'temanggung',
                'event_types'        => ['makeup-tari', 'character-penokohan'],
                'themes'             => ['adat'],
                'theme_types'        => ['jawa', 'sunda', 'nusantara'],
                'looks'              => ['bold', 'spesialisasi'],
                'districts'          => ['temanggung', 'kledung', 'tlogomulyo'],
                'description'        => 'Ahli makeup tari tradisional dan karnaval di Kabupaten Temanggung.',
            ],
            [
                'name'               => 'March Studio',
                'email'              => 'march@muatemanggung.com',
                'whatsapp_number'    => '6281234560004',
                'instagram_username' => 'marchstudio',
                'is_home_service'    => false,
                'district'           => 'ngadirejo',
                'event_types'        => ['prewed', 'wisuda', 'yearbook'],
                'themes'             => ['modern'],
                'theme_types'        => ['modern-kontemporer'],
                'looks'              => ['natural', 'soft', 'korean'],
                'districts'          => ['ngadirejo', 'temanggung', 'jumo'],
                'description'        => 'Studio makeup modern untuk prewed, wisuda, dan yearbook.',
            ],
            [
                'name'               => 'DPR Makeup',
                'email'              => 'dpr@muatemanggung.com',
                'whatsapp_number'    => '6281234560005',
                'instagram_username' => 'dprmakeup',
                'is_home_service'    => true,
                'district'           => 'temanggung',
                'event_types'        => ['prewed', 'akad', 'resepsi'],
                'themes'             => ['adat', 'modern'],
                'theme_types'        => ['jawa', 'sunda', 'modern-kontemporer'],
                'looks'              => ['soft', 'natural', 'bold', 'korean'],
                'districts'          => ['temanggung', 'tembarak', 'selopampang', 'kranggan'],
                'description'        => 'MUA lengkap untuk prewed dan wedding dengan berbagai gaya makeup.',
            ],
            [
                'name'               => 'Ayu Mahardika',
                'email'              => 'ayu@muatemanggung.com',
                'whatsapp_number'    => '6281234560006',
                'instagram_username' => 'ayu_mahardika',
                'is_home_service'    => true,
                'district'           => 'kedu',
                'event_types'        => ['akad', 'resepsi', 'lamaran'],
                'themes'             => ['modern'],
                'theme_types'        => ['modern-kontemporer'],
                'looks'              => ['soft', 'natural', 'bold'],
                'districts'          => ['kedu', 'kandangan', 'temanggung'],
                'description'        => 'Spesialisasi wedding modern dengan paket Silver, Gold, dan Platinum.',
            ],
            [
                'name'               => 'Leina Makeup',
                'email'              => 'leina@muatemanggung.com',
                'whatsapp_number'    => '6281234560007',
                'instagram_username' => 'leina_makeup.id',
                'is_home_service'    => true,
                'district'           => 'parakan',
                'event_types'        => ['prewed', 'akad', 'resepsi'],
                'themes'             => ['adat', 'modern'],
                'theme_types'        => ['jawa', 'sunda', 'modern-kontemporer'],
                'looks'              => ['soft', 'natural', 'bold'],
                'districts'          => ['parakan', 'bansari', 'kledung', 'temanggung'],
                'description'        => 'Makeup artist berpengalaman untuk wedding modern dan adat Jawa-Sunda.',
            ],
            [
                'name'               => 'Sekar Arum Makeup',
                'email'              => 'sekar@muatemanggung.com',
                'whatsapp_number'    => '6281234560008',
                'instagram_username' => 'sekar_arum_makeup',
                'is_home_service'    => true,
                'district'           => 'temanggung',
                'event_types'        => ['yearbook', 'wisuda', 'character-penokohan'],
                'themes'             => ['modern'],
                'theme_types'        => ['modern-kontemporer'],
                'looks'              => ['natural', 'soft', 'bold', 'barbie-look'],
                'districts'          => ['temanggung', 'tembarak', 'pringsurat'],
                'description'        => 'Spesialisasi yearbook, karnaval, wisuda SMP–Universitas, dan bridesmaid.',
            ],
            [
                'name'               => 'Aliyza Makeup',
                'email'              => 'aliyza@muatemanggung.com',
                'whatsapp_number'    => '6281234560009',
                'instagram_username' => 'aliyzamakeup',
                'is_home_service'    => true,
                'district'           => 'ngadirejo',
                'event_types'        => ['lamaran', 'prewed', 'siraman', 'wisuda', 'yearbook'],
                'themes'             => ['adat', 'modern'],
                'theme_types'        => ['jawa', 'modern-kontemporer'],
                'looks'              => ['soft', 'natural', 'korean'],
                'districts'          => ['ngadirejo', 'jumo', 'candiroto', 'temanggung'],
                'description'        => 'MUA all-round melayani lamaran, prewed, siraman, wisuda, dan yearbook.',
            ],
            [
                'name'               => 'Faeyza Wedding MUA',
                'email'              => 'faeyza@muatemanggung.com',
                'whatsapp_number'    => '6281234560010',
                'instagram_username' => 'faeyza_wedding_mua',
                'is_home_service'    => true,
                'district'           => 'temanggung',
                'event_types'        => ['akad', 'resepsi', 'siraman'],
                'themes'             => ['adat', 'modern'],
                'theme_types'        => ['jawa', 'sunda', 'modern-kontemporer'],
                'looks'              => ['soft', 'natural', 'bold'],
                'districts'          => ['temanggung', 'tembarak', 'kranggan', 'selopampang', 'kedu'],
                'description'        => 'Wedding MUA spesialis paket Silver, Gold, Diamond serta Traditional Wedding.',
            ],
        ];

        $logoUrls = [
            'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=300&fit=crop&q=80',
            'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=300&fit=crop&q=80',
            'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=300&fit=crop&q=80',
            'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=300&fit=crop&q=80',
            'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=300&fit=crop&q=80',
            'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=300&fit=crop&q=80',
            'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300&fit=crop&q=80',
            'https://images.unsplash.com/photo-1489426411172-044a508f245c?w=300&fit=crop&q=80',
            'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?w=300&fit=crop&q=80',
            'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=300&fit=crop&q=80'
        ];

        $portfolioPhotos = [
            [
                'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?w=800&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=800&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?w=800&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1519741497674-611481863552?w=800&auto=format&fit=crop&q=80'
            ],
            [
                'https://images.unsplash.com/photo-1512496015851-a90fb38ba796?w=800&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1515688594390-b649af70d282?w=800&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1526045431048-f857369aba09?w=800&auto=format&fit=crop&q=80'
            ],
            [
                'https://images.unsplash.com/photo-1503249023995-51b0f3778ccf?w=800&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1509631179647-0177331693ae?w=800&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1571781926291-c477ebfd024b?w=800&auto=format&fit=crop&q=80'
            ],
            [
                'https://images.unsplash.com/photo-1562322140-8baeececf3df?w=800&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1522337094846-8a818192de2f?w=800&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?w=800&auto=format&fit=crop&q=80'
            ],
            [
                'https://images.unsplash.com/photo-1512496015851-a90fb38ba796?w=800&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1515688594390-b649af70d282?w=800&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?w=800&auto=format&fit=crop&q=80'
            ],
            [
                'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=800&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?w=800&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1519741497674-611481863552?w=800&auto=format&fit=crop&q=80'
            ],
            [
                'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?w=800&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1562322140-8baeececf3df?w=800&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1522337094846-8a818192de2f?w=800&auto=format&fit=crop&q=80'
            ],
            [
                'https://images.unsplash.com/photo-1509631179647-0177331693ae?w=800&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1571781926291-c477ebfd024b?w=800&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?w=800&auto=format&fit=crop&q=80'
            ],
            [
                'https://images.unsplash.com/photo-1526045431048-f857369aba09?w=800&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1503249023995-51b0f3778ccf?w=800&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?w=800&auto=format&fit=crop&q=80'
            ],
            [
                'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=800&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?w=800&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1519741497674-611481863552?w=800&auto=format&fit=crop&q=80'
            ]
        ];

        $pricesMap = [
            'akad' => [
                'Makeup Only' => 1500000,
                'Makeup + Wardrobe' => 3000000,
                'Makeup + Dokumentasi + Dekor' => 7500000
            ],
            'resepsi' => [
                'Pengantin (Makeup Only)' => 2000000,
                'Pengantin + Orang Tua' => 3500000,
                'Pengantin + Ortu + Domas + Penerima Tamu' => 6000000
            ],
            'lamaran' => [
                'Makeup Only' => 800000,
                'Makeup + Wardrobe + Dekor + Dokumentasi' => 3000000
            ],
            'siraman' => [
                'Paket Lengkap' => 1800000,
                'Paket Biasa' => 1000000
            ],
            'prewed' => [
                'Makeup Only' => 750000,
                'Makeup + Wardrobe (Indoor)' => 1500000,
                'Makeup + Wardrobe (Outdoor)' => 2000000
            ],
            'wisuda' => [
                'Makeup Only' => 350000,
                'Makeup + Wardrobe' => 700000
            ],
            'yearbook' => [
                'Makeup Only' => 300000,
                'Makeup + Wardrobe' => 600000
            ],
            'character-penokohan' => [
                'Makeup + Wardrobe' => 1200000
            ],
            'makeup-tari' => [
                'Makeup Only' => 250000,
                'Makeup + Wardrobe' => 500000
            ]
        ];

        foreach ($muas as $index => $data) {
            $mua = Mua::firstOrCreate(
                ['slug' => Str::slug($data['name'])],
                [
                    'name'               => $data['name'],
                    'description'        => $data['description'],
                    'whatsapp_number'    => $data['whatsapp_number'],
                    'instagram_username' => $data['instagram_username'],
                    'is_home_service'    => $data['is_home_service'],
                    'service_radius_km'  => 30,
                    'district_id'        => District::where('slug', $data['district'])->value('id'),
                    'is_active'          => true,
                    'logo'               => $logoUrls[$index % count($logoUrls)],
                ]
            );

            // If MUA already exists but logo is null, update logo
            if (empty($mua->logo)) {
                $mua->update(['logo' => $logoUrls[$index % count($logoUrls)]]);
            }

            // Buat akun user untuk MUA
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name'      => $data['name'],
                    'password'  => Hash::make('mua123'),
                    'role'      => 'mua',
                    'is_active' => true,
                    'mua_id'    => $mua->id,
                ]
            );

            // Sync relasi
            $mua->eventTypes()->sync(
                EventType::whereIn('slug', $data['event_types'])->pluck('id')
            );
            $mua->themes()->sync(
                Theme::whereIn('slug', $data['themes'])->pluck('id')
            );
            $mua->themeTypes()->sync(
                ThemeType::whereIn('slug', $data['theme_types'])->pluck('id')
            );
            $mua->makeupLooks()->sync(
                MakeupLook::whereIn('slug', $data['looks'])->pluck('id')
            );
            $mua->serviceDistricts()->sync(
                District::whereIn('slug', $data['districts'])->pluck('id')
            );

            // Seed Portfolios
            $photos = $portfolioPhotos[$index % count($portfolioPhotos)];
            foreach ($photos as $i => $url) {
                MuaPortfolio::firstOrCreate(
                    [
                        'mua_id'    => $mua->id,
                        'file_path' => $url,
                    ],
                    [
                        'file_type'  => 'photo',
                        'caption'    => 'Hasil makeup profesional oleh ' . $mua->name,
                        'sort_order' => $i + 1,
                    ]
                );
            }

            // Seed Packages based on MUA's event types
            foreach ($data['event_types'] as $eventSlug) {
                $eventType = EventType::where('slug', $eventSlug)->first();
                if (!$eventType) continue;

                $templates = PackageTemplate::where('event_type_id', $eventType->id)->get();
                foreach ($templates as $tpl) {
                    $price = $pricesMap[$eventSlug][$tpl->name] ?? 1000000;
                    
                    // Generate includes as custom description comma-separated
                    $includes = $tpl->includes->pluck('include_item')->toArray();
                    $customDesc = implode(', ', $includes);

                    MuaPackage::firstOrCreate(
                        [
                            'mua_id'              => $mua->id,
                            'package_template_id' => $tpl->id,
                        ],
                        [
                            'is_available'       => true,
                            'custom_description' => $customDesc,
                            'price'              => $price,
                            'notes'              => 'Harga dapat bervariasi tergantung transport dan request tambahan.',
                        ]
                    );
                }
            }

            // Regenerate Vector Biner
            app(VectorBuilderService::class)->saveForMua($mua);
        }
    }
}
