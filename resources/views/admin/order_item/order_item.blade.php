@extends('admin.layout.v_template')

@section('title', 'Order items')

@section('heading', $name."'s Order items")

@section('brd', 'Order item')


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
            <h3 class="card-title">Add Order Item</h3>
        </div>
        <div class="card-body">
            <form method="post" action="{{url('admin/order_item/insert/'.$name.'/'.$id)}}" id="form-order-item">
                @csrf
                <input type="hidden" name="name_user" value="{{$name}}" id="name_user">
                <input type="hidden" name="order_id" value="{{$id}}" id="order_id">
                <div class="form-group">
                    <label for="product_id">Select Product</label>
                    <select class="form-control" id="product_id" name="product_id">
                        @foreach ($products as $row)
                        <option value="{{$row->id}}" class="{{$row->stock}}">{{$row->nama}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="qty">QTY</label>
                    <input type="number" min="1" class="form-control" name="qty" id="qty" required>
                    <div id="emailHelp" class="form-text">Stock available : <span id="stock"></span></div>
                </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
        </div>
        </form>
    </div>

    <br><br>
    <div class="card card-dark">
        <div class="card-header">
            <h3 class="card-title">Show Order Items</h3>
        </div>
        <div class="card-body">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search name or qty" aria-label="Search" id="search">
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Order Id</th>
                        <th>Product Name</th>
                        <th>Qty</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="data-item">
                    <?php $i = 1; ?>
                    @foreach ($order_items as $item)
                    <tr>
                        <td> {{$i}} </td>
                        <td> {{$id}} </td>
                        <td> {{$item->nama}} </td>
                        <td> {{$item->qty}} </td>
                        <td>
                            <a href="{{url('admin/order_item/edit/'.$name.'/'.$id.'/'.$item->id)}}"><button type="button" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></button></a>

                            <a href="{{url('admin/order_item/delete/'.$name.'/'.$id.'/'.$item->id)}}" onclick="return confirm('are you sure, want to delete this data?')" ;><button type="button" class="btn btn-sm btn-danger fa fa-trash-alt"></button></a>
                        </td>
                    </tr>
                    <?php $i++; ?>
                    @endforeach
                </tbody>
            </table>
            <br><br>
            {{ $order_items->links() }}
        </div>
    </div>
</div>
<br><br>
</div>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        $('#form-order-item').on('submit', function(e) {
            e.preventDefault();
            const order_id = $('#order_id').val();
            const name_user = $('#name_user').val();
            const product_id = $('#product_id').val();
            const qty = $('#qty').val();

            $.ajax({
                type: 'POST',
                url: '/api/order_item/insert/' + name_user + '/' + order_id,
                data: {
                    'order_id': order_id,
                    'product_id': product_id,
                    'qty': qty
                },
                success: function(result) {
                    $('#data-item').html(updateTable(result.data))
                    $('#qty').val('')
                    alert('Success insert data')
                    const sisa_stock = result.sisa_stock;
                    $('#stock').text(sisa_stock);

                    if (sisa_stock === 0) {
                        $('#qty').attr("max", sisa_stock);
                        $('#qty').attr("min", sisa_stock);
                        $('#qty').prop("disabled", true);
                        $('#qty').val('');
                    } else {
                        $('#qty').attr("max", sisa_stock);
                        $('#qty').attr("min", 1);
                        $('#qty').prop("disabled", false);
                    }
                }
            })
        })
    })

    $(document).on('click', function(e) {
        if ($(e.target).hasClass('btn-delete')) {
            const order_id = $(e.target).data('order-id');
            const id = $(e.target).data('id');
            const name_user = $('#name_user').val();

            $.ajax({
                type: 'DELETE',
                url: `/api/order_item/delete/${name_user}/${order_id}/${id}`,
                success: function(result) {
                    $('#data-item').html(updateTable(result.data));
                }
            })
        }
    })

    function updateTable(data) {
        let table = '';
        data.forEach((d, i) => {
            table += `
            <tr>
                        <td> ${i+1} </td>
                        <td> ${d.order_id} </td>
                        <td> ${d.product.nama} </td>
                        <td> ${d.qty} </td>
                        <td>
                            <a href=""><button type="button" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></button></a>

                             <button type="button" class="btn btn-sm btn-danger fa fa-trash-alt btn-delete" 
                             data-order-id = "${d.order_id}"
                             data-id = "${d.id}"
                             onclick="return confirm('are you sure, want to delete this data?')"></button>
                        </td>
                    </tr>
            `;
        })
        return table
    }

    $('body').on('keyup', '#search', function() {
        let search = $(this).val();
        const order_id = $('#order_id').val();
        const name_user = $('#name_user').val();

        $.ajax({
            type: 'POST',
            url: `/api/order_item/search/${name_user}/${order_id}`,
            dataType: 'json',
            data: {
                '_token': '{{ csrf_token() }}',
                search: search
            },
            success: function(response) {
                let table = '';
                $('#data-item').html('');

                $.each(response, function(index, value) {
                    table = `
                    <tr>
                        <td> ${index+1} </td>
                        <td> ${value.order_id} </td>
                        <td> ${value.nama} </td>
                        <td> ${value.qty} </td>
                        <td>
                            <a href=""><button type="button" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></button></a>

                             <button type="button" class="btn btn-sm btn-danger fa fa-trash-alt btn-delete" 
                             data-order-id = "${value.order_id}"
                             data-id = "${value.id}"
                             onclick="return confirm('are you sure, want to delete this data?')"></button>
                        </td>
                    </tr>
                `;

                    $('#data-item').append(table);
                })
            }
        })
    });

    $(document).on('click', function(e) {
        if ($(e.target).has('option')) {
            const product_id = $('#product_id').val();

            $.ajax({
                type: 'GET',
                url: `/api/order_item/${product_id}`,
                dataType: 'json',
                success: function(response) {
                    const max = response.stock;
                    $('#stock').text(max);
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
                }
            })

        }
    })
</script>
@endpush