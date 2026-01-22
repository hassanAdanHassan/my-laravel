<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\products;
use Illuminate\Http\Request;

use function PHPUnit\Framework\returnSelf;

class productController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(request $request)
    {
     
        $products = products::all();
        return view('products.index', compact('products'));
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
    //  dd($request->all());
       products::create([
        'name'=>$request->name,
        'description'=>$request->description,
        'price'=>$request->price,
        'amount'=>$request->amount,
        'color'=>$request->color,
        'stock_id'=>$request->stock_id,
        'creater_id'=>$request->creater_id,
        'group_category_id'=>$request->group_category_id,
        'stock'=>$request->stock,
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
