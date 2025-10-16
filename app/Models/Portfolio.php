<?php

namespace App\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
  protected $fillable = ['id', 'language_id', 'title', 'slug', 'start_date', 'submission_date', 'client_name', 'client_image', 'tags', 'featured_image', 'content', 'brand_content', 'service_id', 'status', 'serial_number', 'meta_keywords', 'meta_description', 'website_link'];

  public function portfolio_images()
  {
    return $this->hasMany('App\Models\PortfolioImage');
  }



  public function service()
  {
    return $this->belongsTo('App\Models\Service');
  }

  public function language()
  {
    return $this->belongsTo('App\Models\Language');
  }

    public function scategories()
    {
        return $this->belongsToMany(Scategory::class);
    }
}
