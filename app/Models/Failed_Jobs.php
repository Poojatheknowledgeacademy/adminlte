<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Failed_Jobs extends Model
{
    use HasFactory;

    protected $table = 'failed_jobs';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'uuid',
        'connection',
        'Name',
        'payload',
        'exception',
        'failed_at',
    ];

    public function creator()
    {
      //  return $this->belongsTo(User::class, 'created_by');
    }
}
