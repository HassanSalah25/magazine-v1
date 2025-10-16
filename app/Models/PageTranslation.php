<?php

namespace App\Models\Models\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class PageTranslation extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
    public $timestamps = false;
    protected $fillable = [
        'page_id',
        'locale',
        'title',
        'slug',
        'content',
        'meta_title',
        'meta_desc',
        'canonical',
        'meta_keywords',
        'redirect_url'
    ];
}
