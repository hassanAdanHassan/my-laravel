<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\groupcategories;
use Illuminate\Http\Request;

class groupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(request $request)
    {
        $categories = Category::all();
        $groups = groupcategories::with(['user:id,name','category:id,name'])->get();
        // dd($categories);
      if($request->ajax()){
        return datatables()->of($groups)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $btn = '<a href="'.route('groupCategory.edit', $row->id).'" class="edit btn btn-primary btn-sm">Edit</a>
            <form action="'.route('groupCategory.destroy', $row->id).'" method="POST" style="display:inline;">      
            '.csrf_field().'
            <button type="submit" class="delete btn btn-danger btn-sm" onclick="return confirm(\'Are you sure?\')">Delete</button>
            </form>';
            return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
      }         

        return view('groupCategory.index', compact('groups','categories'));      
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('groupCategory.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(request $request)
    {
        // dd($request->all());
        groupcategories::create([
            'name' => $request->groupname,
            'user_id' => auth()->user()->id,
            'category_id' => $request->category_id
            ]);
        return redirect()->back()->with('success', 'Group Category created successfully.');
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
        $group = groupcategories::findOrFail($id);

        return view('groupCategory.edit', compact('group'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(request $groupRequest, string $id)
    {
        $group = groupcategories::findOrFail($id);
        $group->update([
            'name' => $groupRequest->groupname,
        ]);


        return redirect()->route('groupCategory.index')->with('success', 'Group Category updated successfully ');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $group = groupcategories::findOrFail($id);
        $group->delete();

        return redirect()->back()->with('success', 'Group Category deleted successfully ' . $group->name);
    }
}
