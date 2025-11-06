<?php

namespace App\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
    protected $table = "donations";
    protected $fillable = [
        'title',
        'slug',
        'content',
        'goal_amount',
        'min_amount',
        'custom_amount',
        'image',
        'meta_tags',
        'meta_description',
        'lang_id'
    ];
}
