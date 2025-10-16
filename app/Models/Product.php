<?php

namespace App\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
    protected $fillable = [
        'title',
        'slug',
        'language_id',
        'stock',
        'sku',
        'category_id',
        'tags',
        'feature_image',
        'summary',
        'description',
        'current_price',
        'previous_price',
        'rating',
        'status',
        'meta_keywords',
        'meta_description',
        'type',
        'download_link',
        'download_file'
    ];
    
    /**
     * Automatically convert slug to lowercase when setting
     */
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = $this->normalizeSlug($value);
    }

    public function category() {
        return $this->hasOne('App\Models\Pcategory','id','category_id');
    }

    public function product_images() {
        return $this->hasMany('App\Models\ProductImage');
    }

    public function language() {
        return $this->belongsTo('App\Models\Language');
    }
}
