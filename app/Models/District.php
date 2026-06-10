<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = ['name', 'slug'];

    public function muas()
    {
        return $this->hasMany(Mua::class);
    }

    public function serviceMuas()
    {
        return $this->belongsToMany(Mua::class, 'mua_districts');
    }
}
