<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slug extends Model
{
    use HasFactory;

    protected $fillable = ['slug'];
    public $timestamps = false;
    
    public function entity()
    {
        return $this->morphTo();
    }


}