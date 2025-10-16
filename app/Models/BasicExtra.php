<?php

namespace App\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class BasicExtra extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
  protected $table = 'basic_settings_extra';

  public $timestamps = false;

  public function language()
  {
    return $this->belongsTo('App\Models\Language');
  }

  protected $fillable = [
    'faq_category_status',
    'gallery_category_status',
    'package_category_status',
    'comparison_title',
    'comparison_subtitle',
    'comparison_col1_title',
    'comparison_col1_features',
    'comparison_col2_title',
    'comparison_col2_features',
    'comparison_col3_title',
    'comparison_col3_features',
    'comparison_css',
    'package_banner_image'
  ];

  protected $casts = [
    'comparison_col1_features' => 'array',
    'comparison_col2_features' => 'array',
    'comparison_col3_features' => 'array'
  ];
}
