<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageTemplate extends Model
{
    protected $fillable = ['event_type_id', 'name', 'description', 'sort_order'];

    public function eventType()
    {
        return $this->belongsTo(EventType::class);
    }

    public function includes()
    {
        return $this->hasMany(PackageTemplateInclude::class)->orderBy('sort_order');
    }

    public function muaPackages()
    {
        return $this->hasMany(MuaPackage::class);
    }
}
