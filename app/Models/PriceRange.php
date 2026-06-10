<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceRange extends Model
{
    protected $fillable = ['label', 'min_price', 'max_price', 'sort_order'];
}
