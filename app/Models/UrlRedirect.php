<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrlRedirect extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'source_url',
        'redirect_url'
    ];
}
