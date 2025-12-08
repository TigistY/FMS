<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\Admin\RolesController;

Route::get('/',[HomeController::class,'welcomepage'])->name('wel.link');
Route::get('/home2',[HomeController::class,'homesto'])->name('home.link');
//Route::get('/helpcenter',[HomeController::class,'help'])->name('helpcenter.link');
Route::get('/dashbo',[HomeController::class,'dashBoard'])->name('dashboard')->middleware('auth');
//for login
Route::get('/login-user',[LoginController::class,'showLoginForm'])->name('login');//->middleware('checkLogin');
Route::post('/loginuser',[LoginController::class,'login'])->name('login.submit');
Route::post('/logout-user',[LoginController::class,'logoutUser'])->name('logout');
//for createaccount
Route::get('/create-account',[UserController::class,'createaccount'])->name('create.link');
Route::post('/createaccount',[UserController::class,'storeaccount'])->name('storeaccount.link');

//for  Complaint Submission
Route::get('/create', [ComplaintController::class, 'create'])->name('create');
Route::post('/store', [ComplaintController::class, 'store'])->name('complaints.submit');
//for Feedback Submission
Route::get('/feedback', [FeedbackController::class, 'feedbackform'])->name('feedback.link');
Route::post('/feedb_stor', [FeedbackController::class, 'feedback'])->name('feedback.submit');

Route::middleware(['auth'])->group(function () {
    Route::get('/complaints', [ComplaintController::class, 'index'])->name('index');
    Route::get('/complaint/{complaint}', [ComplaintController::class, 'show'])->name('show'); 
    Route::get('/complaint/{complaint}/respond', [ComplaintController::class, 'respond'])->name('respond');
    Route::post('/complaint/{complaint}/response', [ComplaintController::class, 'processResponse'])->name('processResponse');
    Route::delete('/complaint/{complaint}', [ComplaintController::class, 'destroy'])->name('destroy');

    Route::get('/feedback/list', [FeedbackController::class, 'index'])->name('feedback.index'); 
    Route::get('/feedback/{feedback}', [FeedbackController::class, 'show'])->name('feedback.show');
    Route::get('/feedback/{feedback}/respond', [FeedbackController::class, 'respond'])->name('feedback.respond');
    Route::post('/feedback/{feedback}/response', [FeedbackController::class, 'processResponse'])->name('feedback.processResponse');
    Route::delete('/feedback/{feedback}', [FeedbackController::class, 'destroy'])->name('feedback.destroy');
});

    //for unit
Route::middleware(['auth', 'can:manage-units'])->group(function () {
	 // CRUD UnitController::class, 'index', 'edit', 'update', 'destroy'
    Route::resource('units', UnitController::class)->except(['show']); 
    //Route::get('/units/create', [UnitController::class, 'create'])->name('units.create');
    //Route::post('/units', [UnitController::class, 'store'])->name('units.store'); 
    //Route::get('/units', [UnitController::class, 'index'])->name('units.index'); 
});

//for rolemanagement

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/roles-management', [RolesController::class, 'index'])->name('roles.index');
    Route::put('/roles-management', [RolesController::class, 'updatePermissions'])->name('roles.update-permissions');
});
