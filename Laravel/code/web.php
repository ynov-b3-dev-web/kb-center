<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\UserController;

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

Route::get('/', function() {
    $titre = 'Laravel';
    return view('welcome', ['articles' => $titre]);
    
 });
Route::get('/allUser',[ProductController::class,'index']);
Route::post('contact', [ProductController::class, 'store'])->name('product.create');

