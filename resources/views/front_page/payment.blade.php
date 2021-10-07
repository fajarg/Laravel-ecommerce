@extends('front_page.layout.v_template')

@section('content')

<!-- Page info -->
<div class="page-top-info">
    <div class="container">
        <h4>Payment</h4>
        <div class="site-pagination">
            <a href="">Home</a> /
            <a href="">Payment</a>
        </div>
    </div>
</div>
<!-- Page info end -->

<section class="checkout-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 order-2 order-lg-1">
                <div class="checkout-form">
                    <div class="cf-title">Your Address</div>
                    <div class="form-group">
                        </label>
                        <textarea name="address" class="form-control" rows="5" placeholder="complete address" id="adress" required disabled>{{$address}}</textarea>
                    </div>
                    <br>
                    <div class="cf-title">Your Orders</div>
                    <div class="cart-table">
                        <div class="cart-table-warp">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="product-th">Product</th>
                                        <th class="quy-th">Quantity</th>
                                        <th class="quy-th">Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $total_price = 0; ?>
                                    @foreach ($order_items as $item)
                                    <tr>
                                        <td class="product-col">
                                            <img src="{{asset('template/img/product/')}}/{{$item->image}}" alt="">
                                            <div class="pc-title">
                                                <h4>{{$item->nama}}</h4>
                                                <p>@currency($item->harga)</p>
                                            </div>
                                        </td>
                                        <td class="quy-col">
                                            <div class="quantity">
                                                <div class="prod-qty">
                                                    <input type="text" value="{{$item->qty}}" disabled>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="total-col" style="width:25%">
                                            <h4>@currency($item->harga*$item->qty)</h4>
                                            <?php $total_price += ($item->harga * $item->qty); ?>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="total-cost">
                            <h6>Total + Courier<span>@currency($total_pay)</span></h6>
                        </div>
                    </div>
                    <br>
                    <br>
                    <button id="pay-button" class=" site-btn submit-order-btn">Pay Now</button>

                    <form id="payment-form" method="post" action="">
                        <input type="hidden" name="result_data" id="result-data" value="">
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('script')
<script>
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function() {
        snap.pay('<?= $snap ?>', {
            onSuccess: function(result) {
                console.log('success');
                console.log(result);
            },
            onPending: function(result) {
                console.log('pending');
                console.log(result);
            },
            onError: function(result) {
                console.log('error');
                console.log(result);
            },
            onClose: function() {
                console.log('customer closed the popup without finishing the payment');
            }
        })
    });
</script>
@endpush