<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MuaPortfolio extends Model
{
    protected $fillable = ['mua_id', 'file_path', 'file_type', 'caption', 'sort_order'];

    public function mua()
    {
        return $this->belongsTo(Mua::class);
    }

    public function getUrlAttribute(): string
    {
        if (filter_var($this->file_path, FILTER_VALIDATE_URL)) {
            return $this->file_path;
        }
        return asset('storage/' . $this->file_path);
    }

    public function isPhoto(): bool
    {
        return $this->file_type === 'photo';
    }

    public function isVideo(): bool
    {
        return $this->file_type === 'video';
    }
}
