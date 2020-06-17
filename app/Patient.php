<?php

namespace App;

use App\Scopes\PatientScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Patient extends User
{
    use Notifiable;

    protected $primaryKey='user_id';
    protected $fillable=['first_name','last_name','mobile','dob','gender','country','job','user_id'];

    public function appointments(){
        return $this->hasMany(Appointment::class,'patient_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
