<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Routing\Controller;
use App\Http\Requests\categoryRequest;
use App\Http\Requests\categoryUpdateRequest;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
      if(request()->ajax()){
        $categories = Category::with('user')->select('*');
        return datatables()->of($categories)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $btn = '<a href="'.route('category.edit', $row->id).'" class="edit btn btn-primary btn-sm">Edit</a>
            <form action="'.route('category.destroy', $row->id).'" method="POST" style="display:inline;">
            '.csrf_field().'
            <button type="submit" class="delete btn btn-danger btn-sm" onclick="return confirm(\'Are you sure?\')">Delete</button>
            </form>';
            return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
      }
        return view('category.index');
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
            'creater_id' => auth()->id(),
                       
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
