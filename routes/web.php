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

Route::get('/addparameter','MachineData\ParameterController@indexregisterparameter')->name('addparameter');
Route::post('/addparameter','MachineData\ParameterController@registerparameter')->name('pushparameter');
Route::get('/editparameter/{id}','MachineData\ParameterController@indexeditparameter')->name('editparameter');
Route::put('/editparameter/{id}','MachineData\ParameterController@editparameter')->name('pusheditparameter');
Route::get('/tableparameter','MachineData\ParameterController@indextableparameter')->name('manageparameter');
Route::get('/deleteparameter/{id}','MachineData\ParameterController@deleteparameter')->name('deleteparameter');


Route::get('/addmethod','MachineData\MetodecheckController@indexregistermethod')->name('addmethod');
Route::post('/addmethod','MachineData\MetodecheckController@registermethod')->name('pushmethod');
Route::get('/editmethod/{id}','MachineData\MetodecheckController@indexeditmethod')->name('editmethod');
Route::put('/editmethod/{id}','MachineData\MetodecheckController@editmethod')->name('pusheditmethod');
Route::get('/tablemethod','MachineData\MetodecheckController@indextablemethod')->name('managemethod');
Route::get('/deletemethod/{id}','MachineData\MetodecheckController@deletemethod')->name('deletemethod');

Route::get('/addmachineresult','MachineData\MachineresultController@indexregistermachineresult')->name('addmachineresults');
Route::post('/addmachineresult','MachineData\MachineresultController@registermachineresult')->name('pushmachineresults');
Route::get('/editmachineresult/{id}','MachineData\MachineresultController@indexeditmachineresult')->name('editmachineresults');
Route::put('/editmachineresult/{id}','MachineData\MachineresultController@editmachineresult')->name('pusheditmachineresults');
Route::get('/tablemachineresult','MachineData\MachineresultController@indextablemachineresult')->name('managemachineresults');
Route::get('/deletemachineresult/{id}','MachineData\MachineresultController@deletemachineresult')->name('deletemachineresults');


Route::get('/addpreventivemachine','MachineData\MasterMachineController@indexregisterpreventivemachine')->name('addpreventivemachine');
Route::post('/addpreventivemachine','MachineData\MasterMachineController@registerpreventivemachine')->name('pushpreventivemachine');
