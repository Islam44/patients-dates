<?php

namespace App\Scopes;

use App\Sd;
use App\User_type;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

class AdminScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $type=User_type::where('role','=',Sd::$adminRole)->first();
        $builder->where('type_id','=',$type->id);
    }

}
