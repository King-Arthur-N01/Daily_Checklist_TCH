<?php

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


Route::get('/home', 'HomeController@index')->name('home');

Route::get('/login','Auth\LoginController@indexlogin')->name('login');
Route::post('/login','Auth\LoginController@authenticateuser')->name('pushlogin');
Route::get('/logout','Auth\LoginController@signout')->name('logout');


Route::get('/tablemachine','MachineData\MachineController@indexatablemachine')->name('managemachine');

Route::get('/addmachine','MachineData\MachineController@indexregistermachine')->name('addmachine');
Route::post('/addmachine','MachineData\MachineController@createmachine')->name('pushmachine');
Route::get('/edit/{id}','MachineController@addmachine')->name('showformeditmachine');
