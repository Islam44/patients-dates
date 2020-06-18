<?php

namespace App;


class Patient extends User
{
    protected $primaryKey='user_id';
    protected $fillable=['first_name','last_name','mobile','dob','gender','country','job','user_id'];

    public function appointments(){
        return $this->hasMany(Appointment::class,'patient_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
