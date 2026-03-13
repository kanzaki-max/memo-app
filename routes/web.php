<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemoController;
use App\Http\Controllers\ThemeController;

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
    return redirect('/memos/create');
});

Route::resource('memos', MemoController::class);
Route::get('/themes', [ThemeController::class,'index'])
->name('themes.index');
Route::post('/themes', [ThemeController::class,'store']);
Route::post('/themes/delete/{id}', [ThemeController::class,'destroy']);
Route::get('/memos', [MemoController::class, 'create'])->name('memos.create');