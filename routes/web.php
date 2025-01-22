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
Route::get ('/machinedata/export/csv/{id}','MachineData\ImportdataController@exportexcelwithcondition')->name('exportexcelvalue');
Route::get ('/machinedata/export/pdf','MachineData\ImportdataController@exportpdf')->name('exportpdf');
Route::get ('/machinedata/export/pdf/{id}','MachineData\ImportdataController@exportpdfwithcondition')->name('exportpdfvalue');
// machine import route end

// machine property route
Route::get ('/machineproperty','MachineData\MachinepropertyController@indexmachineproperty')->name('indexproperty');
Route::post('/machineproperty/create','MachineData\MachinepropertyController@createproperty')->name('addproperty');
Route::put ('/machineproperty/update/{id}','MachineData\MachinepropertyController@updateproperty')->name('editproperty');
// Route::get('/machineproperty/find/{id}','MachineData\MachinepropertyController@findproperty')->name('findproperty');
Route::get ('/machineproperty/table/refresh','MachineData\MachinepropertyController@refreshtableproperty')->name('refreshproperty');
Route::delete('/machineproperty/delete/{id}','MachineData\MachinepropertyController@deleteproperty')->name('removeproperty');
// machine property route end

// machine working route
Route::get ('/workinghour','MachineData\WorkingHourController@indexworkinghour')->name('indexworkinghour');
Route::get ('/workinghour/read','MachineData\WorkingHourController@readmachinedata')->name('readmachinewo');
Route::post('/workinghour/create','MachineData\WorkingHourController@createworkinghour')->name('addworkinghour');
Route::get ('/workinghour/find/{id}','MachineData\WorkingHourController@findworkinghour')->name('findworkinghour');
Route::put ('/workinghour/update/{id}','MachineData\WorkingHourController@updateworkinghour')->name('editworkinghour');
Route::get ('/workinghour/view/{id}','MachineData\WorkingHourController@viewworkinghour')->name('viewworkinghour');
Route::get ('/workinghour/table/refresh','MachineData\WorkingHourController@refreshtableworkinghour')->name('refreshworkinghour');
Route::delete('/workinghour/delete/{id}','MachineData\WorkingHourController@deleteworkinghour')->name('removeworkinghour');
// machine working route end

// schedule year route
Route::get ('/schedule','ScheduleData\YearlyScheduleController@indexschedule')->name('indexyear');
Route::post('/schedule/create','ScheduleData\YearlyScheduleController@createschedule')->name('addyear');
Route::put ('/schedule/update/{id}','ScheduleData\YearlyScheduleController@updateschedule')->name('edityear');
Route::delete('/schedule/delete/{id}','ScheduleData\YearlyScheduleController@deleteschedule')->name('removeyear');
Route::get ('/schedule/read','ScheduleData\YearlyScheduleController@readmachinedata')->name('readmachineyear');
Route::get ('/schedule/find/{id}','ScheduleData\YearlyScheduleController@findschedule')->name('findscheduleid');
Route::get ('/schedule/table/refresh','ScheduleData\YearlyScheduleController@refreshtableschedule')->name('refreshyear'); // juga buat numpang tabel known & agreed year
Route::get ('/schedule/table/refresh/{id}','ScheduleData\YearlyScheduleController@refreshdetailtableschedule')->name('refreshdetailyear');
Route::get ('/schedule/view/{id}', 'ScheduleData\YearlyScheduleController@viewdataschedule')->name('viewyear');
// khusus view fullcalendar
Route::get ('/schedule/view/events/{id}', 'ScheduleData\YearlyScheduleController@eventcalendar');
Route::get ('/schedule/view/resources/{id}', 'ScheduleData\YearlyScheduleController@resourcecalendar');
// khusus untuk print schedule
Route::get ('/schedule/print/{id}','ScheduleData\YearlyScheduleController@printscheduleannual')->name('printyear');
Route::get ('/schedule/print/quarter1/{id}','ScheduleData\YearlyScheduleController@printschedulequarter1')->name('print_quarter1');
Route::get ('/schedule/print/quarter2/{id}','ScheduleData\YearlyScheduleController@printschedulequarter2')->name('print_quarter2');
// schedule year route end

// schedule year recognize
// Route::get ('/schedule/recognize','ScheduleData\YearlyScheduleController@indexschedulerecognize')->name('indexyear-recognize');
// Route::get ('/schedule/recognize/read/{id}','ScheduleData\YearlyScheduleController@readscheduledata')->name('readyear-recognize');
// Route::put ('/schedule/recognize/register/{id}','ScheduleData\YearlyScheduleController@registerrecognize')->name('edityear-recognize');
// schedule year recognize end

// schedule year accept
Route::get ('/schedule/accept','ScheduleData\YearlyScheduleController@indexscheduleaccept')->name('indexyear-accept');
Route::get ('/schedule/accept/read/{id}','ScheduleData\YearlyScheduleController@readscheduledata')->name('readyear-accept');
Route::put ('/schedule/accept/register/{id}','ScheduleData\YearlyScheduleController@registeraccept')->name('edityear-accept');
// schedule year accept end




// schedule month route
Route::get ('/schedule/month/read/{id}','ScheduleData\MonthlyScheduleController@readscheduleyeardata')->name('readyear');
Route::get ('/schedule/month/find/{id}','ScheduleData\MonthlyScheduleController@findschedulemonth')->name('findmonthid');
Route::post('/schedule/month/create','ScheduleData\MonthlyScheduleController@createschedulemonth')->name('addmonth');
Route::put('/schedule/month/update/{id}','ScheduleData\MonthlyScheduleController@updatechedulemonth')->name('editmonth');
// Route::get ('/schedule/month/table/refresh/','ScheduleData\MonthlyScheduleController@refreshtableschedulemonth')->name('refreshmonth');
Route::get ('/schedule/month/view/{id}','ScheduleData\MonthlyScheduleController@viewdataschedule')->name('viewmonth');
Route::get ('/schedule/month/print/{id}','ScheduleData\MonthlyScheduleController@printdataschedulemonth')->name('printmonth');
Route::delete('/schedule/month/delete/{id}','ScheduleData\MonthlyScheduleController@deleteschedulemonth')->name('removemonth');
// Route::get ('/schedule/machineschedule/read/{id}','ScheduleData\MonthlyScheduleController@readdatamachineschedule')->name('readmachineschedule');

// Route::get ('/schedule/special/read/machine','ScheduleData\MonthlyScheduleController@readmachinespecialdata')->name('readmachine-special');
// schedule month route

// schedule month special
Route::get ('/schedule/special/read/{id}','ScheduleData\MonthlyScheduleController@readspecialscheduledata')->name('readyear-special');
Route::post('/schedule/special/create','ScheduleData\MonthlyScheduleController@createspecialschedule')->name('addmonth-special');
// schedule month special end

// schedule month accept
Route::get ('/schedule/month/accept','ScheduleData\MonthlyScheduleController@indexschedulemonthaccept')->name('indexmonth-accept');
Route::get ('/schedule/month/accept/read/{id}','ScheduleData\MonthlyScheduleController@readschedulemonthdata')->name('readmonth-accept');
Route::put ('/schedule/month/accept/register/{id}','ScheduleData\MonthlyScheduleController@registermonthaccept')->name('editmonth-accept');
Route::get ('/schedule/month/accept/table/refresh/','ScheduleData\MonthlyScheduleController@refreshtableschedulemonth')->name('refresh-accept');
// schedule month accept end

// schedule month planner
Route::get ('/schedule/month/planner','ScheduleData\MonthlyScheduleController@indexschedulemonthplanner')->name('indexmonth-planner');
Route::get ('/schedule/month/planner/read/{id}','ScheduleData\MonthlyScheduleController@readschedulemonthdata')->name('readmonth-planner');
Route::get ('/schedule/month/planner/find/{id}','ScheduleData\MonthlyScheduleController@readschedulemonthdata')->name('findmonth-planner');
Route::put ('/schedule/month/planner/register/{id}','ScheduleData\MonthlyScheduleController@registerplanner')->name('editmonth-planner');
Route::get ('/schedule/month/planner/table/refresh/','ScheduleData\MonthlyScheduleController@refreshtablescheduleplanner')->name('refresh-planner');
// schedule month planner end

// preventive
Route::get ('/preventive','RecordsData\MachinerecordController@indexpreventive')->name('indexpreventive');
Route::get ('/preventive/read/onschedule/{id}','RecordsData\MachinerecordController@readonscheduledata')->name('readpreventive-onschedule');
// Route::get ('/preventive/read/offschedule/{id}','RecordsData\MachinerecordController@readoffscheduledata')->name('readpreventive-offschedule');
// Route::get ('/preventive/read/special','RecordsData\MachinerecordController@readspecialscheduledata')->name('readpreventive-special');
// Route::get ('/preventive/read/machine','RecordsData\MachinerecordController@readmachinedata')->name('readmachinepreventive');
Route::get ('/preventive/schedule/{id}','RecordsData\MachinerecordController@formmachinerecord')->name('formpreventive');
Route::post('/preventive/create','RecordsData\MachinerecordController@createmachinerecord')->name('addrecord');
Route::get ('/preventive/table/refresh','RecordsData\MachinerecordController@refreshtablepreventive')->name('refreshpreventive');
Route::get ('/preventive/table/refresh/{id}','RecordsData\MachinerecordController@refreshdetailtablepreventive')->name('refreshdetailpreventive');
// preventive end

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
