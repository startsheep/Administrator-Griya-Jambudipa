<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\SendEmailVerification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'phone',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($password)
    {
        return $this->attributes['password'] = bcrypt($password);
    }

    public function sendPasswordResetNotification($token)
    {
        $url = url("/auth/new-password?token=$token&email=$this->email");

        $this->notify(new SendEmailVerification($url));
    }

    public function sendActivationUserNotification($token)
    {
        $url = url("/auth/new-password?token=$token&email=$this->email");

        $this->notify(new SendEmailVerification($url));
    }


    public function document()
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function image()
    {
        return $this->hasOne(Document::class, 'documentable_id', 'id');
    }
}
