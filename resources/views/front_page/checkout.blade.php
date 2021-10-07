@extends('front_page.layout.v_template')

@section('content')
<!-- Page info -->
<div class="page-top-info">
    <div class="container">
        <h4>Checkout</h4>
        <div class="site-pagination">
            <a href="">Home/</a>
            <a href="">Checkout</a>
        </div>
    </div>
</div>
<!-- Page info end -->


<!-- checkout section  -->
<section class="checkout-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 order-2 order-lg-1">
                <form class="checkout-form" action="/payment" method="post">
                    @csrf
                    <div class="cf-title">Billing Address</div>
                    <div>
                        <div class="col-md-12">
                            <input type="hidden" value="{{Auth::user()->id}}" class="form-control" name="user_id" id="user_id">
                            <div class="form-group">
                                <input type="hidden" value="6" class="form-control" name="province_origin">
                            </div>
                            <div class="form-group">
                                <input type="hidden" value="152" class="form-control" id="city_origin" name="city_origin">
                            </div>
                            <div class="form-group">
                                <label>Address<span>*</span>
                                </label>
                                <textarea name="address" class="form-control" rows="5" placeholder="complete address" id="adress" required></textarea>
                                <input type="hidden" value="" class="form-control" id="setAdress" name="setAdress">
                                <input type="hidden" value="{{Auth::user()->id}}" class="form-control" id="user_id" name="user_id">
                            </div>
                            <div class="form-group">
                                <label>Province<span>*</span>
                                </label>
                                <select name="provinsi_id" id="provinsi_id" class="form-control">
                                    <option value="">Select Province</option>
                                    @foreach ($provinsi as $row)
                                    <option value="{{$row['province_id']}}" namaprovinsi="{{$row['province']}}" id="pilih_provinsi">{{$row['province']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>City</label><span>*</span>
                                </label>
                                <select name="kota_id" id="kota_id" class="form-control">
                                    <option value="">Select City</option>
                                </select>
                            </div>
                            <input class="form-control" type="hidden" value="900" id="weight" name="weight">
                        </div>
                    </div>
                    <br>
                    <div class="cf-title">Delievery Info</div>
                    <div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Select Ekspedition<span>*</span>
                                </label>
                                <select name="kurir" id="kurir" class="form-control">
                                    <option value="">Select Courier</option>
                                    <option value="jne">JNE</option>
                                    <option value="tiki">TIKI</option>
                                    <option value="pos">Pos Indonesia</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Select Service<span>*</span>
                                </label>
                                <select name="layanan" id="layanan" class="form-control">
                                    <option value="">Select Service</option>
                                </select>
                            </div>
                            <input class="form-control" type="hidden" value="" id="total_price" name="total_price">
                        </div>
                    </div>
                    <br>
                    <button class=" site-btn submit-order-btn">Go to Payment</button>
                </form>
            </div>
            <div class="col-lg-4 order-1 order-lg-2">
                <div class="checkout-cart">
                    <h3>Your Cart</h3>
                    <ul class="product-list">
                        <?php $total_price = 0; ?>
                        @foreach ($order_items as $item)
                        <li>
                            <div class="pl-thumb"><img src="{{asset('template/img/product/')}}/{{$item->image}}" alt="" height="90"></div>
                            <h6>{{$item->nama}}</h6>
                            <p>@currency($item->harga)<span> x {{$item->qty}}</span></p>
                            <?php $total_price += ($item->harga * $item->qty); ?>
                        </li>
                        @endforeach
                    </ul>
                    <input type="hidden" value="{{$total_price}}" class="form-control" name="total_price" id="total-price">
                    <ul class="price-list">
                        <li>Total<span>@currency($total_price)</span></li>
                        <li>Courier<span id="courier-cost"></span></li>
                        <li class="total">Total<span id="total-all-price"></span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- checkout section end -->
@endsection

@push('script')
<script>
    $(document).ready(function() {
        $('select[name="provinsi_id"]').on('change', function() {
            let provinceid = $(this).val();
            if (provinceid) {
                jQuery.ajax({
                    url: "/city/" + provinceid,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('select[name="kota_id"]').empty();

                        $.each(data, function(key, value) {
                            $('select[name="kota_id"]').append('<option value="' + value.city_id + '" namakota="' + value.type + ' ' + value.city_name + '">' + value.type + ' ' + value.city_name + '</option>');
                        });
                    }
                });
            } else {
                $('select[name="kota_id"]').empty();
            }
        });
    });

    $('select[name="kurir"]').on('change', function() {
        let origin = $("input[name=city_origin]").val();
        let destination = $("select[name=kota_id]").val();
        let courier = $("select[name=kurir]").val();
        let weight = $("input[name=weight]").val();
        if (courier) {
            jQuery.ajax({
                url: "/origin=" + origin + "&destination=" + destination + "&weight=" + weight + "&courier=" + courier,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $.each(data, function(key, value) {
                        $.each(value.costs, function(key1, value1) {
                            $.each(value1.cost, function(key2, value2) {
                                $('select[name="layanan"]').append('<option value="' + value2.value + '">' + value1.service + '-' + value1.description + '-' + value2.value + '</option>');
                            });
                        });
                    });
                },
            });
        } else {
            $('select[name="layanan"]').empty();
        }
    });

    $(document).on('click', function(e) {
        if ($(e.target).is('#layanan')) {
            const cost = parseFloat($('#layanan').val());
            const total_price = parseFloat($('#total-price').val());
            const total_all = parseFloat(cost + total_price);

            let cost_value = parseInt(cost).toLocaleString();
            let total_all_value = parseInt(total_all).toLocaleString();

            $('#courier-cost').html('Rp. ' + cost_value);
            $('#total-all-price').text('Rp. ' + total_all_value);

            $('#total_price').val(total_all)

        }
    })

    $('body').on('keyup', '#adress', function() {
        const getAdress = $('#adress').val();
        const setAdress = $('#setAdress').val(getAdress);
    })
</script>
@endpush