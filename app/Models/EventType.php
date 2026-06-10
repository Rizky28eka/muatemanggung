<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    protected $fillable = ['name', 'slug', 'is_siraman', 'sort_order'];

    protected function casts(): array
    {
        return ['is_siraman' => 'boolean'];
    }

    public function packageTemplates()
    {
        return $this->hasMany(PackageTemplate::class)->orderBy('sort_order');
    }

    public function muas()
    {
        return $this->belongsToMany(Mua::class, 'mua_event_types');
    }
}
