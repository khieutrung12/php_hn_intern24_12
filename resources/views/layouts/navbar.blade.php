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

                <div class="dropdown absolute left-0 top-full w-full bg-white shadow-md py-3 transition z-50 divide-y divide-gray-300 divide-dashed">
                    @php
                        $space_level_1 = config('view.space_level_1');
                        $index = config('view.index');
                    @endphp
                    @foreach ($categories as $category)
                        @if ($category->parent_id == null)
                            <div
                                class="dropdown-1-{{ $index }}">
                                <a href="#"
                                    class="relative px-6 py-3 flex items-center hover:bg-gray-100 hover:text-indigo-900 transition text-sm">
                                    {{ $category->name }}
                                </a>
                                @if ($category->childCategories->toArray())
                                    <div
                                        class="dropdown-1-sub-{{ $index }} absolute left-full w-full top-{{ $space_level_1 }} bg-white shadow-md transition z-50 divide-y divide-gray-300 divide-dashed">
                                        @php
                                            $space_level_2 = config('view.space_level_2');
                                        @endphp
                                        @foreach ($category->childCategories as $sub_category)
                                            <div
                                                class="dropdown-2-{{ $index }}">
                                                <a href="#"
                                                    class="px-6 py-3 flex items-center hover:bg-gray-100 hover:text-indigo-900 transition text-sm">
                                                    {{ $sub_category->name }}
                                                </a>
                                                @if ($sub_category->childCategories->toArray())
                                                    <div
                                                        class="dropdown-2-sub-{{ $index }} absolute left-full w-full top-{{ $space_level_2 }} bg-white shadow-md transition z-50 divide-y divide-gray-300 divide-dashed">
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
                                                $space_level_2 += config('view.space_step');
                                            @endphp
                                        @endforeach
                                    </div>
                                @endif
                                <!-- end dropdown menu level 2 -->
                            </div>
                        @endif
                        @php
                            $space_level_1 += config('view.space_step');
                            $index++;
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
