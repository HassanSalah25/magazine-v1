<?php

namespace App\Models\Models;

use Astrotomic\Translatable\Translatable;
use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
    use Translatable;

    protected $fillable = [
        'parent_id',
        'is_indexed',
    ];

    public $translatedAttributes = [
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

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'sub_category_id');
    }
}
