<?php

namespace App\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class BasicExtended extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
    protected $table = 'basic_settings_extended';
    public $timestamps = false;

    public function language() {
        return $this->belongsTo('App\Models\Language');
    }
}
