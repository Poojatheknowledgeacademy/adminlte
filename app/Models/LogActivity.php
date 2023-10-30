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
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function module()
    {
        return $this->morphTo();
    }

}
