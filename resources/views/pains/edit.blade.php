@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-">
                        <div style="float: left">Edit Pain </div>
                    </div>
                    <div class="card-body">
                        @if (session('message'))
                            <div class="alert alert-success " role="alert">
                                {{ session('message') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('pains.update',$pain->id) }}">
                            @method('PATCH')
                            @csrf
                            <div class="form-group row">
                                <label for="specialty_id" class="col-md-4 col-form-label text-md-right">Select
                                    Specialty</label>
                                <div class="col-md-6">
                                    <select class="form-control " id="specialtyList" name="specialty_id">
                                        <option value="">Select Specialty</option>
                                        @foreach($specialties as $specialty)
                                            @if($pain->specialty->id==$specialty->id)
                                            <option selected value="{{$specialty->id}}">{{$specialty->name}}</option>
                                            @else
                                                <option value="{{$specialty->id}}">{{$specialty->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label text-md-right">Description Of Pain</label>

                                <div class="col-md-6">
                                    <input value="{{$pain->description}}" id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" required autocomplete="description" autofocus>

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Update Pain
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
