<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Coursedetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'course_id' ,
        'country_id' ,
        'heading' ,
        'summary' ,
        'detail' ,
        'overview' ,
        'whats_included' ,
        'pre_requisite' ,
        'who_should_attend' ,
        'added_by' ,
        'meta_title' ,
        'meta_keywords' ,
        'meta_description'
    ];

    public static function boot()
    {
        parent::boot();
        // create a event  on saving
        static::saving(function ($courseDetail) {
            $courseDetail->added_by = Auth::user()->id;
        });
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
    public function logActivities()
    {
        return $this->morphMany(LogActivity::class, 'module');
    }
}
