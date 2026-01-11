<?php

namespace App\Http\Controllers;

use App\Http\Requests\groupRequest;
use App\Models\Category;
use App\Models\GroupCategory;
use Illuminate\Http\Request;

class groupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = GroupCategory::all();
       
        return view('groupCategory.index', compact('groups'));
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
        GroupCategory::create([
            'name' => $request->groupname,
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
        $group = GroupCategory::findOrFail($id);
       
        return view('groupCategory.edit', compact('group'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( request $groupRequest, string $id)
    {
        $group = GroupCategory::findOrFail($id);
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
        $group = GroupCategory::findOrFail($id);
        $group->delete();

        return redirect()->back()->with('success', 'Group Category deleted successfully '. $group->name);
    }
}
