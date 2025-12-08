<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Unit;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
class UserController extends Controller
{

public function createaccount(){
        $units = Unit::all(); 
    
    return view('logins.createaccount',compact('units'));
   }


public function storeaccount(Request $req)
    {
        $req->validate([
            'Name' => 'required|string|max:255',
            'Email' => 'required|email|unique:users,email',
            'Password' => 'required|string|min:8',
            'unit_id' => 'required|exists:units,id'
        ]);
        
        $user = User::create([
            'name' => $req->Name,
            'email' => $req->Email,
            'password' => Hash::make($req->Password),     
            'unit_id' => $req->unit_id,        
        ]);
        
        if ($user) {
             return redirect()->route('login')->with('success', 'Account created successfully! Please log in'); 
        }else
        
        return redirect()->back()->with('error', 'Account creation failed. Please try again.');
    }


}



















