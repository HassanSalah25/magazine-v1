<?php

namespace App\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class DynamicSection extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
    
    protected $fillable = [
        'name',
        'template_type',
        'description',
        'is_active',
        'sort_order',
        'page_type'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function posts()
    {
        return $this->belongsToMany(Blog::class, 'dynamic_section_posts')
                    ->withPivot('sort_order', 'is_featured')
                    ->orderBy('dynamic_section_posts.sort_order');
    }

    public function featuredPost()
    {
        return $this->posts()->wherePivot('is_featured', true)->first();
    }

    public function regularPosts()
    {
        return $this->posts()->wherePivot('is_featured', false);
    }

    // H
}
