<?php

namespace App\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class RssPost extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
    protected $fillable = ['language_id','rss_feed_id','title','slug','photo','description','rss_link'];
    protected $table    = 'rss_posts';
    public $timestamps  = false;

    public function category(){
        return $this->belongsTo('App\Models\RssFeed','rss_feed_id');
    }
}
