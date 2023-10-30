<?php

namespace App\Models;

use App\Observers\RoleObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'description',
        'is_active',
        'created_by',
    ];
    public static function boot()
    {
        parent::boot();
        Role::observe(RoleObserver::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
    public function logActivities()
    {
        return $this->morphMany(LogActivity::class, 'module');
    }
}
