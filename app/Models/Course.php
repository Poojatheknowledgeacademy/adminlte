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
        return $this->morphOne(Slug::class, 'entity');
    }
    public function faqs()
    {
        return $this->morphMany(Faq::class, 'entity');
    }
    public function logActivities()
    {
        return $this->morphMany(LogActivity::class, 'module');
    }

}
