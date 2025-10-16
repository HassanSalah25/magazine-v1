<?php

namespace App\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class PackageOrder extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
    protected $fillable = ['user_id', 'package_id', 'order_number', 'name', 'email', 'fields', 'nda', 'package_title', 'package_price', 'status', 'package_description', 'invoice', 'method', 'receipt', 'payment_status', 'gateway_type'];

    public function package() {
        return $this->belongsTo('App\Models\Package');
    }
}
