<?php

namespace App\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
    public function current_package() {
        return $this->belongsTo('App\Models\Package', 'current_package_id');
    }

    public function next_package() {
        return $this->belongsTo('App\Models\Package', 'next_package_id');
    }

    public function pending_package() {
        return $this->belongsTo('App\Models\Package', 'pending_package_id');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
