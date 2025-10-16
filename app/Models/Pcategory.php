<?php

namespace App\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class Pcategory extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
    protected $fillable = ['name','image','language_id','status','slug'];

    public function products() {
        return $this->hasMany('App\Models\Product','category_id','id');
    }

    public function language() {
        return $this->belongsTo('App\Models\Language');
    }
}
