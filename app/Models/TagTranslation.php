<?php

namespace App\Models\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class TagTranslation extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'slug',
        'meta_title',
        'meta_desc',
        'canonical',
        'url_redirect',
    ];
}
