<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MakeupLook extends Model
{
    protected $fillable = ['name', 'slug'];

    public function muas()
    {
        return $this->belongsToMany(Mua::class, 'mua_makeup_looks');
    }
}
