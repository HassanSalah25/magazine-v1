<?php

namespace App\Services;

use App\Models\Partner;
use Illuminate\Support\Facades\Cache;

class GoogleAdsService
{
    /**
     * Get Google Ads scripts for a specific placement
     */
    public function getAdsForPlacement($placement, $languageId = null)
    {
        $cacheKey = "google_ads_{$placement}_" . ($languageId ?? 'default');
        
        return Cache::remember($cacheKey, 300, function () use ($placement, $languageId) {
            $query = Partner::where('is_google_ads', true)
                          ->where('is_active', true)
                          ->where(function($q) {
                              $q->whereNull('start_date')
                                ->orWhere('start_date', '<=', now());
                          })
                          ->where(function($q) {
                              $q->whereNull('end_date')
                                ->orWhere('end_date', '>=', now());
                          });

            if ($languageId) {
                $query->where('language_id', $languageId);
            }

            if ($placement) {
                $query->where('google_ads_placement', $placement);
            }

            return $query->orderBy('serial_number', 'ASC')->get();
        });
    }

    /**
     * Get all active Google Ads
     */
    public function getAllActiveAds($languageId = null)
    {
        $cacheKey = "all_google_ads_" . ($languageId ?? 'default');
        
        return Cache::remember($cacheKey, 300, function () use ($languageId) {
            $query = Partner::where('is_google_ads', true)
                          ->where('is_active', true)
                          ->where(function($q) {
                              $q->whereNull('start_date')
                                ->orWhere('start_date', '<=', now());
                          })
                          ->where(function($q) {
                              $q->whereNull('end_date')
                                ->orWhere('end_date', '>=', now());
                          });

            if ($languageId) {
                $query->where('language_id', $languageId);
            }

            return $query->orderBy('serial_number', 'ASC')->get();
        });
    }

    /**
     * Clear Google Ads cache
     */
    public function clearCache()
    {
        $patterns = [
            'google_ads_*',
            'all_google_ads_*'
        ];

        foreach ($patterns as $pattern) {
            Cache::forget($pattern);
        }
    }

    /**
     * Render Google Ads HTML for a specific placement
     */
    public function renderAdsForPlacement($placement, $languageId = null)
    {
        $ads = $this->getAdsForPlacement($placement, $languageId);
        
        if ($ads->isEmpty()) {
            return '';
        }

        $html = '<div class="google-ads-container" data-placement="' . $placement . '">';
        
        foreach ($ads as $ad) {
            if ($ad->google_ads_script) {
                $html .= $ad->google_ads_script;
            }
        }
        
        $html .= '</div>';
        
        return $html;
    }

    /**
     * Get sponsor statistics
     */
    public function getSponsorStats($languageId = null)
    {
        $query = Partner::query();
        
        if ($languageId) {
            $query->where('language_id', $languageId);
        }

        return [
            'total' => $query->count(),
            'active' => $query->where('is_active', true)->count(),
            'google_ads' => $query->where('is_google_ads', true)->count(),
            'expired' => $query->where('end_date', '<', now())->count(),
        ];
    }
}
