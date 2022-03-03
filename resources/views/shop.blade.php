@extends('layouts.app')

@section('content')
    <!-- breadcrum -->
    <div class="container py-4 flex justify-between m-auto">
        <div class="flex gap-3 items-center">
            <a href="{{ route('home') }}" class="text-indigo-900 text-base">
                <i class="fas fa-home"></i>
            </a>
            <span class="text-sm text-gray-400"><i
                    class="fas fa-chevron-right"></i></span>
            <p class="text-gray-600 font-medium">{{ __('titles.Shop') }}</p>
        </div>
    </div>
    <!-- breadcrum end -->
    <!-- shop wrapper -->
    <div
        class="container grid lg:grid-cols-4 gap-6 pt-4 pb-16 items-start relative m-auto">
        <!-- sidebar -->
        <div
            class="col-span-1 bg-white px-4 pt-4 pb-6 shadow rounded overflow-hidden absolute lg:static left-4 top-16 z-10 w-72 lg:w-full lg:block">
            <div class="divide-gray-200 divide-y space-y-5 relative">
                <!-- brand filter -->
                <div class="pt-4 mx-3">
                    <h3 class="text-xl text-gray-800 mb-5 uppercase font-medium">
                        {{ __('titles.Brands') }}</h3>
                    <div class="space-y-4">
                        @foreach ($brands as $brand)
                            <div class="flex items-center">
                                <input type="checkbox" id="Dominik"
                                    class="text-indigo-900 focus:ring-0 rounded-sm cursor-pointer">
                                <label for="Dominik"
                                    class="text-gray-600 ml-3 cursor-pointer hover:text-indigo-900">
                                    {{ $brand->name }}
                                </label>
                                <div class="ml-auto text-gray-600 text-sm">
                                    {{ '(' . count($brand->products->toArray()) . ')' }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- brand filter end -->
                <!-- price filter -->
                <div class="pt-4 mx-3">
                    <h3 class="text-xl text-gray-800 mb-5 uppercase font-medium">
                        {{ __('titles.Price') }}</h3>
                    <div class="mt-4 flex items-center">
                        <input type="text"
                            class="w-full border-gray-300 border focus:border-opacity-0 focus:border-indigo-900 px-3 py-1 text-gray-600 text-sm shadow-sm rounded"
                            placeholder="{{ __('titles.min') }}">
                        <span class="mx-3 text-gray-500">-</span>
                        <input type="text"
                            class="w-full border-gray-300 border focus:border-opacity-0 focus:border-indigo-900 px-3 py-1 text-gray-600 text-sm shadow-sm rounded"
                            placeholder="{{ __('titles.max') }}">
                    </div>
                </div>
                <!-- price filter end -->
            </div>
        </div>
        <!-- sidebar end -->
        <!-- products -->
        <div class="col-span-3">
            <!-- sorting -->
            <div class="mb-4 flex items-center justify-end">
                <button
                    class="bg-indigo-900 border border-indigo-900 text-white px-10 py-3 font-medium rounded uppercase hover:bg-transparent hover:text-indigo-900 transition lg:hidden text-sm mr-3 focus:outline-none">
                    Filter
                </button>
                <select
                    class="w-44 bg-white text-sm text-gray-600 px-4 py-3 border border-gray-300 shadow-sm rounded focus:border-opacity-0 focus:border-indigo-900">
                    @foreach (config('sortproduct') as $key => $sort)
                        <option value="{{ $key }}">
                            {{ __('titles.' . $sort) }}</option>
                    @endforeach
                </select>
            </div>
            <!-- sorting end -->
            <!-- product wrapper -->
            <div class="grid lg:grid-cols-2 xl:grid-cols-3 sm:grid-cols-2 gap-6">
                @foreach ($products as $product)
                    <div
                        class="button-product rounded bg-white shadow overflow-hidden">
                        <div class="relative">
                            <img src="{{ asset('images/uploads/products/' . $product->image_thumbnail) }}"
                                class="w-96 h-96">
                            <div
                                class="product absolute inset-0 bg-black bg-opacity-25 flex items-center justify-center gap-2 opacity-0 transition">
                                <a href="{{ route('show', $product->id) }}"
                                    class="text-white text-lg w-9 h-9 rounded-full bg-indigo-900 hover:bg-gray-800 transition flex items-center justify-center">
                                    <i class="fas fa-search"></i>
                                </a>
                                <a href="#"
                                    class="text-white text-lg w-9 h-9 rounded-full bg-indigo-900 hover:bg-gray-800 transition flex items-center justify-center">
                                    <i class="far fa-heart"></i>
                                </a>
                            </div>
                        </div>
                        <div class="pt-4 pb-3 px-4">
                            <a href="{{ route('show', $product->id) }}">
                                <h4
                                    class="uppercase font-medium text-xl mb-2 text-gray-800 hover:text-indigo-900 transition">
                                    {{ $product->name }}
                                </h4>
                            </a>
                            <div class="flex items-baseline mb-1 space-x-2">
                                <p
                                    class="text-lg text-indigo-900 font-roboto font-semibold">
                                    {{ vndFormat($product->price) }}
                                    <input type="hidden" name="_token"
                                        value={{ csrf_token() }}>
                                </p>
                            </div>
                            <div class="flex items-center">
                                <div class="flex gap-1 text-sm text-yellow-400">
                                    <span><i class="fas fa-star"></i></span>
                                    <span><i class="fas fa-star"></i></span>
                                    <span><i class="fas fa-star"></i></span>
                                    <span><i class="fas fa-star"></i></span>
                                    <span><i class="fas fa-star"></i></span>
                                </div>
                                <div class="text-xs text-gray-500 ml-3">(150)</div>
                            </div>
                        </div>
                        <a href="#"
                            data-url="{{ route('addToCart', ['id' => $product->id]) }}"
                            class="block w-full py-1 text-center text-white bg-indigo-900 border border-indigo-900 rounded-b hover:bg-transparent hover:text-indigo-900 transition add_to_cart">
                            {{ __('titles.Add to Cart') }}
                        </a>
                    </div>
                @endforeach
            </div>
            <!-- product wrapper end -->
        </div>
        <!-- products end -->
    </div>
    <!-- shop wrapper end -->
@endsection
