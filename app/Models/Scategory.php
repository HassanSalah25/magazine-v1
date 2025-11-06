<?php

namespace App\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class Scategory extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
  public $timestamps = false;

  public function services()
  {
    return $this->hasMany('App\Models\Service');
  }

  public function language()
  {
    return $this->belongsTo('App\Models\Language');
  }

    public function portfolios()
    {
        return $this->belongsToMany(Portfolio::class);
    }

    public function packages()
    {
        return $this->morphMany('App\Models\Package', 'serviceable');
    }
}

