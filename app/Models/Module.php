<?php

namespace App\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
  public function moduleBelongsToCourse()
  {
    return $this->belongsTo('App\Models\Course');
  }

  public function lessons()
  {
    return $this->hasMany('App\Models\Lesson');
  }
}
