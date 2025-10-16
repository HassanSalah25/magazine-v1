<?php

namespace App\Models\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class ServiceCategoryTranslation extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
    public $timestamps = false;

    protected $fillable = [
        'title',
        'slug',
        'meta_title',
        'meta_desc',
        'canonical',
        'meta_keywords',
        'body',
        'url_redirect',
        'featured_image',
    ];
}
