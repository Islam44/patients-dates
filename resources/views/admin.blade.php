@extends('layouts.app')

@section('content')
    <div class="row">
    <div class="col-md-2">

        <div class="fixed-section affix" data-spy="affix" data-offset-top="400">
            <ul style="list-style-type: none">

                <h4 class="bd-toc-link">Appointment Management</h4>

                <li>
                    <a href="/admin/waiting">Waiting Appointments</a>
                </li>
                <li>
                    <a href="/admin/reject">Rejected Appointments</a>
                </li>
                <li>
                    <a href="/admin/accept">Accepted Appointments</a>
                </li>

            </ul>
        </div>
    </div>
    <div class="col-md-10">
        @if (session('message'))
            <div class="alert alert-success " role="alert">
                {{ session('message') }}
            </div>
        @endif
        <div class="table-responsive table-full-width">
            <table class="table table-hover table-striped">
                <thead>
                <th>Patient Name</th>
                <th>Pain Description</th>
                <th>Doctor</th>
                <th>Time</th>
                <th>Date</th>
                <th>Accept by Doctor</th>
                <th>Accept by Patient</th>
                <th>action</th>

                </thead>
                <tbody>
                @foreach($appointments as $appointment)
                    <tr>
                        <form method="post" action="/update/appointment/{{$appointment->id}}}">
                            @csrf
                            @METHOD('PUT')
                    <td>{{$appointment->patient->first_name}} {{$appointment->patient->last_name}}</td>
                    <td>{{$appointment->pain->description}}</td>
                    <td>   <select class="form-control " id="painsList" name="doctor">
                            @if($appointment->doctor_id)
                                <option value="{{$appointment->doctor_id}}">{{$appointment->doctor->user->name}}</option>
                            @else
                                <option value="">Select Doctor</option>
                            @endif
                            @foreach($appointment->pain->specialty->doctors as $doctor)
                                <option value="{{$doctor->user_id}}">{{$doctor->user->name}}</option>
                            @endforeach
                        </select></td>
                    <td><input type="time" name="time" value="{{$appointment->time}}"></td>
                    <td><input type="date" name="date" value="{{$appointment->date}}"></td>
                       <td>{{$appointment->accept_by_doctor}}</td>
                            <td>{{$appointment->accept_by_user}}</td>
                    <td> <button type="submit" class="btn btn-primary">Add Appointment</button></td>
                        </form>
                    </tr>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div>{{$appointments->links()}}</div>

        </div>
    </div>
    </div>

@endsection

