<div class="container lg:grid grid-cols-12 gap-6 items-start pb-16 pt-4 update_cart_url delete_cart_url"
    data-url="{{ route('updateCart') }}"
    data-url_delete="{{ route('deleteCart') }}">
    <!-- product cart -->
    <div class="xl:col-span-9 lg:col-span-8 ">
        <!-- cart title -->
        <div class="bg-gray-200 py-2 pl-12 pr-20 xl:pr-28 mb-4 hidden md:flex">
            <p class="text-gray-600 text-center"> {{ __('titles.product') }}
            </p>
            <p class="text-gray-600 text-center ml-72 mr-16 xl:mr-24">
                {{ __('titles.quantity') }}
            </p>
            <p class="text-gray-600 text-center"> {{ __('titles.Total') }}
            </p>
            {{-- <p class="text-gray-600 text-center">Chỉnh sửa</p> --}}

        </div>
        <!-- cart title end -->

        <!-- shipping carts -->

        <div class="space-y-4">
            @php
                $total = 0;
            @endphp
            @if (Session::get('cart'))
                @foreach ($carts as $id => $cartItem)
                    @php
                        $total += $cartItem['quantity'] * $cartItem['price'];
                    @endphp
                    <div
                        class="flex items-center md:justify-between gap-4 md:gap-6 p-4 border border-gray-200 rounded flex-wrap md:flex-nowrap">
                        <!-- cart image -->

                        <div class="w-32 flex-shrink-0 style-image">
                            <img src="{{ asset('images/uploads/products/' . $cartItem['image_thumbnail']) }}"
                                class="style-image w-full style-image">
                        </div>
                        <!-- cart image end -->
                        <!-- cart content -->
                        <div class="md:w-1/4 w-full">
                            <h2
                                class="text-gray-800 mb-3 xl:text-xl textl-lg font-medium uppercase">
                                {{ $cartItem['name'] }}
                            </h2>
                            <p class="text-primary font-semibold">
                                {{ vndFormat($cartItem['price']) }}</p>
                            <input type="hidden" name="_token"
                                value={{ csrf_token() }}>
                        </div>
                        <!-- cart content end -->
                        <!-- cart quantity -->
                        <div
                            class="flex border border-gray-300 text-gray-600 divide-x divide-gray-300">
                            <input type="number"
                                class="bg-gray-300 font-semibold number-width outline-none quantityProductCart{{ $id }}"
                                name="custom-input-number" min="1"
                                value="{{ $cartItem['quantity'] }}">

                        </div>

                        <!-- cart quantity end -->
                        <div class="ml-auto md:ml-0">
                            <p class="text-primary text-lg font-semibold">
                                {{ vndFormat($cartItem['quantity'] * $cartItem['price']) }}
                            </p>
                        </div>
                        <div
                            class="text-gray-600 hover:text-primary cursor-pointer">
                            <a href="#" data-id="{{ $id }}"
                                class="cart_update bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('titles.update') }}
                            </a>
                            <a href="#" data-id="{{ $id }}"
                                class="bg-red-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded cart_delete">
                                {{ __('titles.delete') }}

                            </a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- shipping carts end -->
    </div>
    <!-- product cart end -->
    <!-- order summary -->
    <div
        class="xl:col-span-3 lg:col-span-4 border border-gray-200 px-4 py-4 rounded mt-6 lg:mt-0">
        <h4 class="text-gray-800 text-lg mb-4 font-medium uppercase">
            {{ __('titles.Order summary') }}</h4>
        <div class="space-y-1 text-gray-600 pb-3 border-b border-gray-200">
            <div class="flex justify-between font-medium">
                <p> {{ __('titles.Subtotal') }}</p>
                <p>{{ vndFormat($total) }}</p>
            </div>
            <div class="flex justify-between">
                <p> {{ __('titles.Delivery') }}</p>
                <p>{{ __('titles.Free') }}</p>
            </div>

        </div>
        <div
            class="flex justify-between my-3 text-gray-800 font-semibold uppercase">
            <h4>{{ __('titles.Total') }}</h4>
            <h4>{{ vndFormat($total) }}</h4>
        </div>

        <!-- searchbar -->
        <div class="flex mb-5">
            <input type="text"
                class="pl-4 w-full border border-r-0 border-primary py-2 px-3 rounded-l-md focus:ring-primary focus:border-primary text-sm"
                placeholder="Coupon">
            <button type="submit"
                class="bg-primary border border-primary text-white px-5 font-medium rounded-r-md hover:bg-transparent hover:text-primary transition text-sm font-roboto">
                {{ __('titles.Apply') }}
            </button>
        </div>
        <!-- searchbar end -->

        <!-- checkout -->
        <a href="checkout.html"
            class="bg-primary border border-primary text-white px-4 py-3 font-medium rounded-md uppercase hover:bg-transparent
         hover:text-primary transition text-sm w-full block text-center">
            {{ __('titles.Process to checkout') }}
        </a>
        <!-- checkout end -->
    </div>
    <!-- order summary end -->
</div>
