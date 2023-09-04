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


Route::group(['prefix' => '/product'], function(){
    Route::get('/list', function(){
        return view('product.list');
    });
    Route::get('/create', function(){
        return view('product.form');
    });
    Route::get('/edit/{id}', function(){
        return view('product.form');
    });
});


Route::group(['prefix' => '/category'], function(){
    Route::get('/list', function(){
        return view('category.list');
    });
    Route::get('/create', function(){
        return view('category.form');
    });
    Route::get('/edit/{id}', function(){
        return view('category.form');
    });
});