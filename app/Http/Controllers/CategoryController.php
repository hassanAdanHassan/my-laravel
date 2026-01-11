<?php

namespace App\Http\Controllers;

use App\Models\Category;

use App\Http\Requests\categoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(categoryRequest $categoryRequest)
    {
        
           Category::create([
            'name' => $categoryRequest->name,
            'slug' => $categoryRequest->slug,
            'description' => $categoryRequest->description,
            'amount' => $categoryRequest->amount,
        ]);

        return redirect()->back()->with('success', 'Category created successfully.');
    }

    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id )
    {
        
       $category = Category::findOrFail($id);
       
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(categoryRequest $categoryRequest, string $id )
    {
        $category = Category::findOrFail($id);

        $category->update([
            'name' => $categoryRequest->name,
            'slug' => $categoryRequest->slug,
            'description' => $categoryRequest->description,
            'amount' => $categoryRequest->amount,
        ]);

        return redirect("/category")->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect("/category")->with('success', 'Category deleted successfully.');
    }
}
