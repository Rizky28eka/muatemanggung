<?php

namespace App\Notifications;

use App\Models\Mua;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewMuaRegistration extends Notification
{
    use Queueable;

    public function __construct(public Mua $mua)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title'      => 'Pendaftaran Mitra Baru',
            'message'    => "{$this->mua->name} mendaftar sebagai mitra MUA dan menunggu persetujuan.",
            'icon'       => 'user-plus',
            'color'      => 'amber',
            'action_url' => route('admin.mua.show', $this->mua),
        ];
    }
}
