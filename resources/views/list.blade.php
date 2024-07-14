@extends('layouts.app')

@section('title', 'List')



@section('content')




<div class="row" style="" >
        <div class="col-md-5">
        <a href="{{route('download.user.excel')}}" class="btn btn-primary "> Export </a> 
        </div>
        <div class="col-md-6">
        <h3  class="text-left" style=""> User Data </h3>
        </div>
</div>

        <div class="container mt-5">
            <table class="table table-bordered mb-5">
                <thead>
                    <tr class="thead-dark">
                    <th scope="col">#</th>
                        <th scope="col">User Id</th>
                        <th scope="col"> Name</th>
                        <th scope="col">Email Id</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <th scope="row">{{ $user->id }}</th>
                        <td>{{ $user->user_id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->status }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
 
            {{-- Pagination --}}
            <div class="d-flex justify-content-center">
                {!! $users->links('pagination::bootstrap-4') !!}
            </div>
        </div>

    
@endsection

