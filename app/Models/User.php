<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'created_by'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // public static function boot()
    // {
    //     parent::boot();
    //     // create a event  on saving
    //     static::saving(function ($user) {
    //         if ($authenticatedUser = Auth::user()) {
    //             $user->created_by = Auth::user()->id;
    //         }
    //     });
    // }

    // Define the "creator" relationship

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function logActivities()
    {
        return $this->morphMany(LogActivity::class, 'module');
    }
}
