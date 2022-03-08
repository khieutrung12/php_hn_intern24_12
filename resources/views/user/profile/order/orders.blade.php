@extends('user.profile.layouts.profile')
@section('content-profile')
    <!-- account content -->
    <div class="col-span-9 shadow rounded px-6 pt-5 pb-7 mt-6 lg:mt-0 bg-white">
        <h3
            class="text-lg font-medium capitalize mb-12 mx-6 pt-3.5 pb-8 border border-l-0 border-t-0 border-r-0">
            {{ __('titles.your-order') }}: {{ $orders->total() }}
            {{ __('titles.order') }}
        </h3>
        @foreach ($orders as $order)
            <h1 class="font-bold">#{{ $order->code }}</h1>
            <h1 class="font-normal my-2">{{ formatDate($order->created_at) }}</h1>
            <button
                class="bg-transparent text-blue-700 font-semibold hover:text-white py-2 rounded my-2">
                <a class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold 
                hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded my-2"
                    href="{{ route('viewDetailOrder', ['id' => $order->id]) }}">
                    @if ($order->orderStatus->id === config('app.unconfirmed'))
                        {{ __('messages.unconfirmed') }}
                    @elseif($order->orderStatus->id === config('app.confirmed'))
                        {{ __('messages.confirmed') }}
                    @else
                        {{ __('messages.canceled') }}
                    @endif
                </a>
            </button>
            <div class="mb-10">
                @foreach ($order->products as $product)
                    <a href="{{ route('show', ['product' => $product->id]) }}">
                        <div
                            class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-4xl bg-gray-100 ">
                            <div class="md:flex">
                                <div class="md:shrink-0">
                                    <img class="h-48 w-full object-cover md:h-full md:w-48"
                                        src="{{ asset('images/uploads/products/' . $product->image_thumbnail) }}"
                                        alt="Man looking at item at a store">
                                </div>
                                <div class="p-8">
                                    <div
                                        class="uppercase tracking-wide text-sm text-indigo-500 font-semibold">
                                        {{ $product->name }}</div>
                                    <a href="#"
                                        class="block mt-1 text-lg leading-tight font-medium text-black hover:underline">x{{ $product->pivot->product_sales_quantity }}</a>
                                    <p class="mt-2 text-slate-500">
                                        {{ vndFormat($product->price) }}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
                <div class="row">
                    <div class="col-sm-5 text-center">
                    </div>
                    <div class="col-sm-7 text-right text-center-xs">
                        <h1
                            class="uppercase tracking-wide text-lg text-indigo-500 font-semibold">
                            {{ __('titles.Total') }}:
                            {{ vndFormat($order->sum_price) }}</h1>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="row">
            <div class="col-sm-5 text-center">
            </div>
            <div class="col-sm-7 text-right text-center-xs">
                <ul class="pagination pagination-sm m-t-none m-b-none">
                </ul>
            </div>
        </div>
        {{ $orders->links() }}
    </div>
    <!-- account content end -->
@endsection
