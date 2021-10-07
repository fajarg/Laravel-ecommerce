@extends('front_page.layout.v_template')

@section('content')
<!-- Hero section -->
<section class="hero-section">
    <div class="hero-slider owl-carousel">
        <div class="hs-item set-bg" data-setbg="{{asset('template')}}/img/bg.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-7 text-white">
                        <span>New Arrivals</span>
                        <h2>denim jackets</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum sus-pendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis. </p>
                        <a href="/product" class="site-btn sb-line">SEE OTHER</a>
                        <a href="{{url('/detail_product/1')}}" class="site-btn sb-white">SHOP NOW</a>
                    </div>
                </div>
                <div class="offer-card text-white">
                    <span>from</span>
                    <h3>Rp.50k</h3>
                    <p>SHOP NOW</p>
                </div>
            </div>
        </div>
        <div class="hs-item set-bg" data-setbg="{{asset('template')}}/img/bg-2.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-7 text-white">
                        <span>New Arrivals</span>
                        <h2>denim jackets</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum sus-pendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis. </p>
                        <a href="/product" class="site-btn sb-line">SEE OTHER</a>
                        <a href="{{url('/detail_product/2')}}" class="site-btn sb-white">SHOP NOW</a>
                    </div>
                </div>
                <div class="offer-card text-white">
                    <span>from</span>
                    <h3>Rp.50k</h3>
                    <p>SHOP NOW</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="slide-num-holder" id="snh-1"></div>
    </div>
</section>
<!-- Hero section end -->



<!-- Features section -->
<section class="features-section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 p-0 feature">
                <div class="feature-inner">
                    <div class="feature-icon">
                        <img src="{{asset('template')}}/img/icons/1.png" alt="#">
                    </div>
                    <h2>Fast Secure Payments</h2>
                </div>
            </div>
            <div class="col-md-4 p-0 feature">
                <div class="feature-inner">
                    <div class="feature-icon">
                        <img src="{{asset('template')}}/img/icons/2.png" alt="#">
                    </div>
                    <h2>Premium Products</h2>
                </div>
            </div>
            <div class="col-md-4 p-0 feature">
                <div class="feature-inner">
                    <div class="feature-icon">
                        <img src="{{asset('template')}}/img/icons/3.png" alt="#">
                    </div>
                    <h2>Free & fast Delivery</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Features section end -->


<!-- letest product section -->
<section class="top-letest-product-section">
    <div class="container">
        <div class="section-title">
            <h2>LATEST PRODUCTS</h2>
        </div>
        <div class="product-slider owl-carousel mb-2">
            @foreach ($latest_products as $item)
            <div class="product-item mb-3">
                <div class="pi-pic">
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
            @endforeach
        </div>
    </div>
</section>
<!-- letest product section end -->



<!-- Product filter section -->
<section class="product-filter-section">
    <div class="container">
        <div class="section-title">
            <h2>BROWSE TOP SELLING PRODUCTS</h2>
        </div>
        <ul class="product-filter-menu">
            @foreach ($categories as $category)
            <li><a href="/product/{{$category->id}}">{{$category->nama}}</a></li>
            @endforeach
        </ul>
        <div class="row">
            @foreach ($top_products as $item)
            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="product-item">
                    <div class="pi-pic">
                        <a href="{{url('/detail_product/'.$item->id)}}">
                            <img src="{{asset('template/img/product/')}}/{{$item->image}}" alt="">
                        </a>
                        <div class="pi-links">
                            <a href="{{url('/detail_product/'.$item->id)}}" class="add-card"><i class="flaticon-bag"></i><span>SHOP NOW</span></a>
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
        <div class="text-center pt-5">
            <a href="/product" class="site-btn sb-line sb-dark">LOAD MORE</a>
        </div>
    </div>
</section>
<!-- Product filter section end -->


<!-- Banner section -->
<section class="banner-section">
    <div class="container">
        <div class="banner set-bg" data-setbg="{{asset('template')}}/img/banner-bg.jpg">
            <div class="tag-new">NEW</div>
            <span>New Arrivals</span>
            <h2>STRIPED SHIRTS</h2>
            <a href="{{url('/detail_product/25')}}" class="site-btn">SHOP NOW</a>
        </div>
    </div>
</section>
<!-- Banner section end  -->
@endsection