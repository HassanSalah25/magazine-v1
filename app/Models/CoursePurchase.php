<?php

namespace App\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class CoursePurchase extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
  protected $fillable = [
    'user_id',
    'order_number',
    'first_name',
    'last_name',
    'email',
    'course_id',
    'currency_code',
    'current_price',
    'previous_price',
    'payment_method',
    'payment_status',
    'invoice'
  ];

  public function courseSellTo()
  {
    return $this->belongsTo('App\Models\User');
  }

  public function course()
  {
    return $this->hasOne('App\Models\Course', 'id', 'course_id');
  }

  public function user()
  {
    return $this->belongsTo('App\Models\User');
  }
}
