<?php

namespace App\Models;

use App\Traits\TenantAware;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use TenantAware;

    /**
     * The connection name for the model.
     */
    protected $connection = 'central';
    protected $fillable = ['jcategory_id', 'language_id', 'title', 'slug', 'vacancy', 'deadline', 'experience', 'job_responsibilities', 'employment_status', 'educational_requirements', 'experience_requirements', 'additional_requirements', 'job_location', 'salary', 'benefits', 'read_before_apply', 'email', 'serial_number', 'meta_keywords', 'meta_description'];

    public function jcategory() {
        return $this->belongsTo('App\Models\Jcategory');
    }

    public function language() {
        return $this->belongsTo('App\Models\Language');
    }
}
