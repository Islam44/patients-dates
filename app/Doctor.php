<?php

namespace App;

use App\Scopes\DoctorScope;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Doctor extends User
{
    use Notifiable;
    protected $primaryKey='user_id';

//    protected static function boot()
//    {
//        parent::boot();
//
//        static::addGlobalScope(new DoctorScope);
//    }

    protected $fillable = [
        'specialty_id'
    ];

    public function appointments(){
        return $this->hasMany(Appointment::class);
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
