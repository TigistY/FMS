<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    //
    public function info(){
        return view('about.info');
    }
     public function policy(){
        return view('about.policy');
    }
   public function abinfo(){
        return view('about.info2');
    }
     public function abpolicy(){
        return view('about.policy2');
    } 
    public function abouts(){
        return view('about.aboutinu');
    }
     public function helps(){
        return view('about.help');
    } 
}
