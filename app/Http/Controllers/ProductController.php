<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Image;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_product = Product::with('brand', 'category')->orderby('created_at', 'DESC')
            ->paginate(config('app.limit'));

        return view('admin.product.all_product')->with(compact('all_product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Brand::all();
        $categories = Category::whereNull('parent_id')
            ->get();

        return view('admin.product.add_product')->with(compact('brands', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $uploaded_image = "images/uploads/products";
        $new_image_name = time() . '-' . rand(0, 119) . '-' .  $request->name . '.' .
            $request->image_thumbnail->extension();
        $request->image_thumbnail->move(public_path($uploaded_image), $new_image_name);
        $slug = createSlug($request->name);
        $product = Product::create([
            'brand_id' => $request->brand_id,
            'name' => $request->name,
            'slug' => $slug,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'price' => $request->price,
            'image_thumbnail' => $new_image_name,
        ]);
        $product->category()->sync($request->input('categories', []));
        if ($request->hasFile('images')) {
            $data = [];
            $files = $request->file('images');
            foreach ($files as $key => $file) {
                $imageName = time() . '-' . rand(0, 119) . $file->getClientOriginalName();
                $file->move(public_path($uploaded_image), $imageName);
                $data[$key] = [
                    'product_id' => $product->id,
                    'image' => $imageName,
                ];
            }
            Image::insert($data);
        }
        $request->session()->flash('mess', __('messages.add-success', ['name' => __('titles.category')]));

        return Redirect::route('products.create');
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
        $edit_product = Product::findorfail($id);
        $brands = Brand::all();
        $categories = Category::with('parentCategory.parentCategory')
            ->whereHas('parentCategory.parentCategory')
            ->get();

        return view('admin.product.edit_product')->with(compact('edit_product', 'brands', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $uploaded_image = "images/uploads/products/";
        $product = Product::findorfail($id);
        $slug = createSlug($request->name);
        if ($request->hasfile('image_thumbnail')) {
            $destination = $uploaded_image . $product->image_thumbnail;
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $file = $request->file('image_thumbnail');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '-' . rand(0, 119) . '-' .  $request->name . '.' . $extension;
            $file->move($uploaded_image, $filename);
        } else {
            $filename = $request->image_thumbnail_save;
        }
        $product->update([
            'brand_id' => $request->brand_id,
            'name' => $request->name,
            'slug' => $slug,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'image_thumbnail' => $filename,
        ]);
        $product->category()->sync($request->input('categories', []));
        if ($request->hasfile('images')) {
            $data = [];
            $images = Image::where('product_id', $product->id)->get();
            foreach ($images as $image) {
                if (File::exists($uploaded_image . $image->image)) {
                    File::delete($uploaded_image . $image->image);
                }
            }
            Image::where('product_id', $product->id)->delete();
            $files = $request->file('images');
            foreach ($files as $key => $file) {
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '-' . rand(0, 119) . '-' .   '.' . $extension;
                $file->move($uploaded_image, $filename);
                $data[$key] = [
                    'product_id' => $product->id,
                    'image' => $filename,
                ];
            }
            Image::insert($data);
        }
        $request->session()->flash('mess', __('messages.update-success', ['name' => __('titles.category')]));

        return Redirect::to(route('products.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dir_images = 'images/uploads/products/';
        $product = Product::findorfail($id);
        $destination =  $dir_images . $product->image_thumbnail;
        if (File::exists($destination)) {
            File::delete($destination);
        }
        $images = Image::where('product_id', $product->id)->get();
        foreach ($images as $image) {
            if (File::exists($dir_images . $image->image)) {
                File::delete($dir_images . $image->image);
            }
        }
        $product->delete();
        Session::flash('mess', __('messages.delete-success', ['name' => __('titles.product')]));

        return Redirect::to(route('products.index'));
    }

    public function deleteimage($id)
    {
        $dir_images = 'images/uploads/products/';
        $images = Image::findorfail($id);
        if (File::exists($dir_images  . $images->image)) {
            File::delete($dir_images  . $images->image);
        }
        $images->delete();

        return back();
    }
}
