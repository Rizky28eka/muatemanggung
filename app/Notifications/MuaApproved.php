<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class MuaApproved extends Notification
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title'      => 'Akun Disetujui',
            'message'    => 'Selamat! Profil mitra Anda telah disetujui dan kini tampil di hasil rekomendasi.',
            'icon'       => 'badge-check',
            'color'      => 'emerald',
            'action_url' => route('mua.dashboard'),
        ];
    }
}
