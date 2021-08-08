@extends('admin.layout.v_template')

@section('title', 'Users')

@section('heading', 'Data Users')

@section('brd', 'User')


@section('content')
@if (session('status'))
<div class="container">
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
</div>
@endif

<div class="container">
    <div class="card">
        <div class="card-body">
            <a href="/admin/user/insert" class="btn btn-success mb-4">insert</a>
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td> {{$user->id}} </td>
                        <td> {{$user->name}} </td>
                        <td> {{$user->email}} </td>
                        <td>
                            <a href="{{url('admin/user/edit/'.$user->id)}}"><button type="button" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></button></a>

                            <a href="{{url('admin/user/delete/'.$user->id)}}" onclick="return confirm('are you sure, want to delete this data?')" ;><button type="button" class="btn btn-sm btn-danger"><i class="fa fa-trash-alt"></i></button></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <br><br>
            {{ $users->links() }}
        </div>
    </div>
</div>
<br><br>
</div>
@endsection