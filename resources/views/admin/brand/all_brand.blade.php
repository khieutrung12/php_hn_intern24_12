@extends('admin.admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ __('titles.all-brand') }}
            </div>
            <div class="table-responsive">
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
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th class="width-css">
                            </th>
                            <th>{{ __('titles.brand-name') }}</th>
                            <th>{{ __('titles.slug') }}</th>
                            <th class="width-css"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($all_brand as $key => $brand_pro)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <p class="stt">
                                        {{ $brand_pro->name }}</p>
                                </td>
                                <td>
                                    {{ $brand_pro->slug }}
                                </td>
                                <td>
                                    <a href="{{ route('brands.edit', ['brand' => $brand_pro->id]) }}"
                                        class="active styling-edit"
                                        ui-toggle-class="">
                                        <i
                                            class="fas fa-edit text-success text-active"></i></a>
                                    <form
                                        action="{{ route('brands.destroy', ['brand' => $brand_pro->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-icon"
                                            onclick="return confirm('{{ __('messages.confirmDelete', ['name' => __('titles.brand')]) }}')">
                                            <i
                                                class="fa fa-times text-danger text"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-sm-5 text-center">
                    </div>
                    <div class="col-sm-7 text-right text-center-xs">
                        <ul class="pagination pagination-sm m-t-none m-b-none">
                            {{ $all_brand->links() }}
                        </ul>
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection
