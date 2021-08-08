@extends('admin.layout.v_template')

@section('title', 'Products')

@section('heading', 'Data Products')

@section('brd', 'Product')


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
            <a href="/admin/product/insert" class="btn btn-success mb-4">insert</a>
            <table class="table table-striped">
                <thead class="table-dark text-center">
                    <tr>
                        <th>Code</th>
                        <th>Category</th>
                        <th>Name</th>
                        <th>Stock</th>
                        <th>Varian</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $item)
                    <tr>
                        <td> {{$item->code}} </td>
                        <td> {{$item->category->nama}} </td>
                        <td style="width:20%"> {{$item->nama}} </td>
                        <td> {{$item->stock}} </td>
                        <td> {{$item->varian}} </td>
                        <td style="width:30%"> {{Str::limit($item->keterangan, 40)}} </td>
                        <td>
                            <a href="{{url('admin/product/edit/'.$item->id)}}"><button type="button" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></button></a>

                            <a href="{{url('admin/product/delete/'.$item->id)}}" onclick="return confirm('are you sure, want to delete this data?')" ;><button type="button" class="btn btn-sm btn-danger"><i class="fa fa-trash-alt"></i></button></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <br><br>
            {{ $products->links() }}
        </div>
    </div>
</div>
<br><br>
</div>
@endsection