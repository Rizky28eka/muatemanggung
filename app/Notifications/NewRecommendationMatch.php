<?php

namespace App\Notifications;

use App\Models\SearchLog;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewRecommendationMatch extends Notification
{
    use Queueable;

    public function __construct(public SearchLog $searchLog, public float $score)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $percentage = round($this->score);

        return [
            'title'      => 'Profil Anda Direkomendasikan',
            'message'    => "Profil Anda muncul sebagai rekomendasi teratas untuk calon klien dengan kecocokan {$percentage}%.",
            'icon'       => 'sparkles',
            'color'      => 'primary',
            'action_url' => route('mua.dashboard'),
        ];
    }
}
