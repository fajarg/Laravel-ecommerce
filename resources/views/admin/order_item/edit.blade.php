@extends('admin.layout.v_template')

@section('title', 'Edit Order items')

@section('heading', 'Edit Order item')

@section('brd', 'Order item / Edit')


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
    <div class="card card-dark">
        <div class="card-header">
            <h3 class="card-title">Insert data</h3>
        </div>
        <div class="card-body">
            <form method="post" action="{{url('admin/order_item/edit/'.$name.'/'.$id)}}">
                @csrf
                <input type="hidden" name="order_id" value="{{$order_id}}">
                <div class="form-group">
                    <label for="selectProduct">Select Product</label>
                    <select class="form-control" id="selectProduct" name="product_id">
                        <option value="{{$order_items->product_id}}">{{$order_items->nama}} -- selected</option>
                        @foreach ($products as $row)
                        <option value="{{$row->id}}">{{$row->nama}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="qty">QTY</label>
                    <input type="number" min="1" class="form-control" name="qty" id="qty" value="{{old('qty', $order_items->qty)}}" required>
                    <div id="emailHelp" class="form-text">Stock available : <span id="stock">{{$order_items->stock}}</span></div>
                    <input type="hidden" value="{{$order_items->stock}}" id="stock-available">
                </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
        </div>
        </form>
    </div>


</div>
<br><br>
</div>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        const max = $('#stock-available').val();

        $('#stock-available').text(max);

        if (max === 0) {
            $('#qty').attr("max", max);
            $('#qty').attr("min", max);
            $('#qty').prop("disabled", true);
            $('#qty').val('');
        } else {
            $('#qty').attr("max", max);
            $('#qty').attr("min", 1);
            $('#qty').prop("disabled", false);
        }
    })
</script>
@endpush