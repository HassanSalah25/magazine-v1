<?php

namespace App\Models\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class ServiceTranslation extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
    public $timestamps = false;

    protected $fillable = [
        'locale',
        'title',
        'slug',
        'meta_title',
        'meta_desc',
        'canonical',
        'meta_keywords',
        'page_tags',
        'body',
        'url_redirect',
        'featured_image',
    ];
}
