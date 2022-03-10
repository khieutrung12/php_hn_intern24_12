<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Voucher;
use App\Models\Shipping;
use App\Models\OrderStatus;
use Illuminate\Support\Str;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Order\StoreRequest;

class OrderController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::whereNotIn('order_status_id', [config('app.canceled')])
            ->orderby('created_at', 'DESC')->paginate(config('app.limit'));

        return view('admin.order.all_order')->with(compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        if (Session::has('cart')) {
            $order_status = config('app.startOrderStatus');
            $code = Str::random(config('app.limitRandomString'));
            $data = Session::get('data');
            $voucher_id  = $data['voucher']->id;

            $shipping = Shipping::create([
                'name' => $request->name,
                'address' => $request->address,
                'phone' => $request->phone,
                'note' => $request->note,
                'email' => $request->email,
            ]);

            $voucher = Voucher::where('id', $voucher_id)
                ->update([ 'quantity' => $data['voucher']->quantity - 1]);

            $orders = Order::create([
                'user_id' => $request->user_id,
                'order_status_id' => $order_status,
                'code' => $code,
                'sum_price' => $request->sum_price,
                'shipping_id' => $shipping->id,
                'voucher_id' => $voucher_id,
            ]);
            
            $order_product = [];
            if (Session::has('cart')) {
                $carts = session()->get('cart');
                foreach ($carts as $key => $cart) {
                    $order_product[$key] = [
                        'order_id' => $orders->id,
                        'product_id' => $key,
                        'product_sales_quantity' => $cart['quantity'],
                    ];
                }
            }
            OrderProduct::insert($order_product);
            session()->forget('cart');
            session()->forget('data');

            return view('user.checkout.order_complete');
        } else {
            Session::flash('mess', __('messages.cart-empty'));

            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::findorfail($id);
        $order_status = OrderStatus::all();

        return view('admin.order.view_order')->with(compact('order', 'order_status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = Order::findorfail($id);
        $order_status_id = $request->order_status_id;
        if ($order_status_id == config('app.confirmed')) {
            foreach ($order->products as $key => $product) {
                DB::table('products')->where('id', $product->id)
                    ->decrement('quantity', $product->pivot->product_sales_quantity);
            }
        } elseif ($order_status_id != config('app.confirmed') && $order_status_id != config('app.canceled')) {
            foreach ($order->products as $key => $product) {
                DB::table('products')->where('id', $product->id)
                    ->increment('quantity', $product->pivot->product_sales_quantity);
            }
        }
        $order->update([
            'order_status_id' => $request->order_status_id,
        ]);
        $request->session()->flash('mess', __('messages.update-success', ['name' => __('titles.order')]));

        return redirect()->route('orders.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function infoCheckout()
    {
        $carts = [];
        $discount = 0;
        $percent = 0;

        if (Session::has('data')) {
            $data = session()->get('data');
            $carts = $data['carts'];
            $discount = $data['discount'];
            $percent = $data['percent'];
            session()->put('cart', $carts);
        }

        return view('user.checkout.checkout', [
            'carts' => $carts,
            'discount' => $discount,
            'percent' => $percent,
        ]);
    }

    public function allCancelOrder()
    {
        $orders = Order::whereIn('order_status_id', [config('app.canceled')])
            ->orderby('created_at', 'DESC')->paginate(config('app.limit'));

        return view('admin.order.all_cancel_order')->with(compact('orders'));
    }

    public function viewCancelOrder($id)
    {
        $order = Order::findorfail($id);
        $order_status = OrderStatus::all();

        return view('admin.order.view_cancel_order')->with(compact('order'));
    }
}
