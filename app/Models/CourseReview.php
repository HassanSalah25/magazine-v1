<?php

namespace App\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class CourseReview extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
  protected $fillable = [
    'user_id',
    'course_id',
    'comment',
    'rating'
  ];

  public function reviewedCourse()
  {
    return $this->belongsTo('App\Models\Course');
  }

  public function reviewByUser()
  {
    return $this->belongsTo('App\Models\User', 'user_id', 'id');
  }
}
