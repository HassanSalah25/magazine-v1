<?php

namespace App\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
  protected $fillable = [
    'language_id',
    'course_category_id',
    'title',
    'current_price',
    'previous_price',
    'summary',
    'course_image',
    'video_link',
    'overview',
    'instructor_image',
    'instructor_name',
    'instructor_occupation',
    'instructor_details',
    'instructor_facebook',
    'instructor_instagram',
    'instructor_twitter',
    'instructor_linkedin',
    'duration',
    'is_featured',
    'average_rating'
  ];

  public function courseCategory()
  {
    return $this->belongsTo('App\Models\CourseCategory');
  }

  public function language()
  {
    return $this->belongsTo('App\Models\Language');
  }

  public function modules()
  {
    return $this->hasMany('App\Models\Module');
  }

  public function coursePurchase()
  {
    return $this->hasMany('App\Models\CoursePurchase');
  }

  public function review()
  {
    return $this->hasMany('App\Models\CourseReview');
  }
}
