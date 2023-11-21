<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class CountryBlog extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'country_blog';
    protected $dates = ['deleted_at'];
}
