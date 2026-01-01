<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdduserController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\CollegeController;
use App\Http\Controllers\Admin\DirectoryController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\UnitApiController;
use App\Http\Controllers\AboutController;

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
//for user managemnt
Route::middleware(['auth'])->group(function () {
      Route::resource('users', AdduserController::class); 
});

// for Complaint Submission
Route::get('/create', [ComplaintController::class, 'create'])->name('create');
Route::post('/store', [ComplaintController::class, 'store'])->name('complaints.submit');

// for Feedback Submission
Route::get('/feedback', [FeedbackController::class, 'feedbackform'])->name('feedback.link');
Route::post('/feedb_stor', [FeedbackController::class, 'feedback'])->name('feedback.submit');


Route::middleware(['auth'])->group(function () {
    Route::get('/complaints', [ComplaintController::class, 'index'])->name('index');
    Route::get('/complaint/{complaint}', [ComplaintController::class, 'show'])->name('show');
    Route::delete('/complaints/{complaint}/destroy', [ComplaintController::class, 'destroy'])->name('complaints.destroy'); 
    Route::get('/complaint/{complaint}/respond', [ComplaintController::class, 'respond'])->name('respond');
    Route::post('/complaint/{complaint}/response', [ComplaintController::class, 'processResponse'])->name('processResponse');
    
    Route::delete('/complaint/{complaint}', [ComplaintController::class, 'destroy'])->name('destroy');

    Route::get('/feedback/list', [FeedbackController::class, 'index'])->name('feedback.index'); 
    Route::get('/feedback/{feedback}', [FeedbackController::class, 'show'])->name('feedback.show');
    Route::get('/feedback/{feedback}/respond', [FeedbackController::class, 'respond'])->name('feedback.respond');
    Route::post('/feedback/{feedback}/response', [FeedbackController::class, 'processResponse'])->name('feedback.processResponse');
    Route::delete('/feedback/{feedback}/destroy', [FeedbackController::class, 'destroy'])->name('feedback.destroy');
});

//for rolemanagement

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/roles-managements', [RolesController::class, 'index'])->name('roles.index');
    Route::post('/roles-management/update-single', [RolesController::class, 'updateSinglePermission'])->name('roles.update-single-permission');
    Route::put('/roles-management', [RolesController::class, 'updatePermissions'])->name('roles.update-permissions');
});

Route::prefix('api')->group(function () {
    Route::get('/colleges/list', [UnitApiController::class, 'getColleges'])->name('api.colleges.list');
    Route::get('/directories/list', [UnitApiController::class, 'getDirectories'])->name('api.directories.list');  
    Route::get('/colleges/{collegeId}/departments', [UnitApiController::class, 'getDepartmentsByCollege'])->name('api.departments.by_college');
});

Route::middleware(['auth'])->group(function () {
    // for College(CRUD)
    Route::resource('colleges', CollegeController::class); 
    //for  Directory 
    Route::resource('directories', DirectoryController::class); 
    // for Department
    Route::resource('departments', DepartmentController::class); 
});

Route::get('/system-info',[AboutController::class,'info'])->name('System.info');
Route::get('/system-policy',[AboutController::class,'policy'])->name('System.policy');
Route::get('/about-info',[AboutController::class,'abinfo'])->name('aboutinfo');
Route::get('/about-policy',[AboutController::class,'abpolicy'])->name('aboutpolicy');
Route::get('/aboutus',[AboutController::class,'abouts'])->name('aboutinu');
Route::get('/helpcenter',[AboutController::class,'helps'])->name('help');

//for languge 
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'am'])) {
        session()->put('locale', $locale);
        session()->save(); // ሴሽኑ ወዲያው እንዲቀመጥ ያደርጋል
    }
    return redirect()->back();
});