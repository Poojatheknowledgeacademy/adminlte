<?php

namespace App\Models;

use App\Models\Blog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
class BlogDetail extends Model
{
    use HasFactory;
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'blog_id',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'summary',
        'created_by',

    ];

    public static function boot()
    {
        parent::boot();
        // create a event  on saving
        static::saving(function ($blogdetails) {
            $blogdetails->created_by = Auth::user()->id;
        });
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function blog()
    {
        return $this->belongsTo(Blog::class,'blog_id');
    }
    // public function blogname()
    // {

    //     return $this->belongsTo(Blog::class);
    // }
}
