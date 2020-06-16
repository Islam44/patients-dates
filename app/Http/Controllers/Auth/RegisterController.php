<?php

namespace App\Http\Controllers\Auth;

use App\Admin;
use App\Doctor;
use App\Http\Controllers\Controller;
use App\Pain;
use App\Patient;
use App\Providers\RouteServiceProvider;
use App\Sd;
use App\Specialty;
use App\User;
use App\User_type;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/complete-register';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255','unique:users'],
            'email' => ['string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function showAdminRegisterForm()
    {
        return view('auth.register', ['url' => 'admin']);
    }

    public function showDoctorRegisterForm()
    {
        $specialties=Specialty::all();
        return view('auth.register', ['url' => 'doctor','specialties'=>$specialties]);
    }

    protected function createAdmin(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255','unique:users'],
            'email' => ['string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $type=User_type::where('role','=',Sd::$adminRole)->first();
        $admin = Admin::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'type_id'=>$type->id
        ]);

        return redirect()->intended('/login');
    }

    protected function createDoctor(Request $request)
    {
        $this->validator($request->all())->validate();
        $type=User_type::where('role','=',Sd::$doctorRole)->first();
            $user= User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'type_id'=>$type->id
            ]);
            $doctor = Doctor::create([
                'specialty_id'=>$request['specialty'],
                'user_id'=>$user->id
            ]);
        return redirect()->intended('/login');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function create(array $data)
    {
        $type=User_type::where('role','=',Sd::$userRole)->first();
        return $user= User::create([
            'name' => $data['name'],
            'password' => Hash::make($data['password']),
            'type_id'=>$type->id
        ]);

    }
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));
        return redirect($this->redirectPath().'/'.$user->id);
    }
    public function showCompleteRegisterForm(User $user){
        $pains=Pain::all();
        return view('auth.complete-register')->with(['user'=>$user,'pains'=>$pains]);
    }
    public function completeRegister(Request $request,User $user){
        $user->update(['email'=>$request->email]);
        $patient=Patient::create([
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'mobile'=>$request->mobile,
            'country'=>$request->country,
            'dob'=>$request->dob,
            'job'=>$request->job,
            'gender'=>$request->gender,
            'user_id'=>$user->id
        ]);
        Auth::login($user);
        return redirect('/home')->with('message','your form added success');
    }
}
