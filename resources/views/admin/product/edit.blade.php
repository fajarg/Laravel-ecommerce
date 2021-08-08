@extends('admin.layout.v_template')

@section('title', 'Edit Product')

@section('heading', 'Edit Product')

@section('brd', 'Product / Edit')


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
            <h3 class="card-title">Edit data</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form method="post" action="{{url('admin/product/edit/'.$products->id)}}" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <input type="hidden" value="{{$products->id}}">
                <div class="form-group">
                    <label for="selectCategory">Select Category</label>
                    <select class="form-control" id="selectCategory" name="category_id">
                        <option value="{{$products->category->id}}">{{$products->category->nama}} -- selected</option>
                        @foreach ($categories as $row)
                        <option value="{{$row->id}}">{{$row->nama}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="code">Code</label>
                    <input type="text" class="form-control" id="code" placeholder="Enter code" name="code" value="{{old('code', $products->code)}}">
                </div>
                <div class="form-group">
                    <label for="nama">Name</label>
                    <input type="text" class="form-control" id="nama" placeholder="Enter name" name="nama" value="{{old('nama', $products->nama)}}">
                </div>
                <div class="form-group">
                    <label for="stock">Stock</label>
                    <input type="text" class="form-control" id="stock" placeholder="Enter stock" name="stock" value="{{old('stock', $products->stock)}}">
                </div>
                <div class="form-group">
                    <label for="varian">Varian</label>
                    <input type="text" class="form-control" id="varian" placeholder="Enter varian" name="varian" value="{{old('varian', $products->varian)}}">
                </div>
                <div class="form-group">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" rows="3" name="description">{{$products->keterangan}}</textarea>
                </div>
                <div class="form-group">
                    <label for="harga">Price</label>
                    <input type="number" min="1" class="form-control" name="harga" id="harga" value="{{old('harga', $products->harga)}}" placeholder="Enter price" required>
                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" class="form-control-file" id="image" name="image"><br>
                    <img src="{{asset('template/img/product/')}}/{{$products->image}}" width="300px">
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