<?php

namespace App\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
  public function articleCategory() {
    return $this->belongsTo('App\Models\ArticleCategory');
  }

  public function language() {
    return $this->belongsTo('App\Models\Language');
  }
}
