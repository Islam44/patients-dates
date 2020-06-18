<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompleteRegisterRequest;
use App\Http\Requests\UpdateInfoRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Patient;
use App\Repositories\Repository;
use App\Sd;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    protected $model;

    public function __construct(Patient $patient)
    {
        $this->middleware('auth');
        $this->middleware('patient',['except'=>['notifications']]);
        $this->middleware('doctorOrPatient', ['only' => ['notifications']]);
        $this->model = new Repository($patient);
    }

    public function index()
    {
        $user = Auth::user();
        if ($user->email) {
            return redirect('/create_appointment');
        }
        return view('home',['user'=>$user]);
    }

    public function store(CompleteRegisterRequest $request)
    {
        DB::transaction(function () use($request){
            $user = Auth::user();
            $user->update(['email' => $request->email]);
            $request->merge(['user_id' => $user->id]);
            $this->model->create($request->only($this->model->getModel()->fillable));
        });
        return redirect('/create_appointment')->with('message', 'your Information Is Added');
    }

    public function edit()
    {
        $user = Auth::user();
        return view('edit_info', ['user' => $user]);
    }

    public function update(UpdateInfoRequest $request)
    {
        DB::transaction(function ()use($request){
            $user = Auth::user();
            $user->update(['email' => $request->email]);
            $this->model->update($request->only($this->model->getModel()->fillable), $user->id);
        });
        return redirect('/create_appointment')->with('message', 'Profile updated done');

    }

    public function notifications()
    {
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
}
