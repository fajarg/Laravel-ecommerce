@extends('front_page.layout.v_template')

@section('content')
<!-- Page info -->
<div class="page-top-info">
    <div class="container">
        @if ($exist_category)
        <h4>CAtegory {{$exist_category->category_id}}</h4>
        @else
        <h4>All CAtegory</h4>
        @endif
        <div class="site-pagination">
            <a href="">Home</a> /
            <a href="">Shop</a> /
        </div>
    </div>
</div>
<!-- Page info end -->


<!-- Category section -->
<section class="category-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 order-2 order-lg-1">
                <div class="filter-widget">
                    <h2 class="fw-title">Categories</h2>
                    <ul class="category-menu">
                        <li><a href="/product">All Categories</a></li>
                        @foreach ($categories as $row)
                        <li><a href="/product/{{$row->id}}">{{$row->nama}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-lg-9  order-1 order-lg-2 mb-5 mb-lg-0">
                <div class="row">
                    @foreach ($products as $item)
                    <div class="col-lg-4 col-sm-6 mb-5">
                        <div class="product-item">
                            <div class="pi-pic">
                                @if ($item->stock != 0)
                                <div class="tag-new">INSTOCK</div>
                                @else
                                <div class="tag-sale">OUTSTOCK</div>
                                @endif
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
                <div class="text-center w-100 pt-3">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Category section end -->
@endsection