<?php

namespace App\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class ShippingCharge extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
    protected $fillable = ['title','text','language_id','charge'];

    public function language() {
        return $this->belongsTo('App\Models\Language');
    }
}
