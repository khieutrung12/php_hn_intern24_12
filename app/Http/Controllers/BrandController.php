<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Brand\StoreRequest;
use App\Http\Requests\Brand\UpdateRequest;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_brand = Brand::orderby('created_at', 'DESC')->paginate(config('app.limit'));

        return view('admin.brand.all_brand')->with(compact('all_brand'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.brand.add_brand');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $slug = createSlug($request->name);
        Brand::create([
            'name' => $request->name,
            'slug' => $slug,
        ]);
        $request->session()->flash('mess', __('messages.add-success', ['name' => __('titles.brand')]));

        return Redirect::route('brands.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edit_brand = Brand::findorfail($id);

        return view('admin.brand.edit_brand')->with(compact('edit_brand'));
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
        $brand = Brand::findorfail($id);
        $slug = createSlug($request->name);
        $brand->update([
            'name' => $request->name,
            'slug' => $slug,
        ]);
        $request->session()->flash('mess', __('messages.update-success', ['name' => __('titles.brand')]));

        return Redirect::route('brands.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete_brand = Brand::findorfail($id);
        $delete_brand->delete();

        Session::flash('mess', __('messages.delete-success', ['name' => __('titles.brand')]));
        return Redirect::route('brands.index');
    }
}
