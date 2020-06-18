@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-">
                        <div style="float: left">{{ __('Select Your Pain') }}</div>
                        <div style="float: right">
                            <a href="/notifications">
                                <i class="fa fa-envelope fa-2x"></i>
                            </a>
                            <span class="counter counter-lg" style="color: blue">{{$number}}</span>&nbsp;
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('message'))
                            <div class="alert alert-success " role="alert">
                                {{ session('message') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('request_appointment') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="specialty" class="col-md-4 col-form-label text-md-right">Select
                                    Specialty</label>
                                <div class="col-md-6">
                                    <select class="form-control " id="specialtyList" name="specialty">
                                        <option value="">Select Specialty</option>
                                        @foreach($specialties as $specialty)
                                            <option value="{{$specialty->id}}">{{$specialty->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="gender" class="col-md-4 col-form-label text-md-right">Select Your
                                    Pain</label>
                                <div class="col-md-6">
                                    <select class="form-control " id="painsList" name="pain_id">
                                        <option value="">Select Specialty First</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Request an appointment') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
<script src="../js/createAppointment.js" type="text/javascript"></script>
