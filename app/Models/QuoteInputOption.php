<?php

namespace App\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class QuoteInputOption extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
    protected $fillable = ['type', 'label', 'name', 'placeholder', 'required'];

    public function quote_input() {
        return $this->belongsTo('App\Models\QuoteInput');
    }
}
