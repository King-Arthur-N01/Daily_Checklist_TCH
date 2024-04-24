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

// page home route
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
// page home route end

// machine route
Route::get('/addmachine','MachineData\MachineController@indexregistermachine')->name('addmachine');
Route::post('/addmachine','MachineData\MachineController@registermachine')->name('pushmachine');
Route::get('/editmachine/{id}','MachineData\MachineController@indexupdatemachine')->name('editmachine');
Route::put('/editmachine/{id}','MachineData\MachineController@updatemachine')->name('pusheditmachine');
Route::get('/tablemachine','MachineData\MachineController@indextablemachine')->name('managemachine');
Route::get('/deletemachine/{id}','MachineData\MachineController@deletemachine')->name('deletemachine');
// macine route end

// componencheck route
Route::get('/addcomponencheck','MachineData\ComponencheckController@indexregistercomponencheck')->name('addcomponencheck');
Route::post('/addcomponencheck','MachineData\ComponencheckController@registercomponencheck')->name('pushcomponencheck');
Route::get('/editcomponencheck/{id}','MachineData\ComponencheckController@indexeditcomponencheck')->name('editcomponencheck');
Route::put('/editcomponencheck/{id}','MachineData\ComponencheckController@editcomponencheck')->name('pusheditcomponencheck');
Route::get('/tablecomponencheck','MachineData\ComponencheckController@indextablecomponencheck')->name('managecomponencheck');
Route::get('/deletecomponencheck/{id}','MachineData\ComponencheckController@deletecomponencheck')->name('deletecomponencheck');
// componencheck route end

// parameter route
Route::get('/addparameter','MachineData\ParameterController@indexregisterparameter')->name('addparameter');
Route::post('/addparameter','MachineData\ParameterController@registerparameter')->name('pushparameter');
Route::get('/editparameter/{id}','MachineData\ParameterController@indexeditparameter')->name('editparameter');
Route::put('/editparameter/{id}','MachineData\ParameterController@editparameter')->name('pusheditparameter');
Route::get('/tableparameter','MachineData\ParameterController@indextableparameter')->name('manageparameter');
Route::get('/deleteparameter/{id}','MachineData\ParameterController@deleteparameter')->name('deleteparameter');
// parameter route end

// metodecheck route
Route::get('/addmethod','MachineData\MetodecheckController@indexregistermethod')->name('addmethod');
Route::post('/addmethod','MachineData\MetodecheckController@registermethod')->name('pushmethod');
Route::get('/editmethod/{id}','MachineData\MetodecheckController@indexeditmethod')->name('editmethod');
Route::put('/editmethod/{id}','MachineData\MetodecheckController@editmethod')->name('pusheditmethod');
Route::get('/tablemethod','MachineData\MetodecheckController@indextablemethod')->name('managemethod');
Route::get('/deletemethod/{id}','MachineData\MetodecheckController@deletemethod')->name('deletemethod');
// metodecheck route end

// import machine data route
Route::get('/addmachinedata','MachineData\ImportdataController@indextableimport')->name('addmachinedata');
Route::post('/addmachinedata','MachineData\ImportdataController@registermachineresult')->name('pushmachinedata');
Route::get('/editmachinedata/{id}','MachineData\ImportdataController@indexeditmachineresult')->name('editmachinedata');
Route::put('/editmachinedata/{id}','MachineData\ImportdataController@editmachineresult')->name('pusheditmachinedata');
Route::get('/tablemachinedata','MachineData\ImportdataController@indextableimport')->name('managemachinedata');
Route::get('/deletemachinedata/{id}','MachineData\ImportdataController@deletemachineresult')->name('deletemachinedata');
Route::post('/pushfiles', 'MachineData\ImportdataController@importdata')->name('uploadfile');
// impor machine data route end

// input data machine record route
Route::get('/tablepreventivemachine','RecordsData\MachinerecordController@tablemachinerecord')->name('indexmachinerecord');
Route::post('/tablepreventivemachine/filter','RecordData\MachinerecordController@filter')->name('filtermachinerecord');
// Route::post('/addpreventivemachine','RecordsData\MachinerecordController@registerpreventivemachine')->name('pushpreventivemachine');
Route::get('/addpreventivemachine/{id}','RecordsData\MachinerecordController@formmachinerecord')->name('indexuserinput');
Route::put('/addpreventivemachine','RecordsData\MachinerecordController@registermachinerecord')->name('pushuserinput');
// input data machine record route end

// record data machine route
Route::get('/tablehistory','RecordsData\HistoryrecordsController@indextablehistory')->name('historymachine');
Route::get('/viewdetails/{id}','RecordsData\HistoryrecordsController@viewdetails')->name('detailhistory');
// record data machine route end


Route::get('/blacklist','Auth\LoginController@blockuser');