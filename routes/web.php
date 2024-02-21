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


Route::get('/addmachine','MachineData\MachineController@indexregistermachine')->name('addmachine');
Route::post('/addmachine','MachineData\MachineController@registermachine')->name('pushmachine');
Route::get('/editmachine/{id}','MachineData\MachineController@indexupdatemachine')->name('editmachine');
Route::put('/editmachine/{id}','MachineData\MachineController@updatemachine')->name('pusheditmachine');
Route::get('/tablemachine','MachineData\MachineController@indextablemachine')->name('managemachine');
Route::get('/deletemachine/{id}','MachineData\MachineController@deletemachine')->name('deletemachine');

Route::get('/addcomponencheck','MachineData\ComponencheckController@indexregistercomponencheck')->name('addcomponencheck');
Route::post('/addcomponencheck','MachineData\ComponencheckController@registercomponencheck')->name('pushcomponencheck');
Route::get('/editcomponencheck/{id}','MachineData\ComponencheckController@indexeditcomponencheck')->name('editcomponencheck');
Route::put('/editcomponencheck/{id}','MachineData\ComponencheckController@editcomponencheck')->name('pusheditcomponencheck');
Route::get('/tablecomponencheck','MachineData\ComponencheckController@indextablecomponencheck')->name('managecomponencheck');
Route::get('/deletecomponencheck/{id}','MachineData\ComponencheckController@deletecomponencheck')->name('deletecomponencheck');
