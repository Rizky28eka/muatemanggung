<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThemeType extends Model
{
    protected $fillable = ['theme_id', 'name', 'slug'];

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    public function subtypes()
    {
        return $this->hasMany(ThemeSubtype::class);
    }

    public function muas()
    {
        return $this->belongsToMany(Mua::class, 'mua_theme_types');
    }
}
