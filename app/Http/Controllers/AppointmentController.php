<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Http\Requests\CreateAppointment;
use App\Http\Requests\UpdateAppointment;
use App\Notifications\SendNotification;
use App\Sd;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function __construct()
    {
    }


    public function index($status='non_ready')
    {
        $appointments=Appointment::appointment($status)->paginate(2);
        return view('admin',['appointments'=>$appointments,'status'=>$status]);
    }

    public function update(UpdateAppointment $request, Appointment $appointment)
    {
            $appointment->update([
                'doctor_id'=>$request->doctor,
                'time'=>$request->time,
                'date'=>$request->date,
                'admin_id'=>auth()->id(),
                'accept_by_user'=>Sd::$waiting,
                'accept_by_doctor'=>Sd::$waiting,
            ]);

        $this->sendNotification($appointment);
        return  redirect()->back()->with('message','Appointment Completely Created ');
    }

    public function sendNotification($appointment){
        $notification=new SendNotification($appointment);
        $doctor=$appointment->doctor->user;
        $patient=$appointment->patient->user;
        $doctor->notify($notification);
        $patient->notify($notification);
    }
}
