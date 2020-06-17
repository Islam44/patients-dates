<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Http\Requests\UpdateAppointment;
use App\Notifications\SendNotification;

class AppointmentController extends Controller
{

    public function index($status='waiting')
    {
        $appointments=Appointment::appointment($status)->paginate(2);
        return view('admin',['appointments'=>$appointments]);
    }

    public function update(UpdateAppointment $request, Appointment $appointment)
    {
        $appointment->update([
            'doctor_id'=>$request->doctor,
            'time'=>$request->time,
            'date'=>$request->date,
            'admin_id'=>auth()->id()
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
