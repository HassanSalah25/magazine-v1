<?php

namespace App\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class Popup extends Model
{
    use TenantAware;

    public function language() {
        return $this->belongsTo('App\Models\Language');
    }
}
