<?php

namespace App\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class Permalink extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
    protected $fillable = ['permalink', 'type', 'details'];
    public $timestamps = false;
}
