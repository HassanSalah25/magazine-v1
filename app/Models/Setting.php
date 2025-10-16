<?php

namespace App\Models\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
    protected $fillable = ['language_id','key', 'value','type'];
}
