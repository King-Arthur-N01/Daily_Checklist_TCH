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
Route::get ('/manageuser/find/{id}','Auth\RegisterController@finduser')->name('finduserid');
Route::put ('/manageuser/update/{id}','Auth\RegisterController@authenticateedit')->name('edituser');
Route::delete('/manageuser/delete/{id}','Auth\RegisterController@deleteuser')->name('removeuser');
Route::get ('/logout','Auth\LoginController@signout')->name('logout');
// page home route end

// machine import route
Route::get ('/machinedata','MachineData\ImportdataController@indeximport')->name('indexmachinedata');
Route::get ('/machinedata/table/refresh','MachineData\ImportdataController@refreshtableimport')->name('refreshmachinedata');
Route::post('/machinedata/create','MachineData\MachineController@createmachine')->name('addmachine');
Route::put ('/machinedata/update/{id}','MachineData\MachineController@updatemachine')->name('editmachine');
Route::delete('/machinedata/delete/{id}','MachineData\MachineController@deletemachine')->name('removemachine');
Route::post('/machinedata/import','MachineData\ImportdataController@importdata')->name('uploadfile');
Route::get ('/machinedata/view/{id}','MachineData\ImportdataController@detailmachinedata')->name('detailmachine');
Route::get ('/machinedata/find/{id}','MachineData\ImportdataController@findmachine')->name('findmachineid');
Route::get ('/machinedata/print/{id}','MachineData\ImportdataController@printdatamachine')->name('printmachine');
// export data route
Route::get ('/machinedata/export/csv','MachineData\ImportdataController@exportexcel')->name('exportexcel');
Route::get ('/machinedata/export/csv/{value}','MachineData\ImportdataController@exportexcelwithcondition')->name('exportexcelvalue');
Route::get ('/machinedata/export/pdf','MachineData\ImportdataController@exportpdf')->name('exportpdf');
Route::get ('/machinedata/export/pdf/{value}','MachineData\ImportdataController@exportpdfwithcondition')->name('exportpdfvalue');
// machine import route end

// machine property route
Route::get ('/machineproperty','MachineData\MachinepropertyController@indexmachineproperty')->name('indexproperty');
Route::post('/machineproperty/create','MachineData\MachinepropertyController@createproperty')->name('addproperty');
Route::put ('/machineproperty/update/{id}','MachineData\MachinepropertyController@updateproperty')->name('editproperty');
// Route::get('/machineproperty/find/{id}','MachineData\MachinepropertyController@findproperty')->name('findproperty');
Route::get ('/machineproperty/table/refresh','MachineData\MachinepropertyController@refreshtableproperty')->name('refreshproperty');
Route::delete('/machineproperty/delete/{id}','MachineData\MachinepropertyController@deleteproperty')->name('removeproperty');
// machine property route end

// schedule year route
Route::get ('/schedule','ScheduleData\YearlyScheduleController@indexschedule')->name('indexschedule');
Route::post('/schedule/create','ScheduleData\YearlyScheduleController@createschedule')->name('addschedule');
Route::put ('/schedule/update/{id}','ScheduleData\YearlyScheduleController@updateschedule')->name('editschedule');
Route::delete('/schedule/delete/{id}','ScheduleData\YearlyScheduleController@deleteschedule')->name('removeschedule');
// Route::get ('/schedule/view/{id}','ScheduleData\YearlyScheduleController@viewdataschedule')->name('viewscheduleyear');
// Route::get ('/schedule/view/data','ScheduleData\YearlyScheduleController@datacalendar')->name('datacalendar');
Route::get ('/schedule/read','ScheduleData\YearlyScheduleController@readmachinedata')->name('readmachinedata');
Route::get ('/schedule/find/{id}','ScheduleData\YearlyScheduleController@findschedule')->name('findscheduleid');
Route::get ('/schedule/table/refresh','ScheduleData\YearlyScheduleController@refreshtableschedule')->name('refreshschedule');
Route::get ('/schedule/table/refresh/{id}','ScheduleData\YearlyScheduleController@refreshdetailtableschedule')->name('refreshdetailschedule');
// Route::get ('/schedule/calendar/resource','ScheduleData\YearlyScheduleController@resourcecalendar');
Route::get ('/schedule/view/{id}', 'ScheduleData\YearlyScheduleController@viewdataschedule')->name('viewscheduleyear');
Route::get ('/schedule/view/events/{id}', 'ScheduleData\YearlyScheduleController@eventcalendar');
Route::get ('/schedule/view/resources/{id}', 'ScheduleData\YearlyScheduleController@resourcecalendar');
Route::get ('/schedule/print/{id}','ScheduleData\YearlyScheduleController@printscheduleannual')->name('print_year');
Route::get ('/schedule/print/quarter1/{id}','ScheduleData\YearlyScheduleController@printschedulequarter1')->name('print_quarter1');
Route::get ('/schedule/print/quarter2/{id}','ScheduleData\YearlyScheduleController@printschedulequarter2')->name('print_quarter2');
// schedule year route end

// schedule month route
Route::get ('/schedule/month/read/{id}','ScheduleData\MonthlyScheduleController@readscheduleyeardata')->name('readscheduleyear');
Route::get ('/schedule/month/find/{id}','ScheduleData\MonthlyScheduleController@findschedulemonth')->name('findschedulemonthid');
Route::post('/schedule/month/create','ScheduleData\MonthlyScheduleController@createschedulemonth')->name('addschedulemonth');
Route::put('/schedule/month/update/{id}','ScheduleData\MonthlyScheduleController@updatechedulemonth')->name('editschedulemonth');
Route::get ('/schedule/month/view/{id}','ScheduleData\MonthlyScheduleController@viewdataschedule')->name('viewschedulemonth');
Route::get ('/schedule/month/print/{id}','ScheduleData\MonthlyScheduleController@printdataschedulemonth')->name('printschedulemonth');
Route::delete('/schedule/month/delete/{id}','ScheduleData\MonthlyScheduleController@deleteschedulemonth')->name('removeschedulemonth');
// Route::get ('/schedule/machineschedule/read/{id}','ScheduleData\MonthlyScheduleController@readdatamachineschedule')->name('readmachineschedule');
// schedule month route


// machine record
Route::get ('/machinerecord','RecordsData\MachinerecordController@indexmachinerecord')->name('indexmachinerecord');
Route::get ('/machinerecord/schedule/{id}','RecordsData\MachinerecordController@formmachinerecord')->name('formpreventive');
Route::post('/machinerecord/create','RecordsData\MachinerecordController@createmachinerecord')->name('addrecord');
Route::get ('/machinerecord/table/refresh','RecordsData\MachinerecordController@refreshtablerecord')->name('refreshrecord');
Route::get ('/machinerecord/table/refresh/{id}','RecordsData\MachinerecordController@refreshdetailtablerecord')->name('refreshdetailrecord');
// machine record end

// machine records correction
Route::get ('/machinerecord/correction','RecordsData\MachinerecordController@indexcorrection')->name('indexcorrection');
Route::get ('/machinerecord/correction/table/refresh','RecordsData\MachinerecordController@refreshtablecorrection')->name('refreshcorrect');
Route::get ('/machinerecord/correction/read/{id}','RecordsData\MachinerecordController@readdatacorrection')->name('readcorrection');
Route::put ('/machinerecord/correction/insert/{id}','RecordsData\MachinerecordController@registercorrection')->name('insertcorrection');
Route::delete('/machinerecord/correction/delete/{id}','RecordsData\MachinerecordController@deletecorrection')->name('removecorrection');
// machine records correction end

// machine records approval
Route::get ('/machinerecord/approval','RecordsData\MachinerecordController@indexapproval')->name('indexapproval');
Route::get ('/machinerecord/approval/table/refresh','RecordsData\MachinerecordController@refreshtableapproval')->name('refreshapproval');
Route::get ('/machinerecord/approval/read/{id}','RecordsData\MachinerecordController@readdataapproval')->name('readapproval');
Route::put ('/machinerecord/approval/insert/{id}','RecordsData\MachinerecordController@registerapproval')->name('insertapproval');
Route::delete('/machinerecord/approval/delete/{id}','RecordsData\MachinerecordController@deleteapproval')->name('removeapproval');
// machine records approval end

// record data machine route
Route::get ('/historyrecord','RecordsData\MachinerecordController@indexhistoryrecord')->name('indexhistoryrecord');
Route::get ('/historyrecord/table/refresh','RecordsData\MachinerecordController@refreshtablehistory')->name('refreshistory');
Route::get ('/historyrecord/view/{id}','RecordsData\MachinerecordController@detailpreventive')->name('detailhistory');
Route::get ('/historyrecord/print/{id}','RecordsData\MachinerecordController@printdatarecord')->name('printrecord');
// record data machine route end


Route::get ('/blacklist','Auth\LoginController@blockuser');
