<?php

namespace App\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
  public $timestamps = false;

  public function scategory()
  {
    return $this->belongsTo('App\Models\Scategory');
  }

  public function portfolios()
  {
    return $this->hasMany('App\Models\Portfolio');
  }

  public function language()
  {
    return $this->belongsTo('App\Models\Language');
  }

    public function tags()
    {
        return $this->belongsToMany(Tag::class,
            'service_tags',
            'service_id',
            'tag_id');
  }

    public function statistics()
    {
        return $this->hasMany('App\Models\Statistic', 'service_id', 'id');
    }

    public function packages()
    {
        return $this->morphMany('App\Models\Package', 'serviceable');
    }

    public function faqs()
    {
        return $this->hasMany('App\Models\Faq', 'service_id', 'id');
    }
}
