<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('hi', function(){
    return view('welcome');
});
// web.php
Route::get('/{any}', function () {
    return view('welcome'); // Replace 'welcome' with your main Blade template
})->where('any', '.*');
