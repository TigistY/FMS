<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
  public function welcomepage(){
     return view('welcome');
  }
  public function dashBoard(){
    	return view('dashboard');

} 
    public function homesto(){
	return view('logins.home');
} 
 public function help(){
	return view('logins.helpcenter');
}             
}
