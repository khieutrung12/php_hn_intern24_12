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
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="bg-gray-100 h-screen antialiased leading-none font-sans">
    <div id="app">
        <header class="bg-blue-900 py-6">
            <div class=" mx-auto flex justify-between items-center px-6">
                <div>
                    <a href="{{ route('welcome') }}"
                        class="text-lg font-semibold text-gray-100 no-underline">
                        Technology World
                    </a>
                </div>
                <nav class="space-x-4 text-gray-300 text-sm sm:text-base">
                    @guest
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
                        <a class="hover:bg-gray-200 hover:text-teal-800 px-4 py-2 rounded-md"
                            href="{{ route('login') }}">{{ __('titles.login') }}</a>
                        @if (Route::has('register'))
                            <a class="hover:bg-gray-200 hover:text-teal-800 px-4 py-2 rounded-md"
                                href="{{ route('register') }}">{{ __('titles.register') }}</a>
                        @endif
                    @else
                        <span
                            class="font-bold mr-2">{{ Auth::user()->name }}</span>
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
                        <a href="{{ route('logout') }}"
                            class="hover:bg-gray-200 hover:text-teal-800 px-4 py-2 rounded-md"
                            onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">{{ __('titles.logout') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}"
                            method="POST" class="hidden">
                            {{ csrf_field() }}
                        </form>
                    @endguest
                </nav>
            </div>
        </header>

        @yield('content')
    </div>
</body>

</html>
