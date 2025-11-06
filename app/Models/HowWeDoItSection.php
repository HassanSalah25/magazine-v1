<?php

namespace App\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class HowWeDoItSection extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
    protected $fillable = [
        'language_id',
        'title',
        'subtitle',
        'tabs'
    ];

    protected $casts = [
        'tabs' => 'array',
    ];

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
