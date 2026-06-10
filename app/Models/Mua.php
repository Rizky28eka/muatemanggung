<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Mua extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'address', 'logo',
        'whatsapp_number', 'instagram_username',
        'is_home_service', 'service_radius_km',
        'district_id', 'is_active', 'created_by',
    ];

    protected function casts(): array
    {
        return [
            'is_home_service' => 'boolean',
            'is_active'       => 'boolean',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (Mua $mua) {
            if (empty($mua->slug)) {
                $mua->slug = Str::slug($mua->name);
            }
        });
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function eventTypes()
    {
        return $this->belongsToMany(EventType::class, 'mua_event_types');
    }

    public function themes()
    {
        return $this->belongsToMany(Theme::class, 'mua_themes');
    }

    public function themeTypes()
    {
        return $this->belongsToMany(ThemeType::class, 'mua_theme_types');
    }

    public function makeupLooks()
    {
        return $this->belongsToMany(MakeupLook::class, 'mua_makeup_looks');
    }

    public function serviceDistricts()
    {
        return $this->belongsToMany(District::class, 'mua_districts');
    }

    public function packages()
    {
        return $this->hasMany(MuaPackage::class);
    }

    public function availablePackages()
    {
        return $this->hasMany(MuaPackage::class)->where('is_available', true);
    }

    public function portfolios()
    {
        return $this->hasMany(MuaPortfolio::class)->orderBy('sort_order');
    }

    public function photos()
    {
        return $this->hasMany(MuaPortfolio::class)->where('file_type', 'photo')->orderBy('sort_order');
    }

    public function videos()
    {
        return $this->hasMany(MuaPortfolio::class)->where('file_type', 'video')->orderBy('sort_order');
    }

    public function vector()
    {
        return $this->hasOne(MuaVector::class);
    }

    public function getWaLinkAttribute(): ?string
    {
        return wa_link($this->whatsapp_number);
    }

    public function getIgLinkAttribute(): ?string
    {
        return ig_link($this->instagram_username);
    }

    public function getLogoUrlAttribute(): string
    {
        return $this->logo
            ? asset('storage/' . $this->logo)
            : asset('images/mua-placeholder.png');
    }
}
