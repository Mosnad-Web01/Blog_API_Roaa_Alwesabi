<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // يمكن تركه فارغاً إذا لم يكن هناك واجهة لإنشاء فئة
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'description' => 'nullable|string',
            'language' => 'required|in:ar,en',
        ]);

        $category = Category::create($validated);

        return response()->json(['message' => 'Category created successfully', 'category' => $category], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return response()->json($category, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        // يمكن تركه فارغاً إذا لم يكن هناك واجهة لتحرير فئة
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'description' => 'nullable|string',
            'language' => 'required|in:ar,en',
        ]);

        $category->update($validated);

        return response()->json(['message' => 'Category updated successfully', 'category' => $category], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully'], 200);
    }
}
