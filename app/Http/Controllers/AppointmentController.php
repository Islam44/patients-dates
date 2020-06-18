<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Http\Requests\CreateAppointment;
use App\Http\Requests\UpdateAppointment;
use App\Notifications\SendNotification;
use App\Pain;
use App\Patient;
use App\Repositories\Repository;
use App\Sd;
use App\Specialty;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    protected $model;
    protected $specialtyModel;

    public function __construct(Appointment $appointment,Specialty $specialtyModel)
    {
        $this->model = new Repository($appointment);
        $this->specialtyModel=(new Repository($specialtyModel));
    }

    public function index($status='non_ready')
    {
        $appointments=$this->model->filter($status)->paginate(1);
        return view('admin',['appointments'=>$appointments,'status'=>$status]);
    }
    public function create()
    {
        $specialties=$this->specialtyModel->all();
        $notifications = auth()->user()->unreadNotifications()->get();
        return view('create_appointment', ['specialties' => $specialties, 'number' => count($notifications)]);
    }
    public function store(CreateAppointment $request)
    {
        $appointment=$this->model->create($request->only($this->model->getModel()->fillable));
        auth()->user()->patient->appointments()->save($appointment);
        return redirect()->back()->with('message', 'Your Appointment Request Send Successfully');
    }

    public function update(Request $request, $id)
    {
        $request->merge(['accept_by_user' => Sd::$waiting,'accept_by_doctor'=>Sd::$waiting]);
        $this->model->update($request->only($this->model->getModel()->fillable), $id);
        $appointment=$this->model->show($id);
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
