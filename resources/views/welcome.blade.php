<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Technology World</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100 h-screen antialiased leading-none font-sans">
<div class="flex flex-col">
    @if(Route::has('login'))
        <div class="absolute top-0 right-0 mt-4 mr-4 space-x-4 sm:mt-6 sm:space-x-4">
            <span class="rounded-md cursor-default text-sm font-normal text-teal-800 uppercase bg-blue-200 px-4 py-2">
                {{ App::getLocale() }}
            </span>
            @foreach (config('languages') as $key => $lang)
                @if ($key != App::getLocale())
                    <a 
                        href="{{ route('lang', ['locale' => $key]) }}"
                        class="rounded-md text-sm font-normal text-teal-800 uppercase hover:bg-gray-200 px-4 py-2">
                        {{ $key }}
                    </a>
                @endif
            @endforeach
            @auth
                <a href="{{ url('/home') }}" class="rounded-md hover:bg-gray-200 px-4 py-2 text-sm font-normal text-teal-800 uppercase">{{ __('titles.home') }}</a>
            @else
                <a href="{{ route('login') }}" class="rounded-md hover:bg-gray-200 px-4 py-2 text-sm font-normal text-teal-800 uppercase">{{ __('titles.login') }}</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="rounded-md hover:bg-gray-200 px-4 py-2  text-sm font-normal text-teal-800 uppercase">{{ __('titles.register') }}</a>
                @endif
            @endauth
        </div>
    @endif

    <div class="min-h-screen flex items-center justify-center">
        <div class="flex flex-col justify-around h-full">
            <div>
                <h1 class="mb-6 text-gray-600 text-center font-bold tracking-wider text-4xl sm:mb-8 sm:text-6xl">
                    Technology World
                </h1>
            </div>
        </div>
    </div>
</div>
</body>
</html>
