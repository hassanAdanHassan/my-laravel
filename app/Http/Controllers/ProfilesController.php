<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
 use Illuminate\Support\Facades\Hash;

class ProfilesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return view('user.edit');
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
        //
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
   public function edit()
    {
        $user =auth()->user();
        // dd($id);    
         return view('profile.edit', compact('user'));
   }

  

public function update(Request $request, $id)
{
    // Find the user by ID
    $user = User::findOrFail($id);


    // Update user data (hash the password!)
    $user->update([
        'password' => Hash::make($request->password),
    ]);

    // Redirect back with success message
    return redirect()->route('profile.edit', $user->id)
                     ->with('success', 'Password updated successfully!');
}


    public function destroy(string $id)
    {
        //
    }
}
