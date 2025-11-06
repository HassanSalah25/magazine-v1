# Enhanced Sponsor Management System

## Overview
This enhanced sponsor management system provides comprehensive functionality for managing sponsors, including Google Ads integration, image handling, and advanced scheduling features.

## Features

### 1. Sponsor Management
- **Name & Description**: Full sponsor information with descriptions
- **Image Management**: Upload and manage sponsor images with alt text
- **URL Management**: Link sponsors to their websites
- **Serial Number**: Control display order
- **Active/Inactive Status**: Toggle sponsor visibility
- **Scheduling**: Set start and end dates for campaigns

### 2. Google Ads Integration
- **Google Ads Scripts**: Embed custom Google Ads scripts
- **Placement Control**: Specify where ads should appear (header, sidebar, footer, etc.)
- **Automatic Rendering**: Ads are automatically rendered based on placement
- **Caching**: Optimized performance with intelligent caching

### 3. Enhanced Admin Interface
- **Visual Management**: Card-based interface showing sponsor details
- **Quick Actions**: Toggle status, edit, and delete sponsors
- **Bulk Operations**: Manage multiple sponsors efficiently
- **Real-time Updates**: AJAX-powered status toggles

## Database Schema

### New Fields Added to Partners Table
```sql
- name (string): Sponsor name
- description (text): Sponsor description
- image_alt (string): Alt text for desktop images
- mobile_image (string): Mobile-optimized image
- mobile_image_alt (string): Alt text for mobile images
- is_google_ads (boolean): Google Ads integration flag
- google_ads_script (text): Google Ads script content
- google_ads_placement (string): Ad placement location
- is_active (boolean): Active status
- start_date (timestamp): Campaign start date
- end_date (timestamp): Campaign end date
```

## Usage

### 1. Adding a New Sponsor
1. Navigate to Admin → Sponsors
2. Click "Add Sponsor"
3. Fill in sponsor details:
   - Upload desktop image
   - Upload mobile image (optional)
   - Enter name and description
   - Set URL and serial number
   - Configure Google Ads (if applicable)
   - Set scheduling dates
4. Save sponsor

### 2. Google Ads Integration
1. Check "Google Ads Sponsor" checkbox
2. Enter Google Ads script in the textarea
3. Specify placement (e.g., "header", "sidebar", "footer")
4. The system will automatically render ads in the specified locations

### 3. Mobile Image Support
The system now supports separate images for desktop and mobile devices:
- **Desktop Image**: High-resolution image for desktop displays
- **Mobile Image**: Optimized image for mobile devices (optional)
- **Responsive Display**: Automatically serves the appropriate image based on device
- **Fallback**: If no mobile image is provided, desktop image is used

### 4. Frontend Display
Sponsors are automatically displayed in the frontend based on:
- Active status
- Date range (start_date and end_date)
- Serial number for ordering
- Responsive image selection (desktop vs mobile)

### 5. Google Ads Rendering
```php
// In your Blade templates, include:
@include('front.components.google-ads')

// For specific placements:
@include('front.components.google-ads', ['placement' => 'header'])
```

## API Endpoints

### Admin Routes
- `GET /admin/sponsors` - List all sponsors
- `POST /admin/sponsor/toggle-status` - Toggle sponsor status
- `POST /admin/partner/store` - Create new sponsor
- `POST /admin/partner/update` - Update sponsor
- `POST /admin/partner/delete` - Delete sponsor

## Services

### GoogleAdsService
The `GoogleAdsService` provides methods for:
- `getAdsForPlacement($placement, $languageId)` - Get ads for specific placement
- `getAllActiveAds($languageId)` - Get all active ads
- `renderAdsForPlacement($placement, $languageId)` - Render HTML for placement
- `getSponsorStats($languageId)` - Get sponsor statistics
- `clearCache()` - Clear cached ads

## Caching
The system uses intelligent caching to improve performance:
- Ads are cached for 5 minutes
- Cache is automatically cleared when sponsors are updated
- Different cache keys for different placements and languages

## Frontend Integration

### Template Usage
```blade
<!-- Display all sponsors with responsive images -->
@if($partners->count() > 0)
    @foreach($partners as $partner)
        @include('front.components.responsive-sponsor', ['partner' => $partner])
    @endforeach
@endif

<!-- Include Google Ads -->
@include('front.components.google-ads')
```

### Responsive Image Component
The system includes a responsive sponsor component that automatically handles:
- Desktop and mobile image optimization
- Proper alt text for accessibility
- Lazy loading for performance
- Responsive design with CSS media queries

### CSS Classes
- `.sponsor-item` - Individual sponsor container
- `.google-ads-container` - Google Ads container
- `.sponsor-description` - Sponsor description styling

## Migration
Run the migration to add new fields:
```bash
php artisan migrate
```

## Configuration
The system automatically integrates with existing language and tenant systems. No additional configuration is required.

## Best Practices

1. **Image Optimization**: Use optimized images for better performance
2. **Alt Text**: Always provide meaningful alt text for accessibility
3. **Scheduling**: Use start/end dates for time-sensitive campaigns
4. **Placement**: Be specific with Google Ads placements for better organization
5. **Caching**: The system handles caching automatically, but you can clear cache manually if needed

## Troubleshooting

### Common Issues
1. **Images not displaying**: Check file permissions in `assets/front/img/partners/`
2. **Google Ads not showing**: Verify the script is valid and placement is correct
3. **Cache issues**: Clear cache using `GoogleAdsService::clearCache()`

### Debug Mode
Enable debug mode to see detailed information about ad rendering and caching.

## Security
- All file uploads are validated for allowed extensions
- Google Ads scripts are sanitized before rendering
- CSRF protection on all admin forms
- Input validation on all fields

## Performance
- Intelligent caching reduces database queries
- Lazy loading for images
- Optimized queries with proper indexing
- Minimal JavaScript for admin interface

This enhanced sponsor system provides a robust foundation for managing sponsors and Google Ads integration while maintaining excellent performance and user experience.
