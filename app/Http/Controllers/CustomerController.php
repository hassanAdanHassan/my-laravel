<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::with(["user:id,name"])->get();
         if (request()->ajax()) {
            return datatables()->of($customers)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('customer.edit', $row->id) . '" class="edit btn btn-primary btn-sm">Edit</a>';
                    $btn .= "<form action='" . route('customer.destroy', $row->id) . "' method='POST' style='display:inline;'>
            " . csrf_field() . "
            <button type='submit' class='delete btn btn-danger btn-sm' onclick='return confirm(\"Are you sure " . $row->name . "?\")'>Delete</button>
            </form>";
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
         Gate::authorize('admin-only');
        return view('customer.index');
    }

    public function store(Request $request)
    {
        Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'creater_id' => auth()->id(),
        ]);
        return redirect()->back()->with('success', 'Customer created successfully');
    }

    public function edit(string $id)
    {
        $customer = Customer::find($id);
        return view('customer.edit', compact('customer'));
    }

    public function update(Request $request, string $id)
    {
        $customer = Customer::find($id);
        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address
        ]);

        return redirect()->route("customer.index")->with("success", "Customer updated successfully");
    }

    public function destroy(string $id)
    {
        $customer = Customer::find($id);
        $customer->delete();
        return redirect()->back()->with('success', 'Customer deleted successfully');
    }
}
