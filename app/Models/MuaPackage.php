<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MuaPackage extends Model
{
    protected $fillable = [
        'mua_id', 'package_template_id',
        'is_available', 'custom_description', 'price', 'notes',
    ];

    protected function casts(): array
    {
        return ['is_available' => 'boolean'];
    }

    public function mua()
    {
        return $this->belongsTo(Mua::class);
    }

    public function template()
    {
        return $this->belongsTo(PackageTemplate::class, 'package_template_id');
    }

    public function getIncludeLinesAttribute(): array
    {
        if (!$this->custom_description) return [];
        return array_filter(array_map('trim', explode(',', $this->custom_description)));
    }

    public function getPriceFormattedAttribute(): string
    {
        return rupiah($this->price);
    }
}
