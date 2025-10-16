<?php

namespace App\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class PackageCategory extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
  protected $table = 'package_categories';

  protected $fillable = [
    'language_id',
    'name',
    'status',
    'show_in_home',
    'serial_number'
  ];

  public function packageCategoryLang()
  {
    return $this->belongsTo('App\Models\Language');
  }

  public function packageList()
  {
    return $this->hasMany('App\Models\Package', 'category_id', 'id');
  }
}
