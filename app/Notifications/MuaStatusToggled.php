<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class MuaStatusToggled extends Notification
{
    use Queueable;

    public function __construct(public bool $isActive)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        if ($this->isActive) {
            return [
                'title'      => 'Akun Diaktifkan',
                'message'    => 'Akun mitra Anda telah diaktifkan kembali oleh admin dan tampil di hasil rekomendasi.',
                'icon'       => 'toggle-right',
                'color'      => 'emerald',
                'action_url' => route('mua.dashboard'),
            ];
        }

        return [
            'title'      => 'Akun Dinonaktifkan',
            'message'    => 'Akun mitra Anda telah dinonaktifkan sementara oleh admin dan tidak tampil di hasil rekomendasi.',
            'icon'       => 'toggle-left',
            'color'      => 'rose',
            'action_url' => route('mua.dashboard'),
        ];
    }
}
