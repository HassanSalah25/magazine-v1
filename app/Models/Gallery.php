<?php

namespace App\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
  public function language()
  {
    return $this->belongsTo('App\Models\Language');
  }

  public function galleryImgCategory()
  {
    return $this->belongsTo('App\Models\GalleryCategory', 'category_id', 'id');
  }
}
