<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function search(Request $request)
    {
        $products = Product::where('name', 'LIKE', '%' . $request->name . '%')
            ->take(config('app.limit_search'))->get();

        return view('layouts.search', [
            'products' => $products,
            'key' => request('name'),
        ]);
    }

    public function searchList($key)
    {
        $products = Product::where('name', 'LIKE', '%' . $key . '%')
            ->with('brand')
            ->paginate(config('app.limit'));

        if (count($products) == 0) {
            return view('error_search');
        }

        $brands = [];
        foreach ($products as $product) {
            if (isset($brands[$product->brand->name])) {
                $brands[$product->brand->name] += 1;
            } else {
                $brands[$product->brand->name] = 1;
            }
        }

        return view('shop', [
            'products' => $products,
            'brands' => $brands,
            'key' => $key,
            'action' => 'search',
        ]);
    }
}
