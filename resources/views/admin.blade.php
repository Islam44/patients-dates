@extends('layouts.app')

@section('content')
    <div class="row">
        @include('layouts.sidebar')
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
                <th>Updated By Admin</th>
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
                    <td>   <select id="doctor_id" class="form-control @error('doctor_id') is-invalid @enderror" id="painsList" name="doctor_id">
                            @if($appointment->doctor_id)
                                <option value="{{$appointment->doctor_id}}">{{$appointment->doctor->user->name}}</option>
                            @else
                                <option value="">Select Doctor</option>
                            @endif
                            @foreach($appointment->pain->specialty->doctors as $doctor)
                                <option value="{{$doctor->user_id}}">{{$doctor->user->name}}</option>
                            @endforeach
                        </select>
                        @error('doctor_id')
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
                            @if($appointment->admin)
                            <td>{{$appointment->admin->name}}</td>
                            @else
                                <td></td>
                            @endif
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

