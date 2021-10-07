@extends('front_page.layout.v_template')

@section('content')



<!-- Page info -->
<div class="page-top-info">
    <div class="container">
        <h4>Your cart</h4>
        <div class="site-pagination">
            <a href="">Home</a> /
            <a href="">Your cart</a>
        </div>
    </div>
</div>
<!-- Page info end -->

<!-- cart section end -->
<section class="cart-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="cart-table">
                    <h3>Your Cart</h3>
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
                                    <td class="total-col">
                                        <a href="{{url('/delete/'.$item->id)}}" onclick="return confirm('are you sure, want to delete this item?')" class="remove-one-order-item">
                                            <i class="flaticon-remove text-danger remove-one-order-item" data-url=""></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="total-cost">
                        <h6>Total <span>@currency($total_price)</span></h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 card-right">
                <form class="promo-code-form">
                    <input type="text" placeholder="Enter promo code">
                    <button>Submit</button>
                </form>
                <a href="/checkout/{{Auth::user()->id}}" class="site-btn">Proceed to checkout</a>
                <a href="/product" class="site-btn sb-dark">Continue shopping</a>
            </div>
        </div>
    </div>
</section>
<!-- cart section end -->

<!-- Related product section -->
<section class="related-product-section">
    <div class="container">
        <div class="section-title text-uppercase">
            <h2>Continue Shopping</h2>
        </div>
        <div class="row">
            @foreach ($continue_shop as $item)
            <div class="col-lg-3 col-sm-6">
                <div class="product-item">
                    <div class="pi-pic">
                        <div class="tag-new">New</div>
                        <a href="{{url('/detail_product/'.$item->id)}}">
                            <img src="{{asset('template/img/product/')}}/{{$item->image}}" alt="">
                        </a>
                        <div class="pi-links">
                            <a href="{{url('/detail_product/'.$item->id)}}" class="add-card"><i class="flaticon-bag"></i><span>Shop Now</span></a>
                            <a href="{{url('/detail_product/'.$item->id)}}" class="wishlist-btn"><i class="flaticon-heart"></i></a>
                        </div>
                    </div>
                    <div class="pi-text">
                        <a href="{{url('/detail_product/'.$item->id)}}">
                            <h6>@currency($item->harga)</h6>
                            <p>{{$item->nama}}</p>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Related product section end -->
@endsection