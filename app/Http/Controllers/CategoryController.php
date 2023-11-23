<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Exception;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Category::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $validated = $request->validated();
        $category = Category::create($validated);

        return $category;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = Category::find($id);
        if ($category == null) {
            return response(['error' => 'Category Not Found!'], 404);
        }
        return response([
            'message' => 'Category was founded successfully!',
            'category' => $category
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if ($category == null) {
            return response(['error' => 'Category Not Found!'], 404);
        }

        return response([
            'message' => 'Category was deleted successfully!',
            'category' => $category
        ], 200);
    }
}
