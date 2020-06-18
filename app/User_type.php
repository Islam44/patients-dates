<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_type extends Model
{
    protected $fillable=['role'];

    public function users(){
        return $this->hasMany(User::class);
    }
}
