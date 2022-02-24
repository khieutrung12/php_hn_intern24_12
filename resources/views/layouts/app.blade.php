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

    <!-- Styles -->
    <link 
        href="{{ asset('bower_components/font-awesome/css/all.css') }}"
        rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

</head>

<body class="bg-gray-100 h-screen antialiased leading-none font-sans">
    <div id="app">

        <!-- header -->
        <header class="py-6 shadow-sm bg-pink-100 lg:bg-white">
            <div class="container flex items-center justify-between m-auto">

                <!-- logo -->
                <a href="{{ route('home') }}" class="text-lg font-semibold text-teal-800 no-underline">
                    TECHNOLOGY WORLD
                </a>
                <!-- logo end -->

                <!-- searchbar -->
                <div class="w-full xl:max-w-xl lg:max-w-lg lg:flex relative hidden">
                    <input type="text"
                        class="pl-12 w-full border border-r-0 border-red-500 py-3 px-3 rounded-l-md focus:border-red-500 focus:border-opacity-75"
                        placeholder="{{ __('titles.Search') }}">
                    <button type="submit"
                        class=" border-red-500 border bg-red-500 text-white px-8 font-medium rounded-r-md hover:bg-transparent hover:text-red-500 transition">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <!-- searchbar end -->

                @if (Auth::user() != null)
                    <!-- navicons -->
                    <div class="space-x-10 flex items-center justify-center">
                        <a href="#"
                        class="block text-center text-gray-700 hover:text-red-500 transition relative">
                            <span
                                class="absolute left-7 bottom-7 w-5 h-5 rounded-full flex items-center justify-center bg-red-500 text-white text-xs">
                                5
                            </span>
                            <div class="text-2xl">
                                <i class="far fa-heart"></i>
                            </div>
                            <small class="text-xs leading-3">
                                {{ __('titles.Wish List') }}
                            </small>
                        </a>
                        <a href="#"
                        class="lg:block text-center text-gray-700 hover:text-red-500 transition hidden relative">
                            @if (App::getLocale() == 'vi')
                                <span
                                    class="absolute left-7 bottom-7 w-5 h-5 rounded-full flex items-center justify-center bg-red-500 text-white text-xs">
                                    3
                                </span>
                            @else
                                <span
                                    class="absolute left-4 bottom-7 w-5 h-5 rounded-full flex items-center justify-center bg-red-500 text-white text-xs">
                                    3
                                </span>
                            @endif
                            <div class="text-2xl">
                                <i class="fas fa-shopping-bag"></i>
                            </div>
                            <small class="text-xs leading-3">
                                {{ __('titles.Cart') }}
                            </small>
                        </a>
                        <a href="{{ route('profile.edit', Auth::user()->id) }}" class="block text-center text-gray-700 hover:text-red-500 transition">
                            <div class="text-2xl">
                                <i class="far fa-user"></i>
                            </div>
                            <small class="text-xs leading-3">
                                {{ __('titles.Account') }}
                            </small>
                        </a>
                    </div>
                    <!-- navicons end -->
                @endif
                
            </div>
        </header>
        <!-- header end -->

        <!-- navbar -->
        <nav class="bg-gray-800 hidden lg:block">
            <div class="container m-auto">
                <div class="flex">

                    <!-- all category -->
                    <div class="group px-8 py-4 bg-red-500 flex items-center cursor-pointer relative">
                        <span class="text-white">
                            <i class="fas fa-bars"></i>
                        </span>
                        <span class="capitalize ml-2 text-white">
                            {{ __('titles.All categories') }}
                        </span>
                    </div>
                    <!-- all category end -->

                    <!-- nav menu -->
                    <div class="flex items-center justify-between flex-grow pl-12">
                        <div class="flex items-center space-x-6 text-base capitalize">
                            <a href="#" class="text-gray-200 hover:text-white transition">
                                {{ __('titles.Home') }}
                            </a>
                            <a href="#" class="text-gray-200 hover:text-white transition">
                                {{ __('titles.Shop') }}
                            </a>
                            <a href="#" class="text-gray-200 hover:text-white transition">
                                {{ __('titles.About us') }}
                            </a>
                            <a href="#" class="text-gray-200 hover:text-white transition">
                                {{ __('titles.Contact us') }}
                            </a>
                        </div>
                        <nav class="space-x-4 text-gray-300 text-sm sm:text-base">
                            <span class="rounded-md cursor-default text-sm font-normal text-teal-800 uppercase bg-gray-200 px-4 py-2">
                                {{ App::getLocale() }}
                            </span>
                            @foreach (config('languages') as $key => $lang)
                                @if ($key != App::getLocale())
                                    <a 
                                        href="{{ route('lang', ['locale' => $key]) }}"
                                        class="rounded-md text-sm font-normal text-gray-300 uppercase hover:bg-gray-200 hover:text-teal-800 px-4 py-2">
                                        {{ $key }}
                                    </a>
                                @endif
                            @endforeach
                            @guest
                                <a class="hover:bg-gray-200 hover:text-teal-800 px-4 py-2 rounded-md" href="{{ route('login') }}">{{ __('titles.login') }}</a>
                                @if (Route::has('register'))
                                    <a class="hover:bg-gray-200 hover:text-teal-800 px-4 py-2 rounded-md" href="{{ route('register') }}">{{ __('titles.register') }}</a>
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
            <a href="javascript:void(0)" class="block text-center text-gray-700 hover:text-red-500 transition relative">
                <div class="text-2xl" id="menuBar">
                    <i class="fas fa-bars"></i>
                </div>
                <div class="text-xs leading-3">{{ __('titles.Menu') }}</div>
            </a>
            <a href="#" class="block text-center text-gray-700 hover:text-red-500 transition relative">
                <div class="text-2xl">
                    <i class="fas fa-list-ul"></i>
                </div>
                <div class="text-xs leading-3">{{ __('titles.Category') }}</div>
            </a>
            <a href="#" class="block text-center text-gray-700 hover:text-red-500 transition relative">
                <div class="text-2xl">
                    <i class="fas fa-search"></i>
                </div>
                <div class="text-xs leading-3">{{ __('titles.Search') }}</div>
            </a>
            <a href="#" class="text-center text-gray-700 hover:text-red-500 transition relative">
                @if (App::getLocale() == 'en')
                    <span
                        class="absolute left-4 bottom-5 w-5 h-5 rounded-full flex items-center justify-center bg-red-500 text-white text-xs">
                        3
                    </span>
                @else
                    <span
                        class="absolute left-7 bottom-5 w-5 h-5 rounded-full flex items-center justify-center bg-red-500 text-white text-xs">
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
        
    </div>
</body>

</html>
