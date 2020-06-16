<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Scopes\AdminScope;

class Admin extends User
{
    use Notifiable;
    protected $table='users';
   // protected $guard = 'admin';
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new AdminScope);
    }

    public function appointments(){
        return $this->hasMany(Appointment::class);
    }
}
