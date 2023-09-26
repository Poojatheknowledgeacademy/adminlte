<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Tag extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'created_by',
        'is_active'
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

}
