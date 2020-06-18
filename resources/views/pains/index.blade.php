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
                    <a href="{{route('pains.create')}}" class="btn btn-primary">Add New Pain</a>
                </div>
                <table class="table table-hover table-striped">
                    <thead>
                    <th>Description of Pain</th>
                    <th>Specialty</th>
                    <th>Action</th>
                    </thead>
                    <tbody>
                    @foreach($collection as $instance)
                        <tr>
                            <td>{{$instance->description}}</td>
                            <td>{{$instance->specialty->name}}</td>
                            <td>
                                <a href="{{ route('pains.edit',$instance->id)}}" class="btn w-50 mb-1" style=" background-color:#3490dc;color: white">Update</a>
                                <form action="{{ route('pains.destroy', $instance->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger w-50" type="submit">Delete</button>
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

