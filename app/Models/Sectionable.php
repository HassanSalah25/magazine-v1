<?php

namespace App\Models\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class Sectionable extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
    protected $fillable = ['section_id', 'sectionable_type', 'sectionable_id', 'content', 'sort_order', 'mode'];

    protected $casts = [
        'content' => 'array',
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function sectionable()
    {
        return $this->morphTo();
    }
}
