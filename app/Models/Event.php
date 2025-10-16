<?php

namespace App\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
    protected $table ='events';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'date',
        'time',
        'cost',
        'available_tickets',
        'organizer',
        'organizer_email',
        'organizer_phone',
        'organizer_website',
        'venue',
        'venue_location',
        'venue_phone',
        'meta_tags',
        'meta_description',
        'image',
        'video',
        'lang_id',
        'cat_id',
    ];
    public function eventCategories(){
        return $this->belongsTo(EventCategory::class,'cat_id','id');
    }
}
