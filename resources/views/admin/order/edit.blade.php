@extends('admin.layout.v_template')

@section('title', 'Edit Order')

@section('heading', 'Edit Order')

@section('brd', 'Order / Edit')


@section('content')
@if ($errors->any())
<div class="container">
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

@if (session('status'))
<div class="container">
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
</div>
@endif


<div class="container">
    <!-- general form elements -->
    <div class="card card-dark">
        <div class="card-header">
            <h3 class="card-title">Insert data</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form method="post" action="{{url('admin/order/edit/'.$orders->id)}}">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="selectCategory">Select User</label>
                    <select class="form-control" id="selectUser" name="user_id">
                        <option value="{{$orders->user_id}}">{{$orders->name}} -- selected</option>
                        @foreach ($users as $row)
                        <option value="{{$row->id}}">{{$row->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="date_order">Select Date</label>
                    <input type="date" class="form-control" id="date_order" name="date_order" value="{{old('date', $orders->tanggal_order)}}">
                </div>

            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
            </div>
        </form>
    </div>
    <!-- /.card -->
</div>

<br><br>
</div>
@endsection