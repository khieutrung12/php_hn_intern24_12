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
use App\Repositories\Brand\BrandRepositoryInterface;
use App\Repositories\Image\ImageRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $productRepo;
    protected $imageRepo;
    protected $brandRepo;
    protected $categoryRepo;

    public function __construct(
        ProductRepositoryInterface $productRepo,
        ImageRepositoryInterface $imageRepo,
        BrandRepositoryInterface $brandRepo,
        CategoryRepositoryInterface $categoryRepo
    ) {
        $this->productRepo = $productRepo;
        $this->imageRepo = $imageRepo;
        $this->brandRepo = $brandRepo;
        $this->categoryRepo = $categoryRepo;
    }

    public function index()
    {
        $all_product = $this->productRepo->getProduct();

        return view('admin.product.all_product')->with(compact('all_product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = $this->brandRepo->getAll();
        $categories = $this->categoryRepo->getCategoryWhereNull();


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
        $product = $request->all();
        $product['slug'] = $slug;
        $product['image_thumbnail'] = $new_image_name;
        $product = $this->productRepo->createProduct($product, $request->input('categories', []));
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
            $this->imageRepo->createMultipleImage($data);
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
        $edit_product = $this->productRepo->find($id);
        $brands = $this->brandRepo->getAll();
        $categories = $this->categoryRepo->getCategoryWithParent();

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
        $product = $this->productRepo->find($id);
        $productNew = $request->all();
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
        $productNew['slug'] = $slug;
        $productNew['image_thumbnail'] = $filename;
        $this->productRepo->updateProduct($id, $productNew, $request->input('categories', []));
        if ($request->hasfile('images')) {
            $data = [];
            $images = $this->imageRepo->getImageByProductId($product->id);
            foreach ($images as $image) {
                if (File::exists($uploaded_image . $image->image)) {
                    File::delete($uploaded_image . $image->image);
                }
            }
            $this->imageRepo->deleteMultipleImage($product->id);
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
            $this->imageRepo->createMultipleImage($data);
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
        $product = $this->productRepo->find($id);
        $destination =  $dir_images . $product->image_thumbnail;
        if (File::exists($destination)) {
            File::delete($destination);
        }
        $images = $this->imageRepo->getImageByProductId($product->id);
        foreach ($images as $image) {
            if (File::exists($dir_images . $image->image)) {
                File::delete($dir_images . $image->image);
            }
        }
        $this->productRepo->delete($id);

        Session::flash('mess', __('messages.delete-success', ['name' => __('titles.product')]));

        return Redirect::to(route('products.index'));
    }

    public function deleteimage($id)
    {
        $dir_images = 'images/uploads/products/';
        $images = $this->imageRepo->find($id);
        if (File::exists($dir_images  . $images->image)) {
            File::delete($dir_images  . $images->image);
        }
        $images->delete();

        return back();
    }
}
