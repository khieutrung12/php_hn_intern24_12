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
        $categories = Category::all();
        $brands = Brand::all();
        $products = Product::all();

        return view('shop', [
            'categories' => $categories,
            'brands' => $brands,
            'products' => $products,
        ]);
    }

    public function show($id)
    {
        $categories = Category::all();
        $product = Product::find($id);

        return view('show', [
            'categories' => $categories,
            'product' => $product,
        ]);
    }
}
