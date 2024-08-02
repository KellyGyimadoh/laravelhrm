<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated=$request->validate([
            'email'=>['required','email'],
            'password'=>['required']
        ]);

        // if(!Auth::attempt($validated)){
        //     throw ValidationException::withMessages([
        //         'email'=>'Credentials Do not Match'
        //     ]);
        // }

        // $request->session()->regenerate();

        // $user=Auth::user();

        // return redirect('/dashboard')->with(['success'=>'Login Successful','user'=>$user]);

        if (!Auth::attempt($validated)) {
            return response()->json(['error' => 'Credentials do not match'], 422);
        }

        $request->session()->regenerate();

        return response()->json(['success' => 'Login Successful'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('dashboard.edit',['user'=>$user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function delete(Request $request,User $user)
    {
          // Perform the deletion
          $user->delete();

          // Redirect back to the users list page with a success message
          return redirect('/workers')->with('success', 'User deleted successfully.');

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
{
    // Validate user data
    $uservalidate = $request->validate([
        'firstname' => ['required'],
        'lastname' => ['required'],
        'email' => ['required', 'email', 'unique:users,email,' . $user->id],
        'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'], // Validate image
        'role' => ['required'],
        'position'=>['required'],
    ]);

    // Validate department data
    $departmentvalidate = $request->validate([
        'department' => ['required'],
    ]);

    // Handle image upload if a new image is provided
    if ($request->hasFile('image')) {
        // Delete the old image if it exists
        if ($user->image) {
            Storage::delete($user->image);
        }

        // Store the new image
        $imagePath = $request->file('image')->store('profileimage');
    } else {
        // Keep the existing image path if no new image is uploaded
        $imagePath = $user->image;
    }

    // Update or create the department
    $department = Department::updateOrCreate(['name' => $departmentvalidate['department']]);

    // Update the user record
  if($user->update(array_merge($uservalidate, [
        'image' => $imagePath,
        'department_id' => $department->id,
    ]))){
       // Redirect back with success message
    return redirect('/dashboardprofile/' . $user->id)->with('success', 'Update Successful');
    }else{

    // Redirect back with success message
    return redirect('/dashboardprofile/' . $user->id)->with('error', 'Update Failed');
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        Auth::logout();
        return redirect('/');

    }

    public function suspend(User $user){
        if($user->status===2){
            $user->update(['status'=>1]);
            return redirect('/dashboardprofile/'.$user->id)->with('success','User Suspended');
        }else{
            $user->update(['status'=>2]);
            return redirect('/dashboardprofile/'.$user->id)->with('success','User Activated');
        }


    }
}
