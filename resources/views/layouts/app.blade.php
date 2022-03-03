<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('titles.' . Route::currentRouteName()) . ' | ' }}Technology
        World</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/style.js') }}" defer></script>
    <script src="https://unpkg.com/@popperjs/core@2.9.1/dist/umd/popper.min.js"
        charset="utf-8"></script>

    <!-- Styles -->
    <link href="{{ asset('bower_components/font-awesome/css/all.css') }}"
        rel="stylesheet">
    <link href="{{ asset('bower_components/toastr/toastr.css') }}"
        rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ mix('css/style-app-user.css') }}" rel="stylesheet">


</head>

<body class="bg-white h-screen antialiased leading-none font-sans">
    <div id="app">

        <!-- header -->
        <header class="py-6 shadow-sm bg-pink-100 lg:bg-white">
            <div class="container flex items-center space-x-32 m-auto">

                <!-- logo -->
                <a href="{{ route('home') }}"
                    class="text-lg font-bold text-teal-800 no-underline">
                    TECHNOLOGY WORLD
                </a>
                <!-- logo end -->

                <!-- searchbar -->
                <div
                    class="w-full xl:max-w-xl lg:max-w-lg lg:flex relative hidden">
                    <input type="text"
                        class="pl-12 w-full border border-r-0 border-indigo-900 py-3 px-3 rounded-l-md focus:border-indigo-900 focus:border-opacity-0"
                        placeholder="{{ __('titles.Search') }}">
                    <button type="submit"
                        class=" border-indigo-700 border bg-indigo-900 text-white px-8 font-medium rounded-r-md hover:bg-transparent hover:text-indigo-900 transition">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <!-- searchbar end -->

                @if (Auth::check() && Auth::user()->role_id == config('auth.roles.user'))
                    <!-- navicons -->
                    <div class="space-x-10 flex items-center justify-center">
                        <a href="#"
                            class="block text-center text-gray-700 hover:text-indigo-900 transition relative">
                            <span
                                class="absolute left-7 bottom-7 w-5 h-5 rounded-full flex items-center justify-center bg-indigo-900 text-white text-xs">
                                5
                            </span>
                            <div class="text-2xl">
                                <i class="far fa-heart"></i>
                            </div>
                            <small class="text-xs leading-3">
                                {{ __('titles.Wish List') }}
                            </small>
                        </a>
                        <a href="{{ route('carts.index') }}"
                            class="lg:block text-center text-gray-700 hover:text-indigo-900 transition hidden relative">
                            @if (App::getLocale() == 'vi')
                                <span
                                    class="absolute left-7 bottom-7 w-5 h-5 rounded-full flex items-center justify-center bg-indigo-900 text-white text-xs count_product"
                                    data-url_count_product="{{ route('countProduct') }}">
                                    @include('user.cart.cart_components.count_product')
                                </span>
                            @else
                                <span
                                    class="absolute left-7 bottom-7 w-5 h-5 rounded-full flex items-center justify-center bg-indigo-900 text-white text-xs count_product"
                                    data-url_count_product="{{ route('countProduct') }}">
                                    @include('user.cart.cart_components.count_product')
                                </span>
                            @endif
                            <div class="text-2xl">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </div>
                            <small class="text-xs leading-3">
                                {{ __('titles.Cart') }}
                            </small>
                        </a>
                        <a href="{{ route('profile.edit', Auth::user()->id) }}"
                            class="block text-center text-gray-700 hover:text-indigo-900 transition">
                            <div class="text-2xl">
                                <i class="far fa-user"></i>
                            </div>
                            <small class="text-xs leading-3">
                                {{ __('titles.Account') }}
                            </small>
                        </a>
                    </div>
                    <!-- navicons end -->
                @elseif (Auth::check() && Auth::user()->role_id == config('auth.roles.admin'))
                    <div class="space-x-10 flex items-center justify-center">
                        <a href="{{ route('admin') }}"
                            class="block text-center text-gray-700 hover:text-indigo-900 transition">
                            <div class="text-2xl">
                                <i class="far fa-user"></i>
                            </div>
                            <small class="text-xs leading-3">
                                {{ __('titles.admin') }}
                            </small>
                        </a>
                    </div>
                @endif

            </div>
        </header>
        <!-- header end -->

        <!-- navbar -->
        <nav class="bg-gray-800 hidden lg:block">
            <div class="container m-auto">
                <div class="flex">
                    <!-- all category -->
                    <div class="bg-indigo-900 flex items-center relative"
                        id="button-dropdown">
                        <button
                            class="cursor-pointer text-white w-full px-12 py-4"
                            type="button">
                            <i class="fas fa-bars"></i>
                            <span
                                class="capitalize ml-2">{{ __('titles.All categories') }}</span>
                        </button>

                        <div
                            class="dropdown absolute left-0 top-full w-full bg-white shadow-md py-3 transition z-50 divide-y divide-gray-300 divide-dashed">
                            @php
                                $sub_1 = 3;
                                $i = 0;
                            @endphp
                            @foreach ($categories as $category)
                                @if ($category->parent_id == null)
                                    <div
                                        class="dropdown-1-{{ $i }}">
                                        <a href="#"
                                            class="relative px-6 py-3 flex items-center hover:bg-gray-100 hover:text-indigo-900 transition text-sm">
                                            {{ $category->name }}
                                        </a>
                                        @if ($category->childCategories->toArray())
                                            <div
                                                class="dropdown-1-sub-{{ $i }} absolute left-full w-full top-{{ $sub_1 }} bg-white shadow-md transition z-50 divide-y divide-gray-300 divide-dashed">
                                                @php
                                                    $sub_2 = 0;
                                                @endphp
                                                @foreach ($category->childCategories as $sub_category)
                                                    <div
                                                        class="dropdown-2-{{ $i }}">
                                                        <a href="#"
                                                            class="px-6 py-3 flex items-center hover:bg-gray-100 hover:text-indigo-900 transition text-sm">
                                                            {{ $sub_category->name }}
                                                        </a>
                                                        @if ($sub_category->childCategories->toArray())
                                                            <div
                                                                class="dropdown-2-sub-{{ $i }} absolute left-full w-full top-{{ $sub_2 }} bg-white shadow-md transition z-50 divide-y divide-gray-300 divide-dashed">
                                                                @foreach ($sub_category->childCategories as $sub)
                                                                    <a href="#"
                                                                        class="dropdown-sub-3 px-6 py-3 flex items-center hover:bg-gray-100 hover:text-indigo-900 transition text-sm">
                                                                        {{ $sub->name }}
                                                                    </a>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                    @php
                                                        $sub_2 += 9;
                                                    @endphp
                                                @endforeach
                                            </div>
                                        @endif
                                        <!-- end dropdown menu level 2 -->
                                    </div>
                                @endif
                                @php
                                    $sub_1 += 9;
                                    $i++;
                                @endphp
                            @endforeach
                        </div>
                    </div>
                    <!-- all category end -->
                    <!-- nav menu -->
                    <div
                        class="flex items-center justify-between flex-grow pl-12">
                        <div
                            class="flex items-center space-x-6 text-base capitalize">
                            <a href="{{ route('home') }}"
                                class="text-gray-200 hover:text-white transition">
                                {{ __('titles.Home') }}
                            </a>
                            <a href="{{ route('shop') }}"
                                class="text-gray-200 hover:text-white transition">
                                {{ __('titles.Shop') }}
                            </a>
                            <a href="#"
                                class="text-gray-200 hover:text-white transition">
                                {{ __('titles.About us') }}
                            </a>
                            <a href="#"
                                class="text-gray-200 hover:text-white transition">
                                {{ __('titles.Contact us') }}
                            </a>
                        </div>
                        <nav
                            class="space-x-4 text-gray-300 text-sm sm:text-base">
                            <span
                                class="rounded-md cursor-default text-sm font-normal text-teal-800 uppercase bg-gray-200 px-4 py-2">
                                {{ App::getLocale() }}
                            </span>
                            @foreach (config('languages') as $key => $lang)
                                @if ($key != App::getLocale())
                                    <a href="{{ route('lang', ['locale' => $key]) }}"
                                        class="rounded-md text-sm font-normal text-gray-300 uppercase hover:bg-gray-200 hover:text-teal-800 px-4 py-2">
                                        {{ $key }}
                                    </a>
                                @endif
                            @endforeach
                            @guest
                                <a class="hover:bg-gray-200 hover:text-teal-800 px-4 py-2 rounded-md"
                                    href="{{ route('login') }}">{{ __('titles.login') }}</a>
                                @if (Route::has('register'))
                                    <a class="hover:bg-gray-200 hover:text-teal-800 px-4 py-2 rounded-md"
                                        href="{{ route('register') }}">{{ __('titles.register') }}</a>
                                @endif
                            @endguest
                        </nav>
                    </div>
                    <!-- nav menu end -->
                </div>
            </div>
        </nav>
        <!-- navbar end -->
        <!-- mobile menubar -->
        <div
            class="fixed w-full border-t border-gray-200 shadow-sm bg-white py-3 bottom-0 left-0 flex justify-around items-start px-6 lg:hidden z-40">
            <a href="javascript:void(0)"
                class="block text-center text-gray-700 hover:text-indigo-900 transition relative">
                <div class="text-2xl" id="menuBar">
                    <i class="fas fa-bars"></i>
                </div>
                <div class="text-xs leading-3">{{ __('titles.Menu') }}</div>
            </a>
            <a href="#"
                class="block text-center text-gray-700 hover:text-indigo-900 transition relative">
                <div class="text-2xl">
                    <i class="fas fa-list-ul"></i>
                </div>
                <div class="text-xs leading-3">{{ __('titles.Category') }}
                </div>
            </a>
            <a href="#"
                class="block text-center text-gray-700 hover:text-indigo-900 transition relative">
                <div class="text-2xl">
                    <i class="fas fa-search"></i>
                </div>
                <div class="text-xs leading-3">{{ __('titles.Search') }}
                </div>
            </a>
            <a href="#"
                class="text-center text-gray-700 hover:text-indigo-900 transition relative">
                @if (App::getLocale() == 'en')
                    <span
                        class="absolute left-4 bottom-5 w-5 h-5 rounded-full flex items-center justify-center bg-indigo-900 text-white text-xs">
                        3
                    </span>
                @else
                    <span
                        class="absolute left-7 bottom-5 w-5 h-5 rounded-full flex items-center justify-center bg-indigo-900 text-white text-xs">
                        3
                    </span>
                @endif
                <div class="text-2xl">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div class="text-xs leading-3">{{ __('titles.Cart') }}</div>
            </a>
        </div>
        <!-- mobile menu end -->

        @yield('content')

        <!-- footer -->
        <footer class="bg-white pt-20 pb-16 border-t border-gray-100 m-auto">
            <div class="container m-auto">
                <div class="xl:grid xl:grid-cols-3 xl:gap-8">
                    <!-- footer text -->
                    <div class="space-y-8 xl:col-span-1">
                        <span class="text-lg font-semibold text-teal-800">
                            TECHNOLOGY WORLD
                        </span>
                        <p class="text-gray-500 text-base">
                            Lorem ipsum dolor sit amet consectetur <br />
                            adipisicing elit.
                        </p>
                        <div class="flex space-x-6">
                            <a href="#"
                                class="text-gray-400 hover:text-gray-500">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#"
                                class="text-gray-400 hover:text-gray-500">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#"
                                class="text-gray-400 hover:text-gray-500">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#"
                                class="text-gray-400 hover:text-gray-500">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>
                    <!-- footer text end -->
                    <!-- footer links -->
                    <div
                        class="mt-12 grid grid-cols-2 gap-8 xl:mt-0 xl:col-span-2">
                        <div class="md:grid md:grid-cols-2 md:gap-8">
                            <div>
                                <h3
                                    class="text-base font-semibold text-gray-400 tracking-wider uppercase">
                                    {{ __('titles.Solutions') }}
                                </h3>
                                <div class="mt-4 space-y-4">
                                    <a href="#"
                                        class="text-lg text-gray-500 hover:text-gray-900 block">
                                        {{ __('titles.Marketing') }}
                                    </a>
                                    <a href="#"
                                        class="text-lg text-gray-500 hover:text-gray-900 block">
                                        {{ __('titles.Analytics') }}
                                    </a>
                                    <a href="#"
                                        class="text-lg text-gray-500 hover:text-gray-900 block">
                                        {{ __('titles.Commerce') }}
                                    </a>
                                    <a href="#"
                                        class="text-lg text-gray-500 hover:text-gray-900 block">
                                        {{ __('titles.Insights') }}
                                    </a>
                                </div>
                            </div>
                            <div class="mt-12 md:mt-0">
                                <h3
                                    class="text-base font-semibold text-gray-400 tracking-wider uppercase">
                                    {{ __('titles.Support') }}
                                </h3>
                                <div class="mt-4 space-y-4">
                                    <a href="#"
                                        class="text-lg text-gray-500 hover:text-gray-900 block">
                                        {{ __('titles.Pricing') }}
                                    </a>
                                    <a href="#"
                                        class="text-lg text-gray-500 hover:text-gray-900 block">
                                        {{ __('titles.Documentation') }}
                                    </a>
                                    <a href="#"
                                        class="text-lg text-gray-500 hover:text-gray-900 block">
                                        {{ __('titles.Guides') }}
                                    </a>
                                    <a href="#"
                                        class="text-lg text-gray-500 hover:text-gray-900 block">
                                        {{ __('titles.API Status') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="md:grid md:grid-cols-2 md:gap-8">
                            <div>
                                <h3
                                    class="text-base font-semibold text-gray-400 tracking-wider uppercase">
                                    {{ __('titles.Company') }}
                                </h3>
                                <div class="mt-4 space-y-4">
                                    <a href="#"
                                        class="text-lg text-gray-500 hover:text-gray-900 block">
                                        {{ __('titles.About') }}
                                    </a>
                                    <a href="#"
                                        class="text-lg text-gray-500 hover:text-gray-900 block">
                                        {{ __('titles.Blog') }}
                                    </a>
                                    <a href="#"
                                        class="text-lg text-gray-500 hover:text-gray-900 block">
                                        {{ __('titles.Jobs') }}
                                    </a>
                                    <a href="#"
                                        class="text-lg text-gray-500 hover:text-gray-900 block">
                                        {{ __('titles.Press') }}
                                    </a>
                                </div>
                            </div>
                            <div class="mt-12 md:mt-0">
                                <h3
                                    class="text-base font-semibold text-gray-400 tracking-wider uppercase">
                                    {{ __('titles.Legal') }}
                                </h3>
                                <div class="mt-4 space-y-4">
                                    <a href="#"
                                        class="text-lg text-gray-500 hover:text-gray-900 block">
                                        {{ __('titles.Claim') }}
                                    </a>
                                    <a href="#"
                                        class="text-lg text-gray-500 hover:text-gray-900 block">
                                        {{ __('titles.Privacy') }}
                                    </a>
                                    <a href="#"
                                        class="text-lg text-gray-500 hover:text-gray-900 block">
                                        {{ __('titles.Policy') }}
                                    </a>
                                    <a href="#"
                                        class="text-lg text-gray-500 hover:text-gray-900 block">
                                        {{ __('titles.Terms') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- footer links end -->
                </div>
            </div>
        </footer>
        <!-- footer end -->

        <!-- copyright -->
        <div class="bg-gray-800 py-4 m-auto">
            <div class="container flex items-center justify-between m-auto">
                <p class="text-white">© TECHNOLOGY WORLD - All Rights
                    Reserved</p>
                <div>
                    <img src="{{ asset('images/methods.png') }}"
                        class="h-5">
                </div>
            </div>
        </div>
        <!-- copyright end -->

    </div>
    <script src="{{ asset('bower_components/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('bower_components/toastr/toastr.js') }}"></script>
    <script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.js') }}">
    </script>
    <script src="{{ asset('js/jquery.dcjqaccordion.2.7.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/cart_update.js') }}"></script>
</body>

</html>
