@extends('admin.layout.v_template')

@section('title', 'Orders')

@section('heading', 'Data Orders')

@section('brd', 'Order')


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
            <a href="/admin/order/insert" class="btn btn-success mb-4">insert</a>
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Order Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    @foreach ($orders as $item)
                    <tr>
                        <td> {{$i}} </td>
                        <td> {{$item->name}} </td>
                        <td> {{$item->tanggal_order}} </td>
                        <td>
                            <a href="{{url('admin/order/edit/'.$item->id)}}"><button type="button" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></button></a>

                            <a href="{{url('admin/order_item/'.$item->name.'/'.$item->id)}}"><button type="button" class="btn btn-sm btn-success"><i class="fa fa-info"></i></button></a>

                            <a href="{{url('admin/order/delete/'.$item->id)}}" onclick="return confirm('are you sure, want to delete this data?')" ;><button type="button" class="btn btn-sm btn-danger"><i class="fa fa-trash-alt"></i></button></a>
                        </td>
                    </tr>
                    <?php $i++; ?>
                    @endforeach
                </tbody>
            </table>
            <br><br>
            {{ $orders->links() }}
        </div>
    </div>
</div>
<br><br>
</div>
@endsection