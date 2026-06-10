<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $fillable = ['name', 'slug'];

    public function themeTypes()
    {
        return $this->hasMany(ThemeType::class);
    }

    public function muas()
    {
        return $this->belongsToMany(Mua::class, 'mua_themes');
    }
}
