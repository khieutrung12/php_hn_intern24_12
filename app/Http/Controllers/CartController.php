<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carts = session()->get('cart');

        return view('user.cart.cart')->with(compact('carts'));
    }


    public function addToCart($id)
    {
        $product = Product::findorfail($id);
        $cart = session()->get('cart');
        if (isset($cart[$id]['quantity'])) {
            $cart[$id]['quantity'] = $cart[$id]['quantity'] + 1;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image_thumbnail' => $product->image_thumbnail,
            ];
        }
        session()->put('cart', $cart);

        return response()->json([
            'code' => 200,
            'message' => 'success',
            'messageCart' =>  trans('messages.add-success', ['name' => __('titles.product')]),
        ], 200);
    }

    public function updateCart(Request $request)
    {
        if ($request->id && $request->quantity) {
            $carts = session()->get('cart');
            $carts[$request->id]['quantity'] = $request->quantity;
            session()->put('cart', $carts);
            $carts = session()->get('cart');
            $cartComponent = view('user.cart.cart_components.cart_components', compact('carts'))->render();

            return response()->json([
                'cart_component' => $cartComponent,
                'code' => 200,
                'messageCart' =>  trans('messages.update-success', ['name' => __('titles.product')]),
            ], 200);
        }
    }

    public function deleteCart(Request $request)
    {
        if ($request->id) {
            $carts = session()->get('cart');
            unset($carts[$request->id]);
            session()->put('cart', $carts);
            $carts = session()->get('cart');
            $cartComponent = view('user.cart.cart_components.cart_components', compact('carts'))->render();

            return response()->json([
                'cart_component' => $cartComponent,
                'code' => 200,
                'messageCart' =>  trans('messages.delete-success', ['name' => __('titles.product')]),
            ], 200);
        }
    }

    public function countProduct()
    {
        $carts = session()->get('cart');
        session()->put('cart', $carts);
        $carts = session()->get('cart');
        $count_product = view('user.cart.cart_components.count_product')->render();

        return response()->json([
            'count_product' => $count_product,
            'code' => 200,
        ], 200);
    }

    public function addMoreProduct(Request $request, $id)
    {
        if ($request->quantity) {
            $product = Product::findorfail($id);
            $cart = session()->get('cart');
            if (isset($cart[$id]['quantity'])) {
                $cart[$id]['quantity'] = $cart[$id]['quantity'] + $request->quantity;
            } else {
                $cart[$id] = [
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $request->quantity,
                    'image_thumbnail' => $product->image_thumbnail,
                ];
            }
            session()->put('cart', $cart);

            return response()->json([
                'code' => 200,
                'messageCart' =>  trans('messages.add-success', ['name' => __('titles.product')]),
            ], 200);
        }
    }
}
