<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    protected $fillable = ['name'];

    public function pains()
    {
        return $this->hasMany(Pain::class);
    }

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

}
