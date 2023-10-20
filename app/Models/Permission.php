<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'is_active',
        'guard_name',
        'module_id'
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
