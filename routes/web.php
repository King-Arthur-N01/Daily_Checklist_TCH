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
Route::delete ('/manageuser/remove/{id}','Auth\RegisterController@deleteuser')->name('removeuser');
Route::get ('/logout','Auth\LoginController@signout')->name('logout');
// page home route end

// machine route
Route::get ('/machine','MachineData\MachineController@indexmachine')->name('managemachine');
Route::get ('/machine/addmachine','MachineData\MachineController@registermachine')->name('addmachine');
Route::post('/machine/addmachine','MachineData\MachineController@pushregistermachine')->name('pushmachine');
Route::get ('/machine/editmachine/{id}','MachineData\MachineController@updatemachine')->name('editmachine');
Route::put ('/machine/editmachine/{id}','MachineData\MachineController@pushupdatemachine')->name('pusheditmachine');
Route::delete('/machine/deletemachine/{id}','MachineData\MachineController@deletemachine')->name('removemachine');
// machine route end

// machine import route
Route::get ('/machinedata','MachineData\ImportdataController@indeximport')->name('managemachinedata');
Route::post('/machinedata/register','MachineData\MachineController@registermachine')->name('addmachine');
Route::post('/machinedata/pushfiles','MachineData\ImportdataController@importdata')->name('uploadfile');
Route::get ('/machinedata/print/{machineId}','MachineData\ImportdataController@exportpdf')->name('exportfile');

Route::get ('/machinedata/fetch/table/{id}','MachineData\ImportdataController@gettableimport')->name('fetchtableproperty');
Route::get ('/machinedata/fetch/view/{id}','MachineData\ImportdataController@detailproperty')->name('fetchdetailproperty');
Route::get ('/machinedata/fetch/data/{id}','MachineData\ImportdataController@viewproperty')->name('fetchviewproperty');
Route::put ('/machinedata/fetch/register/{id}','MachineData\ImportdataController@registeridproperty')->name('fetchdataproperty');
// machine import route end

// machine property route
Route::get ('/machineproperty','MachineData\MachinepropertyController@indexmachineproperty')->name('indexproperty');
Route::post ('/machineproperty/register','MachineData\MachinepropertyController@addproperty')->name('registerproperty');
// Route::get('/machineproperty/{id}','MachineData\MachinepropertyController@indexeditmethod')->name('editmethod');
// Route::put('/machineproperty/{id}','MachineData\MachinepropertyController@editmethod')->name('pusheditmethod');
// Route::get('/machineproperty','MachineData\MachinepropertyController@indextablemethod')->name('managemethod');
Route::delete ('/machineproperty/remove/{id}','MachineData\MachinepropertyController@deleteproperty')->name('removeproperty');
// machine property route end

// componencheck route
Route::get ('/componencheck','MachineData\ComponencheckController@indexcomponencheck')->name('managecomponencheck');
Route::get ('/componencheck/add','MachineData\ComponencheckController@registercomponencheck')->name('addcomponencheck');
Route::post('/componencheck/add','MachineData\ComponencheckController@pushregistercomponencheck')->name('pushcomponencheck');
Route::get ('/componencheck/edit/{id}','MachineData\ComponencheckController@editcomponencheck')->name('editcomponencheck');
Route::put ('/componencheck/edit/{id}','MachineData\ComponencheckController@pusheditcomponencheck')->name('pusheditcomponencheck');
Route::get ('/componencheck/delete/{id}','MachineData\ComponencheckController@deletecomponencheck')->name('deletecomponencheck');
// componencheck route end

// parameter route
Route::get ('/parameter','MachineData\ParameterController@indexparameter')->name('manageparameter');
Route::get ('/parameter/add','MachineData\ParameterController@registerparameter')->name('addparameter');
Route::post('/parameter/add','MachineData\ParameterController@pushregisterparameter')->name('pushparameter');
Route::get ('/parameter/edit/{id}','MachineData\ParameterController@editparameter')->name('editparameter');
Route::put ('/parameter/edit/{id}','MachineData\ParameterController@pusheditparameter')->name('pusheditparameter');
Route::get ('/parameter/delete/{id}','MachineData\ParameterController@deleteparameter')->name('deleteparameter');
// parameter route end

// metodecheck route
Route::get ('/methodecheck','MachineData\MetodecheckController@indexmethod')->name('managemethod');
Route::get ('/methodecheck/add','MachineData\MetodecheckController@registermethod')->name('addmethod');
Route::post('/methodecheck/add','MachineData\MetodecheckController@pushregistermethod')->name('pushmethod');
Route::get ('/methodecheck/edit/{id}','MachineData\MetodecheckController@editmethod')->name('editmethod');
Route::put ('/methodecheck/edit/{id}','MachineData\MetodecheckController@pusheditmethod')->name('pusheditmethod');
Route::get ('/methodecheck/delete/{id}','MachineData\MetodecheckController@deletemethod')->name('deletemethod');
// metodecheck route end

// input data machine record
Route::get ('/machinerecord/preventive','RecordsData\MachinerecordController@indexmachinerecord')->name('indexmachinerecord');
Route::get ('/machinerecord/preventive/fetch/{id}','RecordsData\MachinerecordController@gettablerecord')->name('fetchtablerecord');
Route::get ('/machinerecord/preventive/machine/{id}','RecordsData\MachinerecordController@formmachinerecord')->name('indexuserinput');
Route::put ('/machinerecord/preventive/machine','RecordsData\MachinerecordController@registermachinerecord')->name('pushuserinput');
// input data machine record end

// input data correction 1
Route::get ('/machinerecord/correction','RecordsData\MachinerecordController@indexcorrection')->name('viewcorrection');
Route::get ('/machinerecord/correction/{id}','RecordsData\MachinerecordController@fetchdatacorrection')->name('fetchcorrection');
Route::put ('/machinerecord/correction/{id}','RecordsData\MachinerecordController@registercorrection')->name('pushcorrection');
Route::delete('/machinerecord/correction/delete/{id}','RecordsData\MachinerecordController@deletecorrection')->name('removecorrect');
// input data correction 1 end

// input data approval 2
Route::get ('/machinerecord/approval','RecordsData\MachinerecordController@indexapproval')->name('viewapproval');
Route::get ('/machinerecord/approval/{id}','RecordsData\MachinerecordController@fetchdataapproval')->name('fetchapproval');
Route::put ('/machinerecord/approval/{id}','RecordsData\MachinerecordController@registerapproval')->name('pushapproval');
Route::delete('/machinerecord/approval/delete/{id}','RecordsData\MachinerecordController@deleteapproval')->name('removeapprove');
// input data approval 2 end

// record data machine route
Route::get ('/historyrecord','RecordsData\HistoryrecordsController@indexhistory')->name('historymachine');
Route::get ('/historyrecord/viewdetails/{id}','RecordsData\HistoryrecordsController@viewdetails')->name('detailhistory');
// record data machine route end


Route::get ('/blacklist','Auth\LoginController@blockuser');
