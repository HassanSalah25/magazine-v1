<?php

namespace App\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

abstract class TenantModel extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = true;

    /**
     * Get the table name without tenant prefix (for migrations)
     */
    public function getBaseTableName(): string
    {
        return parent::getTable();
    }
}
