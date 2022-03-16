<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
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
        $topNew = Product::orderby('created_at', 'DESC')
            ->take(config('app.limit_top_new'))->get();

        return view('home', [
            'topNew' => $topNew,
        ]);
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

    public function searchByCategory($category, Category $childCategory = null, $childCategory2 = null)
    {
        $ids  = collect();
        $brands = Brand::all();
        if ($childCategory2) {
            $subCategory = $childCategory->childCategories()->where('slug', $childCategory2)->firstOrFail();
            $ids = collect($subCategory->id);
        } elseif ($childCategory) {
            $ids = $childCategory->childCategories->pluck('id');
        } elseif ($category) {
            $category = Category::where('slug', $category)->with('childCategories.childCategories')->get();
            foreach ($category as $subCategory) {
                foreach ($subCategory->childCategories as $subSubCategory) {
                    $ids = $ids->merge($subSubCategory->childCategories->pluck('id'));
                }
            }
        }
        $products = Product::whereHas('category', function ($query) use ($ids) {
            $query->whereIn('category_id', $ids);
        })
            ->get();

        return view('shop')->with(compact('products', 'brands'));
    }
}
