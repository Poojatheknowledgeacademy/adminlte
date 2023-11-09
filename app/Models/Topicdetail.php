<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Topicdetail extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'topic_id',
        'country_id',
        'heading',
        'summary',
        'detail',
        'overview',
        'whats_included',
        'pre_requisite',
        'who_should_attend',
        'added_by',
        'meta_title',
        'meta_keywords',
        'meta_description'
    ];
    // public static function boot()
    // {
    //     parent::boot();
    //     // create a event  on saving
    //     static::saving(function ($topicDetail) {
    //         $topicDetail->added_by = Auth::user()->id;
    //     });
    // }
    public function creator()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class,'topic_id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function logActivities()
    {
        return $this->morphMany(LogActivity::class, 'module');
    }
}
