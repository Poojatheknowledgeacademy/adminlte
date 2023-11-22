<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CountryCourse extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'country_courses');
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

}
