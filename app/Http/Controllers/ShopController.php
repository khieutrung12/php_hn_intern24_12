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
        $brands = Brand::all();
        $products = Product::all();

        return view('shop', [
            'brands' => $brands,
            'products' => $products,
        ]);
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->first();

        return view('show', [
            'product' => $product,
        ]);
    }
}
