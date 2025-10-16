<?php

namespace App\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class GalleryCategory extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
  protected $fillable = [
    'language_id',
    'name',
    'status',
    'serial_number'
  ];

  public function galleryCategoryLang()
  {
    return $this->belongsTo('App\Models\Language');
  }

  public function galleryImg()
  {
    return $this->hasMany('App\Models\Gallery', 'category_id', 'id');
  }
}
