<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class LoginController extends Controller
{
public function __construct()
    {
        
        $this->middleware('guest')->except('logoutUser');
    //logout yaladerge sew login page edayaye
 }
  
 //for login
   public function showLoginForm(){
    return view('logins.login');
   }
    public function login(Request $request){
 
    $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);
   
 	if(Auth::attempt($credentials)){

   		return redirect()->route('dashboard');
   	}
   
   else{
    
   		return redirect()->back()->with('error',"Login Fails! please your correct data add");
   }

   }
   public function logoutUser(Request $request){
    Auth::logout();
 
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    //return view('welcome');
    return redirect()->route('login');
   }
}
