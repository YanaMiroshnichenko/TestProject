<?php

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

Route::get('/', ['uses' => 'UserController@index']);
Route::post('/auth', ['uses' => 'UserController@authorization']);
Route::match(['get', 'post'], '/products', ['uses' => 'UserController@products']);
Route::get('/settings', ['uses' => 'UserController@settings']);
Route::post('/set', ['uses' => 'UserController@set']);
Route::get('/{idFlat}/description', ['uses' => 'UserController@description']);

