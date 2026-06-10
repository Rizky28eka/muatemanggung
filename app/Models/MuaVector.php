<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MuaVector extends Model
{
    public $timestamps = false;

    protected $fillable = ['mua_id', 'vector_data', 'updated_at'];

    protected function casts(): array
    {
        return [
            'vector_data' => 'array',
            'updated_at'  => 'datetime',
        ];
    }

    public function mua()
    {
        return $this->belongsTo(Mua::class);
    }
}
