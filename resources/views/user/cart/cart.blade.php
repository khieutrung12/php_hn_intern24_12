@extends('layouts.app')

@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <link rel="stylesheet" href="{{ mix('css/style-tailwind.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/style-custom.css') }}" />
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    </head>

    <body>
        <!-- cart wrapper -->
        <div id="cart_wrapper">
            @include('user.cart.cart_components.cart_components')
        </div>

    </body>

    </html>
@endsection
