<?php

namespace App\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
    protected $fillable = [
        "product_order_id",
        "product_id",
        "user_id",
        "title",
        "sku",
        "category",
        "image",
        "summary",
        "description",
        "price",
        "previous_price",

    ];

    public function product() {
        return $this->belongsTo('App\Models\Product');
    }

}
