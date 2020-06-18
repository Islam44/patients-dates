@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12 text-center">
            <div>
                <h1>{{$code??''}}</h1>
                <h5>{{$message}}</h5>
            </div>
        </div>
    </div>

@endsection

