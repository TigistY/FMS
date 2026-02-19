<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\College;   
use App\Models\Department; 
use App\Models\Directory; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function createaccount()
    {
    
        $colleges = College::all();
        $directories = Directory::all();
        $departments = Department::all(); 
        
        return view('logins.createaccount', compact('colleges', 'directories', 'departments'));
    }

    public function storeaccount(Request $req)
    {
        
        $req->validate([
            'Name' => 'required|string|max:255',
            'Email' => 'required|email|unique:users,email',
            'Password' => 'required|string|min:8',
            'college_id' => 'nullable|exists:colleges,id',
            'department_id' => 'nullable|exists:departments,id',
            'directory_id' => 'nullable|exists:directories,id',
        ]);
        
       
        $user = User::create([
            'name' => $req->Name,
            'email' => $req->Email,
            'password' => Hash::make($req->Password),     
            'college_id' => $req->college_id,        
            'department_id' => $req->department_id,        
            'directory_id' => $req->directory_id,        
        ]);
        
        if ($user) {
             return redirect()->route('login')->with('success', 'Account created successfully! Please log in'); 
        }
        
        return redirect()->back()->with('error', 'Account creation failed. Please try again.');
    }

    public function editProfile() 
    {
        $user = Auth::user(); 
        return view('logins.editprofile', compact('user'));
    }

    public function updateProfile(Request $req) 
    {
        $user = Auth::user(); 

        $req->validate([ 
            'name' => 'required|string|max:255', 
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed', 
        ]);

        $user->name = $req->name;
        $user->email = $req->email; 

        if ($req->filled('password')) {
            $user->password = Hash::make($req->password); 
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile Updated Successfully!'); 
    }
}