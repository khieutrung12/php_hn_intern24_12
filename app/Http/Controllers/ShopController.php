<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $brands = Brand::with('products')->get();
        $products = Product::orderby('created_at', 'DESC')
            ->paginate(config('app.limit'));

        return view('shop', [
            'brands' => $brands,
            'products' => $products,
        ]);
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->with('brand')
            ->first();

        return view('show', [
            'product' => $product,
        ]);
    }
}
