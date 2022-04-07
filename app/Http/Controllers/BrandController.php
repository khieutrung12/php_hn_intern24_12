<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Brand\StoreRequest;
use App\Http\Requests\Brand\UpdateRequest;
use App\Repositories\Brand\BrandRepositoryInterface;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $brandRepo;

    public function __construct(
        BrandRepositoryInterface $brandRepo
    ) {
        $this->brandRepo = $brandRepo;
    }
    public function index()
    {
        $all_brand = $this->brandRepo->getAll();

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
        $brand = $request->all();
        $brand['slug'] = $slug;
        $this->brandRepo->create($brand);
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
        $edit_brand = $this->brandRepo->find($id);

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
        $brand = $request->all();
        $slug = createSlug($request->name);
        $brand['slug'] = $slug;
        $this->brandRepo->update($id, $brand);
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
        $this->brandRepo->delete($id);

        Session::flash('mess', __('messages.delete-success', ['name' => __('titles.brand')]));

        return Redirect::route('brands.index');
    }
}
