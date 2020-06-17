<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/register/admin', 'Auth\RegisterController@showAdminRegisterForm');
Route::get('/register/doctor', 'Auth\RegisterController@showDoctorRegisterForm');
Route::post('/register/admin', 'Auth\RegisterController@createAdmin');
Route::post('/register/doctor', 'Auth\RegisterController@createDoctor');
Route::get('/complete-register/{user}', 'Auth\RegisterController@showCompleteRegisterForm');
Route::post('/completeRegister/{user}', 'Auth\RegisterController@completeRegister')->name('complete_register');

Route::get('/home', 'HomeController@index');
Route::get('/notifications', 'HomeController@notifications');
Route::get('/decision/{decision}/{id}', 'HomeController@acceptReject');
Route::post('/request', 'HomeController@RequestAppointment')->name('request_appointment');

Route::get('/admin/{status}', 'AppointmentController@index');
Route::get('/admin', 'AppointmentController@index');
Route::put('/update/appointment/{appointment}', 'AppointmentController@update');

Route::get('/pains/specialty/{specialty}', 'PainController@pains');

Route::resource('specialties', 'SpecialtyController');
Route::resource('pains', 'PainController');
