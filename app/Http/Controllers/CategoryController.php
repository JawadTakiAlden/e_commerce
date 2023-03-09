<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    use HttpResponses;

    public function index()
    {
        $categories = Category::all();
        return CategoryResource::collection($categories);
    }


    public function store(StoreCategoryRequest $request)
    {
        if (Auth::user()->role->name !== 'admin'){
            return $this->errors('you are not authorize to do this request', 401);
        }
        $request->validated($request->all());
        $category = Category::create($request->all());
        return $this->success($category , 'category added successfully');
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        if (Auth::user()->role->name !== 'admin'){
            return $this->errors('you are not authorize to do this request', 401);
        }
        $request->validated($request->all());
        $category->update($request->all());
        return $this->success($category , 'category updated successfully');
    }

    public function destroy(Category $category)
    {
        if (Auth::user()->role->name !== 'admin'){
            return $this->errors('you are not authorize to do this request', 401);
        }
        $category->delete();
        return $this->success('' , 'category deleted successfully');
    }
}
