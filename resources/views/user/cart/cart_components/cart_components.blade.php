<div class="container lg:grid grid-cols-12 gap-6 items-start pb-16 pt-4 update_cart_url delete_cart_url"
    data-url="{{ route('updateCart') }}"
    data-url_delete="{{ route('deleteCart') }}">
    <!-- product cart -->
    <div class="xl:col-span-9 lg:col-span-8 ">
        <!-- cart title -->
        <div class="bg-gray-200 py-2 pl-12 pr-20 xl:pr-28 mb-4 hidden md:flex shadow-md">
            <p class="text-gray-600 text-center mr-8"> {{ __('titles.product') }}
            </p>
            <p class="text-gray-600 text-center ml-80 mr-16 xl:mr-24">
                {{ __('titles.quantity') }}
            </p>
            <p class="text-gray-600 text-center"> {{ __('titles.Total') }}
            </p>

        </div>
        <!-- cart title end -->
        <!-- shipping carts -->
        <div class="space-y-4">
            @php
                $total = 0;
            @endphp
            @if (Session::get('data'))
                @foreach ($data['carts'] as $id => $cartItem)
                    @php
                        $total += $cartItem['quantity'] * $cartItem['price'];
                    @endphp
                    <div class="shadow-md flex items-center md:justify-between gap-4 md:gap-6 p-4 border border-gray-200 rounded flex-wrap md:flex-nowrap">
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
                            <p class="text-indigo-900 font-semibold">
                                {{ vndFormat($cartItem['price']) }}</p>
                            <input type="hidden" name="_token"
                                value={{ csrf_token() }}>
                        </div>
                        <!-- cart content end -->
                        <!-- cart quantity -->
                        <div class="flex border border-gray-300 text-gray-600 divide-x divide-gray-300">
                            <button id="decrement" onclick="stepper('decrement')"
                                class="h-8 w-8 text-xl flex items-center justify-center cursor-pointer hover:bg-indigo-900 hover:text-white select-none">-</button>
                            <input id="input-number" type="number" min="1"
                                readonly value={{ $cartItem['quantity'] }}
                                class="appearance-none h-8 w-10 flex items-center justify-center cursor-not-allowed text-center quantityProductCart{{ $id }}">
                            <button id="increment" onclick="stepper('increment')"
                                class="h-8 w-8 text-xl flex items-center justify-center cursor-pointer hover:bg-indigo-900 hover:text-white select-none">+</button>
                        </div>
                        <!-- cart quantity end -->
                        <div class="ml-auto md:ml-0">
                            <p class="text-indigo-900 text-lg font-semibold">
                                {{ vndFormat($cartItem['quantity'] * $cartItem['price']) }}
                            </p>
                        </div>
                        <div
                            class="text-gray-600 hover:text-indigo-900 cursor-pointer">
                            <a href="#" data-id="{{ $id }}"
                                class="cart_update bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('titles.update') }}
                            </a>
                            <a href="#" data-id="{{ $id }}"
                                class="bg-indigo-900 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded cart_delete">
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
    @if (isset($data['carts']) && sizeOf($data['carts']) != 0)
        <!-- order summary -->
        <div class="xl:col-span-3 lg:col-span-4 border border-gray-200 px-4 py-4 rounded mt-6 lg:mt-0 shadow-md" id="order-summary">

            <h4 class="text-gray-800 text-lg mb-6 font-medium uppercase">
                {{ __('titles.Order summary') }}
            </h4>
            <div class="space-y-3 text-gray-600 pb-3 border-b border-gray-200 mb-6">
                <div class="flex justify-between font-medium">
                    <p> {{ __('titles.Subtotal') }}</p>
                    <p>{{ vndFormat($total) }}</p>
                </div>
                <div class="flex justify-between">
                    <p> {{ __('titles.Delivery') }}</p>
                    <p>{{ __('titles.Free') }}</p>
                </div>
                <div class="flex justify-between" id="info-discount">
                    <p>
                        {{ __('titles.discount') }}
                        @if ($data['percent'] != 0)
                            {{ ' (' . $data['percent'] . config('voucher.discount') .')' }}
                        @endif
                    </p>
                    <p>{{ vndFormat($data['discount']) }}</p>
                </div>
            </div>
            <div
                class="flex justify-between my-6 text-gray-800 font-semibold uppercase">
                <h4>{{ __('titles.Total') }}</h4>
                <h4>{{ vndFormat($total + $data['discount']) }}</h4>
            </div>
            @if (isset($data['voucher']))
                <div class="info-voucher mb-5 flex justify-between">
                    <span class="text-gray-600">Voucher</span>
                    <div class="space-x-2">
                        <span class="name-voucher text-xs border-dotted border-2 border-gray-500 px-2 py-1 text-gray-500">
                            {{ $data['voucher']->name }}
                        </span>
                        <a  href="#" class="hover:text-gray-500 text-sm cursor-pointer"
                            id="delete_voucher"
                            data-id="{{ $data['voucher']->id }}">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </div>
                </div>
            @endif
            <!-- searchbar -->
            @if(!isset($data['voucher']))
                <form data-url_apply_voucher="{{ route('carts.apply.voucher') }}" id="form_apply_voucher">
                    @error('coupon')
                        <span class="text-red-600 error-text error_coupon text-xs">
                            {{ __($message, ['name' => __('titles.voucher')] )}}
                        </span>
                    @enderror
                    <div class="flex mb-5" >
                        <input type="hidden" name="total" value="{{ $total }}">
                        <input type="text"
                            class="pl-4 w-full border border-r-0 border-indigo-900 py-2 px-3 rounded-l-md focus:ring-indigo-900 focus:border-indigo-900 text-sm"
                            placeholder="Coupon"
                            name="coupon" id="coupon">
                        <button type="submit"
                            id="btn_apply_voucher"
                            class="bg-indigo-900 border border-indigo-900 text-white px-5 font-medium rounded-r-md hover:bg-transparent hover:text-indigo-900 transition text-sm font-roboto">
                            {{ __('titles.Apply') }}
                        </button>
                    </div>
                </form>
            @endif
            {{-- @php
                $orders = auth()->user()->orders;
                foreach ($orders as $order) {
                    if ($order->voucher_id == 22) {
                        dd('true');
                    }
                }
            @endphp --}}
            <!-- searchbar end -->
            <!-- checkout -->
            <a href="{{ route('checkout') }}"
                class="bg-indigo-900 border border-indigo-900 text-white px-4 py-3 font-medium rounded-md uppercase hover:bg-transparent
            hover:text-indigo-900 transition text-sm w-full block text-center">
                {{ __('titles.Process to checkout') }}
            </a>
            <!-- checkout end -->
        </div>
        <!-- order summary end -->
    @endif
    <!-- order summary end -->
</div>
