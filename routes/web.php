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

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/notifications', 'HomeController@notifications')->name('home');
Route::get('/decision/{decision}/{id}', 'HomeController@acceptReject')->name('home');
Route::view('/', 'welcome');
Route::get('/login/admin', 'Auth\LoginController@showAdminLoginForm');
Route::get('/login/doctor', 'Auth\LoginController@showDoctorLoginForm');
Route::get('/register/admin', 'Auth\RegisterController@showAdminRegisterForm');
Route::get('/register/doctor', 'Auth\RegisterController@showDoctorRegisterForm');

Route::post('/login/admin', 'Auth\LoginController@adminLogin');
Route::post('/login/doctor', 'Auth\LoginController@doctorLogin');
Route::post('/register/admin', 'Auth\RegisterController@createAdmin');
Route::post('/register/doctor', 'Auth\RegisterController@createDoctor');

Route::view('/home', 'home')->middleware('auth');
//Route::view('/admin', 'admin')->middleware('auth:admin');
Route::view('/doctor', 'doctor')->middleware('auth:doctor');
Route::get('/admin/{status}', 'AppointmentController@index');
Route::get('/admin', 'AppointmentController@appointments');
Route::put('/update/appointment/{appointment}', 'AppointmentController@update');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/test', 'HomeController@test')->name('test');
Route::post('/request', 'HomeController@RequestAppointment')->name('request_appointment');
Route::get('/pains/{specialty}', 'PainController@index');
Route::post('/post_complete_register', 'Auth\RegisterController@completeRegister');
Route::get('/complete-register/{user}', 'Auth\RegisterController@showCompleteRegisterForm');
Route::post('/completeRegister/{user}', 'Auth\RegisterController@completeRegister')->name('complete_register');

