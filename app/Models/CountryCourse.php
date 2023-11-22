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
    public function course_name()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
    public function country_name()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

}
