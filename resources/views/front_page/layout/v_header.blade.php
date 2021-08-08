<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Divisima</title>
    <meta charset="UTF-8">
    <meta name="description" content=" Divisima | eCommerce Template">
    <meta name="keywords" content="divisima, eCommerce, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicon -->
    <link href="{{asset('template')}}/img/favicon.ico" rel="shortcut icon" />

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,300i,400,400i,700,700i" rel="stylesheet">


    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{asset('template')}}/css/bootstrap.min.css" />
    <link rel="stylesheet" href="{{asset('template')}}/css/font-awesome.min.css" />
    <link rel="stylesheet" href="{{asset('template')}}/css/flaticon.css" />
    <link rel="stylesheet" href="{{asset('template')}}/css/slicknav.min.css" />
    <link rel="stylesheet" href="{{asset('template')}}/css/jquery-ui.min.css" />
    <link rel="stylesheet" href="{{asset('template')}}/css/owl.carousel.min.css" />
    <link rel="stylesheet" href="{{asset('template')}}/css/animate.css" />
    <link rel="stylesheet" href="{{asset('template')}}/css/style.css" />




    <!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Header section -->
    <header class="header-section">
        <div class="header-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2 text-center text-lg-left">
                        <!-- logo -->
                        <a href="/" class="site-logo">
                            <img src="{{asset('template')}}/img/logo.png" alt="">
                        </a>
                    </div>
                    <div class="col-xl-6 col-lg-5">
                        <form class="header-search-form">
                            <input type="text" placeholder="Search on divisima ....">
                            <button><i class="flaticon-search"></i></button>
                        </form>
                    </div>
                    <div class="col-xl-4 text-right col-lg-5">

                        <div class="user-panel">
                            <div class="up-item">
                                <div class="shopping-card">
                                    <i class="flaticon-bag"></i>
                                    @if(session('key') && Auth::check())
                                    <?php $total_qty = 0; ?>
                                    @foreach(session('key') as $id)
                                    <?php $total_qty +=  $id->qty ?>
                                    <span>{{$total_qty}}</span>
                                    @endforeach
                                    @else
                                    <span>0</span>
                                    @endif
                                </div>
                                @if(Auth::check())
                                <a href="/cart/{{Auth()->user()->id}}">Shopping Cart</a>
                                @else
                                <a href="/login">Shopping Cart</a>
                                @endif
                            </div>
                            <div class="up-item">
                                @guest
                                @if (Route::has('login'))
                                <i class="flaticon-profile"></i>
                                <a href="{{ route('login') }}">Sign In</a> or
                                @endif
                                @if (Route::has('register'))
                                <a href="{{ route('register') }}">Create Account</a>
                                @endif

                                @else

                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    @if (Auth::user()->level == 'ADMIN')
                                    <a class="dropdown-item" href="/admin">Dashboard</a>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="
                                event.preventDefault();
                                document.getElementById('formLogout').submit();">Logout</a>

                                    <form id="formLogout" method="post" action="{{ route('logout')}}">@csrf</form>
                                </div>
                                @endguest
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <nav class="main-navbar">
            <div class="container">
                <!-- menu -->
                <ul class="main-menu">
                    <li><a href="/">Home</a></li>
                    <li><a href="/product/1">Kategori 1</a></li>
                    <li><a href="/product/2">Kategori 2</a></li>
                    <li><a href="/product/3">Kategori 3
                            <span class="new">New</span>
                        </a></li>
                    <li><a href="/product/4">Kategori 4</a>
                    </li>
                    <li><a href="#">Pages</a>
                        <ul class="sub-menu">
                            <li><a href="/product">Category Page</a></li>
                            @if(Auth::check())
                            <li><a href="/cart/{{Auth()->user()->id}}">Cart Page</a></li>
                            @else
                            <li><a href="/login">Cart Page</a></li>
                            @endif
                            <li><a href="/checkout">Checkout Page</a></li>
                            <li><a href="/contact">Contact Page</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Header section end -->