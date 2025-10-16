<?php

namespace App\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class BlogFaq extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';

    protected $fillable = [
        'blog_id',
        'question',
        'answer',
        'serial_number'
    ];

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
