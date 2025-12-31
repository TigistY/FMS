<?php

use Illuminate\Support\Facades\Route;

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
//for user managemnt
Route::middleware(['auth'])->group(function () {
    // User CRUD
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
    // Note: It's better to use explicit resource naming for consistency
    Route::delete('/complaint/{complaint}', [ComplaintController::class, 'destroy'])->name('destroy');

    Route::get('/feedback/list', [FeedbackController::class, 'index'])->name('feedback.index'); 
    Route::get('/feedback/{feedback}', [FeedbackController::class, 'show'])->name('feedback.show');
    Route::get('/feedback/{feedback}/respond', [FeedbackController::class, 'respond'])->name('feedback.respond');
    Route::post('/feedback/{feedback}/response', [FeedbackController::class, 'processResponse'])->name('feedback.processResponse');
    Route::delete('/feedback/{feedback}/destroy', [FeedbackController::class, 'destroy'])->name('feedback.destroy');
});

//for rolemanagement

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/roles-management', [RolesController::class, 'index'])->name('roles.index');
    // ለአንድ ፐርሚሽን ብቻ (AJAX)
    Route::post('/roles-management/update-single', [RolesController::class, 'updateSinglePermission'])->name('roles.update-single-permission');
    // ለሙሉ ፎርሙ (የድሮው)
    Route::put('/roles-management', [RolesController::class, 'updatePermissions'])->name('roles.update-permissions');
});

Route::prefix('api')->group(function () {
    // ሁሉንም ኮሌጆች ለማምጣት
    Route::get('/colleges/list', [UnitApiController::class, 'getColleges'])->name('api.colleges.list');
    
    // ሁሉንም ዳይሬክቶሬቶች ለማምጣት
    Route::get('/directories/list', [UnitApiController::class, 'getDirectories'])->name('api.directories.list');
    
    // በተመረጠ ኮሌጅ ስር ያሉ ዲፓርትመንቶችን ለማምጣት (ለ JavaScriptዱ ${collegeId} እንዲሰራ)
    Route::get('/colleges/{collegeId}/departments', [UnitApiController::class, 'getDepartmentsByCollege'])->name('api.departments.by_college');
});

Route::middleware(['auth'])->group(function () {
    // ... ሌሎች የአድሚን ራውቶች (Dashboard, Users, Permissions)

    // College Management (CRUD)
    Route::resource('colleges', CollegeController::class); // URL: /colleges, Name: colleges.index

    // Directory Management (CRUD)
    Route::resource('directories', DirectoryController::class); // URL: /directories, Name: directories.index

    // Department Management (CRUD)
    Route::resource('departments', DepartmentController::class); // URL: /departments, Name: departments.index
});