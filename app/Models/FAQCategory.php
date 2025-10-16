<?php

namespace App\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class FAQCategory extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
  protected $table = 'faq_categories';

  protected $fillable = [
    'language_id',
    'name',
    'status',
    'serial_number'
  ];

  public function faqCategoryLang()
  {
    return $this->belongsTo('App\Models\Language');
  }

  public function frequentlyAskedQuestion()
  {
    return $this->hasMany('App\Models\Faq', 'category_id', 'id');
  }
}
