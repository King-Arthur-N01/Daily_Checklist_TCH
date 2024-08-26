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
Route::get ('/manageuser/table/refresh','Auth\RegisterController@refreshtableuser')->name('refreshuser');
Route::post('/manageuser/register','Auth\RegisterController@authenticatecreate')->name('registeruser');
Route::get ('/manageuser/read/{id}','Auth\RegisterController@readdatauser')->name('readuser');
Route::put ('/manageuser/update/{id}','Auth\RegisterController@authenticateedit')->name('updateuser');
Route::delete('/manageuser/delete/{id}','Auth\RegisterController@deleteuser')->name('removeuser');
Route::get ('/logout','Auth\LoginController@signout')->name('logout');
// page home route end

// machine import route
Route::get ('/machinedata','MachineData\ImportdataController@indeximport')->name('indexmachinedata');
Route::post('/machinedata/create','MachineData\MachineController@createmachine')->name('addmachine');
Route::put ('/machinedata/update/{id}','MachineData\MachineController@updatemachine')->name('updatemachine');
Route::delete('/machinedata/delete/{id}','MachineData\MachineController@deletemachine')->name('removemachine');
Route::post('/machinedata/import','MachineData\ImportdataController@importdata')->name('uploadfile');
Route::get ('/machinedata/export/{machineId}','MachineData\ImportdataController@exportpdf')->name('exportfile');

Route::get ('/machinedata/table/refresh','MachineData\ImportdataController@refreshtableimport')->name('refreshimport');
Route::get ('/machinedata/view/{id}','MachineData\ImportdataController@detailproperty')->name('detailproperty');
Route::get ('/machinedata/data/{id}','MachineData\ImportdataController@readmachinedata')->name('readmachinedata');
// machine import route end

// machine property route
Route::get ('/machineproperty','MachineData\MachinepropertyController@indexmachineproperty')->name('indexproperty');
Route::post('/machineproperty/create','MachineData\MachinepropertyController@createproperty')->name('addproperty');
Route::get ('/machineproperty/table/refresh','MachineData\MachinepropertyController@refreshtableproperty')->name('refreshproperty');
Route::delete('/machineproperty/delete/{id}','MachineData\MachinepropertyController@deleteproperty')->name('removeproperty');
// machine property route end

// machine schedule route
Route::get ('/machineschedule','MachineData\ScheduleController@indexmachineschedule')->name('indexschedule');
Route::get ('/machineschedule/formschedule','MachineData\ScheduleController@formcreatechedule')->name('formschedule');
Route::post('/machineschedule/create','MachineData\ScheduleController@createschedule')->name('addschedule');
Route::get ('/machineschedule/view','MachineData\ScheduleController@fetchmachinedata')->name('getmachinedata');

Route::get ('/machineschedule/table/refresh','MachineData\ScheduleController@refreshtableschedule')->name('refreshschedule');
Route::get ('/machineschedule/calendar/read','MachineData\ScheduleController@datacalendar')->name('datacalendar');
// machine schedule route end

// input data machine record
Route::get ('/machinerecord','RecordsData\MachinerecordController@indexmachinerecord')->name('indexmachinerecord');
Route::get ('/machinerecord/machine/{id}','RecordsData\MachinerecordController@formmachinerecord')->name('formpreventive');
Route::put ('/machinerecord/create','RecordsData\MachinerecordController@createmachinerecord')->name('createrecord');
Route::get ('/machinerecord/table/refresh','RecordsData\MachinerecordController@refreshtablerecord')->name('refreshrecord');
Route::get ('/machinerecord/table/refresh/{id}','RecordsData\MachinerecordController@refreshtabledetail')->name('refreshdetailrecord');
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
Route::get ('/historyrecord/table/refresh','RecordsData\\HistoryrecordsController@refreshtablehistory')->name('refreshistory');
Route::get ('/historyrecord/viewdetails/{id}','RecordsData\HistoryrecordsController@viewdetails')->name('detailhistory');
// record data machine route end


Route::get ('/blacklist','Auth\LoginController@blockuser');
