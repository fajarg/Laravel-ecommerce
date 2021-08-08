@extends('front_page.layout.v_template')

@section('content')
<!-- Page info -->
<div class="page-top-info">
    <div class="container">
        <h4>Detail Product</h4>
        <div class="site-pagination">
            <a href="">Home</a> /
            <a href="">Shop</a>
        </div>
    </div>
</div>
<!-- Page info end -->

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
<!-- product section -->
<section class="product-section">
    <div class="container">
        <div class="back-link">
            <a href="/product"> &lt;&lt; Back to Category</a>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="product-pic-zoom">
                    <img class="product-big-img" src="{{asset('template/img/product/')}}/{{$products->image}}" alt="">
                </div>
                <div class="product-thumbs" tabindex="1" style="overflow: hidden; outline: none;">
                    <div class="product-thumbs-track">
                        <div class="pt active" data-imgbigurl="{{asset('template')}}/img/single-product/1.jpg"><img src="{{asset('template')}}/img/single-product/thumb-1.jpg" alt=""></div>
                        <div class="pt" data-imgbigurl="{{asset('template')}}/img/single-product/2.jpg"><img src="{{asset('template')}}/img/single-product/thumb-2.jpg" alt=""></div>
                        <div class="pt" data-imgbigurl="{{asset('template')}}/img/single-product/3.jpg"><img src="{{asset('template')}}/img/single-product/thumb-3.jpg" alt=""></div>
                        <div class="pt" data-imgbigurl="{{asset('template')}}/img/single-product/4.jpg"><img src="{{asset('template')}}/img/single-product/thumb-4.jpg" alt=""></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 product-details">
                <h2 class="p-title">{{$products->nama}}</h2>
                <h3 class="p-price">@currency($products->harga)</h3>
                @if ($products->stock != 0)
                <h4 class="p-stock">Available: <span>In Stock</span></h4>
                @else
                <h4 class="p-stock">Available: <span>Out Stock</span></h4>
                @endif
                <div class="p-rating">
                    <i class="fa fa-star-o"></i>
                    <i class="fa fa-star-o"></i>
                    <i class="fa fa-star-o"></i>
                    <i class="fa fa-star-o"></i>
                    <i class="fa fa-star-o fa-fade"></i>
                </div>
                <div class="p-review">
                    <a href="">3 reviews</a>|<a href="">Add your review</a>
                </div>
                <div class="fw-size-choose">
                    <p>Size</p>
                    <div class="sc-item">
                        <input type="radio" name="sc" id="xs-size">
                        <label for="xs-size">32</label>
                    </div>
                    <div class="sc-item">
                        <input type="radio" name="sc" id="s-size">
                        <label for="s-size">34</label>
                    </div>
                    <div class="sc-item">
                        <input type="radio" name="sc" id="m-size" checked="">
                        <label for="m-size">36</label>
                    </div>
                    <div class="sc-item">
                        <input type="radio" name="sc" id="l-size">
                        <label for="l-size">38</label>
                    </div>
                    <div class="sc-item disable">
                        <input type="radio" name="sc" id="xl-size" disabled>
                        <label for="xl-size">40</label>
                    </div>
                    <div class="sc-item">
                        <input type="radio" name="sc" id="xxl-size">
                        <label for="xxl-size">42</label>
                    </div>
                </div>
                <form method="post" action="{{url('/cart')}}">
                    @csrf
                    <div class="quantity">
                        <p>Quantity</p>
                        @if ($products->stock != 0)
                        <div class="pro-qty"><input type="text" value="1" name="qty"></div>
                        @else
                        <div class="prod-qty"><input type="text" value="0" disabled></div>
                        @endif
                        <input type="hidden" class="max-qty" value="{{$products->stock}}">
                    </div>
                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                    <input type="hidden" name="date" value="{{$date}}">
                    <input type="hidden" name="product_id" value="{{$products->id}}">
                    <button type="submit" class="site-btn" name="submit">Shop Now</button>
                </form>
                <div id="accordion" class="accordion-area">
                    <div class="panel">
                        <div class="panel-header" id="headingOne">
                            <button class="panel-link active" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">information</button>
                        </div>
                        <div id="collapse1" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="panel-body">
                                <p>{{$products->keterangan}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="panel">
                        <div class="panel-header" id="headingTwo">
                            <button class="panel-link" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">care details </button>
                        </div>
                        <div id="collapse2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="panel-body">
                                <img src="{{asset('template')}}/img/cards.png" alt="">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin pharetra tempor so dales. Phasellus sagittis auctor gravida. Integer bibendum sodales arcu id te mpus. Ut consectetur lacus leo, non scelerisque nulla euismod nec.</p>
                            </div>
                        </div>
                    </div>
                    <div class="panel">
                        <div class="panel-header" id="headingThree">
                            <button class="panel-link" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">shipping & Returns</button>
                        </div>
                        <div id="collapse3" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                            <div class="panel-body">
                                <h4>7 Days Returns</h4>
                                <p>Cash on Delivery Available<br>Home Delivery <span>3 - 4 days</span></p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin pharetra tempor so dales. Phasellus sagittis auctor gravida. Integer bibendum sodales arcu id te mpus. Ut consectetur lacus leo, non scelerisque nulla euismod nec.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="social-sharing">
                    <a href=""><i class="fa fa-google-plus"></i></a>
                    <a href=""><i class="fa fa-pinterest"></i></a>
                    <a href=""><i class="fa fa-facebook"></i></a>
                    <a href=""><i class="fa fa-twitter"></i></a>
                    <a href=""><i class="fa fa-youtube"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- product section end -->


<!-- RELATED PRODUCTS section -->
<section class="related-product-section">
    <div class="container">
        <div class="section-title">
            <h2>RELATED PRODUCTS</h2>
        </div>
        <div class="product-slider owl-carousel">
            @foreach ($related_products as $item)
            <div class="product-item">
                <div class="pi-pic">
                    <a href="{{url('/detail_product/'.$item->id)}}">
                        <img src="{{asset('template/img/product/')}}/{{$item->image}}" alt="">
                    </a>
                    <div class="pi-links">
                        <a href="#" class="add-card"><i class="flaticon-bag"></i><span>ADD TO CART</span></a>
                        <a href="#" class="wishlist-btn"><i class="flaticon-heart"></i></a>
                    </div>
                </div>
                <div class="pi-text">
                    <a href="{{url('/detail_product/'.$item->id)}}">
                        <h6>@currency($item->harga)</h6>
                        <p>{{$item->nama}}</p>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- RELATED PRODUCTS section end -->

@endsection