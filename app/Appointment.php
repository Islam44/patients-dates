<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    //
    public function admin(){
        return $this->belongsTo(Admin::class);
    }
    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function pain(){
        return $this->belongsTo(Pain::class);
    }
}
