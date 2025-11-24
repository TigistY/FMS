<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FeedbackController;

Route::get('/',[HomeController::class,'welcomepage'])->name('wel.link');
Route::get('/home2',[HomeController::class,'homesto'])->name('home.link');
Route::get('/dashbo',[HomeController::class,'dashBoard'])->name('dashboard')->middleware('auth');
//for login
Route::get('/login-user',[LoginController::class,'showLoginForm'])->name('login');//->middleware('checkLogin');
Route::post('/loginuser',[LoginController::class,'login'])->name('login.submit');
Route::post('/logout-user',[LoginController::class,'logoutUser'])->name('logout');
//for createaccount
Route::get('/create-account',[UserController::class,'createaccount'])->name('create.link');
Route::post('/createaccount',[UserController::class,'storeaccount'])->name('storeaccount.link');
Route::get('/feedback',[FeedbackController::class,'feedbackform'])->name('feedback.link');
Route::post('/feedb_stor',[FeedbackController::class,'feedback'])->name('feedback.submit');
