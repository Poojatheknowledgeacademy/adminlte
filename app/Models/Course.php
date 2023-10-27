<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'topic_id',
        'logo',
        'is_active',
        'slug',
        'created_by'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function Topic()
    {
        return $this->belongsTo(Topic::class);
    }
    public function slugs()
    {
        return $this->morphMany(Slug::class, 'entity');
    }
    public function faqs()
    {
        return $this->hasMany(FAQ::class, 'entity_id')->where('entity_type', 'Course');
    }
    public function logActivities()
    {
        return $this->hasMany(LogActivity::class, 'module_ref_id')->where('module', 'course');
    }
}
