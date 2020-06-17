<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Appointment;
use App\Doctor;
use App\Pain;
use App\Patient;
use App\Specialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use PhpParser\Comment\Doc;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $specialties=Specialty::all();
        return view('home',['specialties'=>$specialties]);
    }
    public function RequestAppointment(Request $request)
    {
        $request->validate(['pain'=>'required']);
        auth()->user()->appointments()->save(new Appointment(['pain_id'=>$request->pain]));
        return redirect()->back()->with('message','Your Appointment Request Send Successfully');
    }

}
