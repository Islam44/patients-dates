<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name','email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function appointments(){
        return $this->hasMany(Appointment::class);
    }
    public function doctor(){
        $this->hasOne(Doctor::class);
    }
    public function patient(){
        $this->hasOne(Patient::class);
    }
    public function user_type(){
        return $this->belongsTo(User_type::class,'type_id');
    }
}
