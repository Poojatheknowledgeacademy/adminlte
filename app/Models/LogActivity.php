<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LogActivity extends Model
{
    use HasFactory;
    protected $fillable = [
        'module_type', 'module_id', 'activity', 'created_by'
    ];
    public static function boot()
    {
        parent::boot();
        // create a event  on saving
        static::saving(function ($log) {
                $log->created_by = Auth::user()->id;
        });
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function module()
    {
        return $this->morphTo();
    }

}
