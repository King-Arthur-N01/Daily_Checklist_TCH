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
Route::get ('/home', 'HomeController@index')->name('home');
Route::get ('/login','Auth\LoginController@indexlogin')->name('login');
Route::post('/login','Auth\LoginController@authenticateuser')->name('pushlogin');
Route::get ('/manageuser','Auth\RegisterController@readusertable')->name('manageuser');
Route::post('/manageuser/register','Auth\RegisterController@authenticatecreate')->name('pushregisteruser');
Route::get ('/manageuser/{id}','Auth\RegisterController@fetchdatauser')->name('fetchedituser');
Route::put ('/manageuser/{id}','Auth\RegisterController@authenticateedit')->name('pushedituser');
Route::get ('/manageuser/userdelete/{id}','Auth\RegisterController@deleteuser')->name('deleteaccount');
Route::get ('/logout','Auth\LoginController@signout')->name('logout');
// page home route end

// machine route
Route::get ('/tablemachine','MachineData\MachineController@indextablemachine')->name('managemachine');
Route::get ('/tablemachine/addmachine','MachineData\MachineController@indexregistermachine')->name('addmachine');
Route::post('/tablemachine/addmachine','MachineData\MachineController@registermachine')->name('pushmachine');
Route::get ('/tablemachine/editmachine/{id}','MachineData\MachineController@indexupdatemachine')->name('editmachine');
Route::put ('/tablemachine/editmachine/{id}','MachineData\MachineController@updatemachine')->name('pusheditmachine');
Route::get ('/tablemachine/deletemachine/{id}','MachineData\MachineController@deletemachine')->name('deletemachine');
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
Route::get ('/tablemachinedata','MachineData\ImportdataController@indextableimport')->name('managemachinedata');
Route::get ('/tablemachinedata/addmachinedata','MachineData\ImportdataController@indextableimport')->name('addmachinedata');
Route::post('/tablemachinedata/addmachinedata','MachineData\ImportdataController@registermachineresult')->name('pushmachinedata');
Route::get ('/tablemachinedata/editmachinedata/{id}','MachineData\ImportdataController@indexeditmachineresult')->name('editmachinedata');
Route::put ('/tablemachinedata/editmachinedata/{id}','MachineData\ImportdataController@editmachineresult')->name('pusheditmachinedata');
Route::get ('/tablemachinedata/deletemachinedata/{id}','MachineData\ImportdataController@deletemachineresult')->name('deletemachinedata');
Route::post('/tablemachinedata/pushfiles', 'MachineData\ImportdataController@importdata')->name('uploadfile');
// impor machine data route end

// input data machine record
Route::get('/tablepreventive','RecordsData\MachinerecordController@tablemachinerecord')->name('indexmachinerecord');
Route::get('/tablepreventive/addpreventive/machine/{id}','RecordsData\MachinerecordController@formmachinerecord')->name('indexuserinput');
Route::put('/tablepreventive/addpreventive/machine','RecordsData\MachinerecordController@registermachinerecord')->name('pushuserinput');
// input data machine record end

// input data correction 1
Route::get('/machinerecord/correction','RecordsData\MachinerecordController@tablecorrection')->name('viewcorrection');
Route::get('/machinerecord/correction/{id}','RecordsData\MachinerecordController@fetchdatacorrection')->name('fetchcorrection');
Route::put('/machinerecord/correction/{id}','RecordsData\MachinerecordController@registercorrection')->name('pushcorrection');
Route::put('/machinerecord/correction/reject/{id}','RecordsData\MachinerecordController@rejectcorrection')->name('pushreject1');
// input data correction 1 end

// input data approval 2
Route::get('/machinerecord/approval','RecordsData\MachinerecordController@tableapproval')->name('viewapproval');
Route::get('/machinerecord/approval/{id}','RecordsData\MachinerecordController@fetchdataapproval')->name('fetchapproval');
Route::put('/machinerecord/approval/{id}','RecordsData\MachinerecordController@registerapproval')->name('pushapproval');
Route::put('/machinerecord/approval/reject/{id}','RecordsData\MachinerecordController@rejectapproval')->name('pushreject2');
// input data approval 2 end

// record data machine route
Route::get('/tablehistory','RecordsData\HistoryrecordsController@indextablehistory')->name('historymachine');
Route::get('/tablehistory/viewdetails/{id}','RecordsData\HistoryrecordsController@viewdetails')->name('detailhistory');
// record data machine route end


Route::get('/blacklist','Auth\LoginController@blockuser');
