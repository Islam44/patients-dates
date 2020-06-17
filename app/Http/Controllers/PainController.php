<?php

namespace App\Http\Controllers;

use App\Pain;
use App\Specialty;
use Illuminate\Http\Request;

class PainController extends Controller
{
    public function index(Specialty $specialty)
    {
        $pains=$specialty->pains;
        if (\request()->ajax()){
            return response()->json($pains);
        }
    }
}
