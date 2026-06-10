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
}
