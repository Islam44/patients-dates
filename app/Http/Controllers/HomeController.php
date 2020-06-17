<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Http\Requests\CreateAppointment;
use App\Sd;
use App\Specialty;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index()
    {
       // $this->allowedPatientAction();
        $specialties = Specialty::all();
        $notifications = auth()->user()->unreadNotifications()->get();
        return view('home', ['specialties' => $specialties, 'number' => count($notifications)]);
    }

    public function RequestAppointment(CreateAppointment $request)
    {
       // $this->allowedPatientAction();
        auth()->user()->appointments()->save(new Appointment(['pain_id' => $request->pain]));
        return redirect()->back()->with('message', 'Your Appointment Request Send Successfully');
    }

    public function notifications()
    {
       // $this->allowedPatientAction();
       // $this->allowedDoctorAction();
        $authUser=auth()->user();
        if ($authUser->hasType(Sd::$doctorRole)){
            $acceptedAppointments=$authUser->doctor->appointments()->where('accept_by_doctor', '=', Sd::$accept)->where('accept_by_user', '=', Sd::$accept)->where('date','=',date("Y-m-d"))->get();
        }
        else{
            $acceptedAppointments=$authUser->patient->appointments()->where('accept_by_doctor', '=', Sd::$accept)->where('accept_by_user', '=', Sd::$accept)->where('date','=',date("Y-m-d"))->get();
        }
        $notifications = auth()->user()->unreadNotifications()->paginate(3);
        return view('notifications', ['notifications' => $notifications,'acceptedAppointments'=>$acceptedAppointments]);
    }

    public function acceptReject($decision, $id)
    {
       // $this->allowedPatientAction();
       // $this->allowedDoctorAction();
        DB::transaction(function () use ($decision, $id) {
            $notification = auth()->user()->notifications()->where('id', '=', $id)->first();
            $appointment_id = $notification['data']['appointment']['id'];
            $appointment = Appointment::find($appointment_id);
            if ($notification) {
                $notification->markAsRead();
            }
            if (auth()->user()->hasType(Sd::$userRole)) {
                $appointment->accept_by_user = $decision;
            } else {
                $appointment->accept_by_doctor = $decision;
            }
            $appointment->save();
        });
        return redirect()->back();
    }
}
