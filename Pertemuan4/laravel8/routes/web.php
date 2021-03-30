<?php

use App\Http\Controllers\ManagementUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// call all of methods in ManagementUserController
Route::resource('user', ManagementUserController::class);

// this route can't be used if there's a variable in home.blade.php
// Route::get("/home", function(){
//     return view("home");
// });


// Route without controller
Route::get("/home", function(){
    return view("frontend.home");
});

Route::get("/dashboard", function(){
    return view("backend.dashboard");
});
