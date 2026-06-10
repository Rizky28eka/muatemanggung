<?php

namespace App\Http\Controllers\Mua;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        if (!auth()->user()->isMua()) {
            abort(403, 'Unauthorized.');
        }

        $mua = auth()->user()->mua()->with([
            'packages.template.eventType', 'portfolios', 'vector',
            'eventTypes', 'serviceDistricts', 'makeupLooks', 'district',
        ])->firstOrFail();

        $stats = [
            'packages'      => $mua->packages->count(),
            'available_pkg' => $mua->packages->where('is_available', true)->count(),
            'portfolios'    => $mua->portfolios->count(),
            'has_vector'    => $mua->vector !== null,
            'is_active'     => $mua->is_active,
        ];

        $isWaValid = (bool) preg_match('/^(62|0)\d{8,15}$/', (string) $mua->whatsapp_number);

        $checklist = [
            [
                'label'  => 'Nomor WhatsApp Valid',
                'desc'   => $isWaValid ? 'Format: ' . $mua->whatsapp_number : 'Belum diisi atau format tidak valid',
                'done'   => $isWaValid,
                'action' => route('mua.profile.edit'),
            ],
            [
                'label'  => 'Logo / Foto Profil',
                'desc'   => $mua->logo ? 'Logo sudah diunggah' : 'Belum mengunggah logo usaha',
                'done'   => (bool) $mua->logo,
                'action' => route('mua.profile.edit'),
            ],
            [
                'label'  => 'Deskripsi Usaha',
                'desc'   => $mua->description ? 'Deskripsi sudah dilengkapi' : 'Belum ada deskripsi usaha',
                'done'   => filled($mua->description),
                'action' => route('mua.profile.edit'),
            ],
            [
                'label'  => 'Spesialisasi Acara & Look',
                'desc'   => $mua->eventTypes->count() . ' jenis acara, ' . $mua->makeupLooks->count() . ' makeup look dipilih',
                'done'   => $mua->eventTypes->isNotEmpty() && $mua->makeupLooks->isNotEmpty(),
                'action' => route('mua.profile.edit'),
            ],
            [
                'label'  => 'Radius & Area Layanan',
                'desc'   => $mua->is_home_service
                    ? "Home service aktif, radius {$mua->service_radius_km} km, " . $mua->serviceDistricts->count() . ' kecamatan'
                    : 'Home service belum diaktifkan',
                'done'   => $mua->is_home_service && $mua->serviceDistricts->isNotEmpty(),
                'action' => route('mua.location.edit'),
            ],
            [
                'label'  => 'Paket Layanan',
                'desc'   => $stats['packages'] > 0
                    ? "{$stats['available_pkg']} dari {$stats['packages']} paket tersedia"
                    : 'Belum ada paket layanan terdaftar',
                'done'   => $stats['available_pkg'] > 0,
                'action' => route('mua.packages.index'),
            ],
            [
                'label'  => 'Portofolio Karya',
                'desc'   => $stats['portfolios'] > 0
                    ? "{$stats['portfolios']} karya diunggah"
                    : 'Belum ada foto/video portofolio',
                'done'   => $stats['portfolios'] > 0,
                'action' => route('mua.portfolio.index'),
            ],
            [
                'label'  => 'Vektor Similarity Aktif',
                'desc'   => $stats['has_vector'] ? 'Tersinkronisasi otomatis' : 'Belum tersinkronisasi',
                'done'   => $stats['has_vector'],
                'action' => null,
            ],
        ];

        $completion = (int) round(
            collect($checklist)->where('done', true)->count() / count($checklist) * 100
        );

        // Recent activity feed: profile updates, package changes, portfolio uploads
        $activity = collect();

        $activity->push([
            'title' => 'Profil usaha diperbarui',
            'time'  => $mua->updated_at,
        ]);

        foreach ($mua->packages->sortByDesc('updated_at')->take(3) as $pkg) {
            $activity->push([
                'title' => "Paket \"{$pkg->template->name}\" " . ($pkg->wasRecentlyCreated ? 'ditambahkan' : 'diperbarui'),
                'time'  => $pkg->updated_at,
            ]);
        }

        foreach ($mua->portfolios->sortByDesc('created_at')->take(3) as $port) {
            $activity->push([
                'title' => 'Portofolio baru: ' . ($port->caption ?: ucfirst($port->file_type)),
                'time'  => $port->created_at,
            ]);
        }

        $activity = $activity
            ->filter(fn ($a) => $a['time'] !== null)
            ->sortByDesc('time')
            ->take(5)
            ->values();

        return view('mua.dashboard', compact('mua', 'stats', 'checklist', 'completion', 'activity'));
    }
}
