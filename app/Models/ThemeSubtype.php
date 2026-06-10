<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThemeSubtype extends Model
{
    protected $fillable = ['theme_type_id', 'name', 'slug'];

    public function themeType()
    {
        return $this->belongsTo(ThemeType::class);
    }
}
