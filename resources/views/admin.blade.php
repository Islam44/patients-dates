@extends('layouts.app')

@section('content')
    <div class="row">
    <div class="col-md-2">

        <div class="fixed-section affix" data-spy="affix" data-offset-top="400">
            <ul style="list-style-type: none">

                <h4 class="bd-toc-link">Appointment Management</h4>

                <li>
                    <a href="/admin/non_ready">NotReady Appointments</a>
                </li>
                <li>
                    <a href="/admin/waiting">Waiting Appointments</a>
                </li>
                <li>
                    <a href="/admin/reject">Rejected Appointments</a>
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
                    <td>   <select id="doctor" class="form-control @error('doctor') is-invalid @enderror" id="painsList" name="doctor">
                            @if($appointment->doctor_id)
                                <option value="{{$appointment->doctor_id}}">{{$appointment->doctor->user->name}}</option>
                            @else
                                <option value="">Select Doctor</option>
                            @endif
                            @foreach($appointment->pain->specialty->doctors as $doctor)
                                <option value="{{$doctor->user_id}}">{{$doctor->user->name}}</option>
                            @endforeach
                        </select>
                        @error('doctor')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </td>
                    <td>
                        <input id="time" value="{{$appointment->time}}" type="time" class="form-control @error('time') is-invalid @enderror" name="time">
                        @error('time')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </td>
                    <td>
                        <input id="date" value="{{$appointment->date}}" type="date" class="form-control @error('date') is-invalid @enderror" name="date">
                        @error('date')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </td>
                            <td>{{$appointment->accept_by_doctor}}</td>
                            <td>{{$appointment->accept_by_user}}</td>
                            @if($status=='reject')
                             <td> <button type="submit" class="btn btn-primary">Update Appointment</button></td>
                            @else
                            <td> <button type="submit" class="btn btn-primary">Add Appointment</button></td>
                                @endif
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

