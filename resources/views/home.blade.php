@extends('layouts.app')

@section('content')
    <!-- banner -->
    <div class="bg-head bg-cover bg-no-repeat bg-center pt-20 pb-40 relative m-auto">
        <div class="container m-auto">
            <!-- banner content -->
            <h1 class="xl:text-6xl md:text-5xl text-4xl text-white font-bold mb-8">
                Technology Is Best <br class="hidden sm:block"> When It Brings People Together
            </h1>
            <!-- banner button -->
            <div class="mt-36">
                <a href="{{ route('shop') }}" class=" bg-indigo-900 border border-indigo-900 text-white px-8 py-3 font-medium rounded-md uppercase hover:bg-gray-200
               hover:text-indigo-900 transition">
                    {{ __('titles.Shop now') }}
                </a>
            </div>
            <!-- banner button end -->
            <!-- banner content end -->
        </div>
    </div>
    <!-- banner end -->

    <!-- features -->
    <div class="container py-16 m-auto">
        <div class="lg:w-10/12 grid md:grid-cols-3 gap-3 lg:gap-6 mx-auto justify-center">

            <!-- single feature -->
            <div
                class="border-indigo-900 border rounded-sm px-8 lg:px-3 lg:py-6 py-4 flex justify-center items-center gap-5 bg-white">
                <img src="{{ asset('images/icons/freeship.png') }}" class="lg:w-12 w-10 h-12 object-contain">
                <div>
                    <h4 class="font-medium capitalize text-lg">{{ __('titles.free shipping') }}</h4>
                    <p class="text-gray-500 text-xs lg:text-sm">{{ __('titles.Order over $200') }}</p>
                </div>
            </div>
            <!-- single feature end -->
            <!-- single feature -->
            <div
                class="border-indigo-900 border rounded-sm px-8 lg:px-3 lg:py-6 py-4 flex justify-center items-center gap-5 bg-white">
                <img src="{{ asset('images/icons/moneyreturn.png') }}" class="lg:w-12 w-10 h-12 object-contain">
                <div>
                    <h4 class="font-medium capitalize text-lg">{{ __('titles.Money returns') }}</h4>
                    <p class="text-gray-500 text-xs lg:text-sm">{{ __('titles.30 Days money return') }}</p>
                </div>
            </div>
            <!-- single feature end -->
            <!-- single feature -->
            <div
                class="border-indigo-900 border rounded-sm px-8 lg:px-3 lg:py-6 py-4 flex justify-center items-center gap-5 bg-white">
                <img src="{{ asset('images/icons/support.png') }}" class="lg:w-12 w-10 h-12 object-contain">
                <div>
                    <h4 class="font-medium capitalize text-lg">{{ __('titles.24/7 Support') }}</h4>
                    <p class="text-gray-500 text-xs lg:text-sm">{{ __('titles.Customer support') }}</p>
                </div>
            </div>
            <!-- single feature end -->

        </div>
    </div>
    <!-- features end -->
@endsection
