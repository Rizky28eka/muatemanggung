<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageTemplateInclude extends Model
{
    protected $fillable = ['package_template_id', 'include_item', 'sort_order'];

    public function template()
    {
        return $this->belongsTo(PackageTemplate::class, 'package_template_id');
    }
}
