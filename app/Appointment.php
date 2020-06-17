<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = ['patient_id', 'pain_id', 'doctor_id', 'time', 'date', 'admin_id'];

    //
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function pain()
    {
        return $this->belongsTo(Pain::class);
    }

    public function scopeAppointment($query, $statue)
    {
        return $query->where('accept_by_doctor', '=', $statue)->where('accept_by_user', '=', $statue);

    }
}
