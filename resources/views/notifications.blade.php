@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-">
                        <div style="float: left">My Appointments</div>
                    </div>
                    <div class="card-body">
                        @if (session('message'))
                            <div class="alert alert-success " role="alert">
                                {{ session('message') }}
                            </div>
                        @endif
                        <div class="row">
                            @if(count($notifications)==0)
                            <div class="col-6">
                                @if(auth()->user()->hasType('User'))
                                <p>When doctor reject appointment notification deleted automatically</p>
                                @else
                                <p>When patient reject appointment notification deleted automatically</p>
                                @endif
                                 <h3>Notification List Empty</h3>
                            </div>
                            @else
                            <div class="col-6">
                                @foreach($notifications as $notification)
                                    <h5>Your Appointment :</h5>
                                    @if(auth()->user()->hasType('User'))
                                        <h6>Your Doctor
                                            : {{$notification->data['appointment']['doctor']['user']['name']}}</h6>
                                    @else
                                        <h6>Your Patient
                                            : {{$notification->data['appointment']['patient']['user']['name']}}</h6>
                                    @endif
                                    <h6>Date
                                        : {{date('D', strtotime($notification->data['appointment']['date']))}} {{$notification->data['appointment']['date']}} </h6>
                                    <h6>Time : {{$notification->data['appointment']['time']}}</h6>
                                    <a class="btn btn-primary"
                                       href="decision/accept/{{$notification['id']}}">Accept Appointment</a>
                                    <a class="btn btn-danger"
                                       href="decision/reject/{{$notification['id']}}">Reject Appointment</a>
                                @endforeach
                            </div>
                            @endif
                            <div class="col-6">
                                <h5>Today Appointments</h5>
                                <div class="table-responsive table-full-width">
                                    <table class="table table-hover table-striped">
                                        <thead>
                                        <th>Patient Name</th>
                                        <th>Pain Description</th>
                                        <th>Doctor</th>
                                        <th>Time</th>
                                        </thead>
                                        <tbody>
                                        @foreach($acceptedAppointments as $accepted)
                                            <tr>
                                                <td>{{$accepted->patient->user->name}}</td>
                                                <td>{{$accepted->pain->description}}</td>
                                                <td>{{$accepted->doctor->user->name}}</td>
                                                <td>{{$accepted->time}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                {{$notifications->links()}}
            </div>

        </div>

    </div>
@endsection
