<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\products;
use Illuminate\Http\Request;

use App\Models\groupcategories;
use function PHPUnit\Framework\returnSelf;

class productController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(request $request)
    {
      $group_categories = groupcategories::all();   
        $products = products::with(['groupCategory:id,name'])->get();
    //    dd($categories);
            if (request()->ajax()) {
            return datatables()->of($products)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                        $btn = '';
                    // if(auth()->user()->can('update', $row)) {
                    $btn = '<a href="' . route('products.edit', $row->id) . '" class="edit btn btn-primary btn-sm">Edit</a>';
        // }
        // if(auth()->user()->can('delete', $row)) {
                    $btn .= "<form action='" . route('products.destroy', $row->id) . "' method='POST' style='display:inline;'>
            " . csrf_field() . "
            <button type='submit' class='delete btn btn-danger btn-sm' onclick='return confirm(\"Are you sure " . $row->name . "?\")'>Delete</button>
            </form>";
        // }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        //  Gate::authorize('admin-only');
      
          
        return view('products.index', compact('products','group_categories'));
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
    public function store(Request $request)
    {
    // dd($request->all());
       products::create([
        'name'=>$request->name,
        'description'=>$request->description,
        'price'=>$request->price,
        'amount'=>$request->amount,
        'color'=>$request->color,
        'stock_id'=>$request->stock_id,
        'creater_id'=>$request->user()->id,
        'group_category_id'=>$request->group_category_id,        
       ]); 
       
       return redirect()->back()->with('success','Product created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = products::find($id);
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = products::find($id);
        $product->update([
            'name'=>$request->name,
            'description'=>$request->description,
            'price'=>$request->price,
            'stock'=>$request->stock,
        ]);
        return redirect()->route('products.index')->with('success','Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = products::find($id);
        $product->delete();
        return redirect()->back()->with('success','Product deleted successfully');
    }
}
