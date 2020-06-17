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
                        <div class="col-12">
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
                    </div>


                </div>
                {{$notifications->links()}}
            </div>

        </div>

    </div>
@endsection
