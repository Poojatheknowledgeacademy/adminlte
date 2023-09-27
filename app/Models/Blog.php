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

        'summary',

        'featured_img1',

        'featured_img2',

        'author_name',

        'is_popular',

        'views_count',

        'order_sequence',

        'added_date',
        'created_by',

    ];
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function category()

    {

        return $this->belongsTo(Category::class);
    }

    public function slugs()
     {

        return $this->morphMany(Slug::class, 'entity');
    }

    public function tags(){
      return $this->belongsToMany('App\Models\Tag','blog_tags','blog_id','tag_id');
     }
}
