<?php

namespace App\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
  protected $table = 'feedbacks';

  protected $fillable = [
    'name',
    'email',
    'subject',
    'rating',
    'feedback'
  ];
}
