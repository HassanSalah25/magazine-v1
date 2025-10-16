<?php

namespace App\Models;

use App\Traits\TenantAware;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
    protected $guarded = [];
    public function services()
    {
        return $this->belongsToMany(Service::class,
            'service_tags',
            'tag_id',
            'service_id');
    }

    public function blogs()
    {
        return $this->belongsToMany(Blog::class);
    }
}
