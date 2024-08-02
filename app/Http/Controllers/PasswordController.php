<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class PasswordController extends Controller
{
    public function changePassword(Request $request,User $user)
    {
        $request->validate([
            'password' => ['required'],
            'newpassword' => ['required', 'confirmed'],
        ]);

       // $user = Auth::user(); // Get the authenticated user instance

        // Check if the current password matches
        if (!Hash::check($request->password, $user->password)) {
          // return response()->json(['message'=>'Credentials donot match']);
           throw ValidationException::withMessages(['password'=>'Credentials donot match']);
        }

        // Update the user's password
        $user->password = Hash::make($request->newpassword);

        // Save the changes and check if the operation was successful
        if ($user->save()) {
          // return redirect()->back()->with('success', 'Password changed successfully!');
           return response()->json(['success'=>true,'message'=>'Password update Successful']);
        } else {
           // return redirect()->back()->with('success', 'Failed to update password');
            return response()->json(['success'=>false,'message'=>'failed to update password']);
        }
    }
}
