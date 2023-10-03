<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Topic extends Model
{

    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name', // Add 'name' to the fillable array
        'logo',
        'slug',
        'category_id',
        'is_active',
        'created_by',
    ];


    public static function boot()
    {
        parent::boot();
        // create a event  on saving
        static::saving(function ($topic) {
            $topic->created_by = Auth::user()->id;
        });
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function slugs()
    {
        return $this->morphMany(Slug::class, 'entity');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
