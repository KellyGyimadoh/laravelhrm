<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    public function index(){

    }

    public function create(){
        return view('auth.register');
    }

    public function store(Request $request){
        //validate
        $uservalidated=$request->validate([
            'firstname'=>['required'],
            'lastname'=>['required'],
            'email'=>['email','unique:users,email'],
            'password'=>['required','confirmed',Password::min(4)],
            'image'=>[File::types(['png','jpeg','jpg'])],
            'role'=>['']

        ]);

        //image
       // $imagePath= $request->file('image')->store('profileimage','public');
        $imagePath = $request->file('image') ? $request->file('image')->store('profileimage', 'public') : null;


        //department
        $departmentvalidated= $request->validate([
            'department'=>['required']
        ]);
        $department=Department::firstOrCreate(['name'=>$departmentvalidated['department']]);

       $user= User::create(array_merge($uservalidated,
           ['department_id'=>$department->id,
            'image'=>$imagePath
            ]));
        //authorize


    // Log in the user if they are not already logged in
    if (!Auth::check()) {
        Auth::login($user);
    }



        //redirect
        return redirect('/dashboard')->with('success','Registration complete-Login Success');
    }
}
