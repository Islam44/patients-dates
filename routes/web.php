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

Route::get('/home', 'UserController@index');
Route::get('/edit/info', 'UserController@edit');
Route::put('/update/info', 'UserController@update');
Route::post('/completeRegister', 'UserController@store')->name('complete_register');
Route::get('/notifications', 'UserController@notifications');

Route::get('/create_appointment', 'AppointmentController@create');
Route::get('/decision/{decision}/{id}', 'AppointmentController@acceptReject');
Route::post('/request', 'AppointmentController@store')->name('request_appointment');
Route::get('/admin/{status}', 'AppointmentController@index');
Route::get('/admin', 'AppointmentController@index');
Route::put('/update/appointment/{appointment}', 'AppointmentController@update');

Route::get('/pains/specialty/{specialty}', 'PainController@pains');

Route::resource('specialties', 'SpecialtyController',['except' => [ 'show' ]]);
Route::resource('pains', 'PainController',['except' => [ 'show' ]]);

Route::fallback(function () {
    return redirect("/");
});
