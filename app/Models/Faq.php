<?php

namespace App\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
  public $timestamps = false;

  public function faqCategory()
  {
    return $this->belongsTo('App\Models\FAQCategory', 'category_id', 'id');
  }

  public function service()
  {
    return $this->belongsTo('App\Models\Service', 'service_id', 'id');
  }
}
