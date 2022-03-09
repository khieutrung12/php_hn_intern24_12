<!DOCTYPE html>

<head>
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords"
        content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
    <script type="application/x-javascript">
        addEventListener("load", function() {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <!-- bootstrap-css -->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-dt/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/toastr/toastr.css') }}">
    <link href="{{ asset('css/style.css') }}" rel='stylesheet' type='text/css' />
    <link href="{{ asset('css/style-responsive.css') }}" rel="stylesheet" />
    <link
        href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic'
        rel='stylesheet' type='text/css'>
    <link href="{{ asset('bower_components/font-awesome/css/all.css') }}" rel="stylesheet">
</head>

<body>
    <section id="container">
        <!--header start-->
        <header class="header fixed-top clearfix">
            <!--logo start-->
            <div class="brand">
                <a href="" class="logo">
                    ADMIN
                </a>
                <div class="sidebar-toggle-box">
                    <div class="fa fa-bars"></div>
                </div>
            </div>
            <!--logo end-->

            <div class="top-nav clearfix">
                <!--search & user info start-->
                <ul class="nav pull-right top-menu">
                    <li>
                        <a
                            href="{{ route('lang', ['locale' => 'en']) }}">En</a>

                    </li>
                    <li>
                        <a
                            href="{{ route('lang', ['locale' => 'vi']) }}">Vi</a>
                    </li>
                    <!-- user login dropdown start-->
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle"
                            href="#">
                            <img alt="" src="{{ asset('images/2.png') }}">
                            <span class="username">
                                {{ Auth()->user()->name }}
                            </span>
                            <b class="caret"></b>
                        </a>

                        <ul class="dropdown-menu extended logout">
                            <li><a href="#"><i
                                        class=" fa fa-suitcase"></i>{{ __('titles.profile') }}</a>
                            </li>
                            <li><a href="#"><i class="fa fa-cog"></i>
                                    {{ __('titles.settings') }}</a></li>
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa fa-key"></i>
                                    {{ __('titles.logout') }}
                                </a>
                                <form id="logout-form"
                                    action="{{ route('logout') }}"
                                    method="POST">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </header>
        <!--header end-->
        <!--sidebar start-->
        <aside>
            <div id="sidebar" class="nav-collapse">
                <!-- sidebar menu start-->
                <div class="leftside-navigation">
                    <ul class="sidebar-menu" id="nav-accordion">
                        <!-- Dashboard -->
                        <li>
                            <a class="active" href="">
                                <i class="fa fa-dashboard"></i>
                                <span>{{ __('titles.dashboard') }}</span>
                            </a>
                        </li>
                        <!-- Dashboard -->
                        <!-- Brand -->
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-book"></i>
                                <span>{{ __('titles.brand') }}</span>
                            </a>
                            <ul class="sub">
                                <li><a
                                        href="{{ route('brands.create') }}">{{ __('titles.add-brand') }}</a>
                                </li>
                                <li><a
                                        href="{{ route('brands.index') }}">{{ __('titles.all-brand') }}</a>
                                </li>
                            </ul>
                        </li>
                        <!-- Brand -->
                        <!-- Category -->
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-book"></i>
                                <span>{{ __('titles.category') }}</span>
                            </a>
                            <ul class="sub">
                                <li><a
                                        href="{{ route('categories.create') }}">{{ __('titles.add-var', ['name' => __('titles.category')]) }}</a>
                                </li>
                                <li><a
                                        href="{{ route('categories.index') }}">{{ __('titles.all-var', ['name' => __('titles.category')]) }}</a>
                                </li>
                            </ul>
                        </li>
                        <!-- Category -->
                        <!-- Product -->
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-book"></i>
                                <span>{{ __('titles.product') }}</span>
                            </a>
                            <ul class="sub">
                                <li><a
                                        href="{{ route('products.create') }}">{{ __('titles.add-var', ['name' => __('titles.product')]) }}</a>
                                </li>
                                <li><a
                                        href="{{ route('products.index') }}">{{ __('titles.all-var', ['name' => __('titles.product')]) }}</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-book"></i>
                                <span>{{ __('titles.order') }}</span>
                            </a>
                            <ul class="sub">
                                <li><a
                                        href="{{ route('orders.index') }}">{{ __('titles.all-var', ['name' => __('titles.order')]) }}</a>
                                </li>
                            </ul>
                        </li>
                        <!-- Product -->
                        <!-- Voucher -->
                        <li class="sub-menu">
                            <a href="{{ route('vouchers.index') }}">
                                <i class="fa fa-book"></i>
                                <span>{{ __('titles.Voucher') }}</span>
                            </a>
                        </li>
                        <!-- Voucher -->
                    </ul>
                </div>
            </div>
        </aside>
        <!--sidebar end-->
        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">
                @yield('admin_content')
            </section>
            <!-- footer -->
            <div class="footer">
                <div class="wthree-copyright">
                    <p>© TECHNOLOGY WORLD - All Rights Reserved
                </div>
            </div>
            <!-- / footer -->
        </section>
        <!--main content end-->
    </section>
    <script src="{{ asset('bower_components/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('bower_components/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/jquery.dcjqaccordion.2.7.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/jquery.nicescroll.js') }}"></script>
    <script src="{{ asset('js/style.js') }}"></script>
    <script src="{{ asset('bower_components/toastr/toastr.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/voucher.js') }}"></script>
    
</body>

</html>
