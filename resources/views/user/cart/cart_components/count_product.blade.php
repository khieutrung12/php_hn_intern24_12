@if (Session::has('cart'))
    <span id="update_count_product">{{ count(Session::get('cart')) }}</span>
@else
    <span>0</span>
@endif
