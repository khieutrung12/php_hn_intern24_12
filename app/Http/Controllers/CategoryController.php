<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Repositories\Category\CategoryRepositoryInterface;

class CategoryController extends Controller
{
    protected $categoryRepo;

    public function __construct(
        CategoryRepositoryInterface $categoryRepo
    ) {
        $this->categoryRepo = $categoryRepo;
    }

    public function index()
    {
        $allCategory = $this->categoryRepo->getCategoryWhereNull();

        return view('admin.category.all_category')->with(compact('allCategory'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->categoryRepo->getCategoryWhereNullWithChild();

        return view('admin.category.add_category')->with(compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $category = $request->all();
        $slug = createSlug($request->name);
        $category['slug'] = $slug;
        $this->categoryRepo->create($category);
        $request->session()->flash('mess', __('messages.add-success', ['name' => __('titles.category')]));

        return redirect()->route('categories.create');
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
        $productCategory =   $this->categoryRepo->find($id);
        $categories = $this->categoryRepo->getCategoryWhereNullWithChild();

        return view('admin.category.edit_category')->with(compact('productCategory', 'categories'));
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
        $category = $request->all();
        $slug = createSlug($request->name);
        $category['slug'] = $slug;
        $this->categoryRepo->update($id, $category);
        $request->session()->flash('mess', __('messages.update-success', ['name' => __('titles.category')]));

        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->categoryRepo->delete($id);
        Session::flash('mess', __('messages.delete-success', ['name' => __('titles.category')]));

        return redirect()->route('categories.index');
    }
}
