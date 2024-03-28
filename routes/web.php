<?php

use App\Historyrecords;
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
Route::get('/register','Auth\RegisterController@indexregistration')->name('registeruser');
Route::post('/register','Auth\RegisterController@authenticatecreate')->name('pushregisteruser');
Route::get('/updateuser/{id}','Auth\RegisterController@indexedit')->name('edituser');
Route::put('/updateuser/{id}','Auth\RegisterController@authenticateedit')->name('pushedituser');
Route::get('/userdelete/{id}','Auth\RegisterController@deleteuser')->name('deleteaccount');
Route::get('/manageuser','Auth\RegisterController@readusertable')->name('manageuser');
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


Route::get('/addmachineresult','MachineData\MachineController@indexregistermachineresult')->name('addmachineresults');
Route::post('/addmachineresult','MachineData\MachineresultController@registermachineresult')->name('pushmachineresults');
Route::get('/editmachineresult/{id}','MachineData\MachineresultController@indexeditmachineresult')->name('editmachineresults');
Route::put('/editmachineresult/{id}','MachineData\MachineresultController@editmachineresult')->name('pusheditmachineresults');
Route::get('/tablemachineresult','MachineData\MachineController@indextablemachineresult')->name('managemachineresults');
Route::get('/deletemachineresult/{id}','MachineData\MachineresultController@deletemachineresult')->name('deletemachineresults');


Route::get('/tablepreventivemachine','MachinerecordController@tablemachinerecord')->name('indexmachinerecord');
// Route::post('/addpreventivemachine','MachinerecordController@registerpreventivemachine')->name('pushpreventivemachine');
Route::get('/addpreventivemachine/{id}', 'MachinerecordController@indexmachinerecord')->name('indexuserinput');
Route::put('/addpreventivemachine', 'MachinerecordController@registermachinerecord')->name('pushuserinput');


Route::get('/tablehistory','HistoryrecordsController@indextablehistory')->name('historymachine');
Route::get('/viewdetails/{id}','HistoryrecordsController@viewdetails')->name('detailhistory');


// Route::get('/history', 'HistoryrecordsController@insertoperatoraction')->name('operatoraction');
// Route::post('/history', 'HistoryrecordsController@destroy')->name('deleterecord');
