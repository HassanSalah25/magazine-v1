<?php

namespace App\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
    protected $table = 'event_categories';

    protected $fillable = [
        'name',
        'slug',
        'status',
        'lang_id',
    ];

    public function events(){
        return $this->hasMany(Event::class,'cat_id','id');
    }
}
