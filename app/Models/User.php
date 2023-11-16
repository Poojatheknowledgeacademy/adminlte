<?php

namespace App\Models;

use Exception;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'created_by',
        'remember_token',
        'is_active'
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
    public function generateCode()
    {
        // $code = rand(1000, 9999);

        // UserCode::updateOrCreate(
        //     ['user_id' => auth()->user()->id],
        //     ['code' => $code]
        // );
        // try {
        //     $details = [
        //         'title' => 'your two factor authentication code is:',
        //         'code' => $code
        //     ];
        //     $message = (new SendCodeMail($details))->onQueue('emails');
        //     Mail::to(auth()->user()->email->later(now()->addSeconds(1), $message));
        // } catch (Exception $e) {
        //     info("Error" . $e->getMessage());
        // }
    }
}
