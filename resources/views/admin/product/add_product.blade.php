@extends('admin.admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    {{ __('titles.add-var', ['name' => __('titles.product')]) }}
                </header>
                @if ($errors->any())
                    <div class="alert alert-danger text-center">
                        {{ __('messages.error') }}
                    </div>
                @endif
                <div class="panel-body">
                    <div class="position-center">
                        <form role="form" action="{{ route('products.store') }}"
                            method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            @php
                                $mess = Session::get('mess');
                            @endphp
                            @if ($mess)
                                <span class="text-alert">{{ $mess }}
                                </span>
                                <br><br>
                                @php
                                    Session::put('mess', null);
                                @endphp
                            @endif
                            <div class="form-group">
                                <label for="exampleInputEmail1">
                                    {{ __('titles.name-var', ['name' => __('titles.product')]) }}
                                </label>
                                <input type="text" name="name" class="form-control"
                                    id="exampleInputEmail1"
                                    value="{{ old('name') }}">
                                @error('name')
                                    <span class="text-alert">
                                        {{ __($message, ['name' => __('titles.name-var', ['name' => __('titles.product')])]) }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">
                                    {{ __('titles.quantity') }}</label>
                                <input type="text" name="quantity"
                                    class="form-control"
                                    value="{{ old('quantity') }}">
                                @error('quantity')
                                    <span class="text-alert">
                                        {{ __($message, ['name' => __('titles.quantity')]) }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">
                                    {{ __('titles.price') }}</label>
                                <input type="text" name="price"
                                    class="form-control" id="exampleInputEmail1"
                                    value="{{ old('price') }}">
                                @error('price')
                                    <span class="text-alert">
                                        {{ __($message, ['name' => __('titles.price')]) }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">
                                    {{ __('titles.description') }}</label>
                                <textarea type="text" name="description"
                                    class="form-control"
                                    id="add_product_ckeditor">
                                                    {{ old('description') }}
                                                    </textarea>
                                @error('description')
                                    <span class="text-alert">
                                        {{ __($message, ['name' => __('titles.description')]) }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">
                                    {{ __('titles.name-var', ['name' => __('titles.brand')]) }}</label>
                                <select name="brand_id"
                                    class="form-control input-sm m-bot15">
                                    @foreach ($brands as $key => $brand)
                                        <option value="{{ $brand->id }}">
                                            {{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">
                                    {{ __('titles.name-var', ['name' => __('titles.category')]) }}</label>
                                <select name="category_id"
                                    class="form-control select2">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $category->id ? 'selected' : '' }}>
                                            {{ $category->parentCategory->parentCategory->name }}
                                            /
                                            {{ $category->parentCategory->name }}
                                            / {{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">
                                    {{ __('titles.image-thumbnail') }}</label>
                                <input type="file" name="image_thumbnail"
                                    class="form-control" id="exampleInputEmail1">
                                @error('image_thumbnail')
                                    <span class="text-alert">
                                        {{ __($message, ['name' => __('titles.image_thumbnail')]) }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">
                                    {{ __('titles.list-image') }}
                                </label>
                                <input type="file" name="images[]"
                                    class="form-control" id="exampleInputEmail1"
                                    multiple />
                                @error('images')
                                    <span class="text-alert">
                                        {{ __($message, ['name' => __('title.list-image')]) }}</span>
                                @enderror
                            </div>
                            <button type="submit" name="add_product"
                                class="btn btn-info">
                                {{ __('titles.add') }}</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
