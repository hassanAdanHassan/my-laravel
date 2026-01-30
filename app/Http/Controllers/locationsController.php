<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\location;
class locationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->ajax()){
            $locations = location::all();
            return datatables()->of($locations)
             ->addColumn('action', function($row){
                $btn = '<a href="'.route('location.edit', $row->id).'" class="edit btn btn-primary btn-sm">Edit</a>
                <form action="'.route('location.destroy', $row->id).'" method="POST" style="display:inline;">      
                '.csrf_field().'
                <button type="submit" class="delete btn btn-danger btn-sm" onclick="return confirm(\'Are you sure?\')">Delete</button>
                </form>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);

        }
        return view('location.index');
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
        //validation
        $request->validate([
            'country' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'village' => 'required|string|max:255',
            'zoon' => 'required|string|max:255',
            'state' => 'required|string|max:255',
        ]);
        //create location
        $location = new location();
        $location->country = $request->country;
        $location->province = $request->province;
        $location->district = $request->district;
        $location->village = $request->village;
        $location->zoon = $request->zoon;
        $location->state = $request->state;
        $location->save();  
        return redirect()->route('location.index')->with('success', 'Location created successfully.');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
