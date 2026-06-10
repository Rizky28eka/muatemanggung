<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SearchLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'session_id', 'preference_data',
        'top1_mua_id', 'top2_mua_id', 'top3_mua_id',
        'similarity_scores', 'searched_at',
    ];

    protected function casts(): array
    {
        return [
            'preference_data'  => 'array',
            'similarity_scores' => 'array',
            'searched_at'      => 'datetime',
        ];
    }

    public function top1() { return $this->belongsTo(Mua::class, 'top1_mua_id'); }
    public function top2() { return $this->belongsTo(Mua::class, 'top2_mua_id'); }
    public function top3() { return $this->belongsTo(Mua::class, 'top3_mua_id'); }

    public function getScore1Attribute(): ?float { return $this->similarity_scores[0]['score'] ?? null; }
    public function getScore2Attribute(): ?float { return $this->similarity_scores[1]['score'] ?? null; }
    public function getScore3Attribute(): ?float { return $this->similarity_scores[2]['score'] ?? null; }

    public function getDistrictNameAttribute(): ?string
    {
        $id = $this->preference_data['district_id'] ?? null;
        return $id ? \App\Models\District::find($id)?->name : null;
    }

    public function getEventTypeNameAttribute(): ?string
    {
        $id = $this->preference_data['event_type_id'] ?? null;
        return $id ? \App\Models\EventType::find($id)?->name : null;
    }

    public function getThemeNameAttribute(): ?string
    {
        $id = $this->preference_data['theme_id'] ?? null;
        return $id ? \App\Models\Theme::find($id)?->name : null;
    }

    public function getThemeTypeNameAttribute(): ?string
    {
        $id = $this->preference_data['theme_type_id'] ?? null;
        return $id ? \App\Models\ThemeType::find($id)?->name : null;
    }

    public function getMakeupLookNameAttribute(): ?string
    {
        $id = $this->preference_data['makeup_look_id'] ?? null;
        return $id ? \App\Models\MakeupLook::find($id)?->name : null;
    }

    public function getPriceRangeLabelAttribute(): ?string
    {
        $id = $this->preference_data['price_range_id'] ?? null;
        return $id ? \App\Models\PriceRange::find($id)?->label : null;
    }

    public function getWantsHomeServiceAttribute(): bool
    {
        return (bool) ($this->preference_data['wants_home_service'] ?? false);
    }
}
