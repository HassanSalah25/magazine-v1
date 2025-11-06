<?php

namespace App\Models\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;
use JoeDixon\Translation\Translation as BaseTranslation;

class Translation extends BaseTranslation
{
    protected $fillable = [
        'language_id',
        'group',
        'key',
        'value'
    ];
}
