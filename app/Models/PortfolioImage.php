<?php

namespace App\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class PortfolioImage extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
    public function portfolio() {
      return $this->belongsTo('App\Models\Portfolio');
    }
}
