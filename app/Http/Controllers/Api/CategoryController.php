<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        try {
            $categories = $this->categoryRepo->getCategoryWhereNull();

            return response()->json([
                'categories' => $categories,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function create()
    {
        try {
            $categories = $this->categoryRepo->getCategoryWhereNullWithChild();

            return response()->json([
                'categories' => $categories,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(StoreRequest $request)
    {
        try {
            $category = $request->all();
            $slug = createSlug($request->name);
            $category['slug'] = $slug;
            $this->categoryRepo->create($category);
            $message = __('messages.add-success', ['name' => __('titles.category')]);

            return response()->json([
                'message' => $message,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function edit($id)
    {
        try {
            $productCategory =   $this->categoryRepo->find($id);
            $categories = $this->categoryRepo->getCategoryWhereNullWithChild();

            return response()->json([
                'productCategory' => $productCategory,
                'categories' => $categories,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(UpdateRequest $request, $id)
    {
        try {
            $category = $request->all();
            $slug = createSlug($request->name);
            $category['slug'] = $slug;
            $this->categoryRepo->update($id, $category);

            return response()->json([
                'message' => __('messages.update-success', ['name' => __('titles.category')])
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->categoryRepo->delete($id);

            return response()->json([
                'message' => __('messages.delete-success', ['name' => __('titles.category')])
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
