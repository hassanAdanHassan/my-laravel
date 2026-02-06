<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\products;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $products = products::all();
        $suppliers = Supplier::with(["user:id,name", "products"])->get();
        // dd($suppliers);
         if (request()->ajax()) {
            return datatables()->of($suppliers)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                        $btn = '';
                // if (auth()->user()->can('update', $row)) {
                    $btn = '<a href="' . route('supplier.edit', $row->id) . '" class="edit btn btn-primary btn-sm">Edit</a>';
        // }
        // if(auth()->user()->can('delete', $row)) {
                    $btn .= "<form action='" . route('supplier.destroy', $row->id) . "' method='POST' style='display:inline;'>
            " . csrf_field() . "
            <button type='submit' class='delete btn btn-danger btn-sm' onclick='return confirm(\"Are you sure " . $row->name . "?\")'>Delete</button>
            </form>";
        // }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
         Gate::authorize('admin-only');
        return view('supplier.index', compact('products'));
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
        //   dd($request->all());
        supplier::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            // 'product_id' => $request->product_id,
            'creater_id' => auth()->id(),
        ]);
        return redirect()->back()->with('success', 'supplier created successfully');
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
        $supplier = supplier::find($id);
        return view('supplier.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $supplier = supplier::find($id);
        $supplier->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address
        ]);

        return redirect()->route("supplier.index")->with("success", "supplier updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $supplier = supplier::find($id);
        $supplier->delete();
        return redirect()->back()->with('success', 'supplier deleted successfully');
    }
}
