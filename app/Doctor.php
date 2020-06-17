<?php

namespace App;
use Illuminate\Notifications\Notifiable;

class Doctor extends User
{
    use Notifiable;
    protected $primaryKey='user_id';
    protected $fillable = [
        'specialty_id', 'user_id'
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class,'doctor_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function specialty()
    {
        return $this->belongsTo(Specialty::class, 'user_id');
    }
}
