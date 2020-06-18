<?php

namespace App\Http\Controllers\Auth;

use App\Admin;
use App\Doctor;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAdminRequest;
use App\Http\Requests\CreateDoctorRequest;
use App\Providers\RouteServiceProvider;
use App\Sd;
use App\Specialty;
use App\User;
use App\User_type;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest',['except'=>['showAdminRegisterForm','createAdmin']]);
        $this->middleware(['auth','admin'],['only'=>['showAdminRegisterForm','createAdmin']]);
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

    protected function createAdmin(CreateAdminRequest $request)
    {
        $type = User_type::where('role', '=', Sd::$adminRole)->first();
        $admin = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'type_id' => $type->id
        ]);
        return redirect('/admin')->with('message','Admin Created Successfully');
    }

    protected function createDoctor(CreateDoctorRequest $request)
    {
        DB::transaction(function () use ($request) {
            $type = User_type::where('role', '=', Sd::$doctorRole)->first();
            $user = User::create([
                'name' => 'Dr/' . $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'type_id' => $type->id
            ]);
            Doctor::create([
                'specialty_id' => $request['specialty'],
                'user_id' => $user->id
            ]);
        });
        return redirect('/login')->with('message','Doctor Created Successfully Please Login');
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
        $this->guard()->login($user);
        return redirect($this->redirectPath());
    }

}
