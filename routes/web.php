<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middlchildUserseware group. Now create something great!
|
*/

Route::get('/', function () { return view('user'); });

// Route::get('/', [UserController::class, 'index']);

Route::post('store', [UserController::class, 'add']);

Route::get('/users', [UserController::class, 'fetchUsers']);

Route::get('/childUsers/{parentId}', [UserController::class, 'fetchChildUsers']);

Route::get('/childUsersCount/{parentId}', [UserController::class, 'fetchChildCount']);


