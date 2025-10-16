<?php

namespace App\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
    public $timestamps = true;
    
    protected $fillable = [
        'language_id',
        'bcategory_id',
        'title',
        'slug',
        'content',
        'serial_number',
        'meta_keywords',
        'meta_description',
        'status'
    ];
    
    /**
     * Automatically convert slug to lowercase when setting
     */
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = $this->normalizeSlug($value);
    }

    public function bcategory() {
      return $this->belongsTo('App\Models\Bcategory');
    }

    public function language() {
      return $this->belongsTo('App\Models\Language');
    }

    public function tags() {
        return $this->belongsToMany(Tag::class,
            'blog_tags',
            'blog_id',
            'tag_id');
    }

    public function faqs() {
        return $this->hasMany(BlogFaq::class);
    }
}
