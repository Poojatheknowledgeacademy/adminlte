<?php

namespace App\Models;

use App\Models\Slug;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'tka_id',
        'name', // Add 'name' to the fillable array
        'slug',
        'icon',
        'logo',
        'is_active',
        'is_popular',
        'is_technical',
        'created_by',
    ];

    // public static function boot()
    // {
    //     parent::boot();
    //     // create a event  on saving
    //     static::saving(function ($category) {
    //         $category->created_by = Auth::user()->id;
    //     });
    // }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function slugs()
    {
        return $this->morphMany(Slug::class, 'entity');
    }
    public function topics()
    {
        return $this->hasMany(Topic::class, 'category_id');
    }
    public function faqs()
    {
        return $this->hasMany(FAQ::class, 'entity_id')->where('entity_type', 'Course');
    }
    public function logActivities()
    {
        return $this->morphMany(LogActivity::class, 'module');
    }
    public function countries()
    {
        return $this->belongsToMany(Country::class, 'category_country');
    }

}
