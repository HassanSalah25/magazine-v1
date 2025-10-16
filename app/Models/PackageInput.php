<?php

namespace App\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class PackageInput extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
    protected $fillable = ['language_id', 'type', 'label', 'name', 'placeholder', 'required', 'active'];

    public function package_input_options()
    {
        return $this->hasMany('App\Models\PackageInputOption');
    }

    public function language() {
      return $this->belongsTo('App\Models\Language');
    }
}
