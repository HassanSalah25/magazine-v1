<?php

namespace App\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'language_id',
        'name',
        'description',
        'image',
        'image_alt',
        'mobile_image',
        'mobile_image_alt',
        'url',
        'serial_number',
        'page_id',
        'is_google_ads',
        'google_ads_script',
        'google_ads_placement',
        'is_active',
        'start_date',
        'end_date'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_google_ads' => 'boolean',
        'is_active' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function language() {
        return $this->belongsTo('App\Models\Language');
    }

    /**
     * Scope to get only active partners
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where(function($q) {
                        $q->whereNull('start_date')
                          ->orWhere('start_date', '<=', now());
                    })
                    ->where(function($q) {
                        $q->whereNull('end_date')
                          ->orWhere('end_date', '>=', now());
                    });
    }

    /**
     * Scope to get only Google Ads partners
     */
    public function scopeGoogleAds($query)
    {
        return $query->where('is_google_ads', true);
    }

    /**
     * Get the image URL
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('assets/front/img/partners/' . $this->image);
        }
        return null;
    }

    /**
     * Get the mobile image URL
     */
    public function getMobileImageUrlAttribute()
    {
        if ($this->mobile_image) {
            return asset('assets/front/img/partners/' . $this->mobile_image);
        }
        return null;
    }

    /**
     * Get responsive image data
     */
    public function getResponsiveImageData()
    {
        return [
            'desktop' => [
                'src' => $this->image_url,
                'alt' => $this->image_alt ?? $this->name,
                'srcset' => $this->image ? asset('assets/front/img/partners/' . $this->image) : null
            ],
            'mobile' => [
                'src' => $this->mobile_image_url,
                'alt' => $this->mobile_image_alt ?? $this->name,
                'srcset' => $this->mobile_image ? asset('assets/front/img/partners/' . $this->mobile_image) : null
            ]
        ];
    }
}
