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
Route::get ('/manageuser','Auth\RegisterController@indexusertable')->name('manageuser');
Route::post('/manageuser/register','Auth\RegisterController@authenticatecreate')->name('registeruser');
Route::get ('/manageuser/read/{id}','Auth\RegisterController@readdatauser')->name('readuser');
Route::put ('/manageuser/update/{id}','Auth\RegisterController@authenticateedit')->name('updateuser');
Route::delete ('/manageuser/delete/{id}','Auth\RegisterController@deleteuser')->name('removeuser');
Route::get ('/logout','Auth\LoginController@signout')->name('logout');
// page home route end

// machine route
// Route::get ('/machine','MachineData\MachineController@indexmachine')->name('managemachine');
// Route::get ('/machine/addmachine','MachineData\MachineController@registermachine')->name('addmachine');
// Route::post('/machine/addmachine','MachineData\MachineController@pushregistermachine')->name('pushmachine');
// Route::get ('/machine/editmachine/{id}','MachineData\MachineController@updatemachine')->name('editmachine');
// Route::put ('/machine/editmachine/{id}','MachineData\MachineController@pushupdatemachine')->name('pusheditmachine');
// Route::delete('/machine/deletemachine/{id}','MachineData\MachineController@deletemachine')->name('removemachine');
// machine route end

// machine import route
Route::get ('/machinedata','MachineData\ImportdataController@indeximport')->name('machinedata');
Route::post('/machinedata/create','MachineData\MachineController@createmachine')->name('addmachine');
Route::put ('/machinedata/update/{id}','MachineData\MachineController@updatemachine')->name('updatemachine');
Route::delete('/machinedata/delete/{id}','MachineData\MachineController@deletemachine')->name('removemachine');
Route::post('/machinedata/import/excel','MachineData\ImportdataController@importdata')->name('uploadfile');
Route::get ('/machinedata/export/pdf/{machineId}','MachineData\ImportdataController@exportpdf')->name('exportfile');

Route::get ('/machinedata/table/refresh','MachineData\ImportdataController@refreshtableimport')->name('refreshimport');
Route::get ('/machinedata/view/{id}','MachineData\ImportdataController@detailproperty')->name('detailproperty');
Route::get ('/machinedata/data/{id}','MachineData\ImportdataController@readmachineproperty')->name('readmachineproperty');
// Route::put ('/machinedata/registerproperty/{id}','MachineData\ImportdataController@registeridproperty')->name('fetchdataproperty');
// machine import route end

// machine property route
Route::get ('/machineproperty','MachineData\MachinepropertyController@indexmachineproperty')->name('indexproperty');
Route::post('/machineproperty/create','MachineData\MachinepropertyController@createproperty')->name('addproperty');
Route::get ('/machineproperty/table/refresh','MachineData\MachinepropertyController@refreshtableproperty')->name('refreshproperty');
// Route::get('/machineproperty/{id}','MachineData\MachinepropertyController@indexeditmethod')->name('editmethod');
// Route::put('/machineproperty/{id}','MachineData\MachinepropertyController@editmethod')->name('pusheditmethod');
// Route::get('/machineproperty','MachineData\MachinepropertyController@indextablemethod')->name('managemethod');
Route::delete ('/machineproperty/delete/{id}','MachineData\MachinepropertyController@deleteproperty')->name('removeproperty');
// machine property route end

Route::get ('/machineschedule','MachineData\ScheduleController@indexmachineschedule')->name('indexschedule');
Route::get ('/machineschedule/calendar/read','MachineData\ScheduleController@datacalendar')->name('datacalendar');
Route::get ('/machineschedule/table/refresh','MachineData\ScheduleController@refreshtableschedule')->name('refreshcalendar');

// componencheck route
// Route::get ('/componencheck','MachineData\ComponencheckController@indexcomponencheck')->name('managecomponencheck');
// Route::get ('/componencheck/add','MachineData\ComponencheckController@registercomponencheck')->name('addcomponencheck');
// Route::post('/componencheck/add','MachineData\ComponencheckController@pushregistercomponencheck')->name('pushcomponencheck');
// Route::get ('/componencheck/edit/{id}','MachineData\ComponencheckController@editcomponencheck')->name('editcomponencheck');
// Route::put ('/componencheck/edit/{id}','MachineData\ComponencheckController@pusheditcomponencheck')->name('pusheditcomponencheck');
// Route::get ('/componencheck/delete/{id}','MachineData\ComponencheckController@deletecomponencheck')->name('deletecomponencheck');
// componencheck route end

// parameter route
// Route::get ('/parameter','MachineData\ParameterController@indexparameter')->name('manageparameter');
// Route::get ('/parameter/add','MachineData\ParameterController@registerparameter')->name('addparameter');
// Route::post('/parameter/add','MachineData\ParameterController@pushregisterparameter')->name('pushparameter');
// Route::get ('/parameter/edit/{id}','MachineData\ParameterController@editparameter')->name('editparameter');
// Route::put ('/parameter/edit/{id}','MachineData\ParameterController@pusheditparameter')->name('pusheditparameter');
// Route::get ('/parameter/delete/{id}','MachineData\ParameterController@deleteparameter')->name('deleteparameter');
// parameter route end

// metodecheck route
// Route::get ('/methodecheck','MachineData\MetodecheckController@indexmethod')->name('managemethod');
// Route::get ('/methodecheck/add','MachineData\MetodecheckController@registermethod')->name('addmethod');
// Route::post('/methodecheck/add','MachineData\MetodecheckController@pushregistermethod')->name('pushmethod');
// Route::get ('/methodecheck/edit/{id}','MachineData\MetodecheckController@editmethod')->name('editmethod');
// Route::put ('/methodecheck/edit/{id}','MachineData\MetodecheckController@pusheditmethod')->name('pusheditmethod');
// Route::get ('/methodecheck/delete/{id}','MachineData\MetodecheckController@deletemethod')->name('deletemethod');
// metodecheck route end

// input data machine record
Route::get ('/machinerecord/preventive','RecordsData\MachinerecordController@indexmachinerecord')->name('indexmachinerecord');
Route::get ('/machinerecord/preventive/machine/{id}','RecordsData\MachinerecordController@formmachinerecord')->name('indexuserinput');
Route::put ('/machinerecord/preventive/machine','RecordsData\MachinerecordController@createmachinerecord')->name('createrecord');

Route::get ('/machinerecord/preventive/table/refresh','RecordsData\MachinerecordController@refreshtablerecord')->name('refreshrecord');
// input data machine record end

// machine records correction
Route::get ('/machinerecord/correction','RecordsData\MachinerecordController@indexcorrection')->name('indexcorrection');

Route::get ('/machinerecord/correction/table/refresh','RecordsData\MachinerecordController@refreshtablecorrection')->name('refreshcorrect');
Route::get ('/machinerecord/correction/{id}','RecordsData\MachinerecordController@readdatacorrection')->name('readcorrection');

Route::put ('/machinerecord/correction/{id}','RecordsData\MachinerecordController@registercorrection')->name('insertcorrection');
Route::delete('/machinerecord/correction/delete/{id}','RecordsData\MachinerecordController@deletecorrection')->name('removecorrection');
// machine records correction end

// machine records approval
Route::get ('/machinerecord/approval','RecordsData\MachinerecordController@indexapproval')->name('indexapproval');

Route::get ('/machinerecord/approval/table/refresh','RecordsData\MachinerecordController@refreshtableapproval')->name('refreshapproval');
Route::get ('/machinerecord/approval/{id}','RecordsData\MachinerecordController@readdataapproval')->name('readapproval');

Route::put ('/machinerecord/approval/{id}','RecordsData\MachinerecordController@registerapproval')->name('insertapproval');
Route::delete('/machinerecord/approval/delete/{id}','RecordsData\MachinerecordController@deleteapproval')->name('removeapproval');
// machine records approval end

// record data machine route
Route::get ('/historyrecord','RecordsData\HistoryrecordsController@indexhistory')->name('historymachine');
Route::get ('/historyrecord/viewdetails/{id}','RecordsData\HistoryrecordsController@viewdetails')->name('detailhistory');
// record data machine route end


Route::get ('/blacklist','Auth\LoginController@blockuser');
