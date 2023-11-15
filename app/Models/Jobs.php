<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jobs extends Model
{
    use HasFactory;
    protected $dates = ['deleted_at'];
    protected $table = 'jobs';
    protected $fillable = [

        'name',
        'attempts',
        'payload',
        'available_at',
        'created_at',
    ];

    public function creator()
    {
       // return $this->belongsTo(User::class, 'created_by');
    }
}
