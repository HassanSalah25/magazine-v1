<?php

namespace App\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class Sitemap extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
    protected $fillable = ['sitemap_url','filename'];
    protected $table    = 'sitemaps';

    public $timestamps  = false;

}
