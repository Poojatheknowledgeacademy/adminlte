<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    use HasFactory;
    protected $fillable = [
        'subject', 'url', 'method', 'ip', 'agent', 'user_id','module','module_ref_id'
    ];
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
