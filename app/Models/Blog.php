<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'blog';
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'short_description',
        'featured_img1',
        'featured_img2',
        'author_name',
        'is_popular',
        'views_count',
        'is_active',
        'order_sequence',
        'added_date',
        'created_by',
        'country_id',
    ];

    public function creator()
    {

        return $this->belongsTo(User::class, 'created_by');
    }
    public function category()

    {

        return $this->belongsTo(Category::class);
    }

    public function slugs()
    {

        return $this->morphOne(Slug::class, 'entity');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag', 'blog_tags', 'blog_id', 'tag_id');
    }
    public function blogid()
    {
        return $this->hasMany(BlogDetail::class, 'blog_id');
    }
    public function logActivities()
    {
        return $this->morphMany(LogActivity::class, 'module');
    }
    public function countries()
    {
        return $this->belongsToMany(Country::class, 'country_blog')->withTimestamps();
    }
}
