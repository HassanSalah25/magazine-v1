<?php

namespace App\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
    protected $fillable = ['product_id','user_id','review','comment'];

    public function user() {
        return $this->hasOne('App\Models\User','id','user_id');
    }
}

