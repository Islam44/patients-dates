<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Http\Requests\CreateAppointment;
use App\Http\Requests\UpdateAppointment;
use App\Notifications\SendNotification;
use App\Repositories\Repository;
use App\Sd;
use App\Specialty;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class AppointmentController extends Controller
{
    protected $model;
    protected $specialtyModel;

    public function __construct(Appointment $appointment,Specialty $specialtyModel)
    {
        $this->middleware('auth');
        $this->middleware('admin', ['except' => ['acceptReject', 'create','store']]);
        $this->middleware('patient', ['only' => ['create','store']]);
        $this->middleware('doctorOrPatient', ['only' => ['acceptReject']]);
        $this->model = new Repository($appointment);
        $this->specialtyModel = (new Repository($specialtyModel));
    }

    public function index($status='non_ready')
    {
        $appointments=$this->model->filter($status)->paginate(5);
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

    public function update(UpdateAppointment $request, $id)
    {
        $request->merge(['accept_by_user' => Sd::$waiting,'accept_by_doctor'=>Sd::$waiting,'admin_id'=>auth()->id()]);
        $this->model->update($request->only($this->model->getModel()->fillable), $id);
        $appointment=$this->model->show($id);
        $this->sendNotification($appointment);
        return redirect()->back()->with('message', 'Appointment Completely Updated ');
    }

    public function sendNotification($appointment)
    {
        $notification = new SendNotification($appointment);
        $doctor = $appointment->doctor->user;
        $patient = $appointment->patient->user;
        $doctor->notify($notification);
        $patient->notify($notification);
    }

    public function acceptReject($decision, $id)
    {
        DB::transaction(function () use ($decision, $id) {
            $notification = auth()->user()->notifications()->where('id', '=', $id)->first();
            if ($notification&&$decision==Sd::$reject) {
                $this->markTwoUsersAsRead($notification);
            }
            else{
                if ($notification){
                    $notification->markAsRead();
                }
            }
            $appointment_id = $notification['data']['appointment']['id'];
            $appointment = $this->model->show($appointment_id);
            if (auth()->user()->hasType(Sd::$userRole)) {
                $appointment->accept_by_user = $decision;
            } else {
                $appointment->accept_by_doctor = $decision;
            }
            $appointment->save();
        });
        return redirect()->back();
    }

    private function markTwoUsersAsRead($notification)
    {
            $data=$notification->data;
            $identifier=$data['identifier'];
            $patient_id=$data['appointment']['patient_id'];
            $this->markNotificationAsRead($patient_id,$identifier);
            $doctor_id=$data['appointment']['doctor_id'];
            $this->markNotificationAsRead($doctor_id,$identifier);
    }

    private function markNotificationAsRead($id,$identifier)
    {
        $user=User::find($id);
        $notification=$user->unreadNotifications()->where('identifier', '=', $identifier)->first();
        if ($notification){
            $notification->markAsRead();
        }
    }
}
