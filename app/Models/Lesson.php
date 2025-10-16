<?php

namespace App\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
  public function lessonBelongsToModule()
  {
    return $this->belongsTo('App\Models\Module');
  }
}
