<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\EventType;
use App\Models\MakeupLook;
use App\Models\Mua;
use App\Models\Theme;
use App\Models\ThemeType;
use App\Models\User;
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

        foreach ($muas as $data) {
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
                ]
            );

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
        }
    }
}
