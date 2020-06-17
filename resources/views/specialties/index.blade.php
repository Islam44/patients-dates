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
                <div class="mb-2 float-right">
                    <a href="{{ route('specialties.create')}}" class="btn btn-primary">Add New Specialty</a>
                </div>
                <table class="table table-hover table-striped">
                    <thead>
                    <th>ID</th>
                    <th>Name of Specialty</th>
                    <th>Action</th>
                    </thead>
                    <tbody>
                    @foreach($collection as $instance)
                        <tr>
                            <td>{{$instance->id}}</td>
                            <td>{{$instance->name}}</td>
                            <td>
                                <a href="{{ route('specialties.edit',$instance->id)}}" class="btn btn-primary w-25 mb-1">Update</a>
                                <form action="{{ route('specialties.destroy', $instance->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger w-25" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div>{{$collection->links()}}</div>

            </div>
        </div>
    </div>

@endsection

