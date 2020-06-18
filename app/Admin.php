<?php

namespace App;

use App\Scopes\AdminScope;
use Illuminate\Notifications\Notifiable;

class Admin extends User
{
    use Notifiable;
    protected $table = 'users';

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new AdminScope);
    }

    public function appointments(){
        return $this->hasMany(Appointment::class);
    }
}
