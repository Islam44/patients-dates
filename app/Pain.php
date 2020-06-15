<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pain extends Model
{
    protected $fillable=['description','specialty_id'];

    public function specialty(){
        return $this->belongsTo(Specialty::class);
    }
}
